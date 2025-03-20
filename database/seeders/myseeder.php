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

        // $aurora = [
        //     'Baler',
        //     'Casiguran',
        //     'Dilasag',
        //     'Dinalungan',
        //     'Dingalan',
        //     'Dipaculao',
        //     'Maria Aurora',
        //     'San Luis',
        // ];

        // foreach ($aurora as $auroras) {
        //     Aurora::create([
        //         'municipality' => $auroras,
        //         'unpaid' => '',
        //         'paid' => '',
        //         'bene' => ''
        //     ]);
        // }

        // $bataan = [
        //     'Abucay',
        //     'Dinalupihan',
        //     'Hermosa',
        //     'Morong',
        //     'Orani',
        //     'Samal',
        //     'Bagac',
        //     'Balanga City',
        //     'Limay',
        //     'Mariveles',
        //     'Orion',
        //     'Pilar'
        // ];

        // foreach ($bataan as $bataans) {
        //     Bataan::create([
        //         'municipality' => $bataans,
        //     ]);
        // }


        // $bulacan = [
        //     'Bulacan',
        //     'Calumpit',
        //     'City of Malolos',
        //     'Hagonoy',
        //     'Paombong',
        //     'Pulilan',
        //     'Balagtas',
        //     'Baliuag',
        //     'Bocaue',
        //     'Bustos',
        //     'Guiguinto',
        //     'Pandi',
        //     'Plaridel',
        //     'Angat',
        //     'DRT',
        //     'Norzagaray',
        //     'San Ildefonso',
        //     'San Miguel',
        //     'San Rafael',
        //     'Marilao',
        //     'City of Meycauayan',
        //     'Obando',
        //     'Sta. Maria',
        //     'San Jose',
        //     'Angat'
        // ];

        // foreach ($bulacan as $bulacans) {
        //     Bulacan::create([
        //         'municipality' => $bulacans,
        //     ]);
        // }


        // $nueva = [
        //     'Aliaga',
        //     'Cuyapo',
        //     'Guimba',
        //     'Licap',
        //     'Nampicuan',
        //     'Quezon',
        //     'Sto. Domingo',
        //     'Talavera',
        //     'Zaragoza',
        //     'Carranglan',
        //     'Llanera',
        //     'Lupao',
        //     'Pantabangan',
        //     'Rizal',
        //     'San Jose City',
        //     'Science City of Muñoz',
        //     'Talugtug',
        //     'Cabanatuan City',
        //     'Palayan City',
        //     'Bongabon',
        //     'Gabaldon',
        //     'Gen. Natividad',
        //     'Laur',
        //     'Sta. Rosa',
        //     'Cabiao',
        //     'Gapan City',
        //     'Gen. Tiño',
        //     'Jaen',
        //     'Peñaranda',
        //     'San Antonio',
        //     'San Isidro',
        //     'San Leonardo'
        // ];

        // foreach ($nueva as $nuevas) {
        //     Nueva::create([
        //         'municipality' => $nuevas,
        //     ]);
        // }

        // $pampanga = [
        //     'Angeles City',
        //     'Mabalacat',
        //     'Magalang',
        //     'Florida Blanca',
        //     'Guagua',
        //     'Lubao',
        //     'Porac',
        //     'Santa Rita',
        //     'Sasmuan',
        //     'Arayat',
        //     'Bacolor',
        //     'City of San Fernando',
        //     'Mexico',
        //     'Sta. Ana',
        //     'Apalit',
        //     'Candaba',
        //     'Macabebe',
        //     'Masantol',
        //     'Minalin',
        //     'San Luis',
        //     'San Simon',
        //     'Sto. Tomas'
        // ];

        // foreach ($pampanga as $pampangas) {
        //     Pampanga::create([
        //         'municipality' => $pampangas,
        //     ]);
        // }


        // $tarlac = [
        //     'Anao',
        //     'Camiling',
        //     'Mayantoc',
        //     'Moncada',
        //     'Paniqui',
        //     'Pura',
        //     'Ramos',
        //     'San Clemente',
        //     'San Miguel',
        //     'Sta. Ignacia',
        //     'City of Tarlac',
        //     'Gerona',
        //     'San Jose',
        //     'Victoria',
        //     'Bamban',
        //     'Capas',
        //     'Concepcion',
        //     'La Paz'
        // ];

        // foreach ($tarlac as $tarlacs) {
        //     Tarlac::create([
        //         'municipality' => $tarlacs,
        //     ]);
        // }

        // $zambales = [
        //     'Castillejos',
        //     'Olongapo City',
        //     'San Marcelino',
        //     'Subic',
        //     'Botolan',
        //     'Cabangan',
        //     'Candelaria',
        //     'Iba',
        //     'Masinloc',
        //     'Palauig',
        //     'San Antonio',
        //     'San Felipe',
        //     'San Narciso',
        //     'Sta. Cruz'
        // ];

        // foreach ($zambales as $zambaless) {
        //     Zamb::create([
        //         'municipality' => $zambaless,
        //     ]);
        // }

        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'ect@dswd.gov.ph',
        //     'is_admin' => true
        // ]);

    }
}
