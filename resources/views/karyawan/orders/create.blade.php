@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-slate-100 p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Catat Pesanan Manual</h2>
        <p class="text-sm text-slate-500">Buat pesanan untuk pelanggan yang datang ke dealer langsung.</p>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Motor</label>
            <select name="product_id" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <option value="">-- Pilih Motor Tersedia --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->nama_produk }} - Rp {{ number_format($product->harga,0,',','.') }} (Stok: {{ $product->stok }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pembeli</label>
            <input type="text" name="nama_pembeli" required placeholder="Masukkan nama pelanggan"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan Tambahan</label>
            <textarea name="deskripsi_tambahan" rows="3" placeholder="Opsional"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('orders.index') }}" class="px-5 py-2.5 rounded-lg font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg hover:bg-blue-700 transition-colors">Buat Pesanan</button>
        </div>
    </form>
</div>
@endsection
