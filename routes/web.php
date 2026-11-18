<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Data Induk
    Route::middleware('level:admin')->group(function () {
        Route::resource('petugas', PetugasController::class)->except(['show']);
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('ruang', RuangController::class)->except(['show']);
        Route::resource('inventaris', InventarisController::class)->except(['show']);
        Route::get('inventaris-kode', [InventarisController::class, 'getKode'])->name('inventaris.kode');
        
        Route::get('peminjam/create', [PeminjamController::class, 'create'])->name('peminjam.create');
        Route::post('peminjam', [PeminjamController::class, 'store'])->name('peminjam.store');
        Route::get('peminjam/{peminjam}/edit', [PeminjamController::class, 'edit'])->name('peminjam.edit');
        Route::put('peminjam/{peminjam}', [PeminjamController::class, 'update'])->name('peminjam.update');
        Route::patch('peminjam/{peminjam}/toggle', [PeminjamController::class, 'toggleAktif'])->name('peminjam.toggle');
    });

    // Operator Peminjaman & Pengembalian
    Route::middleware('level:operator')->group(function () {
        Route::get('peminjaman/baru', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('pengembalian', [PeminjamanController::class, 'pengembalianIndex'])->name('pengembalian.index');
        Route::post('pengembalian/{peminjaman}', [PeminjamanController::class, 'kembalikan'])->name('pengembalian.update');

        Route::get('peminjam/create', [PeminjamController::class, 'create'])->name('peminjam.create');
        Route::post('peminjam', [PeminjamController::class, 'store'])->name('peminjam.store');
    });

    // Peminjam & Riwayat bisa diakses admin & operator
    Route::get('peminjam', [PeminjamController::class, 'index'])->name('peminjam.index');
    Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});
