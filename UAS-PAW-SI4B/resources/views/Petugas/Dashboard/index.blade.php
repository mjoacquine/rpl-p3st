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
                <li class="nav-item"><a class="nav-link" href="{{ route('petugas.task.index') }}"><i class="fa-solid fa-hand-holding-hand me-1"></i> Ambil Order Terbuka</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><i class="fa-solid fa-id-card me-1"></i> Kolektor: {{ Auth::user()->name }}</span>
                
                <a href="{{ route('petugas.profile.edit') }}" class="btn btn-sm btn-outline-success me-2" title="Pengaturan Akun & Sinkronisasi GPS"><i class="fa-solid fa-user-gear"></i> Profil</a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Log Out"><i class="fa-solid fa-power-off"></i></button>
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

    <h4 class="fw-bold mb-3"><i class="fa-solid fa-map-location-dot text-success me-2"></i>Manifest Rute Jemputan Hari Ini</h4>
    <p class="text-muted small">Berikut adalah rute penjemputan aktif Anda berdasarkan urutan kalkulasi algoritma terdekat.</p>

    <div class="row mb-5">
        @forelse($tasksToday as $task)
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success p-2"><i class="fa-solid fa-clock me-1"></i> Jam: {{ \Carbon\Carbon::parse($task->pickup_time)->format('H:i') }} WIB</span>
                        <span class="small text-muted fw-bold">Estimasi: {{ $task->estimated_weight }} Kg</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-1">{{ $task->warga_name }}</h5>
                    <p class="card-text text-secondary small mb-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> Alamat: {{ $task->warga_address }}</p>
                    
                    <div class="d-grid gap-2 d-flex">
                        <a href="{{ route('petugas.route.show', $task->id) }}" class="btn btn-sm btn-outline-primary flex-fill fw-bold"><i class="fa-solid fa-navigation me-1"></i> Buka Rute Peta</a>
                        <a href="{{ route('petugas.transaction.edit', $task->id) }}" class="btn btn-sm btn-success flex-fill fw-bold"><i class="fa-solid fa-scale-balanced me-1"></i> Timbang & Selesai</a>
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

    <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Penginputan Timbangan Hari Ini</h5>
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center small">
                <thead class="table-light">
                    <tr>
                        <th>Kode Jadwal</th>
                        <th>Nama Warga</th>
                        <th>Status Sistem</th>
                        <th>Aksi Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $completedToday = DB::table('schedules')
                            ->join('users', 'schedules.warga_id', '=', 'users.id')
                            ->where('schedules.petugas_id', Auth::id())
                            ->where('schedules.status', 'selesai')
                            ->whereDate('schedules.updated_at', \Carbon\Carbon::now()->toDateString())
                            ->select('schedules.*', 'users.name as warga_name')
                            ->get();
                    @endphp
                    @forelse($completedToday as $comp)
                    <tr>
                        <td class="font-monospace text-muted">{{ substr($comp->id, 0, 8) }}</td>
                        <td class="fw-bold">{{ $comp->warga_name }}</td>
                        <td><span class="badge bg-success">Selesai / Lunas</span></td>
                        <td>
                            <a href="{{ route('petugas.transaction.receipt', $comp->id) }}" target="_blank" class="btn btn-sm btn-dark fw-bold py-1 px-2"><i class="fa-solid fa-print me-1"></i> Cetak Struk Nota</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-muted">Belum ada penyelesaian timbangan transaksi hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection