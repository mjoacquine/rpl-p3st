@extends('Layouts.Petugas')

@section('content')
<div class="container-fluid px-0 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-hand-holding-hand text-primary me-2"></i>Bursa Tugas Penjemputan</h4>
            <p class="text-muted small mb-0">Daftar pesanan warga berstatus "Menunggu". Silakan klaim tugas sesuai rute Anda.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Waktu Jemput</th>
                            <th class="py-3">Warga Pemesan</th>
                            <th class="w-25 py-3">Alamat Lokasi</th>
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
                                <form action="{{ route('petugas.task.accept', $task->id) }}" method="POST" onsubmit="return confirm('Klaim tugas ini? Jadwal ini akan langsung masuk ke rute harian Anda.');">
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