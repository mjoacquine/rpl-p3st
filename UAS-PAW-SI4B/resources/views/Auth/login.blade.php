@extends('Layouts.App')

@section('global-content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow border-0 rounded-3" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-p3st"><i class="fa-solid fa-right-to-bracket me-2"></i>Sign In</h3>
            <small class="text-muted">Aplikasi Pengelolaan Sampah Terjadwal Palembang</small>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger p-2 small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-url form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-p3st w-100 py-2 fw-bold shadow-sm">Masuk</button>
        </form>
        <div class="text-center mt-3 small">
            Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar Warga</a>
        </div>
    </div>
</div>
@endsection