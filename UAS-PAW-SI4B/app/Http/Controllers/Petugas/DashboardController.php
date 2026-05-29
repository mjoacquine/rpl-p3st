<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $petugasId = Auth::id();
        
        // Mengambil penugasan aktif hari ini
        $tasksToday = DB::table('schedules')
            ->join('users', 'schedules.warga_id', '=', 'users.id')
            ->where('schedules.petugas_id', $petugasId)
            ->where('schedules.pickup_date', Carbon::now()->toDateString())
            ->whereIn('schedules.status', ['dikonfirmasi', 'diproses'])
            ->select('schedules.*', 'users.name as warga_name', 'users.address as warga_address')
            ->get();

        return view('Petugas.Dashboard.index', compact('tasksToday'));
    }
}