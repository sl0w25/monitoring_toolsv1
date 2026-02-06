<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunRunQrSearchRequest;
use App\Http\Requests\FunRunRegistrationRequest;
use App\Models\FunRunRegistration;
use Illuminate\Support\Facades\Storage;
 use Milon\Barcode\DNS2D;
 use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FunRunRegistrationController extends Controller
{
    public function create()
    {

        return view('fun_run_registration');

    }

    public function waiver()
    {

          $filePath = public_path('storage/templates/waiver_template.pdf');

            if (!file_exists($filePath)) {
                abort(404, 'Form not found.');
            }

            return response()->download($filePath, 'Health_Consent_Form.pdf');

    }

        public function show(FunRunRegistration $registration)
        {
               $registrationId = session('registration_id');
            if (!$registrationId) {
                abort(403, 'Unauthorized access.');
            }

            $registration = FunRunRegistration::findOrFail($registrationId);

            $raceCategories = [
                "5km_20_35" => "5 km – 20 to 35 years old",
                "5km_36_above" => "5 km – 36 years old and above",
                "3km_20_35" => "3 km – 20 to 35 years old",
                "3km_36_above" => "3 km – 36 years old and above",
            ];

            $registration->race_category_label = $raceCategories[$registration->race_category] ?? $registration->race_category;

            $dns2d = new DNS2D();
            $qrSvg = $dns2d->getBarcodeSVG($registration->qr_number, 'QRCODE', 10, 10);

            session(['registration_id' => $registration->id]);
            return view('fun_run_success', compact('registration', 'qrSvg'));
        }


        public function store(FunRunRegistrationRequest $request)
        {
            $data = $request->validated();

               if (FunRunRegistration::where('dswd_id', $data['dswd_id'])->exists()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['dswd_id' => 'This DSWD ID is already registered.']);
               }

            do {
                $qrNumber = (string) mt_rand(1000000000, 9999999999);
            } while (FunRunRegistration::where('qr_number', $qrNumber)->exists());

             $data['qr_number'] = (string) $qrNumber;


            if ($request->hasFile('health_consent_form')) {
                $data['health_consent_form'] = $request->file('health_consent_form')
                    ->store('health_forms', 'public');
            }

            $registration = FunRunRegistration::create($data);

            session(['registration_id' => $registration->id]);

            return redirect()->route('fun-run.success');

        }

        public function showQrForm()
        {
            return view('fun_run_search'); // show search form
        }

        public function searchQr(FunRunQrSearchRequest $request)
        {
            $registration = FunRunRegistration::where('dswd_id', $request->dswd_id)->first();

            if (!$registration) {
                return redirect()->back()
                    ->withErrors(['dswd_id' => 'DSWD ID not found. Please Register first!'])
                    ->withInput();
            }

            return view('fun_run_search', compact('registration'));
        }



        // public function downloadPdf(FunRunRegistration $registration)
        // {

        //     $dns2d = new DNS2D();
        //     $qrSvg = $dns2d->getBarcodeSVG($registration->qr_number, 'QRCODE');

        //     $pdf = Pdf::loadView('fun_run_print', compact('registration', 'qrSvg'))
        //         ->setPaper([0, 0, 153, 242], 'portrait');


        //     return $pdf->download("FunRun_{$registration->first_name}_{$registration->last_name}.pdf");
        // }

        public function printImage()
        {
            $registrationId = session('registration_id');

            if (!$registrationId) {
                abort(403, 'Unauthorized access.');
            }

            $registration = FunRunRegistration::findOrFail($registrationId);

            $dns2d = new DNS2D();

            // Generate QR (Base64 PNG)
            $qrBase64 = $dns2d->getBarcodePNG(
                $registration->qr_number,
                'QRCODE',
                6,
                6
            );

            // Image Manager
            $manager = new ImageManager(new Driver());
            $img = $manager->read(public_path('storage/templates/qr_template.png'));
            $qrImage = $manager->read(base64_decode($qrBase64));
            $qrImage->resize(1000, 1000);
            $img->place($qrImage, 'top-center', 0, 440);

            // Add Name
            $img->text(
                strtoupper($registration->first_name . ' ' . $registration->last_name),
                $img->width() / 2,
                1550,
                function ($font) {
                    $font->file(public_path('fonts/Roboto-Regular.ttf'));
                    $font->size(60);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('bottom');
                }
            );

            return response($img->toPng())
                ->header('Content-Type', 'image/png')
                ->header(
                    'Content-Disposition',
                    'attachment; filename="75th_Anniv_' .
                    $registration->first_name . '_' .
                    $registration->last_name . '.png"'
                );
        }




}
