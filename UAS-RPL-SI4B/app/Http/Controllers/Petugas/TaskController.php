<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Services\RouteOptimizer;

class TaskController extends Controller
{
    // Menggunakan Dependency Injection untuk Service API
    public function index(RouteOptimizer $routeOptimizer)
    {
        // Sistem otomatis mengurutkan tugas dari jarak terdekat (API) 
        // atau waktu antrean terlama (Fallback FIFO)
        $tasks = $routeOptimizer->getOptimizedRoute();

        return view('petugas.task.index', compact('tasks'));
    }
}