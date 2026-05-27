<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Controller Warga
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\CatalogController as WargaCatalogController;
use App\Http\Controllers\Warga\ScheduleController;
use App\Http\Controllers\Warga\EcoStatsController;
use App\Http\Controllers\Warga\ProfileController;

// Controller Petugas
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\TaskController;
use App\Http\Controllers\Petugas\RouteController as PetugasRouteController;
use App\Http\Controllers\Petugas\TransactionController as PetugasTransactionController;
use App\Http\Controllers\Petugas\ProfileController as PetugasProfileController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CatalogController as AdminCatalogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;

// Halaman Utama: Langsung arahkan ke Login
Route::get('/', fn() => redirect('/login'));

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Jalur Pengguna Terautentikasi
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // GRUP KHUSUS AKTOR WARGA
    // ==========================================
    Route::middleware(['role:warga'])->prefix('warga')->name('warga.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/booking', [DashboardController::class, 'storeBooking'])->name('booking.store');
        
        Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/jadwal/create', [ScheduleController::class, 'create'])->name('schedule.create');
        Route::post('/jadwal', [ScheduleController::class, 'store'])->name('schedule.store');
        Route::delete('/jadwal/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
        
        Route::get('/katalog', [WargaCatalogController::class, 'index'])->name('catalog.index');
        Route::get('/ecostats', [EcoStatsController::class, 'index'])->name('ecostats.index');
        
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');
    });

    // ==========================================
    // GRUP KHUSUS AKTOR PETUGAS
    // ==========================================
    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/tugas', [TaskController::class, 'index'])->name('task.index');
        Route::get('/rute/{id}', [PetugasRouteController::class, 'show'])->name('route.show');
        
        Route::get('/transaksi/{id}/edit', [PetugasTransactionController::class, 'edit'])->name('transaction.edit');
        Route::put('/transaksi/{id}', [PetugasTransactionController::class, 'update'])->name('transaction.update');
        
        Route::get('/profil', [PetugasProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profil', [PetugasProfileController::class, 'update'])->name('profile.update');
    });

    // ==========================================
    // GRUP KHUSUS AKTOR ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/katalog', [AdminCatalogController::class, 'index'])->name('catalog.index');
        Route::get('/katalog/create', [AdminCatalogController::class, 'create'])->name('catalog.create');
        Route::post('/katalog', [AdminCatalogController::class, 'store'])->name('catalog.store');
        Route::get('/katalog/{id}/edit', [AdminCatalogController::class, 'edit'])->name('catalog.edit');
        Route::put('/katalog/{id}', [AdminCatalogController::class, 'update'])->name('catalog.update');
        Route::delete('/katalog/{id}', [AdminCatalogController::class, 'destroy'])->name('catalog.destroy');
        
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create_petugas');
        Route::post('/user', [UserController::class, 'store'])->name('user.store_petugas');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});