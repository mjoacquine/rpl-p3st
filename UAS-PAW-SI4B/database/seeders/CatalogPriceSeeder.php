<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatalogPriceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Plastik (PET/Bening)', 'price_per_kg' => 3500.00],
            ['category_name' => 'Kertas / Kardus', 'price_per_kg' => 2000.00],
            ['category_name' => 'Logam / Besi Tua', 'price_per_kg' => 5000.00],
            ['category_name' => 'Kaca', 'price_per_kg' => 1000.00],
            ['category_name' => 'Minyak Jelantah', 'price_per_kg' => 4500.00],
        ];

        foreach ($categories as $cat) {
            DB::table('catalog_prices')->insert([
                'category_name' => $cat['category_name'],
                'price_per_kg' => $cat['price_per_kg'],
                'effective_date' => Carbon::now()->startOfMonth(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}