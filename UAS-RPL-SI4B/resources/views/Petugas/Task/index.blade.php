@extends('Layouts.App')

@section('global-content')
<!-- NAVBAR PETUGAS (SINKRON DENGAN DASHBOARD & RIWAYAT) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="{{ route('petugas.dashboard') }}"><i class="fa-solid fa-truck-ramp-box me-2"></i>P3ST PETUGAS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#petugasNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="petugasNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.dashboard') }}"><i class="fa-solid fa-route me-1"></i> Rute Hari Ini</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold text-success" href="{{ route('petugas.task.index') }}"><i class="fa-solid fa-hand-holding-hand me-1"></i> Ambil Order</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.transaction.history') }}"><i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Transaksi</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><i class="fa-solid fa-id-card me-1"></i> Kolektor: {{ Auth::user()->name }}</span>
                <a href="{{ route('petugas.profile.edit') }}" class="btn btn-sm btn-outline-success me-2"><i class="fa-solid fa-user-gear"></i> Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa-solid fa-power-off"></i></button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- KONTEN UTAMA BURSA TUGAS -->
<div class="container my-4 mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-hand-holding-hand text-success me-2"></i>Bursa Tugas Penjemputan</h4>
            <p class="text-muted small mb-0">Daftar pesanan warga berstatus "Menunggu". Silakan klaim tugas sesuai rute Anda.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-success text-dark">
                        <tr>
                            <th class="py-3">Waktu Jemput</th>
                            <th class="py-3">Warga Pemesan</th>
                            <th class="w-25 py-3 text-start">Alamat Lokasi</th>
                            <th class="py-3">Estimasi Beban</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableTasks as $task)
                        <tr>
                            <td>
                                <span class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($task->pickup_date)->translatedFormat('d M Y') }}</span>
                                <span class="small text-danger fw-semibold">
                                    <i class="fa-regular fa-clock me-1"></i> 
                                    {{ $task->pickup_time ? \Carbon\Carbon::parse($task->pickup_time)->format('H:i') : 'Waktu Fleksibel' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $task->warga_name }}</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mt-1">Status: Menunggu</span>
                            </td>
                            <td class="small text-muted text-start">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ Str::limit($task->warga_address, 45) }}
                            </td>
                            <td>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm">
                                    {{ $task->estimated_weight ?? '0' }} Kg
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('petugas.task.accept', $task->id) }}" method="POST" onsubmit="return confirm('Klaim tugas ini? Jadwal ini akan langsung masuk ke rute harian Anda.');" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-3 py-2 shadow-sm transition-all">
                                        <i class="fa-solid fa-check me-1"></i> Terima Tugas
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-4 mb-3 d-inline-block">
                                        <i class="fa-solid fa-mug-hot fa-3x text-secondary opacity-50"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Tugas Baru</h6>
                                    <p class="small text-muted mb-0">Saat ini tidak ada order penjemputan baru dari warga di bursa tugas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection