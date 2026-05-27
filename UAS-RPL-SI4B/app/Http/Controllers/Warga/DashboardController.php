<?php
namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CatalogPrice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str; // Tambahan untuk memanggil Str::random

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $hariIni = Carbon::today()->toDateString();

        $transactions = Transaction::where('user_id', $userId)
                                   ->with('catalogPrice')
                                   ->latest()
                                   ->get();

        $totalKg = $transactions->where('status', 'selesai')->sum('weight_actual');
        $totalRp = $transactions->where('status', 'selesai')->sum('price_final');

        $hasBookedToday = Transaction::where('user_id', $userId)
                                     ->whereDate('created_at', $hariIni)
                                     ->exists();

        $categories = CatalogPrice::all();

        return view('warga.dashboard.index', compact('transactions', 'totalKg', 'totalRp', 'hasBookedToday', 'categories'));
    }

    public function storeBooking(Request $request)
    {
        $userId = Auth::id();
        $hariIni = Carbon::today()->toDateString();

        $hasBookedToday = Transaction::where('user_id', $userId)
                                     ->whereDate('created_at', $hariIni)
                                     ->exists();

        if ($hasBookedToday) {
            return redirect('/warga/dashboard')->withErrors([
                'booking' => 'Anda sudah melakukan booking penjemputan hari ini. Silakan tunggu petugas datang!'
            ]);
        }

        $request->validate([
            'category_id' => 'required|exists:catalog_prices,category_id',
            'address' => 'required|string|max:500'
        ]);

        $datePrefix = Carbon::now()->format('ymd');
        $randomStr = strtoupper(Str::random(4));
        $transactionId = 'TX-' . $datePrefix . '-' . $randomStr;

        Transaction::create([
            'transaction_id' => $transactionId,
            'user_id' => $userId,
            'category_id' => $request->category_id,
            'pickup_date' => Carbon::tomorrow()->toDateString(), 
            'weight_actual' => 0.00, 
            'price_final' => 0.00,  
            'address' => $request->address,
            'status' => 'menunggu' 
        ]);

        return redirect('/warga/dashboard')->with('success', 'Booking penjemputan berhasil! ID Anda: ' . $transactionId);
    }
}