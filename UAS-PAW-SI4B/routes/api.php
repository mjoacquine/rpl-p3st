<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Mobile App Authentication Endpoint
Route::post('/login', [AuthController::class, 'apiLogin']);

// Protected API Routes (Wajib mengirimkan Bearer Token dari hasil login)
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil data user yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json(['status' => 'success', 'data' => $request->user()]);
    });

    // Endpoint khusus mobile Warga (Booking dari HP)
    Route::middleware('role:warga')->prefix('warga')->group(function () {
        Route::get('/schedules', [\App\Http\Controllers\Warga\ScheduleController::class, 'apiIndex']);
        Route::post('/schedule', [\App\Http\Controllers\Warga\ScheduleController::class, 'apiStore']);
        Route::get('/ecostats', [\App\Http\Controllers\Warga\EcoStatsController::class, 'apiGetStats']);
    });

    // Endpoint khusus mobile Petugas (Update GPS & Transaksi dari HP)
    Route::middleware('role:petugas')->prefix('petugas')->group(function () {
        Route::get('/tasks', [\App\Http\Controllers\Petugas\TaskController::class, 'apiIndex']);
        Route::post('/update-location', [\App\Http\Controllers\Petugas\ProfileController::class, 'apiUpdateLocation']);
        Route::post('/transaction/{scheduleId}/complete', [\App\Http\Controllers\Petugas\TransactionController::class, 'apiCompleteTransaction']);
    });
    
    // Logout API
    Route::post('/logout', [AuthController::class, 'apiLogout']);
});
