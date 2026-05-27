<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthInterfaceService
{
    /**
     * Memproses registrasi warga baru.
     */
    public function registerWarga(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'warga',
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    /**
     * Menentukan rute tujuan setelah login berdasarkan role.
     */
    public function getRedirectRouteByRole($role)
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'petugas' => route('petugas.dashboard'),
            'warga' => route('warga.dashboard'),
            default => route('login'),
        };
    }
}