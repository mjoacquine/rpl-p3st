<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleProcessor
{
    /**
     * Validasi waktu jemputan (Hanya jam operasional dan tidak boleh masa lalu)
     */
    public function isValidPickupTime(string $date, string $time): bool
    {
        try {
            $pickupDateTime = Carbon::createFromFormat('Y-m-d H:i', "{$date} {$time}");
            $now = Carbon::now();

            // Tidak boleh memesan untuk waktu yang sudah lewat
            if ($pickupDateTime->isBefore($now)) {
                return false;
            }

            // Batas jam kerja: 08:00 - 16:30
            $hour = $pickupDateTime->hour;
            $minute = $pickupDateTime->minute;
            
            if ($hour < 8 || $hour > 16 || ($hour == 16 && $minute > 30)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Invalid DateTime format provided: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Konfirmasi jadwal dan tugaskan ke petugas tertentu
     */
    public function assignPetugasToSchedule(Schedule $schedule, int $petugasId): Schedule
    {
        $schedule->update([
            'petugas_id' => $petugasId,
            'status' => 'dikonfirmasi'
        ]);
        
        return $schedule->fresh();
    }

    /**
     * Eksekusi penyelesaian jadwal setelah transaksi ditimbang petugas
     */
    public function completeSchedule(Schedule $schedule): bool
    {
        return $schedule->update(['status' => 'selesai']);
    }
}