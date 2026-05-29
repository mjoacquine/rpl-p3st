<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\ScheduleProcessor;

class TaskController extends Controller
{
    protected $scheduleProcessor;

    public function __construct(ScheduleProcessor $scheduleProcessor)
    {
        $this->scheduleProcessor = $scheduleProcessor;
    }

    public function index()
    {
        // Cari order masuk berstatus 'menunggu' yang belum diklaim petugas manapun
        $availableTasks = DB::table('schedules')
            ->join('users', 'schedules.warga_id', '=', 'users.id')
            ->where('schedules.status', 'menunggu')
            ->select('schedules.*', 'users.name as warga_name', 'users.address as warga_address')
            ->orderBy('schedules.pickup_date', 'asc')
            ->get();

        return view('Petugas.Task.index', compact('availableTasks'));
    }

    public function accept($id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);
        $this->scheduleProcessor->assignPetugasToSchedule($schedule, Auth::id());

        return redirect()->route('petugas.dashboard')->with('success', 'Penjemputan berhasil dikonfirmasi dan masuk ke rute harian.');
    }

    public function apiIndex()
    {
        $tasks = DB::table('schedules')->where('status', 'menunggu')->get();
        return response()->json(['status' => 'success', 'data' => $tasks]);
    }
}