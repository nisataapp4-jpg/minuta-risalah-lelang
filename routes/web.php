<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MinutaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\AuthController;

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Route Registrasi Pegawai
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Menu Minuta
Route::resource('minuta', MinutaController::class);

// Export Excel Minuta
Route::get('/minuta-export', [MinutaController::class, 'export'])
    ->name('minuta.export');

// Menu Peminjaman
Route::resource('peminjaman', PeminjamanController::class);

Route::get('/peminjaman-export', [PeminjamanController::class, 'export'])
    ->name('peminjaman.export');

Route::get(
    '/pengembalian-export',
    [PengembalianController::class,'export']
)->name('pengembalian.export');
// Menu Riwayat Pengembalian
Route::resource('pengembalian', PengembalianController::class);