@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-dark">Dashboard Monitoring Administrasi</h1>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-2">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold">Total Anggota Warga</h6>
                    <h3 class="fw-bold mb-0">{{ $totalWarga }} Akun</h3>
                </div>
                <i class="fa-solid fa-house-user text-p3st fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold">Armada Petugas</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPetugas }} Kolektor</h3>
                </div>
                <i class="fa-solid fa-motorcycle text-primary fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold">Order Penjemputan Bulan Ini</h6>
                    <h3 class="fw-bold mb-0">{{ $totalJadwalBulanIni }} Penjadwalan</h3>
                </div>
                <i class="fa-solid fa-calendar-days text-warning fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white fw-bold py-3">5 Transaksi Terakhir Masuk Log Sistem</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th>Waktu Transaksi</th>
                    <th>Nama Warga</th>
                    <th>Berat Riil</th>
                    <th>Dana Diserahkan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksiTerakhir as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                    <td class="fw-bold">{{ $trx->warga_name }}</td>
                    <td>{{ $trx->weight_actual }} Kg</td>
                    <td class="text-success fw-bold">Rp {{ number_format($trx->price_final, 0, ',', '.') }}</td>
                    <td><span class="badge bg-success">Berhasil</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection