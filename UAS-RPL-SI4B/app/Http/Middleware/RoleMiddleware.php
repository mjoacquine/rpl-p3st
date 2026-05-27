<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // 2. PERBAIKAN: Gunakan in_array dengan underscore dan variabel $roles yang benar
        // $roles di sini otomatis menjadi array dari parameter rute web.php
        if (!in_array($user->role, $roles)) {
            // Jika role tidak cocok, arahkan kembali
            return redirect('/login')->withErrors(['role' => 'Akses ditolak! Anda tidak memiliki izin.']);
        }

        return $next($request);
    }
}