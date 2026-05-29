<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\RouteOptimizer;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    protected $routeOptimizer;

    public function __construct(RouteOptimizer $routeOptimizer)
    {
        $this->routeOptimizer = $routeOptimizer;
    }

    public function show($scheduleId)
    {
        $petugas = Auth::user();
        $schedule = Schedule::with('warga')->findOrFail($scheduleId);

        // Optimasi rute instan berdasarkan koordinat riil GPS petugas saat ini
        $singleCollection = collect([$schedule]);
        $optimized = $this->routeOptimizer->optimizeSchedules((float)$petugas->latitude, (float)$petugas->longitude, $singleCollection);
        
        $targetRoute = $optimized->first();

        return view('Petugas.Route.show', compact('targetRoute', 'petugas'));
    }
}