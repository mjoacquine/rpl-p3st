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
                
                <a href="{{ route('warga.profile.edit') }}" class="btn btn-sm btn-outline-light me-2" title="Pengaturan Akun & Lokasi"><i class="fa-solid fa-user-gear"></i> Profil</a>
                
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button class="btn btn-sm btn-danger" type="submit" title="Keluar Aplikasi"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card bg-p3st text-white border-0 shadow-sm rounded-3 p-3 h-100">
                <small class="text-uppercase tracking-wide opacity-75 fw-bold">Total Keuntungan Terkumpul</small>
                <h2 class="fw-bold my-2">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h2>
                <p class="mb-0 small"><i class="fa-solid fa-wallet me-1"></i> Pembayaran langsung diserahkan tunai oleh kolektor di tempat.</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-dark text-white border-0 shadow-sm rounded-3 p-3 h-100">
                <small class="text-uppercase tracking-wide opacity-75 fw-bold">Menu Navigasi Cepat</small>
                <div class="mt-3">
                    <a href="{{ route('warga.schedule.create') }}" class="btn btn-sm btn-success fw-bold me-2"><i class="fa-solid fa-plus me-1"></i> Buat Order Booking</a>
                    <a href="{{ route('warga.ecostats.index') }}" class="btn btn-sm btn-outline-light fw-bold"><i class="fa-solid fa-leaf me-1"></i> Cek Emisi CO2</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white fw-bold py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-clock-rotate-left text-p3st me-2"></i>Riwayat Aktivitas Penjemputan Anda</span>
                <a href="{{ route('warga.schedule.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal & Jam Jemput</th>
                        <th>Estimasi Berat</th>
                        <th>Nama Petugas</th>
                        <th>Status Sistem</th>
                        <th class="pe-3 text-end">Aksi / Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules->take(5) as $sch)
                    <tr>
                        <td>
                            <span class="d-block fw-bold">{{ \Carbon\Carbon::parse($sch->pickup_date)->format('d M Y') }}</span>
                            <span class="small text-muted">{{ \Carbon\Carbon::parse($sch->pickup_time)->format('H:i') }} WIB</span>
                        </td>
                        <td>{{ $sch->estimated_weight }} Kg</td>
                        <td>
                            @if($sch->petugas_name)
                                <span class="badge bg-light text-dark border">{{ $sch->petugas_name }}</span>
                            @else
                                <span class="badge bg-secondary opacity-50">Menunggu Klaim</span>
                            @endif
                        </td>
                        <td>
                            @if($sch->status == 'menunggu') <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($sch->status == 'dikonfirmasi') <span class="badge bg-primary">Otw Lokasi</span>
                            @elseif($sch->status == 'selesai') <span class="badge bg-success">Selesai (Lunas)</span>
                            @else <span class="badge bg-danger">Batal</span> @endif
                        </td>
                        <td class="pe-3 text-end">
                            @if($sch->status == 'menunggu')
                                <form action="{{ route('warga.schedule.cancel', $sch->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold py-1 px-2"><i class="fa-solid fa-ban"></i> Batal</button>
                                </form>
                            @elseif($sch->status == 'selesai')
                                <a href="{{ route('warga.schedule.receipt', $sch->id) }}" target="_blank" class="btn btn-sm btn-dark fw-bold py-1 px-2"><i class="fa-solid fa-print text-success"></i> Struk</a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted p-4">
                            Belum ada riwayat penjadwalan. Silakan tekan tombol <strong>Buat Order Booking</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection