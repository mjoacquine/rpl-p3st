<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\ScheduleProcessor;
use App\Models\Schedule;
use App\Services\WhatsappNotification;

class TaskController extends Controller
{
    protected $scheduleProcessor;

    public function __construct(ScheduleProcessor $scheduleProcessor)
    {
        $this->scheduleProcessor = $scheduleProcessor;
    }

    public function index()
{
    // 1. Ambil data petugas yang sedang login beserta koordinat terakhirnya
    $petugas = auth()->user();
    $latPetugas = $petugas->latitude;
    $lngPetugas = $petugas->longitude;

    // Pastikan petugas sudah set lokasi, jika belum beri nilai default (misal titik tengah kota)
    if (!$latPetugas || !$lngPetugas) {
        $latPetugas = -2.9909; 
        $lngPetugas = 104.7565;
    }

    // 2. Ambil jadwal penjemputan HARI INI yang berstatus 'menunggu'
    // (Sesuaikan nama model 'Schedule' dengan yang kalian pakai)
$jadwalMentah = \App\Models\Schedule::with('warga')
                ->whereDate('pickup_time', today()) // ✅ UBAH JADI SEPERTI INI
                ->where('status', 'menunggu')
                ->get();
    // 3. Proses Optimisasi Rute (Sorting dari jarak terdekat ke terjauh)
    $ruteOptimal = $jadwalMentah->sortBy(function ($item) use ($latPetugas, $lngPetugas) {
        // Kita hitung jarak antara Petugas dan lokasi Warga
        $jarak = $this->hitungJarakHaversine(
            $latPetugas,
            $lngPetugas,
            $item->warga->latitude, // Pastikan tabel warga punya kolom latitude
            $item->warga->longitude // Pastikan tabel warga punya kolom longitude
        );
        
        // Simpan hasil hitungan sementara ke dalam object agar bisa ditampilkan di Blade nanti
        $item->jarak_km = round($jarak, 2); 

        return $jarak; // Kembalikan nilai jarak untuk diurutkan oleh Laravel
    })->values(); // values() digunakan untuk me-reset nomor urut array

  // Simpan hasil sorting ke variabel yang namanya cocok dengan Blade kamu
$tasksToday = $ruteOptimal; 
return view('Petugas.Dashboard.index', compact('tasksToday'));
}

    public function accept($id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Memasukkan petugas ke jadwal dan otomatis mengubah status menjadi 'diproses' / 'diterima' di dalam service
        $this->scheduleProcessor->assignPetugasToSchedule($schedule, Auth::id());

        return redirect()->route('petugas.dashboard')->with('success', 'Penjemputan berhasil dikonfirmasi dan masuk ke rute harian Anda.');
    }

    /**
     * Konfirmasi Sampai & Kirim Notifikasi (Hanya via WhatsApp)
     */
    public function arrived($id, WhatsappNotification $waService)
    {
        // 1. Ambil data jadwal beserta data warga yang terkait
        $schedule = Schedule::with('warga')->findOrFail($id);
        
        // 2. UPDATE STATUS DI DATABASE (Penting agar data terekam sistem)
        // Ubah status menjadi 'arrived' atau status penanda petugas sudah di lokasi
        $schedule->update([
            'status' => 'sampai' 
        ]);

        $warga = $schedule->warga;
        $petugasName = Auth::user()->name;

        // 3. Siapkan pesan yang akan dikirim via WA
        $message = "*NOTIFIKASI P3ST*\n\nHalo {$warga->name}!\n\nPetugas P3ST atas nama *{$petugasName}* telah sampai di titik penjemputan ({$warga->address}).\n\nMohon bersiap, petugas akan segera melakukan penimbangan sampah Anda.";

        // 4. Kirim Notifikasi via WhatsApp (Cek jika nomor HP valid dan bukan strip '-')
        if (!empty($warga->phone) && $warga->phone !== '-') {
            $waService->setRecipient($warga->phone)
                      ->setMessage($message)
                      ->send();
        }

        // 5. Redirect langsung ke halaman form input timbangan fisik
        return redirect()->route('petugas.transaction.edit', $id)
            ->with('success', 'Status diperbarui menjadi "Sampai". Warga telah dinotifikasi via WhatsApp.');
    }

    public function apiIndex()
    {
        $tasks = DB::table('schedules')->where('status', 'menunggu')->get();
        return response()->json(['status' => 'success', 'data' => $tasks]);
    }
    private function hitungJarakHaversine($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Radius bumi dalam kilometer

    // Ubah derajat ke radian
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    // Penerapan rumus Haversine
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    return $distance; // Akan menghasilkan jarak dalam satuan Kilometer (Km)
}
}