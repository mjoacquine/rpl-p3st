<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request dan pastikan role pengguna sesuai.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return $request->expectsJson() 
                ? response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401)
                : redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user saat ini ada di dalam daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            return $request->expectsJson()
                ? response()->json(['status' => 'error', 'message' => 'Forbidden Access.'], 403)
                : abort(403, 'Akses Ditolak: Anda tidak memiliki izin (otoritas role) untuk mengakses halaman ini.');
        }

        // 3. Jika lolos, lanjutkan request
        return $next($request);
    }
}