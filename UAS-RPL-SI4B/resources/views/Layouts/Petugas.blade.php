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
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.dashboard') }}">Rute Hari Ini</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.task.index') }}">Ambil Order Terbuka</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    @include('Layouts.Notification')
                </div>

                <span class="text-white me-3"><i class="fa-solid fa-id-card me-1"></i> Kolektor: {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
@endsection