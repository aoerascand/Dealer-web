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

        <!-- BRAND -->
        <a href="/" class="text-xl font-bold tracking-wider hover:text-blue-400 transition">
            DEALER<span class="text-green-500">MOTOR</span>
        </a>

        <!-- MENU TENGAH -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('about') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400">About</a>
            <a href="{{ route('kategori') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400">Katalog</a>
            <a href="{{ route('contact') }}" class="text-sm font-semibold text-gray-300 hover:text-green-400">Contact</a>
        </div>

        <!-- KANAN -->
        <div class="flex items-center space-x-4">

            @auth
                <span class="text-sm text-gray-300">
                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                </span>

                {{-- ADMIN --}}
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
                <a href="{{ route('employees.index') }}" class="nav-link">Karyawan</a>
                <a href="{{ route('laporan') }}" class="nav-link">Laporan</a>
                @endif

                {{-- KARYAWAN --}}
                @if(Auth::user()->role == 'karyawan')
                    <a href="{{ route('staff.dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('staff.produk') }}" class="nav-link">Produk</a>
                    <a href="{{ route('staff.entry') }}" class="nav-link">Entry Order</a>
                @endif

                {{-- BOS --}}
                @if(Auth::user()->role == 'bos')
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('laporan') }}" class="nav-link">Laporan</a>
                @endif

                {{-- DEFAULT USER --}}
                @if(!in_array(Auth::user()->role, ['admin','karyawan','bos']))
                    <a href="{{ route('my-orders') }}" class="nav-link">My Orders</a>
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
