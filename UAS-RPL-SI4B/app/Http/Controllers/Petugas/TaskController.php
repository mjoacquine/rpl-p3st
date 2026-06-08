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
        // Cari order masuk berstatus 'menunggu' yang belum diklaim petugas manapun
        $availableTasks = DB::table('schedules')
            ->join('users', 'schedules.warga_id', '=', 'users.id')
            ->where('schedules.status', 'menunggu')
            ->select('schedules.*', 'users.name as warga_name', 'users.address as warga_address')
            ->orderBy('schedules.pickup_date', 'asc')
            ->get();

        return view('Petugas.Task.index', compact('availableTasks'));
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
}