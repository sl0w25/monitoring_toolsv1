<?php

namespace App\Filament\Pages;

use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Beneficiary;
use App\Models\Bulacan;
use App\Models\Location;
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
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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

    public static function canAccess(): bool
    {
        if(!Filament::auth()->user()->is_admin){
            return false;
        }

        else{

        return true;
         }
    }

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

                Action::make('download')
                ->label('Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => Storage::url('csvfiles/template.csv'), true),
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

            // Remove BOM if it exists
            if (substr($csvContent, 0, 3) === "\xEF\xBB\xBF") {
                $csvContent = substr($csvContent, 3);
            }

            // Convert encoding to UTF-8
            $encoding = mb_detect_encoding($csvContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);

            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', $encoding ?: 'UTF-8');


            // Save the cleaned file
            file_put_contents($fullPath, $csvContent);

            $csv = Reader::createFromPath($fullPath, 'r');
            $csv->setHeaderOffset(0);

            $headerMap = [
                        'LASTNAME' => 'last_name',
                        'FIRSTNAME' => 'first_name',
                        'MIDDLENAME' => 'middle_name',
                        'EXT' => 'ext_name',
                        'GENDER' => 'sex',
                        'MONTH' => 'birth_month',
                        'DAY' => 'birth_day',
                        'YEAR' => 'birth_year',
                        'CONTACT NUMBER' => 'contact_number',
                        'BARANGAY/WITH CODE' => 'barangay',
                        'CITY/WITH CODE' => 'municipality',
                        'PROVINCE/WITH CODE' => 'province',
                        'CITY_PSGC' => 'city_psgc',
                        // Optional fields
                        'PROV_PSGC' => 'prov_psgc',
                        'BARANGAY_PSGC' => 'barangay_psgc',
                        'No.' => 'bene_id', // if needed
                    ];



           foreach ($csv as $row) {
                $mapped = [];

                foreach ($headerMap as $csvKey => $dbKey) {
                    $mapped[$dbKey] = $row[$csvKey] ?? null;
                }

                // Convert encodings where needed
                $mapped['last_name'] = $this->convertEncoding($mapped['last_name']);
                $mapped['first_name'] = $this->convertEncoding($mapped['first_name']);
                $mapped['middle_name'] = $this->convertEncoding($mapped['middle_name']);
                $mapped['ext_name'] = $this->convertEncoding($mapped['ext_name']);
                $mapped['barangay'] = $this->convertEncoding($mapped['barangay']);
                $mapped['municipality'] = $this->convertEncoding($mapped['municipality']);


                $mapped['birth_month'] = $mapped['birth_month'] ?? null;
                $mapped['birth_day'] = $mapped['birth_day'] ?? null;
                $mapped['birth_year'] = $mapped['birth_year'] ?? null;
                $mapped['sex'] = $mapped['sex'] ?? null;
                $mapped['prov_psgc'] = $mapped['prov_psgc'] ?? null;
                $mapped['city_psgc'] = $mapped['city_psgc'] ?? null;
                $mapped['barangay_psgc'] = $mapped['barangay_psgc'] ?? null;
                $mapped['contact_number'] = $mapped['contact_number'] ?? null;


                // Fill in default or optional fields
                $mapped['type_of_assistance'] = $row['type_of_assistance'] ?? null;
                $mapped['amount'] = $row['amount'] ?? null;
                $mapped['philsys_number'] = $row['philsys_number'] ?? null;
                $mapped['beneficiary_unique_id'] = $row['beneficiary_unique_id'] ?? null;
                $mapped['target_sector'] = $row['target_sector'] ?? null;
                $mapped['sub_category'] = $row['sub_category'] ?? null;
                $mapped['civil_status'] = $row['civil_status'] ?? null;


                $mapped['qr_number'] = null;
                $mapped['is_hired'] = 0;
                $mapped['w_listed'] = 0;
                $mapped['status'] = null;
                $mapped['validated_by'] = null;
                $mapped['ml_user'] = null;
                $mapped['bene_id'] = $mapped['bene_id'] ?? null;

                //dd($mapped);
                Beneficiary::create($mapped);


               $this->insertBene();
               // $this->inserthired();
                //$this->insertpresent();
                //$this->insertabsent();
               // $this->insertwlisted();
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

            $cleanMunicipality = preg_replace('/[(\/].*$/', '', $municipality->municipality);
            $cleanMunicipality = ucwords(strtolower(trim($cleanMunicipality)));


            $counting = Beneficiary::where('municipality', $municipality->municipality)->count();


                Aurora::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Bataan::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Bulacan::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Pampanga::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Nueva::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Tarlac::where('municipality', $cleanMunicipality)
                ->update(['bene' => $counting]);

                Zamb::where('municipality', $cleanMunicipality)
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

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('paid', 1)->count();


                Aurora::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['paid' => $counting]);
        }

        return response()->json(['message' => 'Successfully updated all hired']);
    }

    // public function insertpresent()
    // {

    //     $municipalities = Beneficiary::select('municipality')
    //         ->distinct()
    //         ->get();

    //   //  dd($municipalities);

    //     foreach ($municipalities as $municipality) {

    //         $counting = Beneficiary::where('municipality', $municipality->municipality)->where('status', "Present")->count();

    //         Aurora::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Bataan::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Bulacan::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Pampanga::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Nueva::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Tarlac::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);

    //         Zamb::where('municipality', $municipality->municipality)
    //         ->update(['present' => $counting]);
    //     }

    //     return response()->json(['message' => 'Successfully updated all present']);
    // }

    public function insertabsent()
    {

        $municipalities = Beneficiary::select('municipality')
            ->distinct()
            ->get();

      //  dd($municipalities);

        foreach ($municipalities as $municipality) {

            $counting = Beneficiary::where('municipality', $municipality->municipality)->where('status', null)->count();


                Aurora::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Bataan::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Bulacan::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Pampanga::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Nueva::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Tarlac::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);

                Zamb::where('municipality', $municipality->municipality)
                ->update(['unpaid' => $counting]);
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


        public function downloadTemplate()
        {
            $filePath = 'storage/csvfiles/template.csv';

            dd(Storage::exist($filePath));

            if (!Storage::exists($filePath)) {
                abort(404, 'Template file not found.');
            }



            return Storage::download($filePath);
        }



}













