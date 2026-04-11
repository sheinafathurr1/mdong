<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Import Controller Mahasiswa
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Mahasiswa\ProjectController;
use App\Http\Controllers\Mahasiswa\TopikController;
use App\Http\Controllers\Mahasiswa\ApplicationController;

//Import Controller Dosen
use App\Http\Controllers\Dosen\DosenDashboardController;
use App\Http\Controllers\Dosen\TopikInterestController;
use App\Http\Controllers\Dosen\ReviewController;
use App\Http\Controllers\Dosen\BimbinganController;

//Import Controller Prodi
use App\Http\Controllers\Prodi\PeriodeController;
use App\Http\Controllers\Prodi\AssignController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Default: Langsung arahkan pengunjung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// AREA AUTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// AREA MAHASISWA
// ==========================================
Route::middleware(['role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        
        // Dashboard Mahasiswa
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        
        // Route Profil Mahasiswa
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

        // Route Portofolio Proyek
        Route::get('/portofolio', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/portofolio/tambah', [ProjectController::class, 'create'])->name('project.create');
        Route::get('/portofolio/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/portofolio/{id}', [ProjectController::class, 'update'])->name('project.update');
        Route::post('/portofolio', [ProjectController::class, 'store'])->name('project.store');
        Route::delete('/portofolio/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

        // Route Cari Topik
        Route::get('/topik-dosen', [TopikController::class, 'index'])->name('topik.index');
        Route::get('/topik-dosen/{id}', [TopikController::class, 'show'])->name('topik.show');
        Route::post('/topik-dosen/{id}/apply', [TopikController::class, 'apply'])->name('topik.apply');

        // Route Status Pengajuan
        Route::get('/status-pengajuan', [ApplicationController::class, 'status'])->name('application.status');
        

});


// ==========================================
// AREA DOSEN & PRODI
// ==========================================
Route::middleware(['role:dosen'])
    ->prefix('dosen')
    ->name('dosen.') // Prefix untuk nama route (misal: dosen.dashboard)
    ->group(function () {
        
        // Dashboard Dosen
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

        // Route Topik Interest Dosen
        Route::get('/topik-interest', [TopikInterestController::class, 'index'])->name('topik.index');
        Route::get('/topik-interest/buat', [TopikInterestController::class, 'create'])->name('topik.create');
        Route::post('/topik-interest', [TopikInterestController::class, 'store'])->name('topik.store');
        Route::get('/topik-interest/{id}/edit', [TopikInterestController::class, 'edit'])->name('topik.edit');
        Route::put('/topik-interest/{id}', [TopikInterestController::class, 'update'])->name('topik.update');

        // Route Review Aplikasi Mahasiswa
        Route::get('/review-aplikasi', [ReviewController::class, 'index'])->name('review.index');
        Route::get('/review-aplikasi/{id}', [ReviewController::class, 'show'])->name('review.show');
        Route::put('/review-aplikasi/{id}', [ReviewController::class, 'update'])->name('review.update');

        // Route Daftar Bimbingan Final
        Route::get('/bimbingan-saya', [BimbinganController::class, 'index'])->name('bimbingan.index');

        // ==========================================
        // AREA KHUSUS ADMIN PRODI
        // ==========================================
        Route::middleware(['prodi'])
            ->prefix('prodi')
            ->name('prodi.') // Prefix: dosen.prodi...
            ->group(function () {
                
                // Manajemen Periode
                Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
                Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
                Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
                Route::patch('/periode/{id}/toggle', [PeriodeController::class, 'toggle'])->name('periode.toggle');
                Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

        });

});