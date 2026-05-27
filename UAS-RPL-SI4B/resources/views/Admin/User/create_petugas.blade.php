@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ url('/admin/user') }}" class="text-slate-400 hover:text-slate-600 text-sm">⬅️ Kembali</a>
    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftarkan Petugas Baru</h2>
</div>

<form action="{{ url('/admin/user') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 max-w-xl space-y-5">
    @csrf
    
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Lengkap Petugas</label>
        <input type="text" name="name" placeholder="Masukkan nama lengkap kurir" class="w-full bg-slate-50 border border-slate-200 py-3 px-4 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Alamat Email Login</label>
        <input type="email" name="email" placeholder="contoh: kurir1@p3st.com" class="w-full bg-slate-50 border border-slate-200 py-3 px-4 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Password Akun</label>
        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 py-3 px-4 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required minlength="8">
        <p class="text-[10px] text-slate-400 mt-1">*Akun akan otomatis didaftarkan sebagai Role: Petugas Lapangan.</p>
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow transition mt-2 text-sm">
        Buat Akun Petugas
    </button>
</form>
@endsectionS