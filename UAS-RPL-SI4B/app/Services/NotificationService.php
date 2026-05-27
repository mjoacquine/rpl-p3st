<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Mengirim notifikasi ganda: Log Sistem & API WhatsApp
     */
    public function sendNotification($userId, $message, $targetPhone = null)
    {
        // 1. Catat di log sistem internal
        Log::channel('daily')->info("NOTIFIKASI WARGA [User: {$userId}]: " . $message);

        // 2. Tembak ke API Fonnte (WhatsApp) jika nomor HP tersedia
        if ($targetPhone) {
            try {
                Http::withHeaders([
                    'Authorization' => env('FONNTE_TOKEN')
                ])->post('https://api.fonnte.com/send', [
                    'target' => $targetPhone,
                    'message' => $message,
                ]);
            } catch (\Exception $e) {
                Log::error("API WA Gagal: " . $e->getMessage());
            }
        }
    }
}