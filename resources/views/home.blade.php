@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-slate-900 to-blue-900 rounded-2xl shadow-2xl overflow-hidden mb-12">
    <div class="px-8 py-16 md:px-16 text-center md:text-left md:flex justify-between items-center text-white">
        
        <!-- TEXT -->
        <div class="md:w-1/2">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">
                Temukan Motor Impian Anda
            </h1>
            <p class="text-lg text-blue-200 mb-8 max-w-lg">
                Dealer resmi terpercaya dengan koleksi motor terlengkap, harga terbaik, dan jaminan purna jual berkualitas. 
            </p>
            <a href="#katalog" class="bg-white text-blue-900 hover:bg-blue-50 font-bold px-8 py-3.5 rounded-full shadow-lg transition-transform transform active:scale-95 inline-block">
                Lihat Katalog
            </a>
        </div>

        <!-- IMAGE -->
        <div class="md:w-1/2 mt-10 md:mt-0 relative flex justify-center items-center">
            
            <!-- Blur effect (biar tetap keliatan fancy) -->
            <div class="absolute w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40"></div>

            <!-- Gambar motor -->
            <img class="animate-float" src="{{ asset('images/motor-removebg-preview.png') }}" 
                 alt="Motor" 
                 class="relative w-[320px] md:w-[420px] object-contain drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>

    </div>
</div>
<!-- Catalog Section -->
<div id="katalog" class="scroll-mt-24">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800">Katalog Produk Ready Stock</h2>
        <p class="text-slate-500 mt-2">Pilih motor idamanmu dan checkout langsung.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="h-56 bg-slate-200 overflow-hidden relative">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">Tidak Ada Gambar</div>
                @endif
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-blue-800 font-bold px-3 py-1 rounded-full shadow-sm text-sm">
                    Stok: {{ $product->stok }}
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $product->nama_produk }}</h3>
                <p class="text-2xl font-black text-blue-600 mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                <p class="text-slate-600 text-sm mb-6 line-clamp-2 h-10">{{ $product->deskripsi }}</p>
                
                @auth
                    @if(Auth::user()->role == 'pelanggan')
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 px-4 rounded-xl shadow transition-colors block text-center">
                            Pesan Sekarang
                        </button>
                    </form>
                    @endif
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-2 rounded-xl shadow-sm transition-colors text-center text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="w-1/2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-3 px-2 rounded-xl shadow-sm transition-colors text-center text-sm">
                            Daftar Baru
                        </a>
                    </div>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-slate-500 bg-white rounded-2xl border border-slate-100">
            <p class="text-lg">Maaf, saat ini belum ada produk yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
