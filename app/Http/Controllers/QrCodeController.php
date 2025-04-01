<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Aurora;
use App\Models\Bataan;
use App\Models\Bulacan;
use App\Models\Nueva;
use App\Models\Pampanga;
use App\Models\Tarlac;
use App\Models\Zamb;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Beneficiary;
use App\Models\FamilyHead;
use App\Models\LocationInfo;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{


    public function index()
    {
        $attendances = Attendance::orderBy('created_at', 'desc')->paginate(9);
        return view('welcome', compact('attendances'));
    }


    public function store(Request $request)
    {

        Log::info('Incoming QR Scan Request:', $request->all());

        $request->validate([
            'qr_number' => 'required|string',
        ]);


      //  $decrypted_qr = Crypt::decrypt($request->qr_number);

        $bene = Beneficiary::where('qr_number', $request->qr_number)->first();


        if (!$bene) {
            return response()->json([
                'error' => 'Beneficiary not found!',
                'attendances' => Attendance::latest()->get(),
            ]);
        }

        $attendanceRecord = Attendance::where('bene_id', $bene->bene_id)->first();
      // dd($attendanceRecord);
        if ($attendanceRecord) {
            return response()->json([
                'error' => 'Oops!<br>' . $bene->first_name . ' ' . $bene->last_name .
                            ' was already log on ' . $attendanceRecord->time_in,
                'attendances' => Attendance::latest()->get(),
            ]);

        } else{

            try {

             //   dd($bene->province);

                DB::transaction(function () use ($bene, $request) {




                    if ($request->imageCapture) {
                        $imageData = $request->imageCapture;

                        $filename = $request->qr_number;


                     $store = Storage::disk('public')->put('qr_images/' . $filename, $imageData);

                    }

                    Log::info('Log Image:', ['filename' => $store]);


                    Attendance::create([
                        'bene_id' => $bene->bene_id,
                        'province' => $bene->province,
                        'municipality' => $bene->municipality,
                        'barangay' => $bene->barangay,
                        'first_name' => $bene->first_name,
                        'middle_name' => $bene->middle_name,
                        'last_name' => $bene->last_name,
                        'ext_name' => $bene->ext_name,
                        'sex' => $bene->sex,
                        'qr_number' => $request->qr_number,
                        'status' => 'Present',
                        'is_hired' => null,
                        'w_listed' => null,
                        'amount' => null,
                        'time_in' => now()->format('Y-m-d h:i A'),
                        'image' => $store,
                    ]);

                   // Assistance::where('fam_id', $bene->fam_id)->update(['cost' => '5000', 'status' => 'Paid']);
                    Beneficiary::where('bene_id', $bene->bene_id)->update(['status' => 'Present']);


                if ($bene->province == 'Aurora') {
                    Aurora::where('municipality', $bene->municipality)->increment('present');
                    Aurora::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Bulacan') {
                    Bulacan::where('municipality', $bene->municipality)->increment('present');
                    Bulacan::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Bataan') {
                    Bataan::where('municipality', $bene->municipality)->increment('present');
                    Bataan::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Nueva Ecija') {
                    Nueva::where('municipality', $bene->municipality)->increment('present');
                    Nueva::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Pampanga') {
                    Pampanga::where('municipality', $bene->municipality)->increment('present');
                    Pampanga::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Tarlac') {
                    Tarlac::where('municipality', $bene->municipality)->increment('present');
                    Tarlac::where('municipality', $bene->municipality)->decrement('absent');
                }
                if ($bene->province == 'Zambales') {
                    Zamb::where('municipality', $bene->municipality)->increment('present');
                    Zamb::where('municipality', $bene->municipality)->decrement('absent');
                }
                });


                return response()->json([
                    'message' => 'Successfully Identified!<br>Name: ' . $bene->first_name . ' ' .
                                 ($bene->middle_name ? $bene->middle_name . ' ' : '') .
                                 $bene->last_name . '<br>Barangay: ' . $bene->barangay,
                    'attendances' => Attendance::latest()->get(),
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Something went wrong! ' . $e->getMessage()], 500);
            }


    }

    }




    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance record removed successfully.');
    }
}
