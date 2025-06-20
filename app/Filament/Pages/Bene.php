<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\LocationInfo;
use App\Models\User;
use App\Mail\BeneficiaryAssigned;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action as ActionsAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Tables\Enums\RecordCheckboxPosition;
use Illuminate\Support\Facades\Mail;


class Bene extends Page implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.pages.bene';

    protected static ?string $navigationLabel ='Master List';

    protected static ?int $navigationSort = 2;

    public $fam_id;

    public array $selectedRecords = [];

    public static function canAccess(): bool
    {
        return Filament::auth()->user()->is_admin || Filament::auth()->user()->is_lgu;
    }


    public function getTitle(): string
    {
        return 'Master List';
    }

    public function updatedTableRecordsPerPage()
    {
        $this->dispatch('restoreSelections', selectedRecords: $this->selectedRecords);
    }



    public function table(Table $table): Table
    {
        return $table

            ->query(
                Beneficiary::query()
                    ->when(
                        !Filament::auth()->user()->is_admin && !Filament::auth()->user()->is_lgu,
                        fn($query) => $query->where('ml_user', Filament::auth()->id()) // Filament::auth()->id())
                    )
                    ->selectRaw('ROW_NUMBER() OVER (ORDER BY id) as row_number, beneficiaries.*')
            )



            ->columns([
                TextColumn::make('row_number')->label('No.'),
                TextColumn::make('province')->label('Province')->searchable(),
                TextColumn::make('municipality')->label('Municipaity')->searchable(),
                TextColumn::make('barangay')->label('Barangay')->searchable(),
                TextColumn::make('first_name')->label('First Name')->searchable(),
                TextColumn::make('middle_name')->label('Middle Name')->searchable(),
                TextColumn::make('last_name')->label('Last Name')->searchable(),


            ])
            ->searchable()
            ->bulkActions([

                BulkAction::make('assign_user')
                    ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin() || Auth::user()->isLgu())
                    ->label('Assign to User')
                    ->modalButton('Confirm Assignment')
                    ->icon('heroicon-o-user-circle')
                    ->form([
                        Select::make('ml_user')
                        ->label('Select Municipal Link')
                        ->options(fn () => User::query()
                        ->when(!Auth::user()->isAdmin(), fn ($query) =>
                            $query->where('office', Auth::user()->office)
                        )
                        ->where('id', '!=', Auth::user()->id)
                        ->get()
                        ->mapWithKeys(fn ($user) => [$user->id => "{$user->name} - ({$user->employee_id})"])
                        ->toArray()
                    )
                        ->searchable()
                        ->required(),
                    ])
                    ->action(function ($records, $data) {
                        $alreadyAssigned = $records->filter(fn ($record) => !empty($record->ml_user));

                        if ($alreadyAssigned->isNotEmpty()) {
                            Notification::make()
                                ->title('Assignment Failed')
                                ->body('Some beneficiaries are already assigned to a user.')
                                ->danger()
                                ->send();

                            return;
                        }

                        // Assign only if ml_user is empty
                        foreach ($records as $record) {
                            $record->update(['ml_user' => $data['ml_user']]);
                        }

                        Notification::make()
                            ->title('Assignment Successful')
                            ->body('Selected beneficiaries have been assigned to the selected user.')
                            ->success()
                            ->send();

                        $this->selectedRecords = $records->pluck('id')->toArray();
                    }),

                BulkAction::make('download_qr')
                    ->visible(fn (): bool => Auth::check())
                    ->label('Download QR Codes')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('filament.pages.qr-bulk-download', ['records' => $records]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'qr_codes.pdf');

                        // return response($pdf->output(), 200, [
                        //     'Content-Type' => 'application/pdf',
                        //     'Content-Disposition' => 'inline; filename="faced_id_' . $records->id . '.pdf"',
                        // ]);
                    }),

                    BulkAction::make('notifyAdmins')
                    ->label('Notify Admins via Email (with QR PDF)')
                    ->action(function (Collection $records) {

                        $pdf = Pdf::loadView('filament.pages.email-qrcode', ['records' => $records])->setPaper([0, 0, 85.60, 54.00], 'portrait');

                        $pdfContent = $pdf->output();

                        foreach ($records as $beneficiary) {
                            Mail::to('jayson9225@gmail.com')->send(
                                new BeneficiaryAssigned($beneficiary, $pdfContent)
                            );
                        }

                        Notification::make()
                            ->title('Email Sent')
                            ->body('QR code PDF sent to the admins via email.')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation()
                    ->color('primary'),


            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'hired' => 'Hired',
                        'wait_listed' => 'Wait Listed',
                        'present' => 'Attendee'
                    ])
                    ->query(function ($query, $data) {
                        if (!isset($data['value'])) {
                            return $query;
                        }

                        $value = $data['value'];

                        if ($value === 'hired') {
                            return $query->where('is_hired', true);
                        } elseif ($value === 'wait_listed') {
                            return $query->where('w_listed', true);
                        } elseif ($value === 'present') {
                            return $query->where('status', 'Present');
                        }

                        return $query;
                    })
            ])



            ->actions([
                ViewAction::make('view_details')
                    ->label('View Details')
                    ->modalContent(function ($record) {
                        return view('filament.modals.family_details', [
                            'familyHead' => Beneficiary::where('id', $record->id)
                                                        ->where('province', $record->province)
                                                        ->first(),
                        ]);

                    })

                    ->modalActions([
                        Action::make('qr_code')
                            ->label('Print QR Code')
                            ->url(function (Beneficiary $record) {

                                return route('faced.print', [
                                    'id' => $record->id,
                                ]);
                                return "javascript:window.open('$url', '_blank');";
                            }),

                            ])
                    ->modalHeading(fn ($record) => 'Beneficiary Details with ID ' . $record->beneficiary_unique_id)
                    ->modalWidth('7xl')
                    ,
            ]);
    }

    protected function getActions(): array
    {
        return [
            ActionsAction::make('generate')
                ->label('Generate Qr Code')
                ->icon('heroicon-o-cog')
                ->action(fn () => $this->generateQrNumbers())
                ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin())
        ];
    }


    public function generateQrNumbers()
    {

        $familyHeads = Beneficiary::all();

       //dd($familyHeads);
        foreach ($familyHeads as $head) {

            if (!$head->qr_number) {
                do {
                    $qr_number = mt_rand(1111111111, 9999999999);

                } while (Beneficiary::where('qr_number', $qr_number)->exists());


                $head->qr_number = $qr_number;
                $head->save();
            }
        }
        Notification::make()
        ->title('Success!')
        ->body('Succesfully generated QR Code')
        ->success()
        ->send();
        return;
      //  return response()->json(['message' => 'QR numbers generated successfully for all Family Heads.']);
    }






}
