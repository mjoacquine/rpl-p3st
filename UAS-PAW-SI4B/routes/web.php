<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\AuthController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CatalogController as AdminCatalog;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\UserController as AdminUser;

// Controller Petugas
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\ProfileController as PetugasProfile;
use App\Http\Controllers\Petugas\RouteController as PetugasRoute;
use App\Http\Controllers\Petugas\TaskController as PetugasTask;
use App\Http\Controllers\Petugas\TransactionController as PetugasTransaction;

// Controller Warga
use App\Http\Controllers\Warga\DashboardController as WargaDashboard;
use App\Http\Controllers\Warga\CatalogController as WargaCatalog;
use App\Http\Controllers\Warga\EcoStatsController as WargaEcoStats;
use App\Http\Controllers\Warga\ProfileController as WargaProfile;
use App\Http\Controllers\Warga\ScheduleController as WargaSchedule;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('Welcome'); })->name('welcome');
Route::get('/panduan', function () { return view('DocsPanduan'); })->name('docs.panduan');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Warga Routes (Portal Pelanggan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboard::class, 'index'])->name('dashboard');
    
    Route::resource('schedule', WargaSchedule::class)->only(['index', 'create', 'store']);
    Route::get('/catalog', [WargaCatalog::class, 'index'])->name('catalog.index');
    Route::get('/ecostats', [WargaEcoStats::class, 'index'])->name('ecostats.index');
    
    Route::get('/profile', [WargaProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [WargaProfile::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Petugas Routes (Portal Pengepul)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/task', [PetugasTask::class, 'index'])->name('task.index');
    Route::post('/task/{id}/accept', [PetugasTask::class, 'accept'])->name('task.accept');
    
    Route::get('/route/{scheduleId}', [PetugasRoute::class, 'show'])->name('route.show'); // Navigasi Maps API
    
    Route::get('/transaction/{scheduleId}/edit', [PetugasTransaction::class, 'edit'])->name('transaction.edit');
    Route::put('/transaction/{scheduleId}', [PetugasTransaction::class, 'update'])->name('transaction.update');
    
    Route::get('/profile', [PetugasProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}/location', [PetugasProfile::class, 'updateLocation'])->name('profile.location'); // Update GPS
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Portal Manajemen)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::resource('catalog', AdminCatalog::class)->except(['show']);
    
    Route::get('/user', [AdminUser::class, 'index'])->name('user.index');
    Route::get('/user/petugas/create', [AdminUser::class, 'createPetugas'])->name('user.create_petugas');
    Route::post('/user/petugas', [AdminUser::class, 'storePetugas'])->name('user.store_petugas');
    
    Route::get('/report', [AdminReport::class, 'index'])->name('report.index');
    Route::get('/report/export-pdf', [AdminReport::class, 'exportPdf'])->name('report.export_pdf');
});
