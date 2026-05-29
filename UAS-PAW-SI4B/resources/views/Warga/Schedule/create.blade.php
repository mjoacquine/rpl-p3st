@extends('Layouts.Warga')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-calendar-check text-p3st me-2"></i>Form Pemesanan Penjemputan Sampah</div>
            <div class="card-body p-4">
                
                @if($errors->any())
                    <div class="alert alert-danger p-2 small">
                        @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                    </div>
                @endif

                <form action="{{ route('warga.schedule.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Pilih Tanggal Penjemputan</label>
                            <input type="date" name="pickup_date" class="form-control" value="{{ old('pickup_date') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Waktu/Jam (08:00 - 16:30)</label>
                            <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}" required>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-3 border mb-3">
                        <div class="fw-bold small text-success mb-2"><i class="fa-solid fa-calculator me-1"></i>Kalkulator Estimasi Nilai Jual</div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Kategori Sampah Utama</label>
                                <select id="calc_category" class="form-select form-select-sm">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->price_per_kg }}">{{ $cat->category_name }} (Rp {{ number_format($cat->price_per_kg, 0, ',', '.') }}/Kg)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Input Berat Perkiraan (Kg)</label>
                                <input type="number" step="0.1" name="estimated_weight" id="calc_weight" class="form-control form-control-sm" value="1.0" min="0.1" required>
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <span class="small text-muted">Perkiraan Pendapatan: </span>
                            <span class="fw-bold text-dark" id="calc_result">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Catatan Tambahan untuk Petugas Pengepul</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Rumah pagar hitam, sampah diletakkan di dalam karung depan gerbang."></textarea>
                    </div>

                    <button type="submit" class="btn btn-p3st w-100 fw-bold shadow-sm">Kirim Ajuan Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const catSelect = document.getElementById('calc_category');
        const weightInput = document.getElementById('calc_weight');
        const resultSpan = document.getElementById('calc_result');

        function calculate() {
            const price = parseFloat(catSelect.value) || 0;
            const weight = parseFloat(weightInput.value) || 0;
            const total = price * weight;
            resultSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        catSelect.addEventListener('change', calculate);
        weightInput.addEventListener('input', calculate);
        calculate(); // Run on load
    });
</script>
@endsection