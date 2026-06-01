<?php

namespace App\Services;

use Illuminate\Support\Collection;

class RouteOptimizer
{
    protected $mapService;

    public function __construct(ExternalMapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * Algoritma Nearest Neighbor (Greedy) untuk mengurutkan jadwal jemput
     */
    public function optimizeSchedules(float $currentLat, float $currentLng, Collection $schedules): Collection
    {
        if ($schedules->isEmpty()) {
            return collect([]);
        }

        $optimizedRoute = collect([]);
        $unvisited = $schedules->keyBy('id');
        
        $currentLocation = ['lat' => $currentLat, 'lng' => $currentLng];

        while ($unvisited->count() > 0) {
            $nearestScheduleId = null;
            $shortestDistance = PHP_INT_MAX;
            
            foreach ($unvisited as $id => $schedule) {
                // PERBAIKAN: Berikan nilai default (Pusat Kota Palembang) jika GPS Warga kosong (null)
                // Casting (float) akan memastikan tipe data sesuai dengan permintaan ExternalMapService
                $wargaLat = (float) ($schedule->warga->latitude ?? -2.990934); 
                $wargaLng = (float) ($schedule->warga->longitude ?? 104.756554);

                // Panggil Google Maps API
                $matrix = $this->mapService->getDistanceMatrix(
                    $currentLocation['lat'], 
                    $currentLocation['lng'], 
                    $wargaLat, 
                    $wargaLng
                );

                // Jika API gagal, fallback gunakan rumus Haversine jarak udara
                $distance = $matrix ? $matrix['distance_meters'] : $this->haversineDistance($currentLocation['lat'], $currentLocation['lng'], $wargaLat, $wargaLng);

                if ($distance < $shortestDistance) {
                    $shortestDistance = $distance;
                    $nearestScheduleId = $id;
                }
            }

            // Pindahkan jadwal terdekat ke rute optimal
            $nearestSchedule = $unvisited->get($nearestScheduleId);
            // Tambahkan atribut jarak agar bisa ditampilkan di View petugas
            $nearestSchedule->calculated_distance_meters = $shortestDistance; 
            
            $optimizedRoute->push($nearestSchedule);
            $unvisited->forget($nearestScheduleId);

            // Update posisi petugas ke titik warga yang baru saja ditambahkan
            // Gunakan fallback yang sama agar perulangan selanjutnya tidak crash
            $currentLocation = [
                'lat' => (float) ($nearestSchedule->warga->latitude ?? -2.990934), 
                'lng' => (float) ($nearestSchedule->warga->longitude ?? 104.756554)
            ];
        }

        return $optimizedRoute;
    }

    /**
     * Fallback perhitungan jarak lurus (meter) jika API Maps gangguan
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}