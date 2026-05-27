<?php
namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RouteOptimizer
{
    public function getOptimizedRoute()
    {
        $tasks = Transaction::with('user')->where('status', 'menunggu')->get();
        if ($tasks->isEmpty()) return collect([]);

        try {
            $origin = "Kantor P3ST, Sumatera Selatan";
            $destinations = implode('|', $tasks->pluck('address')->toArray());
            
            $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'origins' => $origin,
                'destinations' => $destinations,
                'key' => env('MAPS_API_KEY')
            ]);

            if ($response->successful() && $response->json()['status'] === 'OK') {
                $elements = $response->json()['rows'][0]['elements'];
                foreach ($tasks as $index => $task) {
                    $task->distance_value = $elements[$index]['status'] === 'OK' ? $elements[$index]['distance']['value'] : 999999;
                }
                return $tasks->sortBy('distance_value')->values();
            }
            throw new \Exception("Respon Maps API bukan OK");

        } catch (\Exception $e) {
            Log::error("API Maps Gagal, fallback ke FIFO: " . $e->getMessage());
            // Sistem Cadangan: Urutkan berdasarkan waktu pesan (FIFO)
            return $tasks->sortBy('created_at')->values();
        }
    }
}