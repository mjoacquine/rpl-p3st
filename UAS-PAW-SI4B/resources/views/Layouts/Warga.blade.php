@extends('Layouts.App')

@section('global-content')
<nav class="navbar navbar-expand-lg navbar-dark bg-p3st shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('warga.dashboard') }}"><i class="fa-solid fa-leaf me-2"></i>P3ST WARGA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('warga.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('warga.schedule.create') }}"><i class="fa-solid fa-calendar-plus me-1"></i> Booking Jadwal</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('warga.catalog.index') }}"><i class="fa-solid fa-tags me-1"></i> Daftar Harga</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('warga.ecostats.index') }}"><i class="fa-solid fa-seedling me-1"></i> Dampak Lingkungan</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button class="btn btn-sm btn-danger" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>
@endsection