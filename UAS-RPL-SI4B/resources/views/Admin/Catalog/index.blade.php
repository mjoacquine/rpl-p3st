@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Katalog Harga Sampah</h2>
        <p class="text-slate-500 text-sm mt-1">Kelola data acuan nilai ekonomi komoditas sampah (Memenuhi Tugas 1).</p>
    </div>
    <a href="{{ url('/admin/katalog/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2 text-sm">
        <span>➕</span> Tambah Komoditas Baru
    </a>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 rounded-xl mb-6 font-semibold">
    ✅ {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-800 text-sm p-4 rounded-xl mb-6 font-semibold">
    ⚠️ {{ $errors->first() }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                <th class="p-4">Kode ID</th>
                <th class="p-4">Nama Komoditas</th>
                <th class="p-4">Satuan</th>
                <th class="p-4 text-right">Harga Acuan Resmi</th>
                <th class="p-4 text-center">Aksi Manajemen</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
            @foreach($catalogs as $item)
            <tr class="hover:bg-slate-50/50">
                <td class="p-4 font-mono font-bold text-slate-500">{{ $item->category_id }}</td>
                <td class="p-4 font-semibold text-slate-900">{{ $item->category_name }}</td>
                <td class="p-4"><span class="bg-slate-100 px-2 py-0.5 rounded font-mono text-xs">{{ $item->unit }}</span></td>
                <td class="p-4 text-right font-bold text-emerald-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="p-4 text-center flex justify-center gap-3">
                    <a href="{{ url('/admin/katalog/' . $item->category_id . '/edit') }}" class="bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                        Ubah Harga
                    </a>
                    <form method="POST" action="{{ url('/admin/katalog/' . $item->category_id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection