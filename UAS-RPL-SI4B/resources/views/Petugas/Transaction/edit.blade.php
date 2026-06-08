@extends('Layouts.Petugas')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-md-6">
        <h4 class="fw-bold mb-2"><i class="fa-solid fa-scale-balanced text-primary me-2"></i>Finalisasi Penimbangan</h4>
        <p class="text-muted small mb-4">Masukkan hasil timbangan di bawah. Data akan dikirim ke warga untuk <strong>dikonfirmasi</strong> sebelum transaksi dianggap sah (selesai).</p>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white fw-bold py-3">
                <i class="fa-solid fa-weight-scale text-success me-2"></i>Input Hasil Timbangan
            </div>
            <div class="card-body p-4">
                
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-info rounded-circle p-2 me-3 shadow-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $schedule->warga->name }}</h6>
                            <span class="small text-muted">Estimasi Awal Warga: <strong>{{ $schedule->estimated_weight ?? '0' }} Kg</strong></span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('petugas.transaction.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori Sampah Hasil Cek Lapangan</label>
                        <select name="category_id" class="form-select shadow-sm" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }} (Rp {{ number_format($cat->price_per_kg, 0, ',', '.') }}/Kg)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Berat Aktual Hasil Timbangan Fisik</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="number" step="0.01" name="weight_actual" class="form-control text-center fw-bold text-success" placeholder="0.00" min="0.01" required autofocus>
                            <span class="input-group-text bg-light fw-bold text-muted">Kg</span>
                        </div>
                        <div class="form-text text-center small mt-2">
                            <i class="fa-solid fa-circle-exclamation text-warning me-1"></i>Angka ini akan dikirim ke warga untuk dimintai persetujuan.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm transition-all" 
                        onclick="return confirm('Kirim hasil timbangan ke warga? Warga akan menerima notifikasi WA untuk mengonfirmasi hasil ini agar transaksi bisa diselesaikan.')">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Hasil ke Warga
                    </button>
                </form>

                <hr class="my-4 border-secondary border-opacity-25">

                <form action="{{ route('petugas.transaction.cancel', $schedule->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold transition-all" 
                        onclick="return confirm('Yakin ingin membatalkan? Warga akan menerima notifikasi WA bahwa transaksi dibatalkan karena tidak ada kesepakatan.');">
                        <i class="fa-solid fa-xmark me-2"></i> Batalkan Transaksi
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsectionS