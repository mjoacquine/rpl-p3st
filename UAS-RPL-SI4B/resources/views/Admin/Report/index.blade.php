@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Laporan Rekapitulasi Finansial</h2>
    <p class="text-slate-500 text-sm mt-1">Rekam jejak seluruh mutasi transaksi setoran dan penjemputan sampah P3ST (Memenuhi Tugas 3).</p>
</div>

<div class="grid grid-cols-2 gap-6 mb-6">
    <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider opacity-60">Total Massa Sampah Didaur Ulang</p>
            <h1 class="text-3xl font-black mt-1">{{ number_format($summary->total_weight ?? 0, 1) }} kg</h1>
        </div>
        <span class="text-4xl opacity-40">⚖️</span>
    </div>
    <div class="bg-emerald-600 text-white p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider opacity-70">Total Omset Tabungan Terdistribusi</p>
            <h1 class="text-3xl font-black mt-1">Rp {{ number_format($summary->total_income ?? 0, 0, ',', '.') }}</h1>
        </div>
        <span class="text-4xl opacity-40">💰</span>
    </div>
</div>

<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ url('/admin/report') }}" class="flex items-center gap-4">
        <select name="month" class="bg-slate-50 border border-slate-200 rounded-lg py-2 px-4 text-xs font-medium focus:outline-none">
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('month', date('m')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>Bulan {{ $i }}</option>
            @endfor
        </select>
        <select name="year" class="bg-slate-50 border border-slate-200 rounded-lg py-2 px-4 text-xs font-medium focus:outline-none">
            @for($i = date('Y'); $i >= 2024; $i--)
                <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
            @endfor
        </select>
        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold py-2 px-4 rounded-lg transition">
            Terapkan Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                <th class="p-4">Kode ID</th>
                <th class="p-4">Nama Warga</th>
                <th class="p-4">Komoditas Sampah</th>
                <th class="p-4 text-center">Massa (Kg)</th>
                <th class="p-4 text-right">Nilai Nominal</th>
                <th class="p-4 text-right">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
            @forelse($reports as $row)
            <tr class="hover:bg-slate-50/50">
                <td class="p-4 font-mono text-xs font-bold text-blue-600">{{ $row->transaction_id }}</td>
                <td class="p-4 font-semibold text-slate-800">{{ $row->user->name }}</td>
                <td class="p-4 text-xs font-medium text-slate-500">{{ $row->catalogPrice->category_name ?? 'Kategori Dihapus' }}</td>
                <td class="p-4 text-center font-mono text-xs">{{ number_format($row->weight_actual, 2) }}</td>
                <td class="p-4 text-right font-bold text-emerald-600">Rp {{ number_format($row->price_final, 0, ',', '.') }}</td>
                <td class="p-4 text-right">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ strtolower($row->status) == 'selesai' ? 'bg-green-50 text-green-700' : (strtolower($row->status) == 'menunggu' ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}">
                        {{ $row->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-sm text-slate-400 italic">Data transaksi pada periode ini tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection