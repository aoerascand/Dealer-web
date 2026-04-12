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
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold tracking-wider hover:text-blue-400 transition">DEALER<span class="text-blue-500">AUTO</span></a>
            <div>
                @auth
                    <span class="mr-4 text-sm font-medium text-gray-300">Hello, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('products.index') }}" class="mr-4 hover:text-blue-400 transition">Products</a>
                    @elseif(Auth::user()->role == 'karyawan')
                        <a href="{{ route('orders.index') }}" class="mr-4 hover:text-blue-400 transition">Orders</a>
                    @elseif(Auth::user()->role == 'bos')
                        <a href="{{ route('boss.index') }}" class="mr-4 hover:text-blue-400 transition">Dashboard</a>
                    @else
                        <a href="{{ route('my-orders') }}" class="mr-4 hover:text-blue-400 transition">My Orders</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">Logout</button>
                    </form>
                @else
                    <div class="space-x-2">
                        <a href="{{ route('login') }}" class="hover:text-blue-400 transition text-sm font-semibold text-gray-200">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">Daftar</a>
                    </div>
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
