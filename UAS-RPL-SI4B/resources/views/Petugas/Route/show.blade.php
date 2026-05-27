@extends('layouts.petugas')

@section('content')
<div class="mb-5 flex items-center gap-2">
    <a href="{{ url('/petugas/tugas') }}" class="text-slate-400 text-sm hover:text-slate-600">⬅️ Kembali</a>
    <h2 class="text-xl font-black text-slate-900">Informasi Alamat Jemput</h2>
</div>

<div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 space-y-4">
    
    <div>
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Identitas Pemilik Sampah</span>
        <h3 class="text-lg font-bold text-slate-800 mt-0.5">{{ $task->user->name }}</h3>
        <p class="text-xs text-blue-600 font-semibold mt-1">📱 No. WhatsApp: <a href="https://wa.me/{{ $task->user->phone }}" target="_blank" class="underline">{{ $task->user->phone ?? 'Belum ada nomor' }}</a></p>
    </div>

    <hr class="border-slate-100">

    <div>
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">Titik Koordinat / Alamat Tujuan</span>
        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-700">
            {{ $task->address }}
        </div>
    </div>

    <div>
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">Catatan Tambahan Warga</span>
        <p class="text-xs text-slate-500 italic bg-amber-50 p-3 rounded-lg border border-amber-100">
            "{{ $task->notes ?? 'Tidak ada catatan tambahan dari warga.' }}"
        </p>
    </div>

    <a href="{{ url('/petugas/transaksi/' . $task->transaction_id . '/edit') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-xs shadow-md transition mt-4">
        Sudah Sampai Lokasi? Mulai Proses Timbangan ⚖️
    </a>

</div>
@endsection