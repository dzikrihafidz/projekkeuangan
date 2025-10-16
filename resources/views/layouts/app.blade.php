<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-blue-600 dark:bg-blue-800 p-4 text-white">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg flex items-center gap-1">💰 KeuanganKu</h1>

            {{-- Tombol menu (mobile) --}}
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Menu utama --}}
            <div id="menu" class="hidden md:flex gap-4 items-center">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ route('transaksi.index') }}" class="hover:underline">Transaksi</a>
                <a href="{{ route('kategori.index') }}" class="hover:underline">Kategori</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Konten utama --}}
    <main class="flex-1 p-6 max-w-5xl mx-auto w-full">
        @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center text-sm py-4 bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
        © {{ date('Y') }} KeuanganKu — Dzikri Hadars & Ni Made 2AEC4
    </footer>

    {{-- Script: Toggle menu mobile --}}
    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
