@extends('layouts.petugas')

@section('content')
<div class="mb-5">
    <h2 class="text-xl font-extrabold text-slate-900">Manajemen Profil Kurir</h2>
    <p class="text-xs text-slate-500 mt-0.5">Kelola data informasi kontak operasional petugas lapangan Anda.</p>
</div>

@if(session('success'))
<div class="bg-blue-50 border border-blue-200 text-blue-700 text-xs p-3.5 rounded-xl mb-4 font-semibold">
    ✅ {{ session('success') }}
</div>
@endif

<form action="{{ url('/petugas/profil') }}" method="POST" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 space-y-4">
    @csrf
    
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lengkap Petugas</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-200 text-sm text-slate-800 py-3 px-4 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Email Autentikasi Login</label>
        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-slate-100 border border-slate-200 text-sm text-slate-400 py-3 px-4 rounded-xl" readonly>
        <p class="text-[10px] text-slate-400 mt-1">*Alamat email login bersifat permanen dikunci oleh sistem pusat.</p>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nomor Handphone WhatsApp Operasional</label>
        <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="08xxxxxxxxxx" class="w-full bg-slate-50 border border-slate-200 text-sm text-slate-800 py-3 px-4 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-md transition active:scale-95 mt-2">
        Simpan Perubahan Data Diri
    </button>
</form>

<form method="POST" action="{{ url('/logout') }}" class="mt-5">
    @csrf
    <button type="submit" class="w-full bg-red-50 text-red-600 font-bold py-4 rounded-xl shadow-sm border border-red-100 transition hover:bg-red-100 active:scale-95">
        Keluar Akun Aplikasi (Logout) 👋
    </button>
</form>
@endsection