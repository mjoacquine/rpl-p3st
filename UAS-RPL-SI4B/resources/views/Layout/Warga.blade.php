<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P3ST - Dasbor Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { padding-bottom: 80px; background-color: #f3f4f6; }
    </style>
</head>
<body class="text-slate-800 font-sans antialiased">

    <header class="bg-emerald-600 text-white p-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <span class="text-lg font-bold flex items-center gap-2">
            🌱 <span>Bank Sampah P3ST</span>
        </span>
        <span class="bg-emerald-800 text-white text-[10px] font-black px-2 py-1 rounded-full uppercase tracking-wider">
            Warga
        </span>
    </header>

    <main class="p-4 max-w-md mx-auto">
        @yield('content')
    </main>

    <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-slate-200 py-2 px-6 flex justify-between items-center z-50 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
        <a href="{{ url('/warga/dashboard') }}" class="flex flex-col items-center {{ Request::is('warga/dashboard') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-emerald-500' }}">
            <span class="text-2xl">🏠</span>
            <span class="text-[10px] mt-1">Beranda</span>
        </a>
        <a href="{{ url('/warga/katalog') }}" class="flex flex-col items-center {{ Request::is('warga/katalog*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-emerald-500' }}">
            <span class="text-2xl">📚</span>
            <span class="text-[10px] mt-1">Katalog</span>
        </a>
        <a href="{{ url('/warga/jadwal') }}" class="flex flex-col items-center {{ Request::is('warga/jadwal*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-emerald-500' }}">
            <span class="text-2xl">📅</span>
            <span class="text-[10px] mt-1">Jadwal</span>
        </a>
        <a href="{{ url('/warga/profil') }}" class="flex flex-col items-center {{ Request::is('warga/profil*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-emerald-500' }}">
            <span class="text-2xl">👤</span>
            <span class="text-[10px] mt-1">Profil</span>
        </a>
    </nav>
</body>
</html>