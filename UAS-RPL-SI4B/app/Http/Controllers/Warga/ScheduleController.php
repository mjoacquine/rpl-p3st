<?php
namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CatalogPrice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Transaction::where('user_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('warga.schedule.index', compact('schedules'));
    }

    public function create()
    {
        // Lempar data kategori agar view punya pilihan jenis sampah
        $categories = CatalogPrice::all();
        return view('warga.schedule.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:catalog_prices,category_id',
            'pickup_date' => 'required|date|after_or_equal:today',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Perbaikan: Wajib menyertakan format ID dan default nilai angka
        $datePrefix = Carbon::parse($request->pickup_date)->format('ymd');
        $randomStr = strtoupper(Str::random(4));
        $transactionId = 'TX-' . $datePrefix . '-' . $randomStr;

        Transaction::create([
            'transaction_id' => $transactionId,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'pickup_date' => $request->pickup_date,
            'weight_actual' => 0.00,
            'price_final' => 0.00,
            'address' => $request->address,
            'notes' => $request->notes,
            'status' => 'menunggu', 
        ]);

        return redirect()->route('warga.schedule.index')->with('success', 'Jadwal penjemputan berhasil dibuat! Menunggu konfirmasi petugas.');
    }

    public function destroy($id)
    {
        // Perbaikan: Pakai 'transaction_id' bukan 'id'
        $schedule = Transaction::where('transaction_id', $id)
                               ->where('user_id', Auth::id())
                               ->firstOrFail();

        if ($schedule->status == 'menunggu') {
            $schedule->delete();
            return redirect()->back()->with('success', 'Jadwal penjemputan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Jadwal tidak bisa dibatalkan karena petugas sudah mulai memproses.');
    }
}