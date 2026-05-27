@extends('layouts.warga')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold">Laporan EcoStats</h2>
    <p class="text-sm text-gray-500">Kontribusi Anda terhadap lingkungan.</p>
</div>

<div class="grid grid-cols-1 gap-4 mb-6">
    <div class="bg-blue-600 p-6 rounded-2xl shadow-lg text-white flex items-center justify-between">
        <div>
            <p class="text-sm font-medium opacity-90">Total Sampah Didaur Ulang</p>
            <h2 class="text-3xl font-bold mt-1">{{ number_format($totalWeight ?? 0, 1) }} <span class="text-xl">Kg</span></h2>
        </div>
        <div class="text-5xl opacity-50">⚖️</div>
    </div>

    <div class="bg-purple-600 p-6 rounded-2xl shadow-lg text-white flex items-center justify-between">
        <div>
            <p class="text-sm font-medium opacity-90">Tabungan Terkumpul</p>
            <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($totalEarned ?? 0, 0, ',', '.') }}</h2>
        </div>
        <div class="text-5xl opacity-50">💰</div>
    </div>
</div>

<div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 text-center">
    <h3 class="font-bold text-gray-800 mb-2">Terima Kasih! 🌍</h3>
    <p class="text-sm text-gray-600">Setiap gram sampah yang Anda setorkan telah membantu mengurangi pencemaran lingkungan.</p>
</div>
@endsection