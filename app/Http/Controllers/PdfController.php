<?php

namespace App\Http\Controllers;


use App\Models\Assistance;
use App\Models\Beneficiary;
use App\Models\FamilyHead;
use App\Models\FamilyInfo;
use App\Models\LocationInfo;
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
