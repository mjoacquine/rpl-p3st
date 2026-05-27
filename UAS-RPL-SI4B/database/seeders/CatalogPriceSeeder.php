<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatalogPriceSeeder extends Seeder
{
    public function run(): void
    {
        // Berdasarkan Studi Kasus P3ST: Daftar harga sampah referensi per kategori
        $categories = [
            [
                'category_id' => 'KAT-001',
                'category_name' => 'Plastik (Botol/Gelas)',
                'unit' => 'kg',
                'price' => 3000.00,
                'effective_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 'KAT-002',
                'category_name' => 'Kertas / Kardus',
                'unit' => 'kg',
                'price' => 2000.00,
                'effective_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 'KAT-003',
                'category_name' => 'Logam / Besi / Aluminium',
                'unit' => 'kg',
                'price' => 7000.00,
                'effective_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data ke tabel catalog_prices
        DB::table('catalog_prices')->insert($categories);
    }
}