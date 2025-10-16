<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Arahkan root (/) langsung ke halaman login Breeze
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard: ambil data dari TransaksiController
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [TransaksiController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');


    Route::get('/laporan/cetak', [TransaksiController::class, 'cetakLaporan'])
    ->middleware(['auth'])
    ->name('laporan.cetak');




// Semua route di bawah ini harus login dulu
Route::middleware('auth')->group(function () {
    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kategori & Transaksi (resourceful routes)
    Route::resource('kategori', KategoriController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
});

// Route auth bawaan Breeze
require __DIR__.'/auth.php';
