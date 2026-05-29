@extends('Layouts.Petugas')

@section('content')
<h4 class="fw-bold text-dark mb-4"><i class="fa-solid fa-id-card-clip text-primary me-2"></i>Manajemen Akun Kolektor</h4>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-user-gear text-primary me-2"></i>Data Profil Pengepul</div>
            <div class="card-body">
                <form action="{{ route('petugas.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Petugas</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Telepon Kontak</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Update Profil</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white fw-bold py-3"><i class="fa-solid fa-shield-halved text-info me-2"></i>Ubah Password Kerja</div>
            <div class="card-body">
                <form action="{{ route('petugas.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label small">Password Saat Ini</label>
                        <input type="password" name="old_password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Password Baru</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info w-100 fw-bold text-white">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-satellite text-success me-2"></i>Sinkronisasi Posisi Fleet Kendaraan</div>
            <div class="card-body d-flex flex-column justify-content-between">
                <form action="{{ route('petugas.profile.location') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small text-muted">Current Lat</label>
                            <input type="text" name="latitude" id="petugasLat" class="form-control bg-light text-center" value="{{ $user->latitude }}" readonly required>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Current Lng</label>
                            <input type="text" name="longitude" id="petugasLng" class="form-control bg-light text-center" value="{{ $user->longitude }}" readonly required>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-success fw-bold" onclick="getPetugasGPS()">Ping Posisi Fleet</button>
                        <button type="submit" id="btnSavePetugasGPS" class="btn btn-dark fw-bold" disabled>Simpan Koordinat</button>
                    </div>
                </form>
                <div class="mt-3 border rounded overflow-hidden" style="height: 200px;">
                    <iframe width="100%" height="100%" style="border:0" loading="lazy" src="https://maps.google.com/maps?q={{ $user->latitude ?? -2.9909 }},{{ $user->longitude ?? 104.7565 }}&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getPetugasGPS() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("petugasLat").value = position.coords.latitude;
                document.getElementById("petugasLng").value = position.coords.longitude;
                document.getElementById("btnSavePetugasGPS").disabled = false;
                alert("GPS Fleet Berhasil Disinkronkan!");
            });
        }
    }
</script>
@endsection