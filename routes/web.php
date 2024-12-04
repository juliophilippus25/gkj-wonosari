<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home');

Route::prefix('/baptis')->group(function () {
    Route::get('/', [App\Http\Controllers\BaptisController::class, 'index'])->name('baptis');
    Route::get('/daftar', [App\Http\Controllers\BaptisController::class, 'create'])->name('baptis.create')->middleware('auth');
});

Route::prefix('/sidhi')->group(function () {
    Route::get('/', [App\Http\Controllers\SidhiController::class, 'index'])->name('sidhi');
    Route::get('/daftar', [App\Http\Controllers\SidhiController::class, 'create'])->name('sidhi.create')->middleware('auth');
});

Route::prefix('/katekisasi')->group(function () {
    Route::get('/', [App\Http\Controllers\KatekisasiController::class, 'index'])->name('katekisasi');
    Route::get('/daftar', [App\Http\Controllers\KatekisasiController::class, 'create'])->name('katekisasi.create')->middleware('auth');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('verified');

Route::prefix('/jemaat')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\JemaatController::class, 'index'])->name('jemaat.index');
    Route::post('/verifikasi/{id}', [App\Http\Controllers\Admin\JemaatController::class, 'verify'])->name('jemaat.verify');
});

Route::prefix('/pelayanan')->group(function () {
    Route::get('/', [App\Http\Controllers\Pendeta\ServiceController::class, 'index'])->name('service.index');
    Route::get('/{scheduleId}', [App\Http\Controllers\Pendeta\ServiceController::class, 'show'])->name('service.show');
    Route::post('/terima/{registationId}', [App\Http\Controllers\Pendeta\ServiceController::class, 'accept'])->name('service.acceptRegistrant');
    Route::post('/tolak/{registationId}', [App\Http\Controllers\Pendeta\ServiceController::class, 'reject'])->name('service.rejectRegistrant');
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
});

Route::prefix('/pendaftaran')->group(function () {
    Route::get('/', [App\Http\Controllers\User\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/tambah', [App\Http\Controllers\User\RegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/post', [App\Http\Controllers\User\RegistrationController::class, 'store'])->name('registrations.store');
});
