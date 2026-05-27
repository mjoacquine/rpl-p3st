<?php
namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EcoStatsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil transaksi yang sudah beres saja
        $completedTransactions = Transaction::where('user_id', $userId)
                                            ->where('status', 'selesai')
                                            ->orderBy('updated_at', 'desc')
                                            ->get();

        // Hitung statistik keseluruhan
        $totalWeight = $completedTransactions->sum('weight_actual'); // Total Kg
        $totalEarned = $completedTransactions->sum('price_final'); // Total Rupiah

        return view('warga.ecostats.index', compact('completedTransactions', 'totalWeight', 'totalEarned'));
    }
}