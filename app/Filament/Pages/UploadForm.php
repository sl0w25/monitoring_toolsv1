<?php

namespace App\Filament\Pages;

use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Beneficiary;
use App\Models\Bulacan;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UploadForm extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static string $view = 'filament.pages.upload-form';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?string $navigationLabel = 'Import Beneficiaries';
    protected static ?int $navigationSort = 4;

    public array $upload = [];

    public function getTitle(): string
    {
        return 'Import List of Beneficiaries';
    }

    // public static function canAccess(): bool
    // {
    //     return Auth::user()?->isAdmin(); // Adjust as needed
    // }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->description('Upload a CSV file to import beneficiaries.')
                    ->schema([
                        FileUpload::make('upload')
                            ->label('CSV File')
                            ->helperText('Please upload only CSV files.')
                            ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
                            ->directory('csvfiles')
                            ->preserveFilenames()
                            ->live() // Ensures real-time model binding
                            ->multiple(false),


                    ])
            ]);
    }

    protected function getActions(): array
    {
        return [
            Action::make('Import')
                ->icon('heroicon-o-arrow-up-on-square')
                ->disabled(fn () => empty($this->upload))
                ->action(fn () => $this->processCsv()),
        ];
    }

    public function processCsv()
    {
        // Check if upload exists
        if (empty($this->upload)) {
            Notification::make()
                ->title('Error!')
                ->body('No file uploaded. Please select a CSV file.')
                ->danger()
                ->send();
            return;
        }

        // Extract the uploaded file object
        $uploadedFile = reset($this->upload);

        if (!$uploadedFile instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            Notification::make()
                ->title('Error!')
                ->body('Invalid file upload. Please try again.')
                ->danger()
                ->send();
            return;
        }

        // Move file to storage and get the path
        $uploadedFilePath = $uploadedFile->store('csvfiles');

        if (!$uploadedFilePath) {
            Notification::make()
                ->title('Error!')
                ->body('Failed to store uploaded file.')
                ->danger()
                ->send();
            return;
        }

        $fullPath = Storage::path($uploadedFilePath);

        if (!Storage::exists($uploadedFilePath)) {
            Notification::make()
                ->title('Error!')
                ->body('File does not exist after upload.')
                ->danger()
                ->send();
            return;
        }

        try {

            $csvContent = file_get_contents($fullPath);
            $csvContent = preg_replace('/^\xEF\xBB\xBF/', '', $csvContent); // Remove BOM
            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'auto');
            file_put_contents($fullPath, $csvContent);

            $csv = Reader::createFromPath($fullPath, 'r');
            $csv->setHeaderOffset(0);


            foreach ($csv as $record) {
              $entry =  Beneficiary::create([
                  'last_name' => $this->convertEncoding($record['last_name'] ?? null),
                'first_name' => $this->convertEncoding($record['first_name'] ?? null),
                'middle_name' => $this->convertEncoding($record['middle_name'] ?? null),
                'ext_name' => $record['ext_name'] ?? null,
                'birth_month' => $record['birth_month'] ?? null,
                'birth_day' => $record['birth_day'] ?? null,
                'birth_year' => $record['birth_year'] ?? null,
                'sex' => $record['sex'] ?? null,
                'barangay' => $this->convertEncoding($record['barangay'] ?? null),
                'psgc_city' => $record['psgc_city'] ?? null,
                'municipality' => $this->convertEncoding($record['municipality'] ?? null),
                'province' => $record['province'] ?? null,
                'type_of_assistance' => $record['type_of_assistance'] ?? null,
                'amount' => $record['amount'] ?? null,
                'philsys_number' => $record['philsys_number'] ?? null,
                'beneficiary_unique_id' => $record['beneficiary_unique_id'] ?? null,
                'contact_number' => $record['contact_number'] ?? null,
                'target_sector' => $record['target_sector'] ?? null,
                'sub_category' => $record['sub_category'] ?? null,
                'civil_status' => $record['civil_status'] ?? null,
                'qr_number' => null,
                'is_hired' => 0,
                'w_listed' => 0,
                'status' => null,
                'validated_by' => null,
                'ml_user' => null,
                ]);

                $entry->update(['bene_id' => $entry->id]);
                $this->insertBene();
                $this->inserthired();
                $this->insertpresent();
                $this->insertabsent();
                $this->insertwlisted();
            }


            Storage::delete($uploadedFilePath);

            Notification::make()
                ->title('Success!')
                ->body('CSV file imported successfully.')
                ->success()
                ->send();
        } catch (Exception $e) {
            logger()->error('CSV Processing Error: ' . $e->getMessage());

            Notification::make()
                ->title('Error!')
                ->body('CSV Processing failed: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function convertEncoding(?string $value): ?string
{
    return $value !== null ? mb_convert_encoding($value, 'UTF-8', 'auto') : null;
}



    public function insertBene()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();


        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->count();

                Aurora::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['bene' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all municipalities']);
    }

    public function inserthired()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();

      //  dd($municipalities);

        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('is_hired', 1)->count();


                Aurora::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['is_hired' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all hired']);
    }

    public function insertpresent()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();

      //  dd($municipalities);

        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('status', "Present")->count();

            Aurora::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Bataan::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Bulacan::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Pampanga::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Nueva::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Tarlac::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);

            Zamb::where('municipality', $municipality->municipality)
            ->update(['present' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all present']);
    }

    public function insertabsent()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();

      //  dd($municipalities);

        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('status', null)->count();


                Aurora::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['absent' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all present']);
    }

    public function insertwlisted()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();

      //  dd($municipalities);

        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('status', null)->count();


                Aurora::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['w_listed' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all present']);
    }



}













