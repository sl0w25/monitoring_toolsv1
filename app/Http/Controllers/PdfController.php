<?php

namespace App\Http\Controllers;


use App\Models\Assistance;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Beneficiary;
use App\Models\Bulacan;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\LocationInfo;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PdfController extends Controller
{
    public function print($id)
    {
        $location = Beneficiary::findOrFail($id);
      //  $head = FamilyHead::findOrFail($id);
        $familyhead = Beneficiary::where('bene_id', $location->id)->get();

        do {
            $qr_number = mt_rand(1111111111, 9999999999);
          //  $encrypted_qr = Crypt::encrypt($qr_number); // Encrypt the QR number
        } while (Beneficiary::where('qr_number', $qr_number)->exists());

             $existingFamilyHead = Beneficiary::where('bene_id', $id)
             ->whereNull('qr_number')
             ->orwhere('qr_number', $qr_number)
             ->first();


             if ($existingFamilyHead) {

                Beneficiary::updateOrCreate(
                    ['bene_id' => $id],
                    ['qr_number' => $qr_number]
                );

       $data = [
           'location' => $location,
       ];

       $pdf = Pdf::loadView('filament.pages.faced-form', $data);
      // ->setPaper([0, 0, 85.60, 54.00], 'portrait');

       return response($pdf->output(), 200, [
           'Content-Type' => 'application/pdf',
           'Content-Disposition' => 'inline; filename="faced_id_' . $location->id . '.pdf"',
       ]);

             }else {


                $data = [
                    'location' => $location,
                ];


                $pdf = Pdf::loadView('filament.pages.faced-form', $data);
              //  ->setPaper([0, 0, 85.60, 54.00], 'portrait');

                return response($pdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="faced_id_' . $location->id . '.pdf"',
                ]);
    }

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

        return response()->json(['message' => 'QR numbers generated successfully for all Family Heads.']);
    }




    public function downloadAll()

    {
                $locations = Beneficiary::all();
                ini_set('max_execution_time', 1600);


                $pdfFolder = storage_path('app/temp_pdfs');
                if (!is_dir($pdfFolder)) {
                    mkdir($pdfFolder, 0777, true);
                }

                $zipPath = storage_path('app/generated_pdfs.zip');
                $zip = new ZipArchive;

                if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    foreach ($locations as $location) {
                        $head = Beneficiary::findOrFail($location->id);


                        $data = [
                            'location' => $location,
                        ];


                        $pdf = Pdf::loadView('filament.pages.faced-form', $data)
                            ->setPaper([0, 0, 85.60, 54.00], 'portrait');


                        $pdfPath = $pdfFolder . "/faced_id_{$location->id}.pdf";
                        file_put_contents($pdfPath, $pdf->output());


                        $zip->addFile($pdfPath, "4ps_Bene_QR_{$location->id}.pdf");
                    }


                    $zip->close();


                    foreach (glob($pdfFolder . '/*.pdf') as $file) {
                        unlink($file);
                    }
                    rmdir($pdfFolder);


                    return response()->download($zipPath)->deleteFileAfterSend(true);

                } else {

                    return response()->json(['error' => 'Unable to create ZIP file'], 500);

                }
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


}


























    // public function validateQr(Request $request)
    // {
    //     $scannedData = $request->input('qr_data'); // Scanned QR code data

    //     // Decode the JSON from the QR code
    //     $decodedData = json_decode($scannedData, true);

    //     // Validation logic
    //     if (!$decodedData || !isset($decodedData['id'], $decodedData['fam_id'], $decodedData['timestamp'])) {
    //         return response()->json(['message' => 'Invalid QR code data.'], 400);
    //     }

    //     // Verify the data matches the expected values
    //     $location = LocationInfo::find($decodedData['id']);
    //     if (!$location || $location->fam_id !== $decodedData['fam_id']) {
    //         return response()->json(['message' => 'QR code validation failed.'], 400);
    //     }

    //     return response()->json(['message' => 'QR code is valid.', 'data' => $decodedData], 200);
    // }

//     <!-- @if ($qrPath)
//     <img src="{{ storage_path('app/' . $qrPath) }}" alt="QR Code">
// @else -->
