@extends('Layouts.Warga')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-clock-rotate-left text-p3st me-2"></i>Histori Penjadwalan Saya</h2>
    <a href="{{ route('warga.schedule.create') }}" class="btn btn-p3st fw-bold shadow-sm"><i class="fa-solid fa-plus me-1"></i> Buat Order Baru</a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 text-start">Kode Booking</th>
                    <th>Jadwal Request</th>
                    <th>Estimasi Berat</th>
                    <th>Status Akhir</th>
                    <th class="pe-4 text-end">Opsi Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $sch)
                <tr>
                    <td class="ps-4 text-start small text-muted font-monospace">{{ substr($sch->id, 0, 8) }}...</td>
                    <td>
                        <span class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($sch->pickup_date)->format('d M Y') }}</span>
                        <span class="small text-muted">{{ \Carbon\Carbon::parse($sch->pickup_time)->format('H:i') }} WIB</span>
                    </td>
                    <td class="fw-bold">{{ $sch->estimated_weight }} Kg</td>
                    <td>
                        @if($sch->status == 'menunggu')
                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                        @elseif($sch->status == 'dikonfirmasi')
                            <span class="badge bg-primary">Dalam Perjalanan</span>
                        @elseif($sch->status == 'selesai')
                            <span class="badge bg-success"><i class="fa-solid fa-check-double me-1"></i> Selesai (Lunas)</span>
                        @else
                            <span class="badge bg-danger">Dibatalkan</span>
                        @endif
                    </td>
                    <td class="pe-4 text-end">
                        @if($sch->status == 'menunggu')
                            <form action="{{ route('warga.schedule.cancel', $sch->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold"><i class="fa-solid fa-ban"></i> Batalkan</button>
                            </form>
                        @elseif($sch->status == 'selesai')
                            <a href="{{ route('warga.schedule.receipt', $sch->id) }}" target="_blank" class="btn btn-sm btn-light border fw-bold text-dark"><i class="fa-solid fa-print text-success"></i> Cetak Struk</a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-5 text-muted">Anda belum pernah membuat jadwal penjemputan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection