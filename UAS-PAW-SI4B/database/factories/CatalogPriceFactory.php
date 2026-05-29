<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CatalogPrice;
use Carbon\Carbon;

class CatalogPriceFactory extends Factory
{
    protected $model = CatalogPrice::class;

    public function definition(): array
    {
        return [
            'category_name' => fake()->word() . ' Daur Ulang',
            'price_per_kg' => fake()->randomFloat(2, 1000, 7000), // Harga antara 1.000 s/d 7.000
            'effective_date' => Carbon::now()->startOfMonth(),
        ];
    }
}