@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-plus-circle text-p3st me-2"></i>Tambah Kategori Sampah</h2>
    <a href="{{ route('admin.catalog.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-3 w-50">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger p-2 small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('admin.catalog.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Kategori Sampah</label>
                <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" placeholder="Contoh: Plastik Botol PET" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Harga Beli per Kilogram (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="price_per_kg" step="0.01" class="form-control" value="{{ old('price_per_kg') }}" min="100" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Tanggal Efektif Berlakunya Harga</label>
                <input type="date" name="effective_date" class="form-control" value="{{ old('effective_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-p3st w-100 fw-bold shadow-sm"><i class="fa-solid fa-save me-1"></i> Simpan Kategori Baru</button>
        </form>
    </div>
</div>
@endsection