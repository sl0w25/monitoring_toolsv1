<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Bulacan;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use App\Models\User;

class myseeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // User::factory(10)->create();

        $aurora = [
            'Baler/37701000',
            'Casiguran/37702000',
            'Dilasag/37703000',
            'Dinalungan/37704000',
            'Dingalan/37705000',
            'Dipaculao/37706000',
            'Maria Aurora/37707000',
            'San Luis/37708000',
        ];


            foreach ($aurora as $auroras) {
                Aurora::create([
                    'municipality' => preg_replace('/\/.*/', '', $auroras),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }

        $bataan = [
            'Abucay/300801000',
            'Dinalupihan/030804000',
            'Hermosa/030805000',
            'Morong/030808000',
            'Orani/030809000',
            'Samal/030812000',
            'Bagac/030802000',
            'City of Balanga (Capital)/030803000',
            'Limay/030806000',
            'Mariveles/030807000',
            'Orion/030810000',
            'Pilar/030811000'
        ];

            foreach ($bataan as $bataans) {
                Bataan::create([
                    'municipality' => preg_replace('/\/.*/', '', $bataans),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }


        $bulacan = [
            'Bulacan/031405000',
            'Calumpit/031407000',
            'City of Malolos/031410000',
            'Hagonoy/031409000',
            'Paombong/031416000',
            'Pulilan/031418000',
            'Balagtas/031402000',
            'Baliuag/031403000',
            'Bocaue/031404000',
            'Bustos/031406000',
            'Guiguinto/031408000',
            'Pandi/031415000',
            'Plaridel/031417000',
            'Angat/031401000',
            'DRT/031424000',
            'Norzagaray/031413000',
            'San Ildefonso/031419000',
            'San Miguel/031421000',
            'San Rafael/031422000',
            'Marilao/031411000',
            'City of Meycauayan/031412000',
            'Obando/031414000',
            'Sta. Maria/031423000',
            'San Jose/031420000',
            'Angat/031401000'
        ];

            foreach ($bulacan as $bulacans) {
                Bulacan::create([
                    'municipality' => preg_replace('/\/.*/', '', $bulacans),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }


        $nueva = [
            'Aliaga/034901000',
            'Cuyapo/034906000',
            'Guimba/034911000',
            'Licap/034914000',
            'Nampicuan/034918000',
            'Quezon/034922000',
            'Sto. Domingo/034929000',
            'Talavera/034930000',
            'Zaragoza/034932000',
            'Carranglan/034905000',
            'Llanera/034915000',
            'Lupao/034916000',
            'Pantabangan/034920000',
            'Rizal/034923000',
            'San Jose City/034926000',
            'Science City of Muñoz/034917000',
            'Talugtug/034931000',
            'Cabanatuan City/034903000',
            'Palayan City/034919000',
            'Bongabon/034902000',
            'Gabaldon/034907000',
            'Gen. Natividad/034909000',
            'Laur/034913000',
            'Sta. Rosa/034928000',
            'Cabiao/034904000',
            'Gapan City/034908000',
            'Gen. Tiño/034910000',
            'Jaen/034912000',
            'Peñaranda/034921000',
            'San Antonio/034924000',
            'San Isidro/034925000',
            'San Leonardo/034927000'
        ];

            foreach ($nueva as $nuevas) {
                Nueva::create([
                    'municipality' => preg_replace('/\/.*/', '', $nuevas),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }

        $pampanga = [
            'Angeles City',
            'Mabalacat/035409000',
            'Magalang/035411000',
            'Florida Blanca/035406000',
            'Guagua/035407000',
            'Lubao/035408000',
            'Porac/035415000',
            'Santa Rita/035420000',
            'Sasmuan/035422000',
            'Arayat/035403000',
            'Bacolor/035404000',
            'City of San Fernando/035416000',
            'Mexico/035413000',
            'Sta. Ana/035419000',
            'Apalit/035402000',
            'Candaba/035405000',
            'Macabebe/035410000',
            'Masantol/035412000',
            'Minalin/035414000',
            'San Luis/035417000',
            'San Simon/035418000',
            'Sto. Tomas/035421000'
        ];

            foreach ($pampanga as $pampangas) {
                Pampanga::create([
                    'municipality' => preg_replace('/\/.*/', '', $pampangas),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }


        $tarlac = [
            'Anao/036901000',
            'Camiling/036903000',
            'Mayantoc/036908000',
            'Moncada/036909000',
            'Paniqui/036910000',
            'Pura/036911000',
            'Ramos/036912000',
            'San Clemente/036913000',
            'San Miguel/036914000',
            'Sta. Ignacia/036915000	',
            'City of Tarlac/036916000',
            'Gerona/036906000',
            'San Jose/036918000',
            'Victoria/036917000',
            'Bamban/036902000',
            'Capas/036904000',
            'Concepcion/036905000',
            'La Paz/036907000'
        ];

            foreach ($tarlac as $tarlacs) {
                Tarlac::create([
                    'municipality' => preg_replace('/\/.*/', '', $tarlacs),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }

        $zambales = [
            'Castillejos/037104000',
            'Olongapo City/037107000',
            'San Marcelino/037111000',
            'Subic/037114000',
            'Botolan/037101000',
            'Cabangan/037102000',
            'Candelaria/037103000',
            'Iba/037105000',
            'Masinloc/037106000',
            'Palauig/037108000',
            'San Antonio/037109000',
            'San Felipe/037110000	',
            'San Narciso/037112000',
            'Sta. Cruz/037113000'
        ];

            foreach ($zambales as $zambaless) {
                Zamb::create([
                    'municipality' => preg_replace('/\/.*/', '', $zambaless),
                    'paid' => 0,
                    'unpaid' => 0,
                    'w_listed' => 0,
                    'bene' => 0
                ]);
            }

        User::factory()->create([
            'name' => 'Admin User',
            'employee_id' => '03-11310',
            'password' => bcrypt('dswd12345'),
            'email' => 'drims@dswd.gov.ph',
            'region' => 'Region III',
            'province' => 'Pampanga',
            'municipality' => 'City of San Fernando',
            'barangay' => 'Maimpis',
            'psgc' => '035101001',
            'contact' => '09055251852',
            'is_approved' => true,
            'is_lgu' => true,
            'office' => 'DSWD Field Office III',
            'is_admin' => true
        ]);

    }






























    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     $aurora = [
    //         'Baler/37701000',
    //         'Casiguran/37702000',
    //         'Dilasag/37703000',
    //         'Dinalungan/37704000',
    //         'Dingalan/37705000',
    //         'Dipaculao/37706000',
    //         'Maria Aurora/37707000',
    //         'San Luis/37708000',
    //     ];


    //     foreach ($aurora as $auroras) {
    //         Aurora::create([
    //             'municipality' => $auroras,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }

    //     $bataan = [
    //         'Abucay/300801000',
    //         'Dinalupihan/030804000',
    //         'Hermosa/030805000',
    //         'Morong/030808000',
    //         'Orani/030809000',
    //         'Samal/030812000',
    //         'Bagac/030802000',
    //         'City of Balanga (Capital)/030803000',
    //         'Limay/030806000',
    //         'Mariveles/030807000',
    //         'Orion/030810000',
    //         'Pilar/030811000'
    //     ];

    //     foreach ($bataan as $bataans) {
    //         Bataan::create([
    //             'municipality' => $bataans,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }


    //     $bulacan = [
    //         'Bulacan/031405000',
    //         'Calumpit/031407000',
    //         'City of Malolos/031410000',
    //         'Hagonoy/031409000',
    //         'Paombong/031416000',
    //         'Pulilan/031418000',
    //         'Balagtas/031402000',
    //         'Baliuag/031403000',
    //         'Bocaue/031404000',
    //         'Bustos/031406000',
    //         'Guiguinto/031408000',
    //         'Pandi/031415000',
    //         'Plaridel/031417000',
    //         'Angat/031401000',
    //         'DRT/031424000',
    //         'Norzagaray/031413000',
    //         'San Ildefonso/031419000',
    //         'San Miguel/031421000',
    //         'San Rafael/031422000',
    //         'Marilao/031411000',
    //         'City of Meycauayan/031412000',
    //         'Obando/031414000',
    //         'Sta. Maria/031423000',
    //         'San Jose/031420000',
    //         'Angat/031401000'
    //     ];

    //     foreach ($bulacan as $bulacans) {
    //         Bulacan::create([
    //             'municipality' => $bulacans,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }


    //     $nueva = [
    //         'Aliaga/034901000',
    //         'Cuyapo/034906000',
    //         'Guimba/034911000',
    //         'Licap/034914000',
    //         'Nampicuan/034918000',
    //         'Quezon/034922000',
    //         'Sto. Domingo/034929000',
    //         'Talavera/034930000',
    //         'Zaragoza/034932000',
    //         'Carranglan/034905000',
    //         'Llanera/034915000',
    //         'Lupao/034916000',
    //         'Pantabangan/034920000',
    //         'Rizal/034923000',
    //         'San Jose City/034926000',
    //         'Science City of Muñoz/034917000',
    //         'Talugtug/034931000',
    //         'Cabanatuan City/034903000',
    //         'Palayan City/034919000',
    //         'Bongabon/034902000',
    //         'Gabaldon/034907000',
    //         'Gen. Natividad/034909000',
    //         'Laur/034913000',
    //         'Sta. Rosa/034928000',
    //         'Cabiao/034904000',
    //         'Gapan City/034908000',
    //         'Gen. Tiño/034910000',
    //         'Jaen/034912000',
    //         'Peñaranda/034921000',
    //         'San Antonio/034924000',
    //         'San Isidro/034925000',
    //         'San Leonardo/034927000'
    //     ];

    //     foreach ($nueva as $nuevas) {
    //         Nueva::create([
    //             'municipality' => $nuevas,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }

    //     $pampanga = [
    //         'Angeles City',
    //         'Mabalacat/035409000',
    //         'Magalang/035411000',
    //         'Florida Blanca/035406000',
    //         'Guagua/035407000',
    //         'Lubao/035408000',
    //         'Porac/035415000',
    //         'Santa Rita/035420000',
    //         'Sasmuan/035422000',
    //         'Arayat/035403000',
    //         'Bacolor/035404000',
    //         'City of San Fernando/035416000',
    //         'Mexico/035413000',
    //         'Sta. Ana/035419000',
    //         'Apalit/035402000',
    //         'Candaba/035405000',
    //         'Macabebe/035410000',
    //         'Masantol/035412000',
    //         'Minalin/035414000',
    //         'San Luis/035417000',
    //         'San Simon/035418000',
    //         'Sto. Tomas/035421000'
    //     ];

    //     foreach ($pampanga as $pampangas) {
    //         Pampanga::create([
    //             'municipality' => $pampangas,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }


    //     $tarlac = [
    //         'Anao/036901000',
    //         'Camiling/036903000',
    //         'Mayantoc/036908000',
    //         'Moncada/036909000',
    //         'Paniqui/036910000',
    //         'Pura/036911000',
    //         'Ramos/036912000',
    //         'San Clemente/036913000',
    //         'San Miguel/036914000',
    //         'Sta. Ignacia/036915000	',
    //         'City of Tarlac/036916000',
    //         'Gerona/036906000',
    //         'San Jose/036918000',
    //         'Victoria/036917000',
    //         'Bamban/036902000',
    //         'Capas/036904000',
    //         'Concepcion/036905000',
    //         'La Paz/036907000'
    //     ];

    //     foreach ($tarlac as $tarlacs) {
    //         Tarlac::create([
    //             'municipality' => $tarlacs,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }

    //     $zambales = [
    //         'Castillejos/037104000',
    //         'Olongapo City/037107000',
    //         'San Marcelino/037111000',
    //         'Subic/037114000',
    //         'Botolan/037101000',
    //         'Cabangan/037102000',
    //         'Candelaria/037103000',
    //         'Iba/037105000',
    //         'Masinloc/037106000',
    //         'Palauig/037108000',
    //         'San Antonio/037109000',
    //         'San Felipe/037110000	',
    //         'San Narciso/037112000',
    //         'Sta. Cruz/037113000'
    //     ];

    //     foreach ($zambales as $zambaless) {
    //         Zamb::create([
    //             'municipality' => $zambaless,
    //             'paid' => 0,
    //             'unpaid' => 0,
    //             'w_listed' => 0,
    //             'bene' => 0
    //         ]);
    //     }

    //     User::factory()->create([
    //         'name' => 'Admin User',
    //         'employee_id' => '03-11310',
    //         'password' => bcrypt('dswd12345'),
    //         'email' => 'drims@dswd.gov.ph',
    //         'region' => 'Region III',
    //         'province' => 'Pampanga',
    //         'municipality' => 'City of San Fernando',
    //         'barangay' => 'Maimpis',
    //         'psgc' => '035101001',
    //         'contact' => '09055251852',
    //         'is_approved' => true,
    //         'is_lgu' => true,
    //         'office' => 'DSWD Field Office III',
    //         'is_admin' => true
    //     ]);

    // }
}
