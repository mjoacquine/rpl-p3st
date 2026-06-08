@extends('Layouts.App')

@section('global-content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow border-0 rounded-3" style="width: 100%; max-width: 400px;">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success"><i class="fa-solid fa-right-to-bracket me-2"></i>Sign In</h3>
            <small class="text-muted">Aplikasi Pengelolaan Sampah Terjadwal Palembang</small>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success p-2 small">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning p-2 small">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger p-2 small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm mb-3">Masuk via Email</button>
        </form>

        <div class="d-flex align-items-center mb-3">
            <hr class="flex-grow-1">
            <span class="mx-2 text-muted small">ATAU</span>
            <hr class="flex-grow-1">
        </div>

        <a href="{{ route('auth.google') }}" class="btn btn-outline-dark w-100 py-2 fw-bold mb-3">
            <i class="fa-brands fa-google text-danger me-2"></i> Masuk dengan Google
        </a>

        <div class="text-center mt-3 small">
            Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar P3ST</a>
        </div>
    </div>
</div>
@endsection