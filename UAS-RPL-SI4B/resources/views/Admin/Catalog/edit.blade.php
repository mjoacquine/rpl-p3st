@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ url('/admin/katalog') }}" class="text-slate-400 hover:text-slate-600 text-sm">⬅️ Batal</a>
    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Penyesuaian Nilai Harga Pasar</h2>
</div>

<form action="{{ url('/admin/katalog/' . $catalog->category_id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 max-w-xl space-y-5">
    @csrf
    @method('PUT')
    
    <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Kode Kategori Utama (Permanen)</label>
        <input type="text" class="w-full bg-slate-100 border border-slate-200 py-3 px-4 rounded-xl font-mono text-sm text-slate-400 focus:outline-none" value="{{ $catalog->category_id }}" readonly>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Jenis Sampah</label>
        <input type="text" name="category_name" value="{{ $catalog->category_name }}" class="w-full bg-slate-50 border border-slate-200 py-3 px-4 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Satuan Unit Massa</label>
            <input type="text" name="unit" value="{{ $catalog->unit }}" class="w-full bg-slate-100 border border-slate-200 py-3 px-4 rounded-xl text-sm focus:outline-none text-slate-400" readonly required>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Harga Beli Per Kg Terbaru</label>
            <input type="number" name="price" value="{{ $catalog->price }}" class="w-full bg-slate-50 border border-slate-200 py-3 px-4 rounded-xl text-sm font-bold text-emerald-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
        </div>
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow transition mt-2 text-sm">
        Perbarui Nilai Harga Katalog Resmi
    </button>
</form>
@endsection