@extends('Layouts.Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-users-gear text-dark me-2"></i>Manajemen Pengguna Sistem</h2>
    <a href="{{ route('admin.user.create_petugas') }}" class="btn btn-primary fw-bold shadow-sm"><i class="fa-solid fa-motorcycle me-1"></i> Registrasi Petugas Baru</a>
</div>

<ul class="nav nav-tabs mb-4" id="userTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold text-dark" id="petugas-tab" data-bs-toggle="tab" data-bs-target="#petugas-pane" type="button" role="tab"><i class="fa-solid fa-user-shield me-1"></i> Akun Petugas Lapangan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold text-dark" id="warga-tab" data-bs-toggle="tab" data-bs-target="#warga-pane" type="button" role="tab"><i class="fa-solid fa-house-user me-1"></i> Akun Warga Terdaftar</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    
    <div class="tab-pane fade show active" id="petugas-pane" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Petugas</th>
                            <th>Email Login</th>
                            <th>Kontak Aktif</th>
                            <th>Status GPS Track</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $p)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->phone ?? '-' }}</td>
                            <td>
                                @if($p->latitude && $p->longitude)
                                    <span class="badge bg-success"><i class="fa-solid fa-location-crosshairs"></i> Tersinkron</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fa-solid fa-location-dot"></i> Belum Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-muted">Belum ada akun petugas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="warga-pane" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Lengkap Warga</th>
                            <th>Kontak WA</th>
                            <th class="w-50">Alamat Penjemputan Terdaftar</th>
                            <th>Tanggal Gabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warga as $w)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $w->name }}</td>
                            <td>{{ $w->phone ?? 'Belum Diisi' }}</td>
                            <td>{{ $w->address ?? 'Belum Diisi' }}</td>
                            <td>{{ $w->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-muted">Belum ada akun warga yang bergabung di aplikasi ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection