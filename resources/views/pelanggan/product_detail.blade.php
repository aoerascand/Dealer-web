@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden mt-8">
    <div class="md:flex">
        <!-- Image Section -->
        <div class="md:w-1/2 bg-slate-100 flex items-center justify-center p-8">
            <img id="main-product-image" src="{{ $product->default_gambar ? asset('storage/' . $product->default_gambar) : '' }}" class="{{ $product->default_gambar ? '' : 'hidden' }} max-w-full h-auto object-contain hover:scale-105 transition-transform duration-500 drop-shadow-xl" alt="{{ $product->nama_produk }}">
            <div id="no-image-placeholder" class="{{ $product->default_gambar ? 'hidden' : '' }} text-slate-400 flex flex-col items-center">
                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Tidak Ada Gambar</span>
            </div>
        </div>

        <!-- Details Section -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-2 text-sm font-semibold tracking-wider text-green-600 uppercase">Kategori Motor</div>
            <h1 class="text-4xl font-extrabold text-slate-800 mb-4">{{ $product->nama_produk }}</h1>
            
            <div class="flex items-center mb-4">
                <span class="text-3xl font-black text-green-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                <span id="stock-badge" class="ml-4 px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">Tersedia {{ $product->total_stok }} Unit Tersedia</span>
            </div>
            
            @if($product->variants->count() > 0)
            <div class="mb-6">
                <h4 class="text-sm font-semibold text-slate-700 mb-3">Pilih Varian Warna</h4>
                <div class="flex flex-wrap gap-3">
                    @foreach($product->variants as $variant)
                    <label class="cursor-pointer">
                        <input type="radio" name="variant_selection" value="{{ $variant->id }}" class="peer sr-only" 
                            data-img="{{ $variant->gambar ? asset('storage/' . $variant->gambar) : '' }}" data-stok="{{ $variant->stok }}"
                            onchange="updateVariantDetails(this)">
                        <div class="px-4 py-2 rounded-lg border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-medium text-slate-600 transition-all">
                            {{ $variant->warna }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
            
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
                        <form action="{{ route('checkout') }}" method="POST" id="order-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_variant_id" id="selected_variant_id" value="">
                            <div class="mb-4">
                                <label for="deskripsi_tambahan" class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="deskripsi_tambahan" id="deskripsi_tambahan" rows="2" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Keterangan warna, dll..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center text-lg transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Lanjutkan Pesanan
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-green-50 p-6 rounded-xl border border-green-100 text-center">
                        <p class="text-green-800 font-medium mb-4">Silakan login untuk melakukan pemesanan kendaraan ini.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">Login Sekarang</a>
                    </div>
                @endauth
            </div>
            
            <div class="mt-4 text-center">
                <a href="/#kategori" class="text-slate-500 hover:text-green-600 font-medium transition-colors text-sm">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function updateVariantDetails(radio) {
        // Update input hidden
        document.getElementById('selected_variant_id').value = radio.value;
        
        // Update gambar
        const imgUrl = radio.getAttribute('data-img');
        const imgElem = document.getElementById('main-product-image');
        const placeholder = document.getElementById('no-image-placeholder');
        
        if (imgUrl && imgUrl.trim() !== '') {
            imgElem.src = imgUrl;
            imgElem.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        } else {
            imgElem.classList.add('hidden');
            if(placeholder) placeholder.classList.remove('hidden');
        }

        // Update Stok
        const stok = parseInt(radio.getAttribute('data-stok'));
        const badge = document.getElementById('stock-badge');
        badge.innerHTML = 'Tersedia ' + stok + ' Unit Terpilih';
        
        if(stok <= 0) {
            badge.classList.remove('bg-green-100', 'text-green-700');
            badge.classList.add('bg-red-100', 'text-red-700');
            badge.innerHTML = 'Stok Warna Kosong';
        } else {
            badge.classList.remove('bg-red-100', 'text-red-700');
            badge.classList.add('bg-green-100', 'text-green-700');
        }
    }

    // Validation before submit
    document.getElementById('order-form')?.addEventListener('submit', function(e) {
        @if($product->variants->count() > 0)
        if (!document.getElementById('selected_variant_id').value) {
            e.preventDefault();
            alert('Silakan pilih varian warna terlebih dahulu!');
        }
        @endif
    });
</script>
@endsection
