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
        // Divisions and sections
        $divisions = [
        "ADMINISTRATIVE DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "PROCUREMENT AND BAC SECTION",
                    "PROPERTY AND SUPPLY SECTION",
                    "RECORDS AND ARCHIVES MANAGEMENT SECTION",
                    "BUILDING AND GROUND SECTION",
                    "GENERAL SERVICES SECTION"
                ],
                "HUMAN RESOURCE AND MANAGEMENT DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "LEARNING AND DEVELOPMENT SECTION",
                    "HUMAN RESOURCE WELFARE SECTION",
                    "PERSONNEL SECTION",
                    "CLINIC",
                    "HRPPMS"
                ],
                "FINANCE MANAGEMENT DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "ACCOUNTING SECTION",
                    "ACCOUNTING LIQUIDATION",
                    "BUDGET SECTION",
                    "BUDGET REVIEWER",
                    "CASH SECTION",
                    "CASH RELEASING",
                    "COMMISSION ON AUDIT (COA)",
                    "HYBRID"
                ],
                "DISASTER RESPONSE AND MANAGEMENT DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "DISASTER RESPONSE AND REHABILITATION SECTION",
                    "DISASTER RESPONSE AND INFORMATION MANAGEMENT SECTION",
                    "REGIONAL RESOURCE OPERATION SECTION"
                ],
                "POLICY AND PLANS DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "REGIONAL INFORMATION AND COMMUNICATION MANAGEMENT SECTION",
                    "NATIONAL HOUSEHOLD TARGETING SYSTEM",
                    "STANDARDS SECTION",
                    "RESEARCH AND DEVELOPMENT SECTION"
                ],
                "PROTECTIVE SERVICES DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "COMMUNITY BASED SECTION",
                    "CRISIS INTERVENTION SECTION",
                    "SUPPLEMENTAL FEEDING PROGRAM",
                    "SOCIAL PENSION",
                    "MINORS TRAVELLING ABROAD",
                    "CENTER BASED SERVICES SECTION"
                ],
                "PROMOTIVE SERVICES DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "SUSTAINABLE LIVELIHOOD PROGRAM",
                    "KALAHI"
                ],
                "PANTAWID PAMILYANG PILIPINO PROGRAM"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "RPMO",
                    "ICT PANTAWID"
                ],
                "INNOVATIONS DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "STU",
                    "TBTP",
                    "PAG-ABOT",
                    "EPAHP"
                ],
                "OFFICE OF THE FIELD DIRECTOR"=> [
                    "OFFICE OF THE REGIONAL DIRECTOR",
                    "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR ADMINISTRATION",
                    "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR OPERATIONS",
                    "TAAORSS"
                ],
                "SWAD OFFICES"=> [
                    "SWAD - AURORA",
                    "SWAD - BATAAN",
                    "SWAD - BULACAN",
                    "SWAD - NUEVA ECIJA",
                    "SWAD - TARLAC",
                    "SWAD - PAMPANGA",
                    "SWAD - ZAMBALES"
                ],
                "CRCF's"=> [
                    "AMORV",
                    "HAVEN",
                    "RHFG",
                    "RRCY",
                    "RSCC",
                    "THFW",
                    "TLC"
                ]
        ];

        return view('fun_run_registration', compact('divisions'));

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
            $qrSvg = $dns2d->getBarcodeSVG($registration->qr_number, 'QRCODE');

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

            return redirect()->route('fun-run.show')->with('registration_id', $registration->id);

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
                    ->withErrors(['dswd_id' => 'DSWD ID not found.'])
                    ->withInput();
            }

            return view('fun_run_search', compact('registration'));
        }



        public function downloadPdf(FunRunRegistration $registration)
        {
            $dns2d = new DNS2D();
            $qrSvg = $dns2d->getBarcodeSVG($registration->qr_number, 'QRCODE');

            $pdf = Pdf::loadView('fun_run_print', compact('registration', 'qrSvg'))
                ->setPaper([0, 0, 153, 242], 'portrait');


            return $pdf->download("FunRun_{$registration->first_name}_{$registration->last_name}.pdf");
        }

        public function printImage($id)
        {
            $registration = FunRunRegistration::findOrFail($id);

            $dns2d = new DNS2D();

            // Generate QR (Base64 PNG)
            $qrBase64 = $dns2d->getBarcodePNG(
                $registration->qr_number,
                'QRCODE',
                6,
                6
            );

            // Create Image Manager
            $manager = new ImageManager(new Driver());

            // Create blank canvas (CR80 Portrait @300dpi ≈ 638x1016)
            $img = $manager->create(638, 1016)->fill('#ffffff');

            // Read QR image
            $qrImage = $manager->read(
                base64_decode($qrBase64)
            );

            // Resize QR (optional)
            $qrImage->resize(350, 350);

            // Place QR
            $img->place($qrImage, 'top-center', 0, 80);

            // Add Name
            $img->text(
                strtoupper($registration->first_name . ' ' . $registration->last_name),
                319,
                550,
                function ($font) {
                    $font->file(public_path('fonts/Roboto-Regular.ttf'));
                    $font->size(36);
                    $font->color('#000000');
                    $font->align('center');
                }
            );

            // Add Division
            $img->text(
                $registration->division,
                319,
                620,
                function ($font) {
                    $font->file(public_path('fonts/Roboto-Regular.ttf'));
                    $font->size(22);
                    $font->color('#333333');
                    $font->align('center');
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
