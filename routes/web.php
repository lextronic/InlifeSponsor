<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PrController;
use App\Http\Controllers\Pengaju\AjuanSponsorshipController;
use App\Http\Controllers\pr\AjuanKlienController;
use App\Http\Controllers\pr\dashboardPRController;
use App\Http\Controllers\pr\MeetingController;
use App\Http\Controllers\pr\MouController;
use App\Http\Controllers\admin\AjuanMasukAdminController;
use App\Http\Controllers\admin\DashboardAdminController;
use App\Http\Controllers\admin\DataUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default route
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::post('/logout', 'logout')->name('logout');

    // Forgot Password & OTP
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('forgot.password');
    Route::post('/send-otp', 'sendOtp')->name('send.otp');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
    Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
    Route::post('/save-password', 'savePassword')->name('save.password');
});

// Admin Routes (Requires Auth & Role: Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::controller(DashboardAdminController::class)->prefix('dashboard')->group(function () {
        Route::get('/', 'dashboardAdminShow')->name('dashboardAdmin.show');
        Route::get('/chart/yearly-data', 'getYearlyData');
        Route::get('/chart/monthly-data/{year}', 'getMonthlyData');
        Route::get('/chart/status-data/{year}/{month}', 'getStatusData');
    });

    Route::controller(AjuanMasukAdminController::class)->prefix('ajuanmasuk')->group(function () {
        Route::get('/', 'index')->name('ajuanmasuk.index');
        Route::get('/show/{id}', 'showajuan')->name('detailajuan.show');
        Route::post('/ajuan/terima/{id}', 'terima')->name('ajuan.setujui');
        Route::post('/ajuan/tolak/{id}', 'tolak')->name('ajuan.tolak');
        Route::post('/ajuan/{id}/schedule', 'scheduleMeeting')->name('scheduleMeeting');
    });

    Route::controller(DataUserController::class)->prefix('datauser')->group(function () {
        Route::get('/', 'index')->name('datauser.index');
        Route::post('add', 'simpanUser')->name('datauser.add');
        Route::delete('/admin/{id}', 'destroy')->name('datauser.destroy');
    });

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
});

// Pengaju Routes (Requires Auth & Role: Pengaju)
Route::middleware(['auth', 'role:pengaju'])->prefix('ajuan-sponsorship')->group(function () {
    Route::controller(AjuanSponsorshipController::class)->group(function () {
        Route::get('/', 'index')->name('ajuan.index');
        Route::get('/create', 'create')->name('ajuan.create');
        Route::post('/store', 'store')->name('ajuan.store');
        Route::get('/show/{id}', 'show')->name('ajuan.show');
        Route::delete('/destroy/{id}', 'destroy')->name('ajuan.destroy');
        Route::post('/update-status/{id}', 'updateStatus')->name('pengajuan.update.status');
        Route::post('/pengajuans/{id}/signature', 'storeSignature')->name('pengajuans.signature.store');
    });

    Route::get('/profile', [AuthController::class, 'profile'])->name('pengaju.profile');
});

// PR Routes (Requires Auth & Role: PR)
Route::middleware(['auth', 'role:pr'])->prefix('pr')->group(function () {
    Route::controller(dashboardPRController::class)->prefix('dashboard')->group(function () {
        Route::get('/', 'index')->name('dashboardPR.index');
    });

    Route::controller(MeetingController::class)->prefix('meeting')->group(function () {
        Route::get('/', 'index')->name('meeting.index');
        Route::get('/show/{id}', 'showMeet')->name('meeting.show');
        Route::post('/show/{id}/terima', 'updateMeeting')->name('meeting.update');
        Route::post('/show/{id}/tolak', 'tolak')->name('meeting.tolak');
    });

    Route::controller(AjuanKlienController::class)->prefix('ajuanklien')->group(function () {
        Route::get('/', 'index')->name('ajuanklien.index');
        Route::get('/show/{id}', 'show')->name('ajuanklien.show');
        Route::post('/show/{id}/terima', 'terima_banding')->name('banding.setujui');
        Route::post('/show/{id}/tolak', 'tolak_banding')->name('banding.ditolak');
        Route::post('/ajuan/{id}/signature', 'storeSignaturePR')->name('ttd.store');
    });
});

// Shared Routes for PR, Admin, and Pengaju
Route::middleware(['auth', 'role:pr|admin|pengaju'])->group(function () {
    Route::controller(AkunController::class)->prefix('akun')->group(function () {
        Route::get('/', 'index')->name('akun.index');
        Route::put('/update', 'update')->name('akun.update');
    });

    Route::controller(ArsipController::class)->prefix('arsip')->group(function () {
        Route::get('/', 'index')->name('arsip.index');
        Route::get('/show/{id}', 'show')->name('arsip.show');
    });

    Route::controller(DistribusiController::class)->prefix('distribusi-benefit')->group(function () {
        Route::get('/', 'index')->name('distribusi.index');
        Route::get('/show/{id}', 'show')->name('distribusi.show');
        Route::post('/pr/upload-dokumentasi', 'uploadDokumentasi')->name('pr.uploadDokumentasi');
        Route::post('/{id}/selesai', 'distribusiSelesai')->name('distribusi.selesai');
        Route::get('/mou/preview/{id}', 'preview')->name('mou.preview');
    });

    Route::get('/signature/{id}', [AjuanSponsorshipController::class, 'showSignature'])->name('signature.show');
});
Route::get('/databaseil', function () { 
    return view('databaseil');
});
