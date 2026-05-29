<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>
@extends('Layouts.Petugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-route text-primary me-2"></i>Navigasi Rute Penjemputan</h2>
    <a href="{{ route('petugas.dashboard') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100 bg-light">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Target Penjemputan</h5>
                <p class="mb-1 fw-bold text-success"><i class="fa-solid fa-user me-2"></i>{{ $targetRoute->warga->name }}</p>
                <p class="mb-1 text-muted small"><i class="fa-solid fa-phone me-2"></i>{{ $targetRoute->warga->phone }}</p>
                <p class="mb-3 text-muted small"><i class="fa-solid fa-house me-2"></i>{{ $targetRoute->warga->address }}</p>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="small fw-bold text-muted">Jarak Estimasi:</span>
                    <span class="badge bg-danger rounded-pill">{{ number_format($targetRoute->calculated_distance_meters / 1000, 2) }} KM</span>
                </div>
                
                <a href="{{ route('petugas.transaction.edit', $targetRoute->id) }}" class="btn btn-success w-100 fw-bold shadow-sm mt-2"><i class="fa-solid fa-scale-balanced me-1"></i> Mulai Proses Penimbangan</a>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
            <div class="bg-dark text-white p-2 text-center small fw-bold">
                <a href="https://www.google.com/maps/dir/?api=1&origin={{ $petugas->latitude }},{{ $petugas->longitude }}&destination={{ $targetRoute->warga->latitude }},{{ $targetRoute->warga->longitude }}&travelmode=driving" target="_blank" class="text-white text-decoration-none">
                    <i class="fa-solid fa-external-link-alt me-1"></i> Buka Aplikasi Google Maps
                </a>
            </div>
            <iframe 
                width="100%" 
                height="400" 
                style="border:0;" 
                loading="lazy" 
                allowfullscreen 
                src="https://maps.google.com/maps?q={{ $targetRoute->warga->latitude }},{{ $targetRoute->warga->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
            </iframe>
        </div>
    </div>
</div>
@endsection