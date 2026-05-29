<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Services\EcoStatsEngine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EcoStatsController extends Controller
{
    protected $ecoEngine;

    public function __construct(EcoStatsEngine $ecoEngine)
    {
        $this->ecoEngine = $ecoEngine;
    }

    public function index()
    {
        $wargaId = Auth::id();

        // Ambil akumulasi total berat dari seluruh transaksi bernilai 'selesai' milik warga bersangkutan
        $totalWeight = DB::table('transactions')
            ->join('schedules', 'transactions.schedule_id', '=', 'schedules.id')
            ->where('schedules.warga_id', $wargaId)
            ->where('transactions.status', 'selesai')
            ->sum('transactions.weight_actual');

        // Olah data menggunakan mesin konversi dampak lingkungan (Service)
        $ecoStats = $this->ecoEngine->getMonthlyEcoStats((float)$totalWeight);

        return view('Warga.Ecostats.index', compact('ecoStats'));
    }

    public function apiGetStats(Request $request)
    {
        $totalWeight = DB::table('transactions')
            ->join('schedules', 'transactions.schedule_id', '=', 'schedules.id')
            ->where('schedules.warga_id', $request->user()->id)
            ->where('transactions.status', 'selesai')
            ->sum('transactions.weight_actual');

        $stats = $this->ecoEngine->getMonthlyEcoStats((float)$totalWeight);
        return response()->json(['status' => 'success', 'data' => $stats]);
    }
}