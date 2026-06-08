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
            return $request->expectsJson() 
                ? response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401)
                : redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. LOGIKA VERIFIKASI EMAIL
        if ($user->role === 'warga' && !$user->hasVerifiedEmail()) {
            if (is_null($user->google_id)) {
                Auth::logout();
                return $request->expectsJson()
                    ? response()->json(['status' => 'error', 'message' => 'Email not verified.'], 403)
                    : redirect()->route('verification.notice')
                        ->with('error', 'Akun Anda belum diverifikasi. Silakan cek email Anda.');
            }
        }

        // 3. CEK OTORITAS ROLE (DIPERBAIKI)
        // Kita ubah user->role ke lowercase dan semua role yang diizinkan ke lowercase
        $userRole = strtolower($user->role);
        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            return $request->expectsJson()
                ? response()->json(['status' => 'error', 'message' => 'Forbidden Access.'], 403)
                : abort(403, 'Akses Ditolak: Anda tidak memiliki otoritas untuk mengakses halaman ini.');
        }

        // 4. Jika semua syarat terpenuhi
        return $next($request);
    }
}