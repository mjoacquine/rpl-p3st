@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Akun Pengguna</h2>
        <p class="text-slate-500 text-sm mt-1">Otoritas mutlak kendali atas data hak akses Petugas Lapangan (Memenuhi Tugas 4).</p>
    </div>
    <a href="{{ url('/admin/user/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2 text-sm">
        <span>➕</span> Daftarkan Petugas Baru
    </a>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 rounded-xl mb-6 font-semibold">
    ✅ {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-800 text-sm p-4 rounded-xl mb-6 font-semibold">
    ⚠️ {{ $errors->first() }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                <th class="p-4">Nama Pengguna</th>
                <th class="p-4">Surel Elektronik (Email)</th>
                <th class="p-4 text-center">Hak Akses Role</th>
                <th class="p-4 text-center">Nomor WhatsApp</th>
                <th class="p-4 text-center">Tindakan Sistem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
            @forelse($petugas as $u)
            <tr class="hover:bg-slate-50/50">
                <td class="p-4 font-bold text-slate-900">{{ $u->name }}</td>
                <td class="p-4 font-mono text-xs text-slate-500">{{ $u->email }}</td>
                <td class="p-4 text-center">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide {{ strtolower($u->role) == 'petugas' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $u->role }}
                    </span>
                </td>
                <td class="p-4 text-center font-medium text-slate-600">{{ $u->phone ?? 'Belum terdaftar' }}</td>
                <td class="p-4 text-center flex justify-center">
                    <form method="POST" action="{{ url('/admin/user/' . $u->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun petugas ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                            Hapus Akun
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-sm text-slate-400 italic">Belum ada data petugas lapangan yang terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection