@extends('layouts.petugas')

@section('content')
<div class="mb-5 flex items-center gap-2">
    <a href="{{ url('/petugas/tugas') }}" class="text-slate-400 text-sm hover:text-slate-600">⬅️ Batal</a>
    <h2 class="text-xl font-black text-slate-900">Form Validasi Sampah</h2>
</div>

<div class="bg-slate-900 text-white p-4 rounded-xl mb-4 text-xs space-y-1 shadow-sm">
    <p>📄 ID Transaksi : <span class="font-mono font-bold text-amber-400">{{ $transaction->transaction_id }}</span></p>
    <p>👤 Setoran Atas Nama : <span class="font-bold">{{ $transaction->user->name }}</span></p>
    <p>📦 Kategori Sampah Dipesan : <span class="font-bold text-emerald-400">{{ $transaction->catalogPrice->category_name ?? 'Kategori Tidak Diketahui' }}</span></p>
</div>

<form action="{{ url('/petugas/transaksi/' . $transaction->transaction_id) }}" method="POST" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 space-y-4">
    @csrf
    @method('PUT') <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Berat Bersih Aktual (Kg)</label>
        <div class="relative rounded-xl shadow-sm">
            <input type="number" step="0.01" min="0.01" name="weight_actual" id="weight_actual" placeholder="0.00" class="w-full bg-slate-50 border border-slate-200 text-sm font-bold text-slate-800 py-3.5 px-4 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs font-bold text-slate-400">
                Kg
            </div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1.5">*Isi sesuai angka timbangan fisik. Sistem otomatis mengalikan dengan harga master katalog.</p>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Keputusan Status Transaksi</label>
        <select name="status" class="w-full bg-slate-50 border border-slate-200 text-sm text-slate-800 py-3.5 px-4 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            <option value="selesai" selected>Selesai (Sampah Valid & Diangkut)</option>
            <option value="batal">Batal (Warga Tidak Ada di Rumah / Batal Sepihak)</option>
        </select>
    </div>

    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transition active:scale-95 mt-2">
        Kunci Data & Selesaikan Transaksi 🏁
    </button>
</form>
@endsection