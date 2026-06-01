<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            // Mengambil user secara acak atau membuat user baru ber-role warga
            'warga_id' => User::factory()->state(['role' => 'warga']),
            'petugas_id' => User::factory()->state(['role' => 'petugas']),
            'pickup_date' => fake()->dateTimeBetween('-1 month', '+1 week')->format('Y-m-d'),
            'pickup_time' => fake()->time('H:i:s'),
            'estimated_weight' => fake()->randomFloat(2, 2, 20), // Estimasi 2kg s/d 20kg
            'status' => fake()->randomElement(['menunggu', 'dikonfirmasi', 'diproses', 'selesai', 'batal']),
            'notes' => fake()->sentence(),
        ];
    }
}