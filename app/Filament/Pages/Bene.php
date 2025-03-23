<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\LocationInfo;
use App\Models\User;
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
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Tables\Enums\RecordCheckboxPosition;

class Bene extends Page implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.pages.bene';

    protected static ?string $navigationLabel ='Beneficiary List';

    protected static ?int $navigationSort = 2;

    public $fam_id;

    public array $selectedRecords = [];

    public static function canAccess(): bool
    {
        return true;
    }


    public function getTitle(): string
    {
        return 'Beneficiary List';
    }

    public function updatedTableRecordsPerPage()
    {
        // ✅ Restore selected records when table updates (e.g., filtering, search)
        $this->dispatchBrowserEvent('restoreSelections', ['selectedRecords' => $this->selectedRecords]);
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
                TextColumn::make('row_number')->label('#'),
                TextColumn::make('province')->label('Province')->searchable(),
                TextColumn::make('municipality')->label('Municipaity')->searchable(),
                TextColumn::make('barangay')->label('Barangay')->searchable(),
                TextColumn::make('first_name')->label('First Name')->searchable(),
                TextColumn::make('middle_name')->label('Middle Name')->searchable(),
                TextColumn::make('last_name')->label('Last Name')->searchable(),

            ])
            ->searchable()
            ->bulkActions([
                // Bulk Action 1: Assign to User (Admin Only)
                BulkAction::make('assign_user')
                    ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin() || Auth::user()->isLgu())
                    ->label('Assign to User')
                    ->icon('heroicon-o-user-circle')
                    ->form([
                        Select::make('ml_user')
                            ->label('Select Municipal Link')
                            ->options(
                                User::where('office', auth()->user()->office)
                                    ->where('id', '!=', auth()->user()->id) 
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($records, $data) {
                        foreach ($records as $record) {
                            $record->update(['ml_user' => $data['ml_user']]); 
                        }
            
                        Notification::make()
                            ->title('Assignment Successful')
                            ->body('Selected beneficiaries have been assigned to the selected user.')
                            ->success()
                            ->send();
            
                        $this->selectedRecords = $records->pluck('id')->toArray();
                    })
                    ->deselectRecordsAfterCompletion(false), 
            
                // Bulk Action 2: Download QR Codes (All Users)
                BulkAction::make('download_qr')
                    ->visible(fn (): bool => Auth::check()) // Available for all authenticated users
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
                    })
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
