<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappNotification extends NotificationService
{
    public function send(): bool
    {
        try {
            // 1. Mengambil token API Fonnte dari file konfigurasi (berasal dari .env)
            $token = config('services.whatsapp.api_key'); 

            // 2. Cegah error jika token lupa diisi di .env
            if (empty($token)) {
                Log::warning("Gagal mengirim WA: Token Fonnte API belum diatur di file .env");
                return false;
            }
            
            // 3. Mengirim request ke API Fonnte
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $this->recipient, // Nomor HP tujuan (Warga)
                'message' => $this->message,  // Isi pesan konfirmasi
                'countryCode' => '62',        // Menyesuaikan otomatis (08 atau 62)
            ]);

            // 4. Jika pengiriman sukses diterima oleh sistem Fonnte
            if ($response->successful() && $response->json('status') == true) {
                // Mencatat keberhasilan di file log untuk keperluan debugging
                Log::info("Notifikasi WA berhasil dikirim ke: {$this->recipient}");
                return true;
            }

            // 5. Catat error jika API Fonnte menolak (misal: token salah/limit habis)
            Log::error("Fonnte API Error: " . json_encode($response->json()));
            return false;

        } catch (\Exception $e) {
            // 6. Catat error jika terjadi masalah internet/server down
            Log::error("Sistem gagal terhubung ke Fonnte untuk nomor {$this->recipient}. Error: " . $e->getMessage());
            return false;
        }
    }
}