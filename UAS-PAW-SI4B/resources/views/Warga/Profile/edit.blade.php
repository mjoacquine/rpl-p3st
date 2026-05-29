@extends('Layouts.Warga')

@section('content')
<h3 class="fw-bold text-dark mb-4"><i class="fa-solid fa-gears text-success me-2"></i>Pengaturan Akun & Titik Jemput</h3>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-user-pen text-success me-2"></i>Data Identitas Warga</div>
            <div class="card-body">
                <form action="{{ route('warga.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor WhatsApp Aktif</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Fisik Rumah</label>
                        <textarea name="address" class="form-control" rows="2" required>{{ $user->address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-p3st w-100 fw-bold">Simpan Perubahan Data</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white fw-bold py-3"><i class="fa-solid fa-key text-warning me-2"></i>Ganti Password Akun</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger p-2 small">Periksa kecocokan password baru Anda.</div>
                @endif
                <form action="{{ route('warga.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label small">Password Lama</label>
                        <input type="password" name="old_password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Password Baru</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-warning w-100 fw-bold text-dark">Kunci Password Baru</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-map-pin text-danger me-2"></i>Koordinat Geokoding Rumah (GPS)</div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p class="text-muted small">Kunci titik koordinat satelit rumah Anda agar armada pengepul dapat mengkalkulasi jarak rute terpendek secara otomatis.</p>
                
                <form action="{{ route('warga.profile.location') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small text-muted">Latitude</label>
                            <input type="text" name="latitude" id="wargaLat" class="form-control bg-light text-center fw-bold" value="{{ $user->latitude }}" readonly required>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Longitude</label>
                            <input type="text" name="longitude" id="wargaLng" class="form-control bg-light text-center fw-bold" value="{{ $user->longitude }}" readonly required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-danger fw-bold" onclick="getWargaGPS()"><i class="fa-solid fa-location-crosshairs me-1"></i> Dapatkan Lokasi HP Saya</button>
                        <button type="submit" id="btnSaveWargaGPS" class="btn btn-success fw-bold" disabled><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Titik Lokasi Jemputan</button>
                    </div>
                </form>

                <div class="mt-3 border rounded overflow-hidden" style="height: 200px;">
                    <iframe width="100%" height="100%" style="border:0" loading="lazy" src="https://maps.google.com/maps?q={{ $user->latitude ?? -2.9909 }} , {{ $user->longitude ?? 104.7565 }}&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getWargaGPS() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("wargaLat").value = position.coords.latitude;
                document.getElementById("wargaLng").value = position.coords.longitude;
                document.getElementById("btnSaveWargaGPS").disabled = false;
                alert("GPS Rumah Anda Berhasil Dikunci! Silakan Klik Tombol Simpan.");
            }, function() {
                alert("Gagal mengakses GPS. Periksa izin lokasi perangkat Anda.");
            });
        }
    }
</script>
@endsection