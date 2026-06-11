<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule; // Sesuaikan dengan nama model Jadwal kalian
use Carbon\Carbon;
use App\Notifications\PickupReminder; // Nanti dibuat di langkah 4

class SendPickupReminders extends Command
{
    // Ini nama perintah yang akan dipanggil oleh sistem
    protected $signature = 'app:send-pickup-reminders';
    protected $description = 'Memindai database dan mengirim notifikasi penjemputan untuk besok hari';

    public function handle()
    {
        // 1. Ambil tanggal besok
        $tomorrow = Carbon::tomorrow()->toDateString();

        // 2. Cari jadwal yang tanggalnya besok dan belum selesai/batal
        // ✅ SESUDAHNYA (Ganti pakai 'pickup_time')
$schedules = Schedule::with(['warga', 'petugas'])->get(); // Ambil semua data tanpa difilter!

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal penjemputan untuk besok.');
            return;
        }

        foreach ($schedules as $schedule) {
            // 3. Kirim notifikasi ke Petugas
            if ($schedule->petugas) {
                $schedule->petugas->notify(new PickupReminder($schedule, 'petugas'));
            }

            // 4. Kirim notifikasi ke Warga
            if ($schedule->warga) {
                $schedule->warga->notify(new PickupReminder($schedule, 'warga'));
            }
        }

        $this->info('Notifikasi pengingat penjemputan berhasil dikirim!');
    }
}