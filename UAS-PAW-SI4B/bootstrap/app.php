<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Mendaftarkan Middleware Role P3ST
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // MENGATASI ERROR LOGIN: 
        // Arahkan otomatis ke dashboard masing-masing jika user yang sudah login mencoba buka halaman login/register
        $middleware->redirectUsersTo(function (Request $request) {
            $role = auth()->user()->role ?? 'warga';
            
            if ($role === 'admin') {
                return route('admin.dashboard');
            } elseif ($role === 'petugas') {
                return route('petugas.dashboard');
            }
            
            return route('warga.dashboard');
        });
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();