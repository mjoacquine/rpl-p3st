@extends('Layouts.Petugas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white fw-bold"><i class="fa-solid fa-weight-scale text-success me-2"></i>Input Hasil Timbangan Real-Time</div>
            <div class="card-body p-4">
                <div class="mb-3 small border-bottom pb-2">
                    <strong>Nama Penjual (Warga):</strong> {{ $schedule->warga->name }} <br>
                    <strong>Estimasi Awal Warga:</strong> {{ $schedule->estimated_weight }} Kg
                </div>

                <form action="{{ route('petugas.transaction.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori Sampah Hasil Cek Lapangan</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }} (Rp {{ number_format($cat->price_per_kg, 0, ',', '.') }}/Kg)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Berat Aktual Hasil Timbangan Fisik (Kg)</label>
                        <input type="number" step="0.01" name="weight_actual" class="form-control form-control-lg text-center fw-bold text-success" placeholder="0.00" min="0.01" required>
                        <div class="form-text text-center small">Pastikan angka sesuai dengan alat timbangan gantung digital Anda.</div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" onclick="return confirm('Kunci transaksi? Tindakan ini akan mengonfirmasi pembayaran tunai di tempat.')">Finalisasi Transaksi Tunai</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection