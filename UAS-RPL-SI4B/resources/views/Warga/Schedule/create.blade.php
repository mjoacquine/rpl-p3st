@extends('layouts.warga')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold">Minta Jemput Sampah</h2>
    <p class="text-sm text-gray-500">Isi form di bawah agar kurir kami bisa menuju lokasi.</p>
</div>

<form action="{{ url('/warga/jadwal') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-5">
    @csrf
    
    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Jenis Sampah Domestik</label>
        <select name="category_id" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Penjemputan</label>
        <input type="date" name="pickup_date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" required>
        <p class="text-xs text-gray-400 mt-1">*Berat pasti akan ditimbang oleh kurir di lokasi.</p>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Titik Lokasi Penjemputan</label>
        <textarea name="address" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" required>{{ auth()->user()->address }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan (Opsional)</label>
        <textarea name="notes" rows="2" placeholder="Misal: Pagar warna hitam..." class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"></textarea>
    </div>

    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transition">
        Kirim Permintaan Jemput
    </button>
</form>
@endsection