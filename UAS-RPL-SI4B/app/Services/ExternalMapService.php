<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalMapService
{
    protected $apiKey;
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
    }

    /**
     * Mengambil jarak tempuh (meter) dan waktu (detik) sesungguhnya dari Google Maps
     */
    public function getDistanceMatrix(float $originLat, float $originLng, float $destLat, float $destLng): ?array
    {
        if (empty($this->apiKey)) {
            Log::warning('Google Maps API Key is missing.');
            return null;
        }

        try {
            $response = Http::timeout(10)->get($this->baseUrl, [
                'origins' => "{$originLat},{$originLng}",
                'destinations' => "{$destLat},{$destLng}",
                'key' => $this->apiKey,
                'mode' => 'driving' // Asumsi petugas menggunakan motor/mobil
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Pengecekan struktur respons Google Maps
                if ($data['status'] === 'OK' && isset($data['rows'][0]['elements'][0])) {
                    $element = $data['rows'][0]['elements'][0];
                    
                    if ($element['status'] === 'OK') {
                        return [
                            'distance_meters' => $element['distance']['value'],
                            'distance_text' => $element['distance']['text'],
                            'duration_seconds' => $element['duration']['value'],
                            'duration_text' => $element['duration']['text']
                        ];
                    }
                }
            }
            
            Log::error('Google Maps API returned error status: ' . json_encode($response->json()));
            return null;

        } catch (\Exception $e) {
            Log::error('ExternalMapService Exception: ' . $e->getMessage());
            return null;
        }
    }
}