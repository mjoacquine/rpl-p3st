@extends('Layouts.App')

@section('global-content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card p-4 shadow-lg border-0 rounded-4" style="width: 100%; max-width: 500px;">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success"><i class="fa-solid fa-user-plus me-2"></i>Daftar Akun Baru</h3>
            <small class="text-muted">Bergabunglah dalam program ekonomi sirkular P3ST</small>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger p-2 small border-0 rounded-3 mb-3">
                @foreach($errors->all() as $error) 
                    <div><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $error }}</div> 
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <input type="hidden" name="role" value="warga">

            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Sesuai KTP" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Alamat Email Aktif</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Nomor Handphone / WhatsApp</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="081234567890" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Alamat Rumah Lengkap (Titik Jemput)</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan" required>{{ old('address') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label small fw-bold">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm mb-3">Daftar Sekarang</button>
        </form>

        <div class="d-flex align-items-center mb-3">
            <hr class="flex-grow-1">
            <span class="mx-2 text-muted small">ATAU</span>
            <hr class="flex-grow-1">
        </div>

        <a href="{{ route('auth.google') }}" class="btn btn-outline-dark w-100 py-2 fw-bold mb-3">
            <i class="fa-brands fa-google text-danger me-2"></i> Daftar dengan Google
        </a>

        <div class="text-center mt-3 small">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection