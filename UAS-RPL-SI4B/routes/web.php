<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Notifications\DatabaseNotification;

// Controller Admin, Petugas, Warga
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard, CatalogController as AdminCatalog, ReportController as AdminReport, UserController as AdminUser};
use App\Http\Controllers\Petugas\{DashboardController as PetugasDashboard, ProfileController as PetugasProfile, RouteController as PetugasRoute, TaskController as PetugasTask, TransactionController as PetugasTransaction};
use App\Http\Controllers\Warga\{DashboardController as WargaDashboard, CatalogController as WargaCatalog, EcoStatsController as WargaEcoStats, ProfileController as WargaProfile, ScheduleController as WargaSchedule};


/*
|--------------------------------------------------------------------------
| Public & Authentication Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Public & Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('Welcome'); })->name('welcome');
Route::get('/panduan', function () { return view('DocsPanduan'); })->name('docs.panduan');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
    
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});
Route::get('/email/verify', function () {
    // Penulisannya: NamaFolder.NamaFile (tanpa .blade.php)
    return view('Auth.verify-email'); 
})->middleware('auth')->name('verification.notice');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () { return view('Auth.verify-email'); })->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('warga.dashboard')->with('success', 'Email berhasil diverifikasi!');
    })->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang!');
    })->middleware('throttle:6,1')->name('verification.send');

    // 🔽 KUMPULAN RUTE NOTIFIKASI DI SINI 🔽
    
    // 1. Rute untuk Membaca (Read)
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = \Illuminate\Notifications\DatabaseNotification::findOrFail($id);
        $notification->markAsRead();
        $scheduleId = $notification->data['schedule_id'];

        if (auth()->user()->role === 'warga') { 
            return redirect()->route('warga.dashboard')->with('success', 'Notifikasi telah dibaca.');
        } else {
            return redirect()->route('petugas.route.show', $scheduleId);
        }
    })->name('notification.read');

    // 2. Rute untuk Menghapus Semua (Delete All) -> WAJIB DI ATAS {id}
    Route::delete('/notifications/delete-all', function () {
        auth()->user()->unreadNotifications()->delete();
        return back();
    })->name('notification.delete_all');

    // 3. Rute untuk Menghapus Satuan (Delete)
    Route::delete('/notifications/{id}/delete', function ($id) {
        $notification = \Illuminate\Notifications\DatabaseNotification::findOrFail($id);
        $notification->delete(); 
        return back(); 
    })->name('notification.delete');
    
    // 🔼 BATAS AKHIR RUTE NOTIFIKASI 🔼
});
    // 🔽 KUMPULAN RUTE NOTIFIKASI DI SINI 🔽
    
    // 1. Rute untuk Membaca (Read)
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->markAsRead();
        $scheduleId = $notification->data['schedule_id'];

        if (auth()->user()->role === 'warga') { 
            return redirect()->route('warga.dashboard')->with('success', 'Notifikasi telah dibaca.');
        } else {
            return redirect()->route('petugas.route.show', $scheduleId);
        }
    })->name('notification.read');

 // 1. Rute untuk Membaca (Read)
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = \Illuminate\Notifications\DatabaseNotification::findOrFail($id);
        $notification->markAsRead();
        $scheduleId = $notification->data['schedule_id'];

        if (auth()->user()->role === 'warga') { 
            return redirect()->route('warga.dashboard')->with('success', 'Notifikasi telah dibaca.');
        } else {
            return redirect()->route('petugas.route.show', $scheduleId);
        }
    })->name('notification.read');

    // 2. Rute untuk Menghapus Semua (Delete All) -> WAJIB DI ATAS {id}
    Route::delete('/notifications/delete-all', function () {
        auth()->user()->unreadNotifications()->delete();
        return back();
    })->name('notification.delete_all');

    // 3. Rute untuk Menghapus Satuan (Delete)
    Route::delete('/notifications/{id}/delete', function ($id) {
        $notification = \Illuminate\Notifications\DatabaseNotification::findOrFail($id);
        $notification->delete(); 
        return back(); 
    })->name('notification.delete');
/*
|--------------------------------------------------------------------------
| Portal Routes (Dilindungi RoleMiddleware)
|--------------------------------------------------------------------------
*/
// ... (Kodingan route warga, petugas, admin di bawahnya biarkan saja)

/*
|--------------------------------------------------------------------------
| Portal Routes (Dilindungi RoleMiddleware)
|--------------------------------------------------------------------------
*/

// --- WARGA ROUTES ---
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboard::class, 'index'])->name('dashboard');
    
    // Schedule & Transaksi (Ditambahkan Konfirmasi & Decline)
    Route::resource('schedule', WargaSchedule::class)->only(['index', 'create', 'store']);
    Route::post('/schedule/{id}/cancel', [WargaSchedule::class, 'cancel'])->name('schedule.cancel');
    Route::get('/schedule/{id}/receipt', [WargaSchedule::class, 'receipt'])->name('schedule.receipt');
    
    // NEW: Konfirmasi & Decline untuk Warga
    Route::post('/schedule/{id}/confirm', [WargaSchedule::class, 'confirm'])->name('schedule.confirm');
    Route::post('/schedule/{id}/decline', [WargaSchedule::class, 'decline'])->name('schedule.decline');

    // Catalog, Stats, Profile
    Route::get('/catalog', [WargaCatalog::class, 'index'])->name('catalog.index');
    Route::get('/ecostats', [WargaEcoStats::class, 'index'])->name('ecostats.index');
    Route::get('/profile', [WargaProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [WargaProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [WargaProfile::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/location', [WargaProfile::class, 'updateLocation'])->name('profile.location');
});

// --- PETUGAS ROUTES ---
Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    Route::get('/task', [PetugasTask::class, 'index'])->name('task.index');
    Route::post('/task/{id}/accept', [App\Http\Controllers\Petugas\TaskController::class, 'accept'])
    ->name('task.accept');
    Route::post('/task/{id}/arrived', [PetugasTask::class, 'arrived'])->name('task.arrived');


     Route::get('/route/optimize-all', [\App\Http\Controllers\Petugas\RouteController::class, 'optimizeAll'])->name('route.optimizeAll');
    Route::get('/route/{scheduleId}', [PetugasRoute::class, 'show'])->name('route.show');
   
    
    Route::get('/transaction/{scheduleId}/edit', [PetugasTransaction::class, 'edit'])->name('transaction.edit');
    Route::put('/transaction/{scheduleId}', [PetugasTransaction::class, 'update'])->name('transaction.update');
    Route::post('/transaction/{scheduleId}/cancel', [PetugasTransaction::class, 'cancel'])->name('transaction.cancel');
    Route::get('/transaction/{scheduleId}/receipt', [PetugasTransaction::class, 'receipt'])->name('transaction.receipt');
    
    Route::get('/profile', [PetugasProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PetugasProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [PetugasProfile::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/location', [PetugasProfile::class, 'updateLocation'])->name('profile.location');

    Route::get('/riwayat-transaksi', [App\Http\Controllers\Petugas\TransactionController::class, 'history'])
        ->name('transaction.history');
});

// --- ADMIN ROUTES ---
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('catalog', AdminCatalog::class)->except(['show']);
    Route::get('/user', [AdminUser::class, 'index'])->name('user.index');
    Route::get('/user/petugas/create', [AdminUser::class, 'createPetugas'])->name('user.create_petugas');
    Route::post('/user/petugas', [AdminUser::class, 'storePetugas'])->name('user.store_petugas');
    Route::get('/report', [AdminReport::class, 'index'])->name('report.index');
    Route::get('/report/export-pdf', [AdminReport::class, 'exportPdf'])->name('report.export_pdf');
});