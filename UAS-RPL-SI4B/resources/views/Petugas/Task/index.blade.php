@extends('layouts.petugas')

@section('content')
<div class="mb-5">
    <h2 class="text-xl font-black text-slate-900">Daftar Tugas Aktif</h2>
    <p class="text-xs text-slate-500 mt-0.5">Daftar warga yang telah melakukan pemesanan terjadwal dan menunggu kurir.</p>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs p-3.5 rounded-xl mb-5 font-semibold">
    🎉 {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-800 text-xs p-3.5 rounded-xl mb-5 font-semibold">
    ⚠️ {{ $errors->first() }}
</div>
@endif

<div class="space-y-4">
    @forelse($tasks as $item)
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col gap-3">
        
        <div class="flex justify-between items-center">
            <span class="font-mono text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $item->transaction_id }}</span>
            <span class="text-[10px] font-black bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Menunggu</span>
        </div>
        
        <hr class="border-slate-50">

        <div class="text-xs space-y-1 text-slate-600">
            <p>👤 Nama Warga: <span class="font-bold text-slate-800">{{ $item->user->name }}</span></p>
            <p>📅 Tgl Pengajuan: <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($item->pickup_date)->format('d M Y') }}</span></p>
            <p>📍 Lokasi Singkat: <span class="font-medium text-slate-500 italic block mt-0.5 overflow-hidden text-ellipsis whitespace-nowrap">{{ $item->address }}</span></p>
        </div>

        <div class="grid grid-cols-2 gap-3 mt-1">
            <a href="{{ url('/petugas/rute/' . $item->transaction_id) }}" class="text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg text-xs transition">
                📍 Lihat Rute
            </a>
            <a href="{{ url('/petugas/transaksi/' . $item->transaction_id . '/edit') }}" class="text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg text-xs shadow-sm transition">
                ⚖️ Timbang
            </a>
        </div>

    </div>
    @empty
    <div class="text-center bg-white border border-dashed border-slate-200 p-8 rounded-xl text-slate-400">
        <span class="text-4xl block mb-2">🥳</span>
        <p class="text-sm font-medium">Luar Biasa! Semua antrean penjemputan sampah warga telah selesai diproses.</p>
    </div>
    @endforelse
</div>
@endsection