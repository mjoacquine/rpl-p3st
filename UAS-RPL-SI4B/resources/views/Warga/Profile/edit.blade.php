@extends('layouts.warga')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold">Profil Akun</h2>
    <p class="text-sm text-gray-500">Kelola data diri dan alamat penjemputan Anda.</p>
</div>

@if(session('success'))
    <div class="bg-emerald-100 text-emerald-700 p-3 rounded-xl mb-4 text-sm font-bold border border-emerald-200">
        {{ session('success') }}
    </div>
@endif

<form action="{{ url('/warga/profil') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
    @csrf
    
    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Email / Akun</label>
        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-100 border border-gray-200 text-gray-500 py-3 px-4 rounded-xl" readonly>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Handphone (WhatsApp)</label>
        <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="08xxxxxxxxxx" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Penjemputan Default</label>
        <textarea name="address" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" required>{{ auth()->user()->address ?? '' }}</textarea>
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition mt-4">
        Simpan Perubahan
    </button>
</form>

<form method="POST" action="{{ url('/logout') }}" class="mt-6">
    @csrf
    <button type="submit" class="w-full bg-red-100 text-red-600 font-bold py-4 rounded-xl shadow-sm border border-red-200 transition hover:bg-red-200">
        Keluar Akun (Logout)
    </button>
</form>
@endsection