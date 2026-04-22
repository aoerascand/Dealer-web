@extends('layouts.app')

@section('content')
<div class="my-12">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800">Katalog Produk Ready Stock</h2>
        <p class="text-slate-500 mt-2">Pilih motor idamanmu dan checkout langsung.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="h-56 bg-slate-200 overflow-hidden relative">
                @if($product->default_gambar)
                    <img src="{{ asset('storage/' . $product->default_gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">Tidak Ada Gambar</div>
                @endif
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-green-800 font-bold px-3 py-1 rounded-full shadow-sm text-sm">
                    Stok: {{ $product->total_stok }}
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $product->nama_produk }}</h3>
                <!-- <div class="text-yellow-400 text-sm mt-1">
                    ★★★★☆ <span class="text-slate-400 text-xs">(4.2)</span>
                </div> -->
                <p class="text-2xl font-black text-green-700 mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                <p class="text-slate-600 text-sm mb-6 line-clamp-2 h-10">{{ $product->deskripsi }}</p>
                
                <a href="{{ route('product.show', $product->id) }}" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 px-4 rounded-xl shadow transition-colors block text-center">
                    Lihat Detail
                </a>
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
