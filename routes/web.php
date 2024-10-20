<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/content', function () {
    return view('layouts.content');
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
    Route::get('/', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/tambah', [App\Http\Controllers\Admin\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/post', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
});

Route::prefix('/pendaftaran')->group(function () {
    Route::get('/', [App\Http\Controllers\User\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/tambah', [App\Http\Controllers\User\RegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/post', [App\Http\Controllers\User\RegistrationController::class, 'store'])->name('registrations.store');
});
