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
Route::get('/pengguna', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
Route::get('/pengguna/verifikasi/{id}', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('users.verify');
