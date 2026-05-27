@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Utama</h2>
    <p class="text-slate-500 text-sm mt-1">Pantau perkembangan sirkulasi volume sampah dan saldo finansial bank sampah.</p>
</div>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Nasabah Mandiri (Warga)</p>
            <h1 class="text-3xl font-black text-slate-800 mt-2">{{ $totalWarga }} Akun</h1>
        </div>
        <span class="text-4xl bg-blue-50 p-3 rounded-xl">🏡</span>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kurir Aktif (Petugas)</p>
            <h1 class="text-3xl font-black text-slate-800 mt-2">{{ $totalPetugas }} Akun</h1>
        </div>
        <span class="text-4xl bg-amber-50 p-3 rounded-xl">🚛</span>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kas Perputaran Tabungan</p>
            <h1 class="text-3xl font-black text-emerald-600 mt-2">Rp {{ number_format($totalSaldoPool, 0, ',', '.') }}</h1>
        </div>
        <span class="text-4xl bg-emerald-50 p-3 rounded-xl">💰</span>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800">Aktivitas 5 Transaksi Terkini</h3>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                <th class="p-4">ID Transaksi</th>
                <th class="p-4">Warga Pemesan</th>
                <th class="p-4">Tanggal Input</th>
                <th class="p-4 text-right">Status Skenario</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
            @foreach($recentTransactions as $tx)
            <tr class="hover:bg-slate-50/50">
                <td class="p-4 font-mono text-xs font-bold text-blue-600">{{ $tx->transaction_id }}</td>
                <td class="p-4 font-semibold text-slate-700">{{ $tx->user->name }}</td>
                <td class="p-4 text-slate-500">{{ \Carbon\Carbon::parse($tx->pickup_date)->format('d/m/Y') }}</td>
                <td class="p-4 text-right">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wide {{ strtolower($tx->status) == 'selesai' ? 'bg-green-100 text-green-700' : (strtolower($tx->status) == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ $tx->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection