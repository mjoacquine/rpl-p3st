<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P3ST - Sisi Petugas Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { padding-bottom: 85px; background-color: #f8fafc; }
    </style>
</head>
<body class="text-slate-800 font-sans antialiased">

    <header class="bg-slate-900 text-white p-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <span class="text-lg font-bold flex items-center gap-2">
            🏃‍♂️ <span>P3ST Kurir Lapangan</span>
        </span>
        <span class="bg-amber-500 text-slate-900 text-[10px] font-black px-2 py-1 rounded-full uppercase tracking-wider">
            Petugas
        </span>
    </header>

    <main class="p-4 max-w-md mx-auto">
        @yield('content')
    </main>

    <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-slate-200 py-2.5 px-8 flex justify-between items-center z-50 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
        <a href="{{ url('/petugas/dashboard') }}" class="flex flex-col items-center {{ Request::is('petugas/dashboard') ? 'text-blue-600 font-bold' : 'text-slate-400 hover:text-blue-500' }}">
            <span class="text-2xl">🏠</span>
            <span class="text-[11px] mt-1">Beranda</span>
        </a>
        <a href="{{ url('/petugas/tugas') }}" class="flex flex-col items-center {{ Request::is('petugas/tugas*') || Request::is('petugas/transaksi*') ? 'text-blue-600 font-bold' : 'text-slate-400 hover:text-blue-500' }}">
            <span class="text-2xl">📋</span>
            <span class="text-[11px] mt-1">Daftar Tugas</span>
        </a>
        <a href="{{ url('/petugas/profil') }}" class="flex flex-col items-center {{ Request::is('petugas/profil*') ? 'text-blue-600 font-bold' : 'text-slate-400 hover:text-blue-500' }}">
            <span class="text-2xl">👤</span>
            <span class="text-[11px] mt-1">Profil</span>
        </a>
    </nav>

</body>
</html>