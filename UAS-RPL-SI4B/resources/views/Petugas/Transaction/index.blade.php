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
                <li class="nav-item"><a class="nav-link active fw-bold text-success" href="{{ route('petugas.transaction.history') }}"><i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Transaksi</a></li>
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

<div class="container mt-4 mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-success mb-1"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Transaksi Penjemputan</h4>
                <p class="text-muted small mb-0">Daftar seluruh transaksi penjemputan sampah warga Kota Palembang</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-success text-dark">
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th>Tanggal</th>
                        <th>Nama Warga</th>
                        <th>Alamat</th>
                        <th>Total Berat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }} WIB</td>
                        <td>{{ $trx->schedule->warga->name ?? 'Warga Tidak Ditemukan' }}</td>
                        <td>{{ $trx->schedule->warga->address ?? '-' }}</td>
                        <td><span class="badge bg-secondary text-white">{{ $trx->weight_actual ?? 0 }} Kg</span></td>
                        <td>
                            @if($trx->status === 'selesai')
                                <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i> Diproses</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fa-solid fa-folder-open fa-2x mb-2 text-secondary"></i><br>
                            Belum ada riwayat transaksi saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection