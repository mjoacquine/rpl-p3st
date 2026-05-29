<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthInterfaceService
{
    /**
     * Proses Login Web Stateful
     */
    public function attemptWebLogin(array $credentials): User
    {
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
        ]);
    }

    /**
     * Proses Logout Web
     */
    public function performWebLogout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Pembuatan API Token untuk Mobile App (Jika Warga/Petugas login dari HP)
     */
    public function generateApiToken(User $user): string
    {
        // Hapus token lama agar single-device policy berjalan (opsional)
        $user->tokens()->delete();
        
        return $user->createToken('p3st-mobile-access')->plainTextToken;
    }
}