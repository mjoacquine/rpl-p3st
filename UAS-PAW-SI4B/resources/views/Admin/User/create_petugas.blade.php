@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-user-plus text-primary me-2"></i>Registrasi Petugas Lapangan</h2>
    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-3 w-50">
    <div class="card-body p-4">
        <div class="alert alert-info small border-0"><i class="fa-solid fa-circle-info me-1"></i> Akun warga dapat mendaftar mandiri via halaman depan, namun akun <strong>Petugas Penjemput (Kolektor)</strong> diwajibkan melalui entri manual Administrator.</div>

        @if($errors->any())
            <div class="alert alert-danger p-2 small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('admin.user.store_petugas') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap Petugas</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Email (Gunakan email resmi/valid)</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Nomor Handphone / WhatsApp Aktif</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08..." required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Buat Kata Sandi Sementara</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm"><i class="fa-solid fa-check-circle me-1"></i> Daftarkan Anggota Petugas</button>
        </form>
    </div>
</div>
@endsection