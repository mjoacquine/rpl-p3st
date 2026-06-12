<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan lokalisasi Indonesia agar data bawaan Faker menyesuaikan
        $faker = Faker::create('id_ID'); 

        // Ambil semua ID user yang memiliki role warga dan petugas
        $wargaIds = User::where('role', 'warga')->pluck('id')->toArray();
        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();

        // Pengaman seandainya di database belum ada user sama sekali
        if (empty($wargaIds) || empty($petugasIds)) {
            $this->command->error('Gagal mengisi data dummy: Pastikan sudah ada user dengan role warga dan petugas di database!');
            return;
        }

        $statuses = ['menunggu', 'diproses', 'selesai', 'batal'];

        $this->command->info('Sedang menyuntikkan 35 data dummy transaksi penjemputan...');

        for ($i = 1; $i <= 35; $i++) {
            $status = $faker->randomElement($statuses);

            // Acak waktu penjemputan dari 30 hari lalu hingga 5 hari ke depan
            $pickupTime = Carbon::now()
                ->addDays($faker->numberBetween(-30, 5))
                ->setHour($faker->numberBetween(8, 16)) // Jam operasional 08:00 - 16:00
                ->setMinute($faker->randomElement([0, 15, 30, 45]))
                ->setSecond(0);

           Schedule::create([
                'warga_id'    => $faker->randomElement($wargaIds),
                'petugas_id'  => $status === 'menunggu' ? null : $faker->randomElement($petugasIds),
                'status'      => $status,
                
                // 💡 TAMBAHKAN BARIS INI (Ambil tanggalnya saja: YYYY-MM-DD)
                'pickup_date' => $pickupTime->format('Y-m-d'), 
                
                'pickup_time' => $pickupTime,
                'estimated_weight' => $faker->randomFloat(2, 2, 65),
            ]);   // Jika statusnya masih 'menunggu', petugas_id dikosongkan (belum diklaim)
          
        }

        $this->command->info('Sukses! 35 data dummy transaksi berhasil dimasukkan ke database.');
    }
}