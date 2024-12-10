<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home');

Route::prefix('/baptis')->group(function () {
    Route::get('/', [App\Http\Controllers\BaptisController::class, 'index'])->name('baptis');
    Route::get('/daftar', [App\Http\Controllers\BaptisController::class, 'create'])->name('baptis.create')->middleware('auth');
    Route::post('/post', [App\Http\Controllers\BaptisController::class, 'store'])->name('baptis.store');
});

Route::prefix('/sidhi')->group(function () {
    Route::get('/', [App\Http\Controllers\SidhiController::class, 'index'])->name('sidhi');
    Route::get('/daftar', [App\Http\Controllers\SidhiController::class, 'create'])->name('sidhi.create')->middleware('auth');
    Route::post('/post', [App\Http\Controllers\SidhiController::class, 'store'])->name('sidhi.store');
});

Route::prefix('/katekisasi')->group(function () {
    Route::get('/', [App\Http\Controllers\KatekisasiController::class, 'index'])->name('katekisasi');
    Route::get('/daftar', [App\Http\Controllers\KatekisasiController::class, 'create'])->name('katekisasi.create')->middleware('auth');
    Route::post('/post', [App\Http\Controllers\KatekisasiController::class, 'store'])->name('katekisasi.store');
});

Route::prefix('/jadwal-pelayanan')->group(function () {
    Route::get('/', [App\Http\Controllers\JadwalPelayananController::class, 'index'])->name('lp.jadwal');
    Route::get('/{id}', [App\Http\Controllers\JadwalPelayananController::class, 'show'])->name('lp.jadwal.show');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('verified');

Route::get('/surat-kehadiran-katekisasi/{id}', [App\Http\Controllers\DashboardController::class, 'kartuKehadiranPDF'])->name('kartuKehadiranPDF');

Route::prefix('/jemaat')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\JemaatController::class, 'index'])->name('jemaat.index');
    Route::post('/verifikasi/{id}', [App\Http\Controllers\Admin\JemaatController::class, 'verify'])->name('jemaat.verify');
});

Route::prefix('/pelayanan')->group(function () {
    Route::prefix('/baptis')->group(function () {
        Route::get('/', [App\Http\Controllers\Pendeta\BaptisController::class, 'index'])->name('baptis.pendeta.index');
        Route::get('/{id}', [App\Http\Controllers\Pendeta\BaptisController::class, 'show'])->name('baptis.pendeta.show');
        Route::post('/diterima/{id}', [App\Http\Controllers\Pendeta\BaptisController::class, 'accept'])->name('baptis.pendeta.accept');
        Route::get('/ditolak/{id}', [App\Http\Controllers\Pendeta\BaptisController::class, 'showRejectForm'])->name('baptis.pendeta.rejectForm');
        Route::post('/pendaftar/ditolak/{id}', [App\Http\Controllers\Pendeta\BaptisController::class, 'reject'])->name('baptis.pendeta.reject');
    });

    Route::prefix('/katekisasi')->group(function () {
        Route::get('/', [App\Http\Controllers\Pendeta\KatekisasiController::class, 'index'])->name('katekisasi.pendeta.index');
        Route::get('/{id}', [App\Http\Controllers\Pendeta\KatekisasiController::class, 'show'])->name('katekisasi.pendeta.show');
        Route::post('/diterima/{id}', [App\Http\Controllers\Pendeta\KatekisasiController::class, 'accept'])->name('katekisasi.pendeta.accept');
        Route::get('/ditolak/{id}', [App\Http\Controllers\Pendeta\KatekisasiController::class, 'showRejectForm'])->name('katekisasi.pendeta.rejectForm');
        Route::post('/pendaftar/ditolak/{id}', [App\Http\Controllers\Pendeta\KatekisasiController::class, 'reject'])->name('katekisasi.pendeta.reject');
    });

    Route::prefix('/sidhi')->group(function () {
        Route::get('/', [App\Http\Controllers\Pendeta\SidhiController::class, 'index'])->name('sidhi.pendeta.index');
        Route::get('/{id}', [App\Http\Controllers\Pendeta\SidhiController::class, 'show'])->name('sidhi.pendeta.show');
        Route::post('/diterima/{id}', [App\Http\Controllers\Pendeta\SidhiController::class, 'accept'])->name('sidhi.pendeta.accept');
        Route::get('/ditolak/{id}', [App\Http\Controllers\Pendeta\SidhiController::class, 'showRejectForm'])->name('sidhi.pendeta.rejectForm');
        Route::post('/pendaftar/ditolak/{id}', [App\Http\Controllers\Pendeta\SidhiController::class, 'reject'])->name('sidhi.pendeta.reject');
    });
});

Route::prefix('/pendeta')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\PendetaController::class, 'index'])->name('pendeta.index');
    Route::get('/tambah', [App\Http\Controllers\Admin\PendetaController::class, 'create'])->name('pendeta.create');
    Route::post('/post', [App\Http\Controllers\Admin\PendetaController::class, 'store'])->name('pendeta.store');
});

Route::prefix('/jadwal')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/tambah', [App\Http\Controllers\Admin\JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/post', [App\Http\Controllers\Admin\JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/{id}', [App\Http\Controllers\Admin\JadwalController::class, 'show'])->name('jadwal.show');
    Route::post('/{id}/hadir', [App\Http\Controllers\Admin\JadwalController::class, 'verifyPresent'])->name('jadwal.present');
    Route::post('/{id}/tidak-hadir', [App\Http\Controllers\Admin\JadwalController::class, 'verifyAbsent'])->name('jadwal.absent');
    Route::get('/pdf/{id}', [App\Http\Controllers\Admin\JadwalController::class, 'downloadPDF'])->name('jadwal.pdf');
});

