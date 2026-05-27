@extends('layouts.petugas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-900">Semangat Kerja, {{ auth()->user()->name }}! 💪</h2>
    <p class="text-slate-500 text-xs mt-0.5">Pantau terus antrean pemesanan penjemputan sampah warga Palembang.</p>
</div>

<div class="grid grid-cols-1 gap-4 mb-6">
    
    <div class="bg-amber-500 text-slate-900 p-5 rounded-2xl shadow-sm flex justify-between items-center relative overflow-hidden">
        <div>
            <p class="text-xs uppercase font-bold tracking-wider opacity-80">Antrean Perlu Dijemput</p>
            <h1 class="text-4xl font-black mt-1">{{ $tugasMenunggu ?? 0 }} <span class="text-lg font-normal">Warga</span></h1>
        </div>
        <div class="text-5xl opacity-20 absolute -right-2 -bottom-2 pointer-events-none">🚛</div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 text-center">
            <span class="text-2xl block mb-1">✅</span>
            <span class="text-[11px] text-slate-400 font-medium block">Selesai Hari Ini</span>
            <span class="text-xl font-bold text-slate-800">{{ $tugasSelesaiHariIni ?? 0 }} Tugas</span>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 text-center">
            <span class="text-2xl block mb-1">🏁</span>
            <span class="text-[11px] text-slate-400 font-medium block">Total Keseluruhan</span>
            <span class="text-xl font-bold text-slate-800">{{ $totalTugasSelesai ?? 0 }} Selesai</span>
        </div>
    </div>

</div>

<a href="{{ url('/petugas/tugas') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-md transition active:scale-95">
    Buka Daftar Antrean Tugas Lapangan 🚀
</a>
@endsection