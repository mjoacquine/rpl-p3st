@extends('Layouts.App')

@section('global-content')
<div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
    <div class="card p-5 shadow-lg border-0 rounded-4" style="max-width: 600px; background-color: white;">
        <i class="fa-solid fa-recycle text-p3st mb-4" style="font-size: 4rem;"></i>
        <h1 class="fw-bold mb-2">Platform P3ST</h1>
        <p class="text-muted mb-4 text-uppercase tracking-wider">Penjadwalan Penjemputan Sampah Terintegrasi<br><span class="fw-bold text-success">Universitas MDP</span></p>
        <p class="mb-4 text-secondary">Ubah limbah rumah tangga Anda menjadi keuntungan ekonomi nyata tanpa perlu keluar rumah. Biarkan petugas pengepul kami yang menjemput dan menimbang di tempat.</p>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="{{ route('login') }}" class="btn btn-p3st btn-lg px-4 me-md-2 fw-bold shadow-sm">Masuk Sistem</a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4 fw-bold">Daftar Warga</a>
        </div>
        <div class="mt-4">
            <a href="{{ route('docs.panduan') }}" class="text-decoration-none text-success small fw-bold"><i class="fa-solid fa-book me-1"></i> Lihat Dokumen Panduan Pengguna (User Guide)</a>
        </div>
    </div>
</div>
@endsection