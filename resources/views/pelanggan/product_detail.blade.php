@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden mt-8">
    <div class="md:flex">
        <!-- Image Section -->
        <div class="md:w-1/2 bg-slate-100 flex items-center justify-center p-8">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="max-w-full h-auto object-contain hover:scale-105 transition-transform duration-500 drop-shadow-xl">
            @else
                <div class="text-slate-400 flex flex-col items-center">
                    <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Tidak Ada Gambar</span>
                </div>
            @endif
        </div>

        <!-- Details Section -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-2 text-sm font-semibold tracking-wider text-blue-600 uppercase">Kategori Motor</div>
            <h1 class="text-4xl font-extrabold text-slate-800 mb-4">{{ $product->nama_produk }}</h1>
            
            <div class="flex items-center mb-6">
                <span class="text-3xl font-black text-blue-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                <span class="ml-4 px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">Tersedia {{ $product->stok }} Unit</span>
            </div>
            
            <div class="mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3">Deskripsi / Keterangan Produk</h3>
                <div class="prose text-slate-600 leading-relaxed bg-slate-50 p-6 rounded-xl border border-slate-100">
                    {!! nl2br(e($product->deskripsi ?? 'Tidak ada keterangan tambahan untuk produk ini.')) !!}
                </div>
            </div>

            <!-- Order Form -->
            <div class="mt-auto border-t border-slate-100 pt-6">
                @auth
                    @if(Auth::user()->role == 'pelanggan')
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-4">
                                <label for="deskripsi_tambahan" class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="deskripsi_tambahan" id="deskripsi_tambahan" rows="2" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Keterangan warna, dll..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 hover:bg-blue-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center text-lg transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Lanjutkan Pesanan
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 text-center">
                        <p class="text-blue-800 font-medium mb-4">Silakan login untuk melakukan pemesanan kendaraan ini.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">Login Sekarang</a>
                    </div>
                @endauth
            </div>
            
            <div class="mt-4 text-center">
                <a href="/#kategori" class="text-slate-500 hover:text-blue-600 font-medium transition-colors text-sm">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
