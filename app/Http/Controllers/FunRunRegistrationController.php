<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunRunQrSearchRequest;
use App\Http\Requests\FunRunRegistrationRequest;
use App\Models\FunRunRegistration;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FunRunRegistrationController extends Controller
{
    /* ================= CREATE ================= */

    public function create()
    {
        return view('fun_run_registration');
    }

    /* ================= SHOW SUCCESS ================= */

    public function show()
    {
        $id = session('registration_id');

        if (!$id) abort(403);

        $registration = FunRunRegistration::findOrFail($id);

        // Decrypt all encrypted fields
        $this->decryptFields($registration);

        $categories = [
            "5km_20_35" => "5 km – 20 to 35 years old",
            "5km_36_above" => "5 km – 36 years old and above",
            "3km_20_35" => "3 km – 20 to 35 years old",
            "3km_36_above" => "3 km – 36 years old and above",
        ];

        $registration->race_category_label =
            $categories[$registration->race_category] ?? $registration->race_category;

        $qr = new DNS2D();
        $qrSvg = $qr->getBarcodeSVG($registration->qr_number, 'QRCODE', 10, 10);

        return view('fun_run_success', compact('registration', 'qrSvg'));
    }

    /* ================= STORE ================= */

    public function store(FunRunRegistrationRequest $request)
    {
        $data = $request->validated();

        /* ===== RECAPTCHA ===== */

        $res = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!($res->json()['success'] ?? false)) {
            return back()->withErrors(['captcha' => 'Captcha failed'])->withInput();
        }

        /* ===== HASH (SEARCH) ===== */

        $dswdHash = hash('sha256', $data['dswd_id']);

        if (FunRunRegistration::where('dswd_id_hash', $dswdHash)->exists()) {
            return back()
                ->withErrors(['dswd_id' => 'Already registered'])
                ->withInput();
        }

        /* ===== GENERATE QR ===== */

        do {
            $qrNumber = (string) rand(1000000000, 9999999999);
            $qrHash = hash('sha256', $qrNumber);
        } while (FunRunRegistration::where('qr_number_hash', $qrHash)->exists());

        $data['qr_number'] = $qrNumber;

        /* ===== UPLOAD FILE ===== */

        if ($request->hasFile('health_consent_form')) {
            $data['health_consent_form'] =
                $request->file('health_consent_form')
                    ->store('health_forms', 'public');
        }

        /* ===== ENCRYPT ALL FIELDS ===== */

        $encrypt = [
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

        foreach ($encrypt as $field) {
            if (!empty($data[$field])) {
                $data[$field] = Crypt::encryptString(
                    strtoupper($data[$field])
                );
            }
        }

        /* ===== SAVE HASH ===== */

        $data['dswd_id_hash'] = $dswdHash;
        $data['qr_number_hash'] = $qrHash;

        /* ===== SAVE ===== */

        $reg = FunRunRegistration::create($data);

        session(['registration_id' => $reg->id]);

        return redirect()->route('fun-run.success');
    }

    /* ================= SEARCH ================= */

    public function searchQr(FunRunQrSearchRequest $request)
    {
        $hash = hash('sha256', $request->dswd_id);

        $reg = FunRunRegistration::where('dswd_id_hash', $hash)->first();

        if (!$reg) {
            return back()
                ->withErrors(['dswd_id' => 'Not found'])
                ->withInput();
        }

        session(['registration_id' => $reg->id]);

        return redirect()->route('fun-run.success');
    }

    /* ================= PRINT IMAGE ================= */

    public function printImage()
    {
        $id = session('registration_id');

        if (!$id) abort(403);

        $reg = FunRunRegistration::findOrFail($id);

        $this->decryptFields($reg);

        $dns = new DNS2D();

        $qr = $dns->getBarcodePNG(
            $reg->qr_number,
            'QRCODE',
            6,
            6
        );

        $manager = new ImageManager(new Driver());

        $img = $manager->read(
            public_path('storage/templates/qr_template.png')
        );

        $qrImg = $manager->read(base64_decode($qr));
        $qrImg->resize(1000, 1000);

        $img->place($qrImg, 'top-center', 0, 440);

        $img->text(
            $reg->first_name . ' ' . $reg->last_name,
            $img->width() / 2,
            1550,
            function ($font) {
                $font->file(public_path('fonts/Roboto-Regular.ttf'));
                $font->size(60);
                $font->color('#000');
                $font->align('center');
            }
        );

        return response($img->toPng())
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename="75th_Anniv.png"'
            );
    }

    /* ================= HELPER ================= */

    private function decryptFields($reg)
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
            if (!empty($reg->$field)) {
                $reg->$field = Crypt::decryptString($reg->$field);
            }
        }
    }
}
