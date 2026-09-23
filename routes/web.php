<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PengajuanController;

// Auth
Route::get('/', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login.authenticate');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// USER
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/presensi', [PresensiController::class, 'index'])
        ->name('presensi');
    
    Route::post('/presensi/check-in', [PresensiController::class, 'checkIn'])
        ->name('presensi.checkIn');

    Route::post('/presensi/check-out', [PresensiController::class, 'checkOut'])
        ->name('presensi.checkOut');
    
    Route::post('/pengajuan', [PengajuanController::class, 'store'])
        ->name('pengajuan.store');

});


