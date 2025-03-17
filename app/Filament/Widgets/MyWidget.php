<?php

namespace App\Filament\Widgets;

use App\Models\Assistance;
use App\Models\Attendance;
use App\Models\FamilyHead;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Beneficiary;
use App\Models\Bulacan;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class MyWidget extends Widget
{
    protected static string $view = 'filament.widgets.my-widget';

    protected int | string | array $columnSpan = 'full';



    public function render(): View
    {
        $aurorabene = Beneficiary::where('province', 'Aurora')->count();
        $amunicipality = Aurora::all();
        $aurorapresent = Beneficiary::where('province', 'Aurora')->where('status', 'Present')->count();
        $aurorahired = Beneficiary::where('province', 'Aurora')->where('is_hired', true)->count();
        // $aamount = Attendance::where('province', 'Aurora')->sum('amount');
        // $aformattedAmount = '₱ ' . number_format($aamount, 2);

        $bataanbene = Beneficiary::where('province', 'Bataan')->count();
        $bamunicipality = Bataan::all();
        $bataanpresent = Beneficiary::where('province', 'Bataan')->where('status', 'Present')->count();
        $bataanhired = Beneficiary::where('province', 'Bataan')->where('is_hired', true)->count();
        // $baamount = Attendance::where('province', 'Bataan')->sum('amount');
        // $baformattedAmount = '₱ ' . number_format($baamount, 2);

        $bulacanbene = Beneficiary::where('province', 'Bulacan')->count();
        $bumunicipality = Bulacan::all();
        $bulacanpresent = Beneficiary::where('province', 'Bulacan')->where('status', 'Present')->count();
        $bulacanhired = Beneficiary::where('province', 'Bulacan')->where('is_hired', true)->count();
        // $buamount = Attendance::where('province', 'Bulacan')->sum('amount');
        // $buformattedAmount = '₱ ' . number_format($buamount, 2);

        $nuevabene = Beneficiary::where('province', 'Nueva Ecija')->count();
        $nemunicipality = Nueva::all();
        $nuevapresent = Beneficiary::where('province', 'Nueva Ecija')->where('status', 'Present')->count();
        $nuevahired = Beneficiary::where('province', 'Nueva Ecija')->where('is_hired', true)->count();
        // $neamount = Attendance::where('province', 'Nueva Ecija')->sum('amount');
        // $neformattedAmount = '₱ ' . number_format($neamount, 2);

        $pampangabene = Beneficiary::where('province', 'Pampanga')->count();
        $pmunicipality = Pampanga::all();
        $pampangapresent = Beneficiary::where('province', 'Pampanga')->where('status', 'Present')->count();
        $pampangahired = Beneficiary::where('province', 'Pampanga')->where('is_hired', true)->count();

        // $paamount = Attendance::where('province', 'Pampanga')->sum('amount');
        // $paformattedAmount = '₱ ' . number_format($paamount, 2);

        $tarlacbene = Beneficiary::where('province', 'Tarlac')->count();
        $tmunicipality = Tarlac::all();
        $tarlacpresent = Beneficiary::where('province', 'Tarlac')->where('status', 'Present')->count();
        $tarlachired = Beneficiary::where('province', 'Tarlac')->where('is_hired', true)->count();
        // $taamount = Attendance::where('province', 'Tarlac')->sum('amount');
        // $taformattedAmount = '₱ ' . number_format($taamount, 2);

        $zambalesbene = Beneficiary::where('province', 'Zambales')->count();
        $zmunicipality = Zamb::all();
        $zambalespresent = Beneficiary::where('province', 'Zambales')->where('status', 'Present')->count();
        $zambaleshired = Beneficiary::where('province', 'Zambales')->where('is_hired', true)->count();
        // $zaamount = Attendance::where('province', 'Zambales')->sum('amount');
        // $zaformattedAmount = '₱ ' . number_format($zaamount, 2);


        $provinces = [

            ['name' => 'Aurora','municipality' => $amunicipality, 'absent' => number_format($aurorabene - $aurorapresent), 'present' => number_format($aurorapresent), 'hired' => number_format($aurorahired), 'bene' => number_format($aurorabene),], //'amount' => $aformattedAmount],
            ['name' => 'Bataan','municipality' => $bamunicipality, 'absent' => number_format($bataanbene - $bataanpresent), 'present' => number_format($bataanpresent), 'hired' => number_format($bataanhired), 'bene' => number_format($bataanbene),], //'amount' => $baformattedAmount],
            ['name' => 'Bulacan','municipality' => $bumunicipality, 'absent' => number_format($bulacanbene - $bulacanpresent), 'present' => number_format($bulacanpresent), 'hired' => number_format($bulacanhired), 'bene' => number_format($bulacanbene),], //'amount' => $buformattedAmount],
            ['name' => 'Nueva Ecija','municipality' => $nemunicipality, 'absent' => number_format($nuevabene - $nuevapresent), 'present' => number_format($nuevapresent), 'hired' => number_format($nuevahired), 'bene' => number_format($nuevabene),], //'amount' => $neformattedAmount],
            ['name' => 'Pampanga','municipality' => $pmunicipality, 'absent' => number_format($pampangabene - $pampangapresent), 'present' => number_format($pampangapresent), 'hired' => number_format($pampangahired), 'bene' => number_format($pampangabene),], //'amount' => $paformattedAmount],
            ['name' => 'Tarlac','municipality' => $tmunicipality, 'absent' => number_format($tarlacbene - $tarlacpresent), 'present' => number_format($tarlacpresent), 'hired' => number_format($tarlachired), 'bene' => number_format($tarlacbene),], //'amount' => $taformattedAmount],
            ['name' => 'Zambales','municipality' => $zmunicipality, 'absent' => number_format($zambalesbene - $zambalespresent), 'present' => number_format($zambalespresent), 'hired' => number_format($zambaleshired), 'bene' => number_format($zambalesbene),],// 'amount' => $zaformattedAmount],
        ];


        // $municipality =[ ['name' => 'baler', 'unpaid' => 255, 'paid' => 345]];

        return view('filament.widgets.my-widget', [
            'data' => $this->getData(),
            'provinces' => $provinces,

        ]);

    }

    protected function getData()
    {
        $amount = Attendance::sum('amount');
        $formattedAmount = '₱ ' . number_format($amount, 2);

        return [
            'bene_id' =>  number_format(Beneficiary::count()),
            'male' =>  number_format(Attendance::where('sex', 'Male')->count()),
            'female' =>  number_format(Attendance::where('sex', 'Female')->count()),
            'present' =>  number_format(Attendance::where('status', 'Present')->count()),
            'absent' =>  number_format(Beneficiary::where('status', null)->count()),
            'hired' =>  number_format(Beneficiary::where('is_hired', true)->count()),

           // 'amount' => $formattedAmount,

        ];

    }




}
