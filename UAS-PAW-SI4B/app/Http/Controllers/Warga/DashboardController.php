<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $wargaId = Auth::id();
        
        $schedules = DB::table('schedules')
            ->leftJoin('users', 'schedules.petugas_id', '=', 'users.id')
            ->where('schedules.warga_id', $wargaId)
            ->select('schedules.*', 'users.name as petugas_name')
            ->orderBy('schedules.created_at', 'desc')
            ->get();

        // Hitung akumulasi uang yang telah diterima warga
        $totalTabungan = DB::table('transactions')
            ->join('schedules', 'transactions.schedule_id', '=', 'schedules.id')
            ->where('schedules.warga_id', $wargaId)
            ->where('transactions.status', 'selesai')
            ->sum('transactions.price_final');

        return view('Warga.Dashboard.index', compact('schedules', 'totalTabungan'));
    }
}