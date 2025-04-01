<?php

namespace Filament\Pages\Auth;

use App\Models\Location;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Filament\Support\Enums\IconPosition;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;

/**
 * @property Form $form
 */
class Register extends SimplePage
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;
    use WithRateLimiting;

    public ?string $recaptchaToken = null;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.auth.register';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected string $userModel;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->callHook('beforeFill');

        $this->form->fill();

        $this->callHook('afterFill');
    }

    #[On('recaptchaValidated')]
    public function setRecaptchaToken($token)
    {
        $this->recaptchaToken = $token;
    }


    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        if (!$this->recaptchaToken) {


            Notification::make()
            ->title('Error!')
            ->body('Please complete the reCAPTCHA.')
            ->success()
            ->send();

            return null;
        }

        $verification = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $this->recaptchaToken,
            'remoteip' => request()->ip(),
        ])->json();

        if (!isset($verification['success']) || !$verification['success']) {


            Notification::make()
            ->title('Error!')
            ->body('reCAPTCHA verification failed. Please try again.')
            ->success()
            ->send();

            return null;

        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Notification::make()
        ->title('Registration Successful')
        ->body('You have successfully registered. Please wait for Administrator to approved your account.')
        ->success()
        ->send();

       // Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        return $this->getUserModel()::create($data);
    }

    protected function sendEmailVerificationNotification(Model $user): void
    {
        if (! $user instanceof MustVerifyEmail) {
            return;
        }

        if ($user->hasVerifiedEmail()) {
            return;
        }

        if (! method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = app(VerifyEmail::class);
        $notification->url = Filament::getVerifyEmailUrl($user);

        $user->notify($notification);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getRegionFormComponent(),
                        $this->getProvinceFormComponent(),
                        $this->getMunicipalityFormComponent(),
                        $this->getBarangayFormComponent(),
                        $this->getPsgcFormComponent(),
                        $this->getContactFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getSwadFormComponent(),
                        $this->getEmployeeIdFormComponent(),
                        $this->getFormCaptcha(),
                        $this->getFormCaptcha2(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getFormCaptcha(): Component
    {
        return View::make('filament.forms.recaptcha')
            ->columnSpanFull(); // Ensure it spans full width
    }

    protected function getFormCaptcha2(): Component
    {
        return Hidden::make('recaptcha')
            ->default(fn () => request('g-recaptcha-response'));
    }


    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('filament-panels::pages/auth/register.form.name.label'))
            ->required()
            ->minLength(3) // Minimum 3 characters
            ->maxLength(50) // Maximum 50 characters
            ->rule('regex:/^[a-zA-Z\s]+$/')->validationMessages([
                'regex' => 'The name can only contain letters and spaces.',
            ])
            ->prefixIcon('heroicon-o-user')
            ->placeholder('Enter your full name')
            ->autofocus();
    }

    protected function getEmployeeIdFormComponent(): Component
    {
        return TextInput::make('employee_id')
            ->label('Employee ID')
            ->required()
            ->prefixIcon('heroicon-o-identification')
            ->maxLength(20)
            ->placeholder('Enter your DSWD ID No. 03-XXXX')
            ->autofocus()
            ->unique($this->getUserModel());


    }

    protected function getRegionFormComponent(): Component
    {
        return Select::make('region')
        ->label('Region')
        ->required()
        ->prefixIcon('heroicon-o-map-pin')
        ->options([
            'Region III (Central Luzon)' => 'Region III (Central Luzon)',

        ])
        ->native(false);

    }

        protected function getProvinceFormComponent(): Component
    {
        return Select::make('province')
        ->label('Province')
        ->required()
        ->reactive()
        ->prefixIcon('heroicon-o-map-pin')
        ->searchable()
        ->options([
                    'Aurora' => 'Aurora',
                    'Bataan' => 'Bataan',
                    'Bulacan' => 'Bulacan',
                    'Nueva Ecija' => 'Nueva Ecija',
                    'Pampanga' => 'Pampanga',
                    'Tarlac' => 'Tarlac',
                    'Zambales' => 'Zambales'
                ])
                ->native(false);
    }
    protected function getMunicipalityFormComponent(): Component
    {
        return Select::make('municipality')
                ->label('Municipality')
                ->required()
                ->reactive()
                ->prefixIcon('heroicon-o-map-pin')
                ->searchable()
                ->options(function (callable $get) {
                    $province = $get('province');

                    // Fetch the municipalities matching the selected province
                    $municipalities = Location::where('province', $province)
                        ->whereNotNull('municipality')
                        ->whereNotNull('barangay')
                        ->pluck('municipality', 'municipality');

                    return $municipalities->toArray();
                })
                ->native(false);
        }

        protected function getBarangayFormComponent(): Component
        {
            return Select::make('barangay')
                ->label('Barangay')
                ->required()
                ->searchable()
                ->prefixIcon('heroicon-o-map-pin')
                ->reactive()
                ->options(function (callable $get) {
                    $municipality = $get('municipality');

                    // Fetch the municipalities matching the selected province
                    $barangay = Location::where('municipality', $municipality)
                        ->whereNotNull('municipality')
                        ->whereNotNull('barangay')
                        ->pluck('barangay', 'barangay');



            return $barangay->toArray();
        })
        ->afterStateUpdated(function (callable $set, $state, callable $get) {
            // Recalculate the average whenever the second semester is updated
            $province = $get('province');
            $municipality = $get('municipality');
            $barangay = $get('barangay');



            if ($province !== null && $municipality !== null && $barangay !== null) {

                $psgc = Location::where('barangay', $barangay)
                ->where('municipality', $municipality)
                ->where('province', $province)
                ->value('psgc');

               $set('psgc', $psgc);

            } else {
                $set('psgc', null);

            }
        })
        ->native(false);
    }
    protected function getPsgcFormComponent(): Component
    {
        return Hidden::make('psgc')
            ->reactive();
    }





    protected function getContactFormComponent(): Component
    {
        return TextInput::make('contact')
            ->label('Mobile Number')
            ->required()
            ->prefixIcon('heroicon-o-calculator')
            ->placeholder('Enter your Contact Number')
            ->maxLength(11)
            ->mask('999999999999') // Allows only numeric input, up to 12 digits
            ->numeric(); // Ensures only numbers are allowed
    }




    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->placeholder('Enter your Valid Email Address')
            ->required()
            ->prefixIcon('heroicon-o-envelope')
            ->maxLength(255)
            ->unique($this->getUserModel());
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    protected function getSwadFormComponent(): Component
    {
        return Select::make('office')
        ->label('Swad Office')
        ->required()
        ->prefixIcon('heroicon-o-building-office-2')
        ->searchable()
        ->options([
                    'Swad-Aurora' => 'Swad-Aurora',
                    'Swad-Bataan' => 'Swad-Bataan',
                    'Swad-Bulacan' => 'Swad-Bulacan',
                    'Swad-Nueva Ecija' => 'Swad-Nueva Ecija',
                    'Swad-Pampanga' => 'Swad-Pampanga',
                    'Swad-Tarlac' => 'Swad-Tarlac',
                    'Swad-Zambales' => 'Swad-Zambales'
                ])
                ->native(false);
    }


    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label(__('filament-panels::pages/auth/register.actions.login.label'))
            ->url(filament()->getLoginUrl());
    }

    protected function getUserModel(): string
    {
        if (isset($this->userModel)) {
            return $this->userModel;
        }

        /** @var SessionGuard $authGuard */
        $authGuard = Filament::auth();

        /** @var EloquentUserProvider $provider */
        $provider = $authGuard->getProvider();

        return $this->userModel = $provider->getModel();
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.heading');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
            ->submit('register');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        return $data;
    }
}
