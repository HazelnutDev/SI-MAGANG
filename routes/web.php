<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\AbsensiController;
use App\Http\Controllers\Mahasiswa\TugasController;
use App\Http\Controllers\Mahasiswa\LaporanAkhirController;
use App\Http\Controllers\Mahasiswa\SertifikatController;
use App\Http\Controllers\Mahasiswa\ProfileController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes (Auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Change Password Routes
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [AuthController::class, 'changePassword'])->name('password.update');

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin-panel')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::get('users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
        
        // Absensi Management
        Route::resource('absensi', App\Http\Controllers\Admin\AbsensiController::class);
        Route::get('absensi/export', [App\Http\Controllers\Admin\AbsensiController::class, 'export'])->name('absensi.export');
        
        // Tugas Management
        Route::resource('tugas', App\Http\Controllers\Admin\TugasController::class);
        
        // Laporan Management
        Route::resource('laporan', App\Http\Controllers\Admin\LaporanController::class);
        Route::patch('laporan/{laporan}/approve', [App\Http\Controllers\Admin\LaporanController::class, 'approve'])->name('laporan.approve');
        Route::patch('laporan/{laporan}/reject', [App\Http\Controllers\Admin\LaporanController::class, 'reject'])->name('laporan.reject');
        Route::get('laporan/{laporan}/download', [App\Http\Controllers\Admin\LaporanController::class, 'download'])->name('laporan.download');
        
        // Sertifikat Management
        Route::resource('sertifikat', App\Http\Controllers\Admin\SertifikatController::class);
        Route::get('sertifikat/export', [App\Http\Controllers\Admin\SertifikatController::class, 'export'])->name('sertifikat.export');
        Route::post('sertifikat/import', [App\Http\Controllers\Admin\SertifikatController::class, 'import'])->name('sertifikat.import');
        Route::get('sertifikat/template', [App\Http\Controllers\Admin\SertifikatController::class, 'downloadTemplate'])->name('sertifikat.template');
        
        // Nilai Management
        Route::resource('nilai', App\Http\Controllers\Admin\NilaiController::class);
        
        // Profile Perusahaan
        Route::resource('profile-perusahaan', App\Http\Controllers\Admin\ProfilePerusahaanController::class);
        
        // Admin Profile
        Route::get('profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::match(['put','patch'],'profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::match(['put','patch'],'profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });

    // Mahasiswa Routes
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Absensi
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/', [AbsensiController::class, 'index'])->name('index');
            Route::get('/create', [AbsensiController::class, 'create'])->name('create');
            Route::post('/', [AbsensiController::class, 'store'])->name('store');
        });

        // Tugas Kegiatan Harian
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/', [TugasController::class, 'index'])->name('index');
            Route::get('/{id}', [TugasController::class, 'show'])->name('show');
            Route::post('/{id}/upload', [TugasController::class, 'upload'])->name('upload');
        });

        // Laporan Akhir
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanAkhirController::class, 'index'])->name('index');
            Route::get('/create', [LaporanAkhirController::class, 'create'])->name('create');
            Route::post('/', [LaporanAkhirController::class, 'store'])->name('store');
        });

        // Sertifikat
        Route::prefix('sertifikat')->name('sertifikat.')->group(function () {
            Route::get('/', [SertifikatController::class, 'index'])->name('index');
            Route::get('/{id}/download', [SertifikatController::class, 'download'])->name('download');
        });

        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [ProfileController::class, 'update'])->name('update');
            Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
            Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
            });
        });
    // });
});
