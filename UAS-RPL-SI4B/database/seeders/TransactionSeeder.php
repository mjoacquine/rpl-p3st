<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [];
        
        // Definisikan harga referensi untuk kalkulasi matematis
        $hargaPlastik = 3000;
        $hargaKertas = 2000;
        $hargaLogam = 7000;

        // Ambil ID secara dinamis dari tabel catalog_prices 
        $idPlastik = DB::table('catalog_prices')->where('category_name', 'like', '%Plastik%')->value('category_id') ?? 'KAT-001';
        $idKertas = DB::table('catalog_prices')->where('category_name', 'like', '%Kertas%')->value('category_id') ?? 'KAT-002';
        $idLogam = DB::table('catalog_prices')->where('category_name', 'like', '%Logam%')->value('category_id') ?? 'KAT-003';

        // Ambil ID khusus untuk akun yang role-nya 'warga' 
        $userId = DB::table('users')->where('role', 'warga')->value('id') ?? 3;

        // Array data mentah 30 transaksi historis warga (P3ST)
        $dummyData = [
            ['id' => 1,  'weight' => 5.5,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 2,  'weight' => 12.0, 'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 3,  'weight' => 3.2,  'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 4,  'weight' => 8.0,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 5,  'weight' => 15.5, 'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 6,  'weight' => 0.0,  'price_per_kg' => $hargaPlastik, 'status' => 'Batal'],
            ['id' => 7,  'weight' => 20.0, 'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 8,  'weight' => 4.5,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 9,  'weight' => 9.2,  'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 10, 'weight' => 6.0,  'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 11, 'weight' => 7.5,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 12, 'weight' => 11.0, 'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 13, 'weight' => 2.5,  'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 14, 'weight' => 14.0, 'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 15, 'weight' => 5.0,  'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 16, 'weight' => 0.0,  'price_per_kg' => $hargaLogam,   'status' => 'Batal'],
            ['id' => 17, 'weight' => 18.5, 'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 18, 'weight' => 22.0, 'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 19, 'weight' => 1.8,  'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 20, 'weight' => 10.0, 'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 21, 'weight' => 6.4,  'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 22, 'weight' => 13.5, 'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 23, 'weight' => 3.0,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 24, 'weight' => 8.7,  'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 25, 'weight' => 0.0,  'price_per_kg' => $hargaPlastik, 'status' => 'Menunggu'],
            ['id' => 26, 'weight' => 0.0,  'price_per_kg' => $hargaKertas,  'status' => 'Menunggu'],
            ['id' => 27, 'weight' => 16.0, 'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
            ['id' => 28, 'weight' => 4.2,  'price_per_kg' => $hargaPlastik, 'status' => 'Selesai'],
            ['id' => 29, 'weight' => 19.0, 'price_per_kg' => $hargaKertas,  'status' => 'Selesai'],
            ['id' => 30, 'weight' => 35.0, 'price_per_kg' => $hargaLogam,   'status' => 'Selesai'],
        ];

        foreach ($dummyData as $data) {
            $categoryId = $idPlastik;
            if ($data['price_per_kg'] == $hargaKertas) {
                $categoryId = $idKertas;
            } elseif ($data['price_per_kg'] == $hargaLogam) {
                $categoryId = $idLogam;
            }

            $generatedDate = Carbon::now()->subDays(30 - $data['id']);

            $transactions[] = [
                'transaction_id' => 'TX-' . str_pad($data['id'], 3, '0', STR_PAD_LEFT),
                'user_id'        => $userId, 
                'category_id'    => $categoryId, 
                'pickup_date'    => $generatedDate->format('Y-m-d'),
                'address'        => 'Jl. Jend. Sudirman No. ' . $data['id'] . ', Palembang',
                'notes'          => 'Setoran sampah rutin data historis ke-' . $data['id'],
                'weight_actual'  => $data['weight'],
                'price_final'    => $data['weight'] * $data['price_per_kg'], 
                'status'         => strtolower($data['status']), 
                'created_at'     => $generatedDate,
                'updated_at'     => $generatedDate,
            ];
        }

        DB::table('transactions')->insert($transactions);
    }
}