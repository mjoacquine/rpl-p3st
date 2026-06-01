@extends('Layouts.Warga')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-tags text-p3st me-2"></i>Katalog Harga Daur Ulang</h2>
</div>

<p class="text-muted mb-4 small">Sebagai bentuk transparansi, Bank Sampah P3ST mempublikasikan nilai beli per Kilogram untuk setiap jenis limbah. Harga di bawah ini dapat berfluktuasi mengikuti kondisi nilai ekonomi sirkular pasar.</p>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($catalogs as $cat)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3 text-center transition-hover">
            <div class="card-header bg-p3st-light border-0 pt-3 pb-2">
                <i class="fa-solid fa-recycle fa-2x text-p3st opacity-50 mb-2"></i>
                <h5 class="card-title fw-bold text-dark mb-0">{{ $cat->category_name }}</h5>
            </div>
            <div class="card-body">
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($cat->price_per_kg, 0, ',', '.') }}</h3>
                <small class="text-muted">per Kilogram (Kg)</small>
            </div>
            <div class="card-footer bg-white border-0 small text-muted pb-3">
                <i class="fa-solid fa-info-circle me-1"></i> Update terakhir: {{ $cat->effective_date->format('d M Y') }}
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Administrator belum mengatur harga katalog pasar.</p>
    </div>
    @endforelse
</div>
@endsection