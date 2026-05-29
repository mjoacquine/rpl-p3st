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
        User::create([
            'name' => 'Siti Chairunisah Suyta', // Admin representatif
            'email' => 'admin@p3st.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor P3ST Pusat Palembang'
        ]);

        // 2. Akun Petugas Pengepul
        User::create([
            'name' => 'Michael Andrew', // Petugas representatif
            'email' => 'petugas@p3st.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'phone' => '081298765432',
            'latitude' => -2.990934, // Koordinat default Palembang
            'longitude' => 104.756554,
        ]);

        // 3. Akun Warga
        User::create([
            'name' => 'M Joacquine WQ',
            'email' => 'joacquine@warga.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'phone' => '081122334455',
            'address' => 'Jl. Jendral Sudirman, Palembang',
            'latitude' => -2.976073,
            'longitude' => 104.745435,
        ]);

        User::create([
            'name' => 'Darren Ariyo JT',
            'email' => 'darren@warga.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'phone' => '089988776655',
            'address' => 'Jl. Veteran, Palembang',
            'latitude' => -2.970123,
            'longitude' => 104.750123,
        ]);
    }
}