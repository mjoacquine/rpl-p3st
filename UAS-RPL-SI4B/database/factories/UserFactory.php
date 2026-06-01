<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;
    
    // Password default untuk semua akun hasil generate
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            'role' => fake()->randomElement(['warga', 'warga', 'warga', 'petugas']), // Warga lebih banyak dari petugas
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            // Acak koordinat di sekitar wilayah Palembang
            'latitude' => fake()->latitude(-3.050000, -2.900000), 
            'longitude' => fake()->longitude(104.700000, 104.800000),
            'remember_token' => Str::random(10),
        ];
    }
}