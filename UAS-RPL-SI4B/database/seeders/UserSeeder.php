<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Akun Admin Bank Sampah
        User::create([
            'name' => 'Admin P3ST Kelompok 6',
            'email' => 'admin@p3st.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Data Akun Kurir / Petugas Lapangan
        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@p3st.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // 3. Data Akun Warga / Nasabah Mandiri
        User::create([
            'name' => 'M Joacquine',
            'email' => 'warga@p3st.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'address' => 'Palembang',
        ]);
    }
}