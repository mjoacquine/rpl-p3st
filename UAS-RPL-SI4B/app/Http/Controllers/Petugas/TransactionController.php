<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Repositories\CatalogDao;
use App\Services\EconomicCalculator;
use App\Services\ScheduleProcessor;
use App\Services\WhatsappNotification;

class TransactionController extends Controller
{
    protected $catalogDao;
    protected $calculator;
    protected $scheduleProcessor;

    public function __construct(CatalogDao $catalogDao, EconomicCalculator $calculator, ScheduleProcessor $scheduleProcessor)
    {
        $this->catalogDao = $catalogDao;
        $this->calculator = $calculator;
        $this->scheduleProcessor = $scheduleProcessor;
    }

    public function edit($scheduleId)
    {
        $schedule = Schedule::with('warga')->findOrFail($scheduleId);
        $categories = $this->catalogDao->getAllCategories();
        
        return view('Petugas.Transaction.edit', compact('schedule', 'categories'));
    }

    public function update(Request $request, $scheduleId, WhatsappNotification $waService)
    {
        $request->validate([
            'category_id' => 'required|exists:catalog_prices,category_id',
            'weight_actual' => 'required|numeric|gt:0',
        ]);

        $schedule = Schedule::with('warga')->findOrFail($scheduleId);
        $catalog = $this->catalogDao->findById($request->category_id);

        // Kalkulasi harga final
        $priceFinal = $this->calculator->calculateEstimatedPrice(
            (float)$request->weight_actual, 
            (float)$catalog->price_per_kg
        );

        // 1. Simpan Transaksi dengan status 'menunggu_konfirmasi'
        Transaction::updateOrCreate(
            ['schedule_id' => $schedule->id],
            [
                'category_id' => $catalog->category_id,
                'weight_actual' => $request->weight_actual,
                'price_final' => $priceFinal,
                'status' => 'menunggu_konfirmasi'
            ]
        );

        // 2. Ubah status schedule menjadi 'menunggu_konfirmasi' 
        // (Ini menahan status agar tidak 'selesai' sebelum warga klik Setuju)
        $schedule->update(['status' => 'menunggu_konfirmasi']);

        // 3. EKSEKUSI NOTIFIKASI WA (Instruksi Konfirmasi)
        if (!empty($schedule->warga->phone) && $schedule->warga->phone !== '-') {
            $message = "*BANK SAMPAH P3ST - KONFIRMASI*\n\n" .
                       "Petugas telah menyelesaikan penimbangan:\n" .
                       "Berat: *{$request->weight_actual} Kg*\n" .
                       "Estimasi Dana: *Rp " . number_format($priceFinal, 0, ',', '.') . "*\n\n" .
                       "Mohon segera buka Dashboard Web Anda untuk *Konfirmasi* atau *Batalkan* transaksi ini agar dana bisa diproses.";
            
            $waService->setRecipient($schedule->warga->phone)
                      ->setMessage($message)
                      ->send();
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Timbangan berhasil dikirim. Menunggu persetujuan warga.');
    }

    /**
     * Membatalkan Transaksi (Bisa dilakukan petugas jika terjadi kesalahan)
     */
    public function cancel($scheduleId, WhatsappNotification $waService)
    {
        $schedule = Schedule::with('warga')->findOrFail($scheduleId);
        
        // Ubah status menjadi 'batal'
        $schedule->update(['status' => 'batal']);

        // Notifikasi pembatalan
        if (!empty($schedule->warga->phone) && $schedule->warga->phone !== '-') {
            $message = "*BANK SAMPAH P3ST*\n\n" .
                       "Maaf, transaksi penjemputan Anda dibatalkan oleh petugas. Silakan hubungi admin jika ada kendala.";
            
            $waService->setRecipient($schedule->warga->phone)
                      ->setMessage($message)
                      ->send();
        }

        return redirect()->route('petugas.dashboard')
            ->with('error', 'Penjemputan telah dibatalkan.');
    }

    public function receipt($scheduleId)
    {
        $schedule = Schedule::with(['warga', 'petugas'])->findOrFail($scheduleId);
        
        // Validasi: Nota hanya bisa dicetak jika status sudah 'selesai'
        if ($schedule->status !== 'selesai') {
            return redirect()->back()->with('error', 'Nota hanya bisa dicetak setelah transaksi selesai dikonfirmasi.');
        }

        $transaction = Transaction::with('catalogPrice')->where('schedule_id', $schedule->id)->firstOrFail();

        return view('Warga.Schedule.receipt', compact('schedule', 'transaction'));
    }
    public function history()
{
    // Mengambil semua data transaksi beserta data warga (user) yang melakukan transaksi
    $transactions = \App\Models\Transaction::with('schedule.warga')
        ->orderBy('created_at', 'desc')
        ->get();

    // Melempar data ke view yang ada di folder views/Petugas/Transaction/index.blade.php
    return view('Petugas.Transaction.index', compact('transactions'));
}
}