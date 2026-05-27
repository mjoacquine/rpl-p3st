@extends('layouts.warga')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold">Riwayat Penjemputan</h2>
        <p class="text-sm text-gray-500">Status transaksi sampah Anda.</p>
    </div>
    <a href="{{ url('/warga/jadwal/create') }}" class="bg-emerald-600 text-white p-2 px-4 rounded-full shadow hover:bg-emerald-700 transition font-bold">
        + Buat Baru
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-100 text-emerald-700 p-3 rounded-xl mb-4 text-sm font-bold border border-emerald-200">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-4">
    @forelse($schedules as $tx)
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col gap-2">
        <div class="flex justify-between items-start">
            <span class="font-bold text-gray-800 text-sm">{{ $tx->transaction_id }}</span>
            
            @if(strtolower($tx->status) == 'selesai')
                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Selesai</span>
            @elseif(strtolower($tx->status) == 'menunggu')
                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Menunggu</span>
            @else
                <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $tx->status }}</span>
            @endif
        </div>
        
        <div class="text-sm text-gray-600 mt-2">
            <p>📅 Tgl Jemput: <span class="font-medium">{{ \Carbon\Carbon::parse($tx->pickup_date)->format('d M Y') }}</span></p>
            <p>⚖️ Berat: <span class="font-medium">{{ $tx->weight_actual }} Kg</span></p>
            <p>💰 Nominal: <span class="font-medium text-emerald-600">Rp {{ number_format($tx->price_final, 0, ',', '.') }}</span></p>
        </div>

        @if(strtolower($tx->status) == 'menunggu')
        <form action="{{ url('/warga/jadwal/' . $tx->transaction_id) }}" method="POST" class="mt-2 border-t pt-3" onsubmit="return confirm('Yakin ingin membatalkan jadwal ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-red-500 font-bold hover:text-red-700">Batalkan Penjemputan</button>
        </form>
        @endif
    </div>
    @empty
    <div class="text-center bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <span class="text-4xl block mb-2">🗑️</span>
        <p class="text-gray-500 text-sm font-medium">Belum ada riwayat penjemputan.</p>
    </div>
    @endforelse
</div>
@endsection