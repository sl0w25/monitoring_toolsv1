<?php

use App\Filament\Pages\ClassificationForm;
use App\Filament\Pages\UploadForm;
use App\Http\Controllers\FunRunRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\QrCodeController;
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


Route::get('/fun-run/register', [FunRunRegistrationController::class, 'create'])->name('funrun.create');

Route::post('/fun-run/register', [FunRunRegistrationController::class, 'store'])->name('funrun.store');

Route::get('/bene/{id}/print/{trans_no?}', [PdfController::class, 'print'])->name('faced.print');

Route::post('/', [QrCodeController::class, 'store'])->name('scan.qr');

Route::post('/admin/bene/deleteall', [QrCodeController::class, 'deleter']);

Route::post('/admin/classification-form', [ClassificationForm::class, 'setSearchQuery'])->name('hired-qr');

Route::get('/', [QrCodeController::class, 'index'])->name('qr-scanner');

Route::get('/attendances', function () {
    return response()->json([
        'attendances' => Attendance::orderBy('created_at', 'desc')->paginate(9)
    ]);
})->name('attendances.list');


//Route::post('/register', Register::class)->name('filament.faced.auth.register');

// Route::get('/insert', [PdfController::class, 'insertBene']);

// Route::get('/inserthired', [PdfController::class, 'inserthired']);

// Route::get('/insertpresent', [PdfController::class, 'insertpresent']);

// Route::get('/insertabsent', [PdfController::class, 'insertabsent']);









