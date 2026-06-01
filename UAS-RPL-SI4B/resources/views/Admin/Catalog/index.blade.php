@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-tags text-p3st me-2"></i>Manajemen Harga Katalog</h2>
    <a href="{{ route('admin.catalog.create') }}" class="btn btn-p3st fw-bold shadow-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Kategori Baru</a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Kategori / Jenis Sampah</th>
                        <th>Harga per Kg (Rp)</th>
                        <th>Mulai Berlaku Sejak</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($catalogs as $index => $cat)
                    <tr>
                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $cat->category_name }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($cat->price_per_kg, 0, ',', '.') }}</td>
                        <td>{{ $cat->effective_date->format('d M Y') }}</td>
                        <td class="text-center pe-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.catalog.edit', $cat->category_id) }}" class="btn btn-sm btn-outline-primary" title="Edit Data"><i class="fa-solid fa-pen"></i></a>
                                
                                <form action="{{ route('admin.catalog.destroy', $cat->category_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori sampah ini? Peringatan: Akan gagal jika kategori ini sudah pernah digunakan dalam transaksi.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-muted">Belum ada data master kategori sampah. Silakan tambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection