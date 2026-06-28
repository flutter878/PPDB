<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\ExportController;

// ── Public ────────────────────────────────────────────────
Route::get('/', [PendaftaranController::class, 'index'])->name('home');
Route::get('/cek-status', [PendaftaranController::class, 'cekStatus'])->name('pendaftaran.cek');
Route::get('/pengumuman', [PendaftaranController::class, 'pengumuman'])->name('pengumuman');

// ── Auth Orang Tua ────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Pendaftaran (harus login sebagai orang tua) ───────────
Route::middleware('auth')->group(function () {
    Route::get('/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/sukses/{no_seri}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
    Route::get('/bukti/{no_seri}', [PendaftaranController::class, 'bukti'])->name('pendaftaran.bukti');
});

// ── Auth Admin ────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth:admin');

    // Dashboard admin (placeholder — akan diisi nanti)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Ekspor
        Route::get('/ekspor/csv', [ExportController::class, 'csv'])->name('ekspor.csv');
        Route::get('/ekspor/excel', [ExportController::class, 'excel'])->name('ekspor.excel');

        // CRUD Peserta
        Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('/peserta/{no_seri}', [PesertaController::class, 'show'])->name('peserta.show');
        Route::get('/peserta/{no_seri}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('/peserta/{no_seri}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::delete('/peserta/{no_seri}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
        Route::patch('/peserta/{no_seri}/status', [PesertaController::class, 'updateStatus'])->name('peserta.status');
    });
});
