<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\LocationInfo;
use Filament\Actions\Action as ActionsAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Bene extends Page implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.pages.bene';

    protected static ?string $navigationLabel ='Beneficiary List';

    protected static ?int $navigationSort = 2;

    public $fam_id;


    public function getTitle(): string
    {
        return 'Beneficiary List';
    }

    public function table(Table $table): Table
    {
        return $table

    //    ->query(LocationInfo::with(['accountInfo','familyHeads','assistance']))
    //         ->columns([
    //             TextColumn::make('id')->label('Payroll Number')->searchable(),
    //             TextColumn::make('province')->label('Province')->searchable(),
    //             TextColumn::make('municipality')->label('Municipaity')->searchable(),
    //             TextColumn::make('barangay')->label('Barangay')->searchable(),
    //             TextColumn::make('familyHeads.first_name')->label('First Name')->searchable(),
    //             TextColumn::make('familyHeads.middle_name')->label('Middle Name')->searchable(),
    //             TextColumn::make('familyHeads.last_name')->label('Last Name')->searchable(),
    //             TextColumn::make('assistance.status')->label('Status')->searchable(),
    //         ])


            ->query(
                Beneficiary::query()
                    ->when(
                        !Filament::auth()->user()->is_admin,
                        fn($query) => $query->where('ml_user', null) // Filament::auth()->id())
                    )
                    ->selectRaw('ROW_NUMBER() OVER (ORDER BY id) as row_number, beneficiaries.*')
            )



            ->columns([
                TextColumn::make('row_number')->label('#'),
                TextColumn::make('province')->label('Province')->searchable(),
                TextColumn::make('municipality')->label('Municipaity')->searchable(),
                TextColumn::make('barangay')->label('Barangay')->searchable(),
                TextColumn::make('first_name')->label('First Name')->searchable(),
                TextColumn::make('middle_name')->label('Middle Name')->searchable(),
                TextColumn::make('last_name')->label('Last Name')->searchable(),
                TextColumn::make('is_hired')->label('Hired')->searchable(),
                TextColumn::make('w_listed')->label('listed')->searchable(),
                TextColumn::make('qr_number')->label('qr')->searchable(),
            ])
            ->searchable()
            ->filters([

            ])
            ->actions([
                ViewAction::make('view_details')
                    ->label('View Details')
                    ->modalContent(function ($record) {
                        return view('filament.modals.family_details', [
                            'familyHead' => Beneficiary::where('bene_id', $record->id)->first(),
                        ]);

                    })

                    ->modalActions([
                        Action::make('qr_code')
                            ->label('Print QR Code')
                            ->url(function (Beneficiary $record) {

                                return route('faced.print', [
                                    'id' => $record->id,
                                ]);
                            })

                            ])
                    ->modalHeading(fn ($record) => 'Beneficiary Details with ID ' . $record->beneficiary_unique_id)
                    ->modalWidth('7xl')
                    ,
            ]);
    }

    protected function getActions(): array
    {
        return [
            ActionsAction::make('Generate qr Code')
                ->icon('heroicon-o-cog')
                ->action(fn () => $this->generateQrNumbers()) // Calls CSV processing method
                ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin())
        ];
    }


    public function generateQrNumbers()
    {

        $familyHeads = Beneficiary::all();

        foreach ($familyHeads as $head) {

            if (!$head->qr_number) {
                do {
                    $qr_number = mt_rand(1111111111, 9999999999);
                  //  $encrypted_qr = Crypt::encrypt($qr_number);
                } while (Beneficiary::where('qr_number', $qr_number)->exists());


                $head->qr_number = $qr_number;
                $head->save();
            }
        }
        Notification::make()
        ->title('Success!')
        ->body('Succesfully generated QR Code')
        ->danger()
        ->send();
        return;
      //  return response()->json(['message' => 'QR numbers generated successfully for all Family Heads.']);
    }


}
