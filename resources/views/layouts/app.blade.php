<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Showroom Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 font-sans text-gray-800">
    <nav class="bg-slate-900 text-white p-4 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex items-center justify-between">

        <!-- KIRI: BRAND -->
        <div>
            <a href="/" class="text-xl font-bold tracking-wider hover:text-blue-400 transition">
                DEALER<span class="text-green-500">MOTOR</span>
            </a>
        </div>

        <!-- TENGAH: MENU -->
        <div class="hidden md:flex space-x-6 absolute left-1/2 transform -translate-x-1/2">
            <a href="{{ route('about') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">About</a>
            <a href="{{ route('kategori') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Katalog</a>
            <a href="{{ route('contact') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Contact</a>
        </div>

        <!-- KANAN: AUTH -->
        <div class="flex items-center space-x-4">
            @auth
                <span class="text-sm font-medium text-gray-300">
                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                </span>

                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Products</a>
                @elseif(Auth::user()->role == 'karyawan')
                    <a href="{{ route('staff.dashboard') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Dashboard</a>
                    <a href="{{ route('staff.produk') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Produk</a>
                    <a href="{{ route('staff.entry') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Entry Order</a>
                @elseif(Auth::user()->role == 'bos')
                    <a href="{{ route('boss.index') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Dashboard</a>
                    <a href="{{ route('boss.laporan') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">Laporan</a>
                @else
                    <a href="{{ route('my-orders') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400 transition">My Orders</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-semibold">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-200 hover:text-green-400">Login</a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm font-semibold">
                    Daftar
                </a>
            @endauth
        </div>

    </div>
</nav>
    <main class="container mx-auto p-4 mt-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
