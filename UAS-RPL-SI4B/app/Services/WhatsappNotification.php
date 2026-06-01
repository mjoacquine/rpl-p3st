<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappNotification extends NotificationService
{
    public function send(): bool
    {
        try {
            // Contoh menggunakan Fonnte API (Layanan WA Gateway populer di Indonesia)
            $token = config('services.whatsapp.api_key', 'YOUR_WA_TOKEN_HERE'); 
            
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $this->recipient, // Nomor HP tujuan
                'message' => $this->message,
                'countryCode' => '62',
            ]);

            if ($response->successful() && $response->json('status') == true) {
                return true;
            }

            Log::error("WhatsApp Gateway failed: " . json_encode($response->json()));
            return false;

        } catch (\Exception $e) {
            Log::error("Failed to send WA to {$this->recipient}. Error: " . $e->getMessage());
            return false;
        }
    }
}