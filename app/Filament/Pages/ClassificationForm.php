<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Beneficiary;
use App\Models\Bulacan;
use App\Models\FamilyHead;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\User;
use App\Models\Zamb;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClassificationForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.pages.classification-form';

    protected static ?string $navigationLabel ='Qr Scanning';

    public ?array $location = [];

    public ?array $fhead = [];


    public $qr_number;

    public $beneficiary;

    public bool $formVisible = false;

    protected $listeners = ['setSearchQuery'];

    public function getTitle(): string
    {
        return 'QR Scanning';
    }

    // public static function canAccess(): bool
    // {
    //     $user = Auth::user();

    //     return ($user && ($user->isAdmin() || !$user->isLgu())) ? true : false;
    // }



    // public function boot()
    // {
    //     $this->dispatch('setSearchQuery', function ($data) {
    //         Log::info('Livewire event triggered:', ['data' => $data]);
    //         $this->setSearchQuery($data);
    //     });
    // }



    public function form(Form $form): Form
    {
        return $form
             ->schema([
                Section::make('')
          ->description('Location Information')
            ->schema([
                TextInput::make('province')
                ->label('Province')
                ->live()
                ->disabled()
                ->required(),

                TextInput::make('municipality')
                ->label('Municipality')
                ->live()
                ->disabled()
                ->required(),

                TextInput::make('barangay')
                ->label('Barangay')
                ->live()
                ->disabled()
                ->required(),


                ])
                ->columns(3)
                ->statePath('location'),

                    Section::make('')
                     ->description('Beneficiary Information')
                    ->schema([
                        TextInput::make('last_name')
                        ->label('Last Name')
                        ->disabled()
                        ->live()
                        ->required(),

                        TextInput::make('first_name')
                        ->label('First Name')
                        ->live()
                        ->disabled()
                        ->required(),

                        TextInput::make('middle_name')
                        ->label('Middle Name')
                        ->live()
                        ->disabled()
                        ->required(),

                        TextInput::make('ext_name')
                        ->live()
                        ->disabled()
                        ->label('EXT Name'),

                        DatePicker::make('birthday')
                        ->label('Date of Birth')
                        ->required()
                        ->disabled()
                        ->debounce(500)
                        ->native(false)
                        ->format('Y-m-d')
                        ->afterStateUpdated(function (callable $set, callable $get) {
                            $birthday = $get('birthday');

                            if ($birthday) {
                                $age_now = Carbon::parse($birthday)->age;
                                $set('age', $age_now);
                            } else {
                                $set('age', null);
                            }
                        })
                        ->live(),

                        TextInput::make('contact')
                        ->label('Contact Number')
                        ->required()
                        ->disabled()
                        ->live(),


                        Toggle::make('is_hired')->label('Is Hired?')
                        ->helperText('Toggle if the beneficiary is Hired'),

                        Toggle::make('w_listed')->label('Is WaitListed?')
                        ->helperText('Toggle if the beneficiary is WaitListed'),

                        Hidden::make('validated_by')
                        ->reactive(),

                    ])
                    ->columns(4)
                    ->statePath('location'),

         ]);


    }

   #[On('fillTheForm')]
public function fillTheForm($qr_number){



    $this->formVisible = true;

    $this->qr_number = $qr_number;


    $beneficiary = Beneficiary::where('qr_number', $qr_number)->where('status', "present")->first();

    $this->fill([
        'location' => [
            'province' => $beneficiary->province ?? '',
            'municipality' => $beneficiary->municipality ?? '',
            'barangay' => $beneficiary->barangay ?? '',
            'psgc' => $beneficiary->psgc ?? '',
            'last_name' => $beneficiary->last_name ?? '',
            'first_name' => $beneficiary->first_name ?? '',
            'middle_name' => $beneficiary->middle_name ?? '',
            'ext_name' => $beneficiary->ext_name ?? '',
            'birthday' => $beneficiary->birth_year && $beneficiary->birth_month && $beneficiary->birth_day
            ? "{$beneficiary->birth_year}-{$beneficiary->birth_month}-{$beneficiary->birth_day}"
            : null,
            'contact' => $beneficiary->contact_number ?? '',
            'is_hired' => $beneficiary->is_hired ?? '',
           'w_listed' => $beneficiary->w_listed ?? '',
            'validated_by' => Filament::auth()->user()?->id,

        ],
    ]);


}





    #[On('setSearchQuery')]
    public function setSearchQuery(Request $request)
    {
        Log::info('QR number received:', ['qr_number' => $request->qr_number]);

      //  dd($request->qr_number);

        try {


           // Fetch the family head details
           $beneficiary = Attendance::where('qr_number', $request->qr_number)->first();
          // $beneficiary2 = Beneficiary::where('qr_number', $request->qr_number)->first();
           Log::info('Beneficiary record:', ['beneficiary' => $beneficiary]);


           if (!$beneficiary) {

            $this->formVisible = false;
            $this->resetExcept(['qr_number']);

            return response()->json(['error' => 'This Beneficiary is not yet Log in Attendance'], 400);


        }

        if (in_array($beneficiary->is_hired, ['hired']) || in_array($beneficiary->w_listed, ['yes'])) {
            $this->formVisible = false;
            $this->resetExcept(['qr_number']);

            return response()->json([
                'error' => 'This Beneficiary is already ' . ($beneficiary->is_hired === 'hired' ? 'hired' : 'Wait Listed')
            ], 400);
        }


        if ($beneficiary->validated_by === null && $beneficiary->status === "Present") {

            return response()->json([
                'success' => true,
                'message' => 'Record Found!',
                'data' => [
                    'name' => $beneficiary->first_name . ' ' .$beneficiary->middle_name. ' ' . $beneficiary->last_name,
                    'province' => $beneficiary->province,
                    'municipality' => $beneficiary->municipality,
                    'barangay' => $beneficiary->barangay,
                ]
            ]);


        }


        } catch (\Exception $e) {
            Log::error('Error in setSearchQuery method: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json(['error' => 'Something went wrong. Please try again later', 400]);

        }
    }





    protected function getFormActions(): array
    {

        return [
              Action::make('submit')
                ->label('Submit')
                ->action('submit')

        ];
    }

    #[On('submit')]
    public function submit()
    {
        try {

            $fam = Beneficiary::where('qr_number', $this->qr_number)->first();
            // if (!$fam) {
            //     $this->dispatch('swal',
            //         title: 'Error!',
            //         text: 'Beneficiary not found.',
            //         icon: 'error'
            //     );
            //     return;
            // }

            // Validate input
            $validated = $this->validate([
                'location.validated_by' => 'required|integer|max:10',
                'location.is_hired' => 'required|integer|max:1',
                'location.w_listed' => 'required|integer|max:1',
            ]);

           // dd($validated['location']);

            $fam->update($validated['location']);

            if ($fam->province == 'Bulacan') {

                if ($fam->is_hired) {
                    Bulacan::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Bulacan::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Pampanga') {

                if ($fam->is_hired) {
                    Pampanga::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Pampanga::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Aurora') {

                if ($fam->is_hired) {
                    Aurora::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Aurora::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Bataan') {

                if ($fam->is_hired) {
                    Bataan::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Bataan::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Nueva Ecija') {

                if ($fam->is_hired) {
                    Nueva::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Nueva::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Tarlac') {

                if ($fam->is_hired) {
                    Tarlac::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Tarlac::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }

            if ($fam->province == 'Zambales') {

                if ($fam->is_hired) {
                    Zamb::where('municipality', $fam->municipality)->increment('is_hired');
                }

                if ($fam->w_listed) {
                    Zamb::where('municipality', $fam->municipality)->increment('w_listed');
                }

                $attendanceData = [
                    'is_hired' => $fam->is_hired ? 'hired' : 'not hired',
                    'w_listed' => $fam->w_listed ? 'yes' : 'no',
                ];


                Attendance::where('qr_number', $this->qr_number)->update($attendanceData);
            }


            $this->formVisible = false;


            $this->dispatch('swal',
            title: 'Success!',
            text: 'Record updated successfully.',
            icon: 'success'
        );

        $this->dispatch('reloadPage');

        } catch (\Exception $e) {
            Log::error('Error in submit method: ' . $e->getMessage(), ['exception' => $e]);

            $this->dispatch('swal',
                title: 'Error!',
                text: 'Something went wrong. Please try again later.',
                icon: 'error'
            );
        }


    }
}

