<?php

use App\Filament\Pages\ClassificationForm;
use App\Filament\Pages\UploadForm;
use App\Http\Controllers\FunRunRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\QrCodeController;
use App\Http\Middleware\CheckDeviceToken;
use App\Models\Attendance;
use App\Models\FunRunRegistration;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Login;
use Filament\Pages\Auth\Register;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/generateQRs', [PdfController::class, 'generateQrNumbers']);

//Route::get('/download-all', [PdfController::class, 'downloadAll']);


Route::get('/', [FunRunRegistrationController::class, 'create'])->name('fun-run.create');

Route::post('/fun-run/register', [FunRunRegistrationController::class, 'store'])->name('fun-run.store');

Route::get('/fun-run/download-waiver', [FunRunRegistrationController::class, 'waiver'])->name('fun-run.download-waiver');

Route::get('/fun-run/download-mechanic', [FunRunRegistrationController::class, 'mechanic'])->name('fun-run.download-mechanic');

Route::get('/fun-run/success', [FunRunRegistrationController::class, 'show'])->name('fun-run.success');

Route::get('/fun-run/{registration}/pdf', [FunRunRegistrationController::class, 'downloadPdf'])->name('fun-run.pdf');

Route::get('/fun-run/print-image/', [FunRunRegistrationController::class, 'printImage'])->name('fun-run.print-image');

Route::get('/fun-run/qr', [FunRunRegistrationController::class, 'showQrForm'])->name('fun-run.qr');

Route::post('/fun-run/qr', [FunRunRegistrationController::class, 'searchQr'])->name('fun-run.qr.search');

Route::get('/bene/{id}/print/{trans_no?}', [PdfController::class, 'print'])->name('faced.print');

Route::post('/admin/bene/deleteall', [QrCodeController::class, 'deleter']);

Route::post('/admin/classification-form', [ClassificationForm::class, 'setSearchQuery'])->name('hired-qr');

Route::middleware([CheckDeviceToken::class])->group(function () {
    Route::post('/attendance', [QrCodeController::class, 'store'])
        ->name('scan.qr');

    Route::get('/attendance', [QrCodeController::class, 'index'])->name('qr-scanner');

    // New route for JSON data
    Route::get('/attendances/list', [QrCodeController::class, 'list'])
        ->name('attendances.list');
});


Route::get('/unauthorized-device', function () {
    return view('fun_run_unauthorized-device');
})->name('unauthorized.device');



// Route::post('/attendance', [QrCodeController::class, 'store'])->name('scan.qr');

// Route::get('/attendance', [QrCodeController::class, 'index'])->name('qr-scanner');

//Route::get('/attendance', [QrCodeController::class, 'maintenance_page'])->name('qr-scanner');

//Route::post('/register', Register::class)->name('filament.faced.auth.register');

// Route::get('/insert', [PdfController::class, 'insertBene']);

// Route::get('/inserthired', [PdfController::class, 'inserthired']);

// Route::get('/insertpresent', [PdfController::class, 'insertpresent']);

// Route::get('/insertabsent', [PdfController::class, 'insertabsent']);









