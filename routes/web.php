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

// User
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/presensi', [PresensiController::class, 'index'])
        ->name('presensi');

    Route::post('/presensi/check-in', [PresensiController::class, 'checkIn'])
        ->name('presensi.checkIn');

    Route::post('/presensi/check-out', [PresensiController::class, 'checkOut'])
        ->name('presensi.checkOut');

    // pengajuan
    Route::post('/pengajuan', [PengajuanController::class, 'store'])
        ->name('pengajuan.store');
});

// Admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::patch('/pengajuan/{pengajuan}/accept', [PengajuanController::class, 'accept'])
        ->name('pengajuan.accept');

    Route::patch('/pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])
        ->name('pengajuan.reject');
    
    Route::get('/presensi/export/excel', [DashboardController::class, 'exportExcel'])
        ->name('presensi.export.excel');

    Route::get('/presensi/export/pdf', [DashboardController::class, 'exportPdf'])
        ->name('presensi.export.pdf');
});


