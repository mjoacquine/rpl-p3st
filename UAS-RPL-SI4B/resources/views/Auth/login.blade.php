<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - P3ST Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Sistem P3ST Palembang</h4>
                    <small>Platform Penjemputan Sampah Terjadwal</small>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Login Sebagai (Pilih Peran)</label>
                            <select name="role" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                <option value="warga">Warga / Nasabah</option>
                                <option value="petugas">Petugas Lapangan</option>
                                <option value="admin">Admin Bank Sampah</option>
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Masuk Sistem</button>
                    </form>
                </div>
                <div class="card-footer text-center bg-white py-3">
                    Belum punya akun warga? <a href="{{ url('/register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>