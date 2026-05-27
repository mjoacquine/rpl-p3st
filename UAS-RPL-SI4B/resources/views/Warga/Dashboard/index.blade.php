@extends('layouts.warga')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
    <p class="text-gray-500 text-sm mt-1">Mari selamatkan lingkungan hari ini.</p>
</div>

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-sm font-bold border border-red-200">
        {{ $errors->first() }}
    </div>
@endif

<div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg mb-6">
    <p class="text-sm font-medium opacity-90">Total Tabungan Anda</p>
    <h1 class="text-4xl font-extrabold mt-2">Rp {{ number_format($totalRp ?? 0, 0, ',', '.') }}</h1>
</div>

<div class="grid grid-cols-2 gap-4 mb-6">
    <a href="{{ url('/warga/jadwal/create') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-col items-center text-center transition hover:bg-gray-50">
        <span class="text-3xl mb-2">🚛</span>
        <span class="text-sm font-bold text-gray-700">Minta Jemput</span>
    </a>
    <a href="{{ url('/warga/ecostats') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-col items-center text-center transition hover:bg-gray-50">
        <span class="text-3xl mb-2">📈</span>
        <span class="text-sm font-bold text-gray-700">Statistik Saya</span>
    </a>
</div>
@endsection