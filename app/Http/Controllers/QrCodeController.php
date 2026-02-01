<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunRunQrSearchRequest;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\FunRunRegistration;
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


      //  $decrypted_qr = Crypt::decrypt($request->qr_number);

       $request->validate([
            'qr_number' => 'required|string',
        ]);

        $participants = FunRunRegistration::where('qr_number', $request->qr_number)->first();


        if (!$participants) {
            return response()->json([
                'error' => 'Participants not found!',
                'attendances' => Attendance::latest()->get(),
            ]);
        }
       
        $attendanceRecord = Attendance::where('dswd_id', $participants->dswd_id)->first();
      // dd($attendanceRecord);
        if ($attendanceRecord) {
            return response()->json([
                'error' => 'Oops!<br>' . $participants->first_name . ' ' . $participants->last_name .
                            ' was already log on ' . $attendanceRecord->time_in,
                'attendances' => Attendance::latest()->get(),
            ]);

        } else{

            try {
                DB::transaction(function () use ($participants, $request) {
                    $store = null; // default value
                    if ($request->imageCapture) {
                        $imageData = $request->imageCapture;
                        $filename = $request->qr_number;
                        $store = Storage::disk('public')->put('qr_images/' . $filename, $imageData);

                    }
                    Log::info('Log Image:', ['filename' => $store]);

                    Attendance::create([
                        'dswd_id' => $participants->dswd_id,
                        'first_name' => $participants->first_name,
                        'middle_name' => $participants->middle_name,
                        'last_name' => $participants->last_name,
                        'ext_name' => $participants->ext_name,
                        'division' => $participants->division,
                        'section' => $participants->section,
                        'sex' => $participants->sex,
                        'qr_number' => $request->qr_number,
                        'status' => 'Present',
                        'time_in' => now()->format('Y-m-d h:i A'),
                        'image' => $store ?? null,
                    ]);

                 
                   // Assistance::where('fam_id', $bene->fam_id)->update(['cost' => '5000', 'status' => 'Paid']);
                  //  FunRunRegistration::where('bene_id', $participants->dswd_id)->update(['status' => 'Present']);

                });


                return response()->json([
                    'message' => 'Successfully Identified!<br>Name: ' . $participants->first_name . ' ' .
                                 ($participants->middle_name ? $participants->middle_name . ' ' : '') .
                                 $participants->last_name . '<br>Division: ' . $participants->division,
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
