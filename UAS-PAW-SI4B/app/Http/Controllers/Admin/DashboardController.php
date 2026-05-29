<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = DB::table('users')->where('role', 'warga')->count();
        $totalPetugas = DB::table('users')->where('role', 'petugas')->count();
        $totalJadwalBulanIni = DB::table('schedules')
            ->whereMonth('pickup_date', Carbon::now()->month)
            ->count();
            
        $transaksiTerakhir = DB::table('transactions')
            ->join('schedules', 'transactions.schedule_id', '=', 'schedules.id')
            ->join('users', 'schedules.warga_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as warga_name', 'transactions.created_at')
            ->orderBy('transactions.created_at', 'desc')
            ->take(5)
            ->get();

        return view('Admin.Dashboard.index', compact('totalWarga', 'totalPetugas', 'totalJadwalBulanIni', 'transaksiTerakhir'));
    }
}