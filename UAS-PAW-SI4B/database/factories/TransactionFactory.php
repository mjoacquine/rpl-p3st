<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\Schedule;
use App\Models\CatalogPrice;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $beratAktual = fake()->randomFloat(2, 2, 20);
        $hargaPerKg = fake()->randomFloat(2, 1000, 5000);

        return [
            'id' => Str::uuid(),
            // Jika memanggil Transaction::factory()->create(), ini akan otomatis membuat Schedule & Catalog baru jika belum di-passing
            'schedule_id' => Schedule::factory(),
            'category_id' => CatalogPrice::factory(),
            'weight_actual' => $beratAktual,
            'price_final' => $beratAktual * $hargaPerKg,
            'status' => fake()->randomElement(['menunggu', 'selesai', 'batal']),
        ];
    }
}