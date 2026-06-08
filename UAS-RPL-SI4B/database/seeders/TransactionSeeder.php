<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil ID yang sudah dibuat sebelumnya dalam bentuk Array
        $wargaIds = DB::table('users')->where('role', 'warga')->pluck('id')->toArray();
        $petugasIds = DB::table('users')->where('role', 'petugas')->pluck('id')->toArray();
        $catalogs = DB::table('catalog_prices')->get();

        // 1. VALIDASI KEAMANAN: Cegah error jika data master belum ada
        if (empty($wargaIds) || empty($petugasIds) || $catalogs->isEmpty()) {
            $this->command->error('GAGAL: Pastikan Anda sudah membuat minimal 1 Warga, 1 Petugas, dan 1 Harga Katalog sebelum menjalankan seeder ini!');
            return;
        }

        $this->command->info('Mulai men-generate 30 transaksi riwayat P3ST...');

        $totalWeightBulanan = 0;
        $totalIncomeBulanan = 0;

        for ($i = 0; $i < 30; $i++) {
            // Pemilihan Aktor & Katalog secara Acak
            $wargaId = $faker->randomElement($wargaIds);
            $petugasId = $faker->randomElement($petugasIds); // Diperbaiki: Acak dari banyak petugas
            $catalog = $faker->randomElement($catalogs);
            
            // Estimasi berat oleh warga antara 2kg hingga 15kg
            $estimasiBerat = $faker->randomFloat(2, 2, 15);
            
            // Berat aktual (bisa selisih sedikit dari estimasi saat petugas menimbang)
            $beratAktual = $estimasiBerat + $faker->randomFloat(2, -0.5, 1.5); 
            if ($beratAktual <= 0) $beratAktual = 1; // Cegah minus
            
            $hargaFinal = $beratAktual * $catalog->price_per_kg;

            // Buat Data Jadwal (Schedule)
            $scheduleId = Str::uuid();
            $pickupDate = Carbon::now()->subDays(rand(1, 28)); // Acak hari dalam sebulan terakhir
            
            DB::table('schedules')->insert([
                'id' => $scheduleId,
                'warga_id' => $wargaId,
                'petugas_id' => $petugasId,
                'pickup_date' => $pickupDate->toDateString(),
                'pickup_time' => $faker->time('H:i:s'),
                'estimated_weight' => $estimasiBerat,
                'status' => 'selesai',
                'notes' => 'Tolong timbang dengan pas ya mas.',
                'created_at' => $pickupDate,
                'updated_at' => $pickupDate,
            ]);

            // Buat Data Transaksi (Transaction)
            DB::table('transactions')->insert([
                'id' => Str::uuid(),
                'schedule_id' => $scheduleId,
                'category_id' => $catalog->category_id, // Pastikan nama kolom di tabel Anda 'category_id' atau 'id'
                'weight_actual' => $beratAktual,
                'price_final' => $hargaFinal,
                'status' => 'selesai',
                'created_at' => $pickupDate,
                'updated_at' => $pickupDate,
            ]);

            // Akumulasi untuk Laporan Bulanan
            $totalWeightBulanan += $beratAktual;
            $totalIncomeBulanan += $hargaFinal;
        }

        // 3. Buat Data Laporan Bulanan (Monthly Report) dari agregasi 30 transaksi
        // Asumsi konversi CO2: 1 Kg sampah = 2.5 Kg CO2eq
        DB::table('monthly_reports')->insert([
            'id' => Str::uuid(),
            'report_month' => Carbon::now()->month,
            'report_year' => Carbon::now()->year,
            'total_weight' => $totalWeightBulanan,
            'total_income' => $totalIncomeBulanan,
            'total_co2_reduction' => $totalWeightBulanan * 2.5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('SUKSES! 30 data riwayat transaksi dan Laporan Bulanan berhasil dimasukkan ke Database.');
    }
}