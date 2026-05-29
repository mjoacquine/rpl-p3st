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

    public function update(Request $request, $scheduleId)
    {
        $request->validate([
            'category_id' => 'required|exists:catalog_prices,category_id',
            'weight_actual' => 'required|numeric|gt:0',
        ]);

        $schedule = Schedule::with('warga')->findOrFail($scheduleId);
        $catalog = $this->catalogDao->findById($request->category_id);

        $priceFinal = $this->calculator->calculateEstimatedPrice(
            (float)$request->weight_actual, 
            (float)$catalog->price_per_kg
        );

        Transaction::create([
            'schedule_id' => $schedule->id,
            'category_id' => $catalog->category_id,
            'weight_actual' => $request->weight_actual,
            'price_final' => $priceFinal,
            'status' => 'selesai'
        ]);

        $this->scheduleProcessor->completeSchedule($schedule);

        // EKSEKUSI NOTIFIKASI WA KEPADA WARGA SAAT SELESAI TIMBANG
        try {
            $notification = new WhatsappNotification();
            $notification->setRecipient($schedule->warga->phone)
                         ->setMessage("BANK SAMPAH P3ST: Transaksi selesai! Berat aktual: " . $request->weight_actual . " Kg, Dana tunai diserahkan: Rp " . number_format($priceFinal, 0, ',', '.'))
                         ->send();
        } catch (\Exception $e) {
            // Silently skip
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Transaksi lunas berhasil dicatat dan struk digital siap dicetak.');
    }

    public function receipt($scheduleId)
    {
        // Dapat diakses oleh petugas pengepul
        $schedule = Schedule::with(['warga', 'petugas'])->findOrFail($scheduleId);
        $transaction = Transaction::with('catalogPrice')->where('schedule_id', $schedule->id)->firstOrFail();

        return view('Warga.Schedule.receipt', compact('schedule', 'transaction'));
    }
}