<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunRunQrSearchRequest;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\FunRunRegistration;
use App\Models\AllowedDevice;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    /* ================= INDEX ================= */

    public function index()
    {
        $attendances = Attendance::orderBy('created_at', 'desc')->paginate(9);

        return view('welcome', compact('attendances'));
    }

    public function maintenance_page()
    {
        return view('under_maintenance');
    }

    /* ================= LIST ================= */

    public function list()
    {
        $attendances = Attendance::orderBy('created_at', 'desc')->paginate(9);

        return response()->json([
            'attendances' => [
                'total' => $attendances->total(),
                'per_page' => $attendances->perPage(),
                'current_page' => $attendances->currentPage(),
                'data' => $attendances->items(),
                'links' => (string) $attendances->links(),
            ]
        ]);
    }

    /* ================= STORE (QR SCAN) ================= */

    public function store(Request $request)
    {
        Log::info('Incoming QR Scan:', $request->all());

        $request->validate([
            'qr_number' => 'required|string',
        ]);

        /* ================= SEARCH VIA HASH ================= */

        $qrHash = hash('sha256', $request->qr_number);

        $participant = FunRunRegistration::where(
            'qr_number_hash',
            $qrHash
        )->first();

        if (!$participant) {
            return response()->json([
                'error' => 'Participant not found!',
                'attendances' => Attendance::latest()->get(),
            ]);
        }

        /* ================= DECRYPT DATA ================= */

        $this->decryptParticipant($participant);

        /* ================= CHECK ATTENDANCE ================= */

        $exists = Attendance::where(
            'dswd_id',
            $participant->dswd_id
        )->exists();

        $timeIn = Attendance::where(
            'dswd_id',
            $participant->dswd_id
        )->value('time_in');

        if ($exists) {
            return response()->json([
                'error' =>
                    'Oops!<br>' .
                    $participant->first_name . ' ' .
                    $participant->last_name .
                    ' was already logged at ' . $timeIn,

                'attendances' => Attendance::latest()->get(),
            ]);
        }

        /* ================= SAVE ATTENDANCE ================= */

        try {

            DB::transaction(function () use ($participant, $request) {

                /* ===== IMAGE CAPTURE ===== */

                if ($request->imageCapture) {

                    $image = preg_replace(
                        '#^data:image/\w+;base64,#i',
                        '',
                        $request->imageCapture
                    );

                    $image = base64_decode($image);

                    $filename =
                        $request->qr_number .
                        '_' .
                        time() .
                        '.png';

                    Storage::disk('public')
                        ->put('qr_images/' . $filename, $image);

                    $imagePath = 'qr_images/' . $filename;

                } else {
                    $imagePath = null;
                }

                Log::info('Log Image:', ['file' => $imagePath]);

                /* ===== CREATE ATTENDANCE ===== */

                Attendance::create([

                    'dswd_id' => $participant->dswd_id,

                    'first_name' => $participant->first_name,
                    'middle_name' => $participant->middle_name,
                    'last_name' => $participant->last_name,
                    'ext_name' => $participant->ext_name,

                    'division' => $participant->division,
                    'section' => $participant->section,

                    'sex' => $participant->sex,

                    'qr_number' => $request->qr_number,

                    'status' => 'Present',

                    'race_category' => $participant->race_category,

                    'time_in' => now()->format('h:i A'),

                    'image' => $imagePath,
                ]);
            });

            return response()->json([

                'message' =>
                    'Successfully Identified!<br>' .
                    'Name: ' .
                    $participant->first_name . ' ' .
                    ($participant->middle_name
                        ? $participant->middle_name . ' '
                        : '') .
                    $participant->last_name .
                    '<br>Division: ' .
                    $participant->division,

                'attendances' => Attendance::latest()->get(),
            ]);

        } catch (\Exception $e) {

            Log::error('QR Error:', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /* ================= DELETE ================= */

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();

        return back()->with('success', 'Attendance removed.');
    }

    /* ================= HELPER ================= */

    private function decryptParticipant($participant)
    {
        $fields = [
            'dswd_id',
            'first_name',
            'middle_name',
            'last_name',
            'ext_name',
            'division',
            'section',
            'contact_number',
            'sex',
            'emergency_contact_name',
            'emergency_contact_number',
            'race_category',
            'qr_number',
        ];

        foreach ($fields as $field) {

            if (!empty($participant->$field)) {

                try {
                    $participant->$field =
                        Crypt::decryptString($participant->$field);
                } catch (\Exception $e) {
                    // Prevent crash if already decrypted
                }
            }
        }
    }
}
