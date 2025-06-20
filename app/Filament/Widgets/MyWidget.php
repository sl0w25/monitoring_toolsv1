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

    protected static ?int $sort = 2;

    public function render(): View
    {
        $aurorabene = Beneficiary::where('province', 'LIKE', 'Aurora%')->count();
        $amunicipality = Aurora::all();
        $aurorapaid = Beneficiary::where('province', 'LIKE', 'Aurora%')->where('paid', true)->count();
        $auroraw_listed = Beneficiary::where('province', 'LIKE', 'Aurora%')->where('w_listed', true)->count();
        // $aamount = Attendance::where('province', 'Aurora')->sum('amount');
        // $aformattedAmount = '₱ ' . number_format($aamount, 2);

        $bataanbene = Beneficiary::where('province', 'LIKE' ,'Bataan%')->count();
        $bamunicipality = Bataan::all();
        $bataanpaid = Beneficiary::where('province', 'LIKE' ,'Bataan%')->where('paid', true)->count();
        $bataanw_listed = Beneficiary::where('province', 'LIKE' ,'Bataan%')->where('w_listed', true)->count();
        // $baamount = Attendance::where('province', 'Bataan')->sum('amount');
        // $baformattedAmount = '₱ ' . number_format($baamount, 2);

        $bulacanbene = Beneficiary::where('province','LIKE', 'Bulacan%')->count();
        $bumunicipality = Bulacan::all();
        $bulacanpaid = Beneficiary::where('province','LIKE', 'Bulacan%')->where('paid', true)->count();
        $bulacanw_listed = Beneficiary::where('province','LIKE', 'Bulacan%')->where('w_listed', true)->count();
        // $buamount = Attendance::where('province', 'Bulacan')->sum('amount');
        // $buformattedAmount = '₱ ' . number_format($buamount, 2);

        $nuevabene = Beneficiary::where('province','LIKE', 'Nueva Ecija%')->count();
        $nemunicipality = Nueva::all();
        $nuevapaid = Beneficiary::where('province','LIKE', 'Nueva Ecija%')->where('paid', true)->count();
        $nuevaw_listed = Beneficiary::where('province','LIKE', 'Nueva Ecija%')->where('w_listed', true)->count();
        // $neamount = Attendance::where('province', 'Nueva Ecija')->sum('amount');
        // $neformattedAmount = '₱ ' . number_format($neamount, 2);

        $pampangabene = Beneficiary::where('province','LIKE', 'Pampanga%')->count();
        $pmunicipality = Pampanga::all();
        $pampangapaid = Beneficiary::where('province','LIKE', 'Pampanga%')->where('paid', true)->count();
        $pampangaw_listed = Beneficiary::where('province','LIKE', 'Pampanga%')->where('w_listed', true)->count();

        // $paamount = Attendance::where('province', 'Pampanga')->sum('amount');
        // $paformattedAmount = '₱ ' . number_format($paamount, 2);

        $tarlacbene = Beneficiary::where('province','LIKE', 'Tarlac%')->count();
        $tmunicipality = Tarlac::all();
        $tarlacpaid = Beneficiary::where('province','LIKE', 'Tarlac%')->where('paid', true)->count();
        $tarlacw_listed = Beneficiary::where('province','LIKE', 'Tarlac%')->where('w_listed', true)->count();
        // $taamount = Attendance::where('province', 'Tarlac')->sum('amount');
        // $taformattedAmount = '₱ ' . number_format($taamount, 2);

        $zambalesbene = Beneficiary::where('province','LIKE', 'Zambales%')->count();
        $zmunicipality = Zamb::all();
        $zambalespaid = Beneficiary::where('province','LIKE', 'Zambales%')->where('paid', true)->count();
        $zambalesw_listed = Beneficiary::where('province','LIKE', 'Zambales%')->where('w_listed', true)->count();
        // $zaamount = Attendance::where('province', 'Zambales')->sum('amount');
        // $zaformattedAmount = '₱ ' . number_format($zaamount, 2);


        $provinces = [
            ['name' => 'Aurora','municipality' => $amunicipality, 'unpaid' => number_format($aurorabene - $aurorapaid),  'paid' => number_format($aurorapaid), 'w_listed' => number_format($auroraw_listed), 'bene' => number_format($aurorabene),], //'amount' => $aformattedAmount],
            ['name' => 'Bataan','municipality' => $bamunicipality, 'unpaid' => number_format($bataanbene - $bataanpaid),  'paid' => number_format($bataanpaid), 'w_listed' => number_format($bataanw_listed), 'bene' => number_format($bataanbene),], //'amount' => $baformattedAmount],
            ['name' => 'Bulacan','municipality' => $bumunicipality, 'unpaid' => number_format($bulacanbene - $bulacanpaid),  'paid' => number_format($bulacanpaid), 'w_listed' => number_format($bulacanw_listed), 'bene' => number_format($bulacanbene),], //'amount' => $buformattedAmount],
            ['name' => 'Nueva Ecija','municipality' => $nemunicipality, 'unpaid' => number_format($nuevabene - $nuevapaid),  'paid' => number_format($nuevapaid), 'w_listed' => number_format($nuevaw_listed), 'bene' => number_format($nuevabene),], //'amount' => $neformattedAmount],
            ['name' => 'Pampanga','municipality' => $pmunicipality, 'unpaid' => number_format($pampangabene - $pampangapaid),  'paid' => number_format($pampangapaid), 'w_listed' => number_format($pampangaw_listed), 'bene' => number_format($pampangabene),], //'amount' => $paformattedAmount],
            ['name' => 'Tarlac','municipality' => $tmunicipality, 'unpaid' => number_format($tarlacbene - $tarlacpaid),  'paid' => number_format($tarlacpaid), 'w_listed' => number_format($tarlacw_listed), 'bene' => number_format($tarlacbene),], //'amount' => $taformattedAmount],
            ['name' => 'Zambales','municipality' => $zmunicipality, 'unpaid' => number_format($zambalesbene - $zambalespaid),  'paid' => number_format($zambalespaid), 'w_listed' => number_format($zambalesw_listed), 'bene' => number_format($zambalesbene),],// 'amount' => $zaformattedAmount],
        ];

       // dd($provinces);
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
            //'male' =>  number_format(Attendance::where('sex', 'Male')->count()),
            //'female' =>  number_format(Attendance::where('sex', 'Female')->count()),
            'unpaid' =>  number_format(Beneficiary::where('paid', false)->count()),
            'paid' =>  number_format(Beneficiary::where('paid', true)->count()),
            'w_listed' =>  number_format(Beneficiary::where('w_listed', true)->count()),

           // 'amount' => $formattedAmount,

        ];

    }




}
