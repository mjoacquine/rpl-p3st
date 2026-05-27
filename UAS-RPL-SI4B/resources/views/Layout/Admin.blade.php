<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P3ST - Admin Panel Pusat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f8fafc; }
    </style>
</head>
<body class="text-slate-800 font-sans antialiased flex min-h-screen">

    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-50">
        <div class="p-5 border-b border-slate-800 flex items-center gap-3 bg-slate-950">
            <span class="text-2xl">⚙️</span>
            <span class="font-black text-white tracking-wide text-lg">P3ST ADMIN</span>
        </div>
        
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition {{ Request::is('admin/dashboard') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ url('/admin/katalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition {{ Request::is('admin/katalog*') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>🏷️</span> Master Katalog Harga
            </a>
            <a href="{{ url('/admin/report') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition {{ Request::is('admin/report*') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>📜</span> Laporan Transaksi
            </a>
            <a href="{{ url('/admin/user') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition {{ Request::is('admin/user*') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>👥</span> Manajemen User
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-950 flex flex-col gap-2">
            <div class="text-xs">
                <p class="text-slate-500">Masuk sebagai:</p>
                <p class="font-bold text-slate-300 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
            </div>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white font-bold py-2 px-3 rounded-lg text-xs transition text-center block">
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
            <span class="text-sm font-semibold text-slate-500">Sistem Informasi Pengelolaan Sampah Terjadwal</span>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Pusat Kendali</span>
        </header>

        <main class="p-8 flex-1 max-w-6xl w-full mx-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>