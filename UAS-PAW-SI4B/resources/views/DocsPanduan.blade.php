@extends('Layouts.App')

@section('global-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="text-center mb-5">
                <i class="fa-solid fa-book-open-reader fa-3x text-success mb-3"></i>
                <h2 class="fw-bold text-dark">Buku Panduan Penggunaan</h2>
                <p class="text-muted">Sistem Penjadwalan Penjemputan Sampah Terintegrasi (P3ST) - MDP</p>
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-sm mt-2"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-p3st text-white fw-bold py-3">
                    <i class="fa-solid fa-house-user me-2"></i> 1. Panduan Untuk Warga (Pelanggan)
                </div>
                <div class="card-body p-4 text-secondary">
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Cara Mendaftar:</strong> Klik tombol "Daftar Warga" di halaman awal, isi nama, WhatsApp, email, dan kata sandi.</li>
                        <li class="mb-2"><strong>Mengatur Titik Jemput (GPS):</strong> Masuk ke menu Profil, scroll ke bawah, lalu klik "Dapatkan Lokasi HP Saya" agar titik koordinat rumah Anda terkunci. Jangan lupa klik Simpan.</li>
                        <li class="mb-2"><strong>Membuat Order Jemput:</strong> Klik menu "Booking Jadwal", tentukan tanggal, jam (08:00 - 16:30), dan estimasi berat. Sistem akan otomatis memunculkan status 'Menunggu'.</li>
                        <li class="mb-2"><strong>Membatalkan Order:</strong> Selama status masih 'Menunggu', Anda bisa menekan tombol "Batal" (merah) di tabel Dashboard.</li>
                        <li><strong>Melihat Struk Lunas:</strong> Setelah petugas selesai menimbang sampah Anda di rumah, status akan berubah menjadi 'Selesai'. Klik tombol "Struk" (hitam) untuk mencetak nota digital.</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-dark text-white fw-bold py-3">
                    <i class="fa-solid fa-truck-ramp-box me-2"></i> 2. Panduan Untuk Petugas (Pengepul)
                </div>
                <div class="card-body p-4 text-secondary">
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Mengklaim Tugas:</strong> Buka menu "Ambil Order Terbuka". Pilih order warga yang masuk dan klik "Terima Order".</li>
                        <li class="mb-2"><strong>Melihat Rute:</strong> Di Dashboard, klik "Buka Rute Peta" untuk diarahkan langsung ke Google Maps menuju lokasi rumah Warga.</li>
                        <li class="mb-2"><strong>Sinkronisasi GPS Armada:</strong> Masuk ke menu Profil Petugas, klik "Ping Posisi Fleet" agar algoritma sistem dapat menghitung jarak armada Anda ke rumah warga terdekat.</li>
                        <li><strong>Menyelesaikan Timbangan:</strong> Sesampainya di lokasi, klik "Timbang & Selesai". Masukkan jenis sampah dan berat aktual. Sistem akan otomatis menghitung total uang yang harus Anda bayarkan kepada Warga.</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <i class="fa-solid fa-user-tie me-2"></i> 3. Panduan Untuk Administrator
                </div>
                <div class="card-body p-4 text-secondary">
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Mengelola Harga Sampah:</strong> Buka menu "Katalog Harga", admin dapat menambah, mengedit, atau menghapus jenis kategori sampah beserta harga per kilogramnya.</li>
                        <li class="mb-2"><strong>Manajemen Akun Petugas:</strong> Buka menu "Data Pengguna", admin dapat mendaftarkan akun baru untuk armada petugas pengepul lapangan.</li>
                        <li><strong>Cetak Laporan:</strong> Buka menu "Laporan Bulanan", pilih bulan dan tahun, lalu klik "Ekspor Cetak PDF" untuk mengunduh rekap agregasi data ekonomi sirkular.</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-5 mb-4 text-muted small">
                &copy; 2026 Sistem Informasi - Universitas Multi Data Palembang<br>
                Disusun untuk keperluan dokumentasi proyek P3ST.
            </div>

        </div>
    </div>
</div>
@endsection