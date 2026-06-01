@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Katalog Harga</h2>
    <a href="{{ route('admin.catalog.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-3 w-50">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger p-2 small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('admin.catalog.update', $catalog->category_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Kategori Sampah</label>
                <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $catalog->category_name) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Harga Beli per Kilogram (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="price_per_kg" step="0.01" class="form-control" value="{{ old('price_per_kg', $catalog->price_per_kg) }}" required>
                </div>
                <div class="form-text small">Ubah harga ini jika terjadi penyesuaian fluktuasi nilai jual di pasar daur ulang.</div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Tanggal Efektif Berlakunya Harga</label>
                <input type="date" name="effective_date" class="form-control" value="{{ old('effective_date', $catalog->effective_date->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm"><i class="fa-solid fa-check-double me-1"></i> Perbarui Harga</button>
        </form>
    </div>
</div>
@endsection