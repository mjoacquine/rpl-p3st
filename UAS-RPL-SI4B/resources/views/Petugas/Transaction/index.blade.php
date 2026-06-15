@extends('Layouts.App') 

@section('global-content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-success mb-1">Riwayat Transaksi Penjemputan</h4>
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
                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}</td>
                        <td>{{ $trx->schedule->warga->name ?? 'Warga Tidak Ditemukan' }}</td>
                        <td>{{ $trx->schedule->warga->address ?? '-' }}</td>
                        <td><span class="badge bg-secondary text-white">{{ $trx->weight_actual ?? 0 }} Kg</span></td>
                        <td>
                            @if($trx->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat transaksi saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection