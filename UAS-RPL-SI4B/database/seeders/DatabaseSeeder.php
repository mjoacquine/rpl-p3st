<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,         // 1. User
            CatalogPriceSeeder::class, // 2. Katalog Harga
            TransactionSeeder::class,  // 3. Transaksi Historis
        ]);
    }
}