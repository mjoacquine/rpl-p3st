@extends('Layouts.App') 

@section('global-content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm border-0 rounded-4" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-success"><i class="fa-solid fa-envelope-circle-check me-2"></i>Verifikasi Email</h4>
            <p class="text-muted small">Terima kasih telah mendaftar! Silakan cek email Anda untuk link verifikasi sebelum melanjutkan.</p>
        </div>

        @if (session('message'))
            <div class="alert alert-success small p-2 text-center">
                {{ session('message') }}
            </div>
        @endif

        <div class="card-body p-0">
            <p class="small text-center">Jika Anda tidak menerima email:</p>
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>
            
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-link w-100 text-decoration-none text-muted small">
                    Kembali ke halaman Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection