<?php

namespace App\Filament\Pages;

use App\Models\LocationInfo;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\AccountInfo;
use App\Models\Assistance;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Bulacan;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use Doctrine\DBAL\Exception\InvalidColumnType\ColumnScaleRequired;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Datepicker;
use Filament\Forms\Components\Button;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EncodeForm extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static string $view = 'filament.pages.encode-form';

    protected static ?int $navigationSort = 1;

    public ?array $location = [];

    public ?array $fhead = [];

    public ?array $fmember = [];

    public ?array $faccount = [];

    public $selectedId = null;

    public $id;


    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->form->fill();
    }


    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('')
          ->description('Location Information')
            ->schema([
                Select::make('region')
                ->label('Region')
                ->required()
                ->options([
                            'III' => 'III',
                        ])
                        ->native(false),

                Select::make('province')
                ->label('Province')
                ->required()
                ->options([
                            'Aurora' => 'Aurora',
                        ])
                        ->native(false),

                Select::make('municipality')
                ->label('Municipality')
                ->required()
                ->options([
                            'Dipaculao' => 'Dipaculao',
                        ])
                        ->native(false),

                TextInput::make('district')
                ->label('District'),

                Select::make('barangay')
                ->label('Barangay')
                ->required()
                ->searchable()
                ->options([
                            'Bayabas' => 'Bayabas',
                            'Borlongan' => 'Borlongan',
                            'Buenavista' => 'Buenavista',
                            'Calaocan' => 'Calaocan',
                            'Diamanen' => 'Diamanen',
                            'Dianed' => 'Dianed',
                            'Diarabasin' => 'Diarabasin',
                            'Dibutunan' => 'Dibutunan',
                            'Dimabuno' => 'Dimabuno',
                            'Dinadiawan' => 'Dinadiawan',
                            'Ditale' => 'Ditale',
                            'Gupa' => 'Gupa',
                            'Ipil' => 'Ipil',
                            'Lipit' => 'Lipit',
                            'Lobbot' => 'Lobbot',
                            'Maligaya' => 'Maligaya',
                            'Mijares' => 'Mijares',
                            'Mucdol' => 'Mucdol',
                            'North Poblacion' => 'North Poblacion',
                            'Puangi' => 'Puangi',
                            'Salay' => 'Salay',
                            'Sapangkawayan' => 'Sapangkawayan',
                            'South Poblacion' => 'South Poblacion',
                            'Toytoyan' => 'Toytoyan',
                        ])
                        ->native(false),

                        Select::make('ec')
                        ->label('EC/Site')
                        ->required()
                        ->options([
                                    'yes' => 'yes',
                                    'no' => 'no',
                                ])
                                ->native(false),
                ])
                ->columns(3)
                ->statePath('location'),


                    Section::make('')
                     ->description('Family Head Information')
                    ->schema([
                        TextInput::make('last_name')
                        ->label('Last Name')
                        ->required(),

                        TextInput::make('first_name')
                        ->label('First Name')
                        ->required(),

                        TextInput::make('middle_name')
                        ->label('Middle Name')
                        ->required(),

                        TextInput::make('ext_name')
                        ->label('EXT Name'),

                        DatePicker::make('birthday')
                        ->label('Date of Birth')
                        ->required(),

                        TextInput::make('age')
                        ->label('Age')
                        //->disabled()
                        ->required(),

                        TextInput::make('birthplace')
                        ->label('Birth Place')
                        ->required(),

                        Select::make('gender')
                        ->label('Gender')
                        ->required()
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female'
                        ])->native(false),

                        Select::make('civil_status')
                        ->label('Civil Status')
                        ->required()
                        ->options([
                            'Single' => 'Single',
                            'Married' => 'Married',
                            'Separted' => 'Separted',
                            'Widowed' => 'Widowed',
                            'Common-Law' => 'Common-Law'
                        ])->native(false),

                        TextInput::make('mothers_maiden')
                        ->label('Mothers Maiden Name')
                        ->required(),

                        Select::make('religion')
                        ->label('Religion')
                        ->required()
                        ->options([
                            'Catholic' => 'Catholic',
                            'Born Again' => 'Born Again',
                            'INC' => 'INC',
                            'Christian' => 'Christian',
                            'Muslim' => 'Muslim',
                            'UFSCI' => 'UFSCI'
                        ])->native(false),

                        TextInput::make('occupation')
                        ->label('Occupation'),

                        TextInput::make('net_income')
                        ->label('Monthly Net Income')
                        ->type('number')
                        ->numeric(),

                        TextInput::make('id_card')
                        ->label('Id Card Presented'),

                        TextInput::make('id_number')
                        ->label('Id Number'),

                        TextInput::make('contact')
                        ->label('Contact Number')
                        ->required(),

                        TextInput::make('permanent_address')
                        ->label('Permanent Address')
                        ->required(),

                        Select::make('4ps')
                        ->label('4ps?')
                        ->required()
                        ->options([
                            'yes' => 'yes',
                            'no' => 'no'
                        ])->native(false),

                        Select::make('ips')
                        ->label('IP?')
                        //->required()
                        ->options([
                            'yes' => 'yes',
                            'no' => 'no'
                        ])->native(false),

                        TextInput::make('others')
                        ->label('Others'),

                    ])
                    ->columns(4)
                    ->statePath('fhead'),

                    Section::make('')
                    ->description('Account Information')
                   ->schema([

                    TextInput::make('bank')
                    ->label('Bank/E-Wallet'),


                    TextInput::make('account_name')
                    ->label('Account Name'),


                    TextInput::make('account_type')
                    ->label('Account Type'),


                    TextInput::make('account_number')
                    ->label('Account Number'),

                    Select::make('house_ownership')
                    ->label('House Ownership')
                    ->required()
                    ->options([
                        'Owner' => 'Owner',
                        'Renter' => 'Renter',
                        'Sharer' => 'Sharer'
                    ])->native(false),

                    Select::make('shelter')
                    ->label('Shelter Classification')
                    ->required()
                    ->options([
                        'N/A' => 'N/A',
                        'Partially Damaged' => 'Partially Damaged',
                        'Totally Damaged' => 'Totally Damaged',
                    ])->native(false),


                   ])
                   ->columns(3)
                   ->statePath('faccount'),


                   Section::make('Family Members')
                   ->description('Click "Add Family Members" to add more fields')
                //    ->hidden(fn ($get) => !$get('fam_id'))
                   ->schema([
                       Repeater::make('dynamic_fields')
                           ->label('')
                           ->schema([

                            TextInput::make('last_name')
                            ->label('Last Name')
                            ->required(),

                            TextInput::make('first_name')
                            ->label('First Name')
                            ->required(),

                            TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->required(),

                            TextInput::make('ext_name')
                            ->label('EXT Name'),

                            Select::make('relation')
                            ->label('Relation to Family Head')
                            ->required()
                            ->options([
                                'Father' => 'Father',
                                'Mother' => 'Mother',
                                'Son' => 'Son',
                                'Daughter' => 'Daughter',
                                'Spouse' => 'Spouse',
                                'Common-Law' => 'Common-Law',
                                'Grand-Son' => 'Grand-Daugher',
                                'Brother' => 'Brother',
                                'Sister' => 'Sister'
                            ])->native(false),

                            DatePicker::make('birthday')
                            ->label('Date of Birth')
                            ->required(),

                            TextInput::make('age')
                        ->label('Age')
                        //->disabled()
                        ->required(),

                        Select::make('gender')
                        ->label('Gender')
                        ->required()
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female'
                        ])->native(false),

                        TextInput::make('educational_attainment')
                        ->label('Highest Educational Attainment')
                        ->required(),

                        TextInput::make('occupation')
                        ->label('Occupation'),

                        TextInput::make('vulnerability_type')
                        ->label('Type of Vulnerability'),

                           ])->columns(4)
                             ->createItemButtonLabel('Add Family Members') // Label for the add button
                             ->defaultItems(0)

                   ])->statePath('fmember')

         ]);


    }


    protected function getFormActions(): array
{
    //ray('getFormActions called'); // Use `ray` for debugging or a basic `dd()` statement
    return [
          Action::make('save')
            ->label('Save')
            ->action('submit')

    ];
}


    public function submit()
    {
        $data = $this->form->getState();

        

        // Check if the 'id' key exists in the form state data
        if (isset($data[' id'])) {
            $fam_id = LocationInfo::updateOrCreate(
                ['id' => $data['id']], // Find the record by ID if provided
                [ // Otherwise create a new one with the provided location data
                    'region' => $data['location']['region'],
                    'province' => $data['location']['province'],
                    'municipality' => $data['location']['municipality'],
                    'district' => $data['location']['district'],
                    'barangay' => $data['location']['barangay'],
                    'ec' => $data['location']['ec'],
                ]
            );


          
        } else {
            
            // If 'id' doesn't exist, just create a new LocationInfo
            $fam_id = LocationInfo::create([
                'region' => $data['location']['region'],
                'province' => $data['location']['province'],
                'municipality' => $data['location']['municipality'],
                'district' => $data['location']['district'],
                'barangay' => $data['location']['barangay'],
                'ec' => $data['location']['ec'],
                
            ]);
            // if ($fam_id->province == 'Aurora') {

            //   //  DD($fam_id->province);
            //     Aurora::where('municipality', $fam_id->municipality)->update(['bene' => +1, 'unpaid' => +1]);
            // }

        


                    // Now create the FamilyHead with the generated or existing LocationInfo ID
        FamilyHead::create([
            'fam_id' => $fam_id->id, // Link FamilyHead to LocationInfo
            'province' => $data['location']['province'],
            'municipality' => $data['location']['municipality'],
            'barangay' => $data['location']['barangay'],
            'last_name' => $data['fhead']['last_name'],
            'first_name' => $data['fhead']['first_name'],
            'middle_name' => $data['fhead']['middle_name'],
            'ext_name' => $data['fhead']['ext_name'],
            'birthday' => $data['fhead']['birthday'],
            'age' => $data['fhead']['age'],
            'birthplace' => $data['fhead']['birthplace'],
            'gender' => $data['fhead']['gender'],
            'civil_status' => $data['fhead']['civil_status'],
            'mothers_maiden' => $data['fhead']['mothers_maiden'],
            'religion' => $data['fhead']['religion'],
            'occupation' => $data['fhead']['occupation'],
            'net_income' => $data['fhead']['net_income'],
            'id_card' => $data['fhead']['id_card'],
            'id_number' => $data['fhead']['id_number'],
            'contact' => $data['fhead']['contact'],
            'permanent_address' => $data['fhead']['permanent_address'],
            '4ps' => $data['fhead']['4ps'],
            'ips' => $data['fhead']['ips'],
            'others' => $data['fhead']['others'],
            'status' => 'Unpaid'
        ]);

        Assistance::create([
            'fam_id' => $fam_id->id,
            'status' => 'Unpaid',
        ]);



            AccountInfo::create([
                'fam_id' => $fam_id->id,
                'bank' => $data['faccount']['bank'],
                'account_name' => $data['faccount']['account_name'],
                'account_type' => $data['faccount']['account_type'],
                'account_number' => $data['faccount']['account_number'],
                'house_ownership' => $data['faccount']['house_ownership'],
                'shelter' => $data['faccount']['shelter'],
                'status' => 'Unpaid',
            ]);

       // Loop through repeater fields and save each rating entry
       foreach ($this->fmember['dynamic_fields'] as $field) {

       // dd($field);

        FamilyInfo::create([
            'fam_id' => $fam_id->id,
            'last_name' => $field['last_name'],
            'first_name' => $field['first_name'],
            'middle_name' => $field['middle_name'],
            'ext_name' => $field['ext_name'],
            'relation' => $field['relation'],
            'birthday' => $field['birthday'],
            'age' => $field['age'],
            'gender' => $field['gender'],
            'educational_attainment' => $field['educational_attainment'],
            'occupation' => $field['occupation'],
            'vulnerability_type' => $field['vulnerability_type'],
        ]);


        }


    }

            // Show success notification
            Notification::make()
            ->title('Saved successfully!')
            ->success()
            ->send();

            $this->reset();


    }



}

