<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci pengecekan
            [
                'name' => 'Siti Chairunisah Suyta',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Kantor P3ST Pusat Palembang',
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Petugas Pengepul
        User::updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Michael Andrew',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'phone' => '081298765432',
                'latitude' => -2.990934,
                'longitude' => 104.756554,
                'email_verified_at' => now(),
            ]
        );

        // 3. Akun Warga 1
        User::updateOrCreate(
            ['email' => 'joacquine@gmail.com'],
            [
                'name' => 'M Joacquine WQ',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'phone' => '081122334455',
                'address' => 'Jl. Jendral Sudirman, Palembang',
                'latitude' => -2.976073,
                'longitude' => 104.745435,
                'email_verified_at' => now(),
            ]
        );

        // 4. Akun Warga 2
        User::updateOrCreate(
            ['email' => 'darren@gmail.com'],
            [
                'name' => 'Darren Ariyo JT',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'phone' => '089988776655',
                'address' => 'Jl. Veteran, Palembang',
                'latitude' => -2.970123,
                'longitude' => 104.750123,
                'email_verified_at' => now(),
            ]
        );
    }
}