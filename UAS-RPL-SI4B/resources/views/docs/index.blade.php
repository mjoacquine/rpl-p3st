<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Panduan - Sistem P3ST</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📚</span>
                <h1 class="text-xl font-bold tracking-tight">Buku Panduan P3ST</h1>
            </div>
            <a href="{{ url('/login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition">
                Masuk ke Aplikasi
            </a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        
        <aside class="w-full md:w-64 shrink-0">
            <div class="sticky top-24 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-4">Daftar Isi Panduan</h3>
                <nav class="flex flex-col gap-2 text-sm font-medium text-slate-600">
                    <a href="#intro" class="hover:text-blue-600 transition">🌟 Pengenalan Sistem</a>
                    <a href="#warga" class="hover:text-emerald-600 transition">🏡 Panduan Warga (Nasabah)</a>
                    <a href="#petugas" class="hover:text-amber-600 transition">🚛 Panduan Kurir (Petugas)</a>
                    <a href="#admin" class="hover:text-slate-900 transition">⚙️ Panduan Admin Pusat</a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 space-y-12">
            
            <section id="intro" class="scroll-mt-24">
                <h2 class="text-3xl font-black text-slate-900 mb-4">Selamat Datang di P3ST</h2>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 leading-relaxed text-slate-600">
                    <p><strong>Platform Penjemputan Sampah Terjadwal (P3ST)</strong> adalah sistem digitalisasi bank sampah modern untuk wilayah Palembang. Sistem ini menghubungkan warga yang memiliki sampah daur ulang dengan petugas kurir lapangan secara real-time.</p>
                </div>
            </section>

            <section id="warga" class="scroll-mt-24">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">🏡</span>
                    <h2 class="text-2xl font-black text-emerald-700">Panduan Warga (Nasabah)</h2>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 mb-2">1. Cara Memesan Penjemputan</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Login menggunakan akun Warga Anda.</li>
                            <li>Pada Dashboard, klik tombol <strong>"Minta Jemput"</strong>.</li>
                            <li>Pilih jenis sampah, tanggal penjemputan, dan pastikan alamat titik jemput sudah benar.</li>
                            <li>Klik "Kirim Permintaan Jemput". Anda hanya diizinkan membuat antrean 1x dalam sehari untuk mencegah spam.</li>
                        </ul>
                    </div>
                    <div class="p-6 border-b border-slate-100 bg-slate-50">
                        <h4 class="font-bold text-slate-800 mb-2">2. Memantau Saldo & Statistik</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Total saldo tabungan rupiah Anda akan tampil otomatis di <strong>Dashboard Utama</strong>.</li>
                            <li>Untuk melihat seberapa besar kontribusi Anda dalam mengurangi emisi Karbon (CO2), buka menu <strong>"Statistik Saya" (EcoStats)</strong>.</li>
                        </ul>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-slate-800 mb-2">3. Membatalkan Pemesanan</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Buka menu <strong>Jadwal (Riwayat Penjemputan)</strong>.</li>
                            <li>Pembatalan hanya bisa dilakukan jika status transaksi masih <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs font-bold">MENUNGGU</span>. Jika sudah selesai, pesanan tidak bisa dibatalkan.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section id="petugas" class="scroll-mt-24">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">🚛</span>
                    <h2 class="text-2xl font-black text-amber-600">Panduan Petugas Lapangan</h2>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 mb-2">1. Membaca Daftar Tugas & Rute</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Buka menu <strong>Daftar Tugas</strong> dari menu navigasi bawah.</li>
                            <li>Sistem otomatis mengurutkan tugas warga berdasarkan lokasi terdekat atau antrean terlama.</li>
                            <li>Klik tombol <strong>"Lihat Rute"</strong> untuk melihat detail alamat dan catatan instruksi dari warga.</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-slate-50">
                        <h4 class="font-bold text-slate-800 mb-2">2. Melakukan Timbangan Aktual (Validasi)</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Saat tiba di rumah warga, klik tombol <strong>"Timbang Sampah"</strong>.</li>
                            <li>Masukkan <strong>Berat Bersih (Kg)</strong> sesuai angka di timbangan fisik Anda.</li>
                            <li>Pilih status <strong>"Selesai"</strong>. Sistem akan otomatis menghitung konversi uang dan mengirim notifikasi saldo ke warga.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section id="admin" class="scroll-mt-24">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">⚙️</span>
                    <h2 class="text-2xl font-black text-slate-900">Panduan Admin Pusat</h2>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 mb-2">1. Master Data Katalog Harga</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Buka menu <strong>Katalog Harga</strong> di sidebar kiri.</li>
                            <li>Anda bisa menambah komoditas sampah baru atau mengubah (Update) harga per-kilogram sesuai harga pasar terbaru. ID Kategori dibuat otomatis oleh sistem.</li>
                        </ul>
                    </div>
                    <div class="p-6 border-b border-slate-100 bg-slate-50">
                        <h4 class="font-bold text-slate-800 mb-2">2. Membaca Laporan Transaksi</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Buka menu <strong>Laporan Transaksi</strong>.</li>
                            <li>Gunakan filter <strong>Bulan dan Tahun</strong> di bagian atas untuk mencetak rekapitulasi data total sampah (Kg) dan omset perputaran uang (Rp).</li>
                        </ul>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-slate-800 mb-2">3. Manajemen Akun Petugas</h4>
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-2">
                            <li>Buka menu <strong>Manajemen User</strong>.</li>
                            <li>Anda memiliki otoritas penuh untuk mendaftarkan akun kurir/petugas baru agar mereka bisa login ke aplikasi mobile, atau menghapus akun petugas yang sudah *resign*.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <footer class="mt-12 py-6 border-t border-slate-200 text-center text-sm text-slate-400">
                <p>&copy; {{ date('Y') }} Sistem Informasi P3ST Kelompok 6. Semua Hak Cipta Dilindungi.</p>
            </footer>

        </main>
    </div>
</body>
</html>