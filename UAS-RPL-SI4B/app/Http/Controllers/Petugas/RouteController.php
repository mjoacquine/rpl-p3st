<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\RouteOptimizer;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    protected $routeOptimizer;

    public function __construct(RouteOptimizer $routeOptimizer)
    {
        $this->routeOptimizer = $routeOptimizer;
    }

    // FUNGSI UNTUK SATU RUTE (Sudah ada)
    public function show($scheduleId)
    {
        $petugas = Auth::user();
        $schedule = Schedule::with('warga')->findOrFail($scheduleId);

        $singleCollection = collect([$schedule]);
        $optimized = $this->routeOptimizer->optimizeSchedules((float)$petugas->latitude, (float)$petugas->longitude, $singleCollection);
        
        $targetRoute = $optimized->first();

        return view('Petugas.Route.show', compact('targetRoute', 'petugas'));
    }

    /**
     * BARU: Optimasi Semua Rute Aktif
     */
    public function optimizeAll()
    {
        $petugas = Auth::user();
        
        // 1. Ambil semua jadwal yang sudah diterima petugas (diproses)
        $activeSchedules = Schedule::with('warga')
            ->where('petugas_id', $petugas->id)
            ->whereIn('status', ['diproses']) // Sesuaikan statusnya
            ->get();

        if ($activeSchedules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal penjemputan aktif.');
        }

        // 2. Optimasi seluruh koleksi jadwal
        $optimizedSchedules = $this->routeOptimizer->optimizeSchedules(
            (float)$petugas->latitude, 
            (float)$petugas->longitude, 
            $activeSchedules
        );

        // 3. Susun URL Google Maps dengan Waypoints (Optimized)
        $origin = $petugas->latitude . ',' . $petugas->longitude;
        
        // Buat list waypoints dari koordinat warga
        $waypoints = $optimizedSchedules->map(function($s) {
            return $s->warga->latitude . ',' . $s->warga->longitude;
        })->implode('|');

        // Parameter &optimize=true memerintahkan Google menyusun urutan tercepat
        $mapsUrl = "https://www.google.com/maps/dir/?api=1" .
                   "&origin=" . $origin .
                   "&destination=" . $optimizedSchedules->last()->warga->latitude . "," . $optimizedSchedules->last()->warga->longitude .
                   "&waypoints=" . $waypoints .
                   "&optimize=true" .
                   "&travelmode=driving";

        return redirect()->away($mapsUrl);
    }
}