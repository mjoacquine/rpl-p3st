<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\RouteOptimizer;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendReminderNotification;
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
    public function sendReminder($id)
{
    // 1. Cari data jadwal penjemputan beserta warga pemesannya
    $schedule = Schedule::with('warga')->findOrFail($id);
    $warga = $schedule->warga;

    // Keamanan: Cek jika data warga kosong
    if (!$warga) {
        return redirect()->back()->with('error', 'Gagal mengirim pengingat: Data warga tidak ditemukan.');
    }

    // 2. TRIGGER NOTIFIKASI KUNING!
    // Memanggil file notifikasi pengingat dan mengirimkannya ke akun warga
    // (Pastikan nama class Notification-mu sudah di-import di atas atau disesuaikan namanya)
    $warga->notify(new \App\Notifications\SendReminderNotification($schedule));

    // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Pesan pengingat berhasil dikirim! Lonceng warga kini telah menyala kuning.');
}
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
        
        // Buat list waypoints dari koordinat warga (Titik tengah perjalanan)
        // Kita keluarkan titik terakhir karena dia akan jadi 'destination'
        $waypointsSchedules = $optimizedSchedules->slice(0, -1);
        $waypoints = '';
        if ($waypointsSchedules->isNotEmpty()) {
            $waypoints = "&waypoints=" . $waypointsSchedules->map(function($s) {
                return $s->warga->latitude . ',' . $s->warga->longitude;
            })->implode('|');
        }
        // Titik akhir perjalanan
        $destination = $optimizedSchedules->last()->warga->latitude . "," . $optimizedSchedules->last()->warga->longitude;

        // Gunakan URL resmi Google Maps Directions API
        $mapsUrl = "https://www.google.com/maps/dir/?api=1" .
                   "&origin=" . $origin .
                   "&destination=" . $destination .
                   "&waypoints=" . $waypoints .
                   "&travelmode=driving";

        return redirect()->away($mapsUrl);
    }
}