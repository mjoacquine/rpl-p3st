<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Rangkuman metrik tugas untuk petugas
        $tugasMenunggu = Transaction::where('status', 'menunggu')->count();
        $tugasSelesaiHariIni = Transaction::where('status', 'selesai')
                                          ->whereDate('updated_at', $hariIni)
                                          ->count();
        $totalTugasSelesai = Transaction::where('status', 'selesai')->count();

        return view('petugas.dashboard.index', compact('tugasMenunggu', 'tugasSelesaiHariIni', 'totalTugasSelesai'));
    }
}