@extends('Layouts.App')

@section('global-content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="{{ route('petugas.dashboard') }}"><i class="fa-solid fa-truck-ramp-box me-2"></i>P3ST PETUGAS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#petugasNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="petugasNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.dashboard') }}"><i class="fa-solid fa-route me-1"></i> Rute Hari Ini</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.task.index') }}"><i class="fa-solid fa-hand-holding-hand me-1"></i> Ambil Order</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><i class="fa-solid fa-id-card me-1"></i> Kolektor: {{ Auth::user()->name }}</span>
                <a href="{{ route('petugas.profile.edit') }}" class="btn btn-sm btn-outline-success me-2"><i class="fa-solid fa-user-gear"></i> Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa-solid fa-power-off"></i></button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-map-location-dot text-success me-2"></i>Manifest Rute Jemputan</h4>
        </div>
        
        <a href="{{ route('petugas.route.optimizeAll') }}" 
           class="btn btn-primary shadow-sm fw-bold {{ $tasksToday->isEmpty() ? 'disabled' : '' }}">
            <i class="fa-solid fa-route me-1"></i> Optimasi Semua Rute
        </a>
    </div>

    <div class="row mb-5">
        @forelse($tasksToday as $task)
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success p-2"><i class="fa-solid fa-clock me-1"></i> {{ \Carbon\Carbon::parse($task->pickup_time)->format('H:i') }} WIB</span>
                        <span class="small text-muted fw-bold">{{ $task->estimated_weight }} Kg</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-1">{{ $task->warga_name }}</h5>
                    <p class="card-text text-secondary small mb-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $task->warga_address }}</p>
                    
                    <div class="d-grid gap-2 d-flex">
                        <a href="{{ route('petugas.route.show', $task->id) }}" class="btn btn-sm btn-outline-primary flex-fill fw-bold"><i class="fa-solid fa-map-marked-alt me-1"></i> Buka Rute</a>
                        <a href="{{ route('petugas.transaction.edit', $task->id) }}" class="btn btn-sm btn-success flex-fill fw-bold"><i class="fa-solid fa-scale-balanced me-1"></i> Timbang</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card p-4 text-center border-0 shadow-sm text-muted small">
                <i class="fa-solid fa-circle-check text-success fa-2x mb-2"></i><br> Tidak ada antrean rute aktif saat ini.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection