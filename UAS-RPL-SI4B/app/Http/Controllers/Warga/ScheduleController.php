<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Repositories\CatalogDao;
use App\Services\ScheduleProcessor;
use App\Services\WhatsappNotification;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $catalogDao;
    protected $scheduleProcessor;

    public function __construct(CatalogDao $catalogDao, ScheduleProcessor $scheduleProcessor)
    {
        $this->catalogDao = $catalogDao;
        $this->scheduleProcessor = $scheduleProcessor;
    }

    public function index()
    {
        $schedules = Schedule::where('warga_id', Auth::id())->latest()->get();
        return view('Warga.Schedule.index', compact('schedules'));
    }

    public function create()
    {
        $categories = $this->catalogDao->getAllCategories();
        return view('Warga.Schedule.create', compact('categories'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'estimated_weight' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        $isValid = $this->scheduleProcessor->isValidPickupTime($request->pickup_date, $request->pickup_time);
        
        if (!$isValid) {
            return redirect()->back()
                ->withErrors(['pickup_time' => 'Penjemputan hanya dilayani pada jam operasional bank sampah (08:00 - 16:30) dan tidak boleh waktu lampau.'])
                ->withInput();
        }

        $schedule = Schedule::create([
            'warga_id' => Auth::id(),
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'estimated_weight' => $request->estimated_weight,
            'status' => 'menunggu',
            'notes' => $request->notes,
        ]);

        // === 🚀 PEMICU NOTIFIKASI KE LONCENG PETUGAS 🚀 ===
        $semuaPetugas = \App\Models\User::where('role', 'petugas')->get();
        \Illuminate\Support\Facades\Notification::send($semuaPetugas, new \App\Notifications\OrderMasukNotification($schedule));
        // =================================================

        try {
            $notification = new WhatsappNotification();
            $notification->setRecipient(Auth::user()->phone)
                         ->setMessage("Halo " . Auth::user()->name . ", booking penjemputan sampah Anda berhasil dibuat. Status: MENUNGGU KLAIM PETUGAS.")
                         ->send();
        } catch (\Exception $e) {
            // Abaikan error gateway jika offline
        }

        return redirect()->route('warga.dashboard')->with('success', 'Jadwal berhasil diajukan!');
    }

    /**
     * BARU: Konfirmasi hasil timbangan oleh warga
     */
    public function confirm($id, WhatsappNotification $waService)
    {
        $schedule = Schedule::with('petugas')->where('warga_id', Auth::id())->findOrFail($id);

        if ($schedule->status !== 'menunggu_konfirmasi') {
            return redirect()->back()->with('error', 'Status transaksi tidak dapat dikonfirmasi.');
        }

        $schedule->update(['status' => 'selesai']);

        // Notifikasi ke Petugas bahwa warga setuju
        if ($schedule->petugas && $schedule->petugas->phone) {
            $waService->setRecipient($schedule->petugas->phone)
                      ->setMessage("Transaksi {$id} telah disetujui oleh warga. Transaksi SELESAI.")
                      ->send();
        }

        return redirect()->route('warga.dashboard')->with('success', 'Transaksi disetujui! Struk nota siap dicetak.');
    }

    /**
     * BARU: Pembatalan oleh warga karena tidak setuju harga
     */
    public function decline($id, WhatsappNotification $waService)
    {
        $schedule = Schedule::with('petugas')->where('warga_id', Auth::id())->findOrFail($id);

        $schedule->update(['status' => 'batal']);

        // Notifikasi ke Petugas bahwa warga membatalkan
        if ($schedule->petugas && $schedule->petugas->phone) {
            $waService->setRecipient($schedule->petugas->phone)
                      ->setMessage("Mohon maaf, transaksi {$id} dibatalkan oleh warga.")
                      ->send();
        }

        return redirect()->route('warga.dashboard')->with('error', 'Transaksi dibatalkan. Terima kasih atas konfirmasinya.');
    }

    public function cancel($id)
    {
        $schedule = Schedule::where('warga_id', Auth::id())->findOrFail($id);
        
        if ($schedule->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Gagal membatalkan. Jadwal sudah diambil oleh petugas.');
        }

        $schedule->update(['status' => 'batal']);
        return redirect()->route('warga.dashboard')->with('success', 'Penjadwalan dibatalkan.');
    }

    public function receipt($id)
    {
        $schedule = Schedule::with(['warga', 'petugas'])->where('warga_id', Auth::id())->findOrFail($id);
        
        // Proteksi: Hanya bisa cetak jika sudah selesai
        if ($schedule->status !== 'selesai') {
            return redirect()->back()->with('error', 'Nota belum tersedia karena transaksi belum selesai.');
        }

        $transaction = Transaction::where('schedule_id', $schedule->id)->firstOrFail();

        return view('Warga.Schedule.receipt', compact('schedule', 'transaction'));
    }
}