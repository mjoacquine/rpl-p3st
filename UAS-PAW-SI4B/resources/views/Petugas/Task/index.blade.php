<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
</div>
@extends('Layouts.Petugas')

@section('content')
<h4 class="fw-bold mb-3"><i class="fa-solid fa-hand-holding-hand text-primary me-2"></i>Bursa Tugas Penjemputan Terbuka</h4>
<p class="text-muted small">Daftar di bawah ini adalah pesanan penjemputan warga yang belum memiliki petugas. Silakan klaim (terima) tugas yang berada di rute/wilayah operasional Anda.</p>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th>Waktu Jemput</th>
                    <th>Warga Pemesan</th>
                    <th class="w-25">Alamat Lokasi</th>
                    <th>Estimasi Beban</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availableTasks as $task)
                <tr>
                    <td>
                        <span class="d-block fw-bold">{{ \Carbon\Carbon::parse($task->pickup_date)->format('d M Y') }}</span>
                        <span class="small text-danger"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($task->pickup_time)->format('H:i') }}</span>
                    </td>
                    <td class="fw-bold">{{ $task->warga_name }}</td>
                    <td class="small text-muted">{{ Str::limit($task->warga_address, 40) }}</td>
                    <td><span class="badge bg-secondary">{{ $task->estimated_weight }} Kg</span></td>
                    <td>
                        <form action="{{ route('petugas.task.accept', $task->id) }}" method="POST" onsubmit="return confirm('Klaim tugas ini? Jadwal ini akan masuk ke rute harian Anda.');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary fw-bold shadow-sm"><i class="fa-solid fa-check"></i> Terima Tugas</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-5 text-center text-muted">
                        <i class="fa-solid fa-mug-hot fa-2x mb-3 text-secondary"></i><br>
                        Saat ini tidak ada order penjemputan baru dari warga.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection