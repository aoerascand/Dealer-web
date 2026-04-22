@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-slate-100 p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Edit Data Motor</h2>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Motor</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual (Rp)</label>
            <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Spesifikasi</label>
            <textarea name="deskripsi" rows="4"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-lg font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg hover:bg-blue-700 transition-colors">Perbarui Data</button>
        </div>
    </form>
</div>

<!-- Variant Management Section -->
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow-lg border border-slate-100 p-8">
    <div class="mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-2xl font-bold text-slate-800">Varian Warna Produk</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola pilihan warna untuk kendaraan ini beserta foto spesifik warnanya.</p>
    </div>

    <!-- List Existing Variants -->
    <div class="mb-8">
        @if($product->variants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($product->variants as $variant)
                <div class="flex p-4 border border-slate-200 rounded-lg shadow-sm bg-slate-50 relative group">
                    <div class="w-20 h-20 bg-white rounded-md flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($variant->gambar)
                            <img src="{{ asset('storage/' . $variant->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs text-slate-400">No Img</span>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <form action="{{ route('variants.update', $variant->id) }}" method="POST" class="flex flex-col xl:flex-row gap-2 mb-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="warna" value="{{ $variant->warna }}" required placeholder="Nama Warna" class="border px-3 py-1.5 rounded-lg w-full xl:w-2/3 text-sm font-bold text-slate-800 outline-none focus:ring-1 focus:ring-blue-500 border-slate-300">
                            <div class="flex gap-2 w-full xl:w-auto mt-2 xl:mt-0">
                                <input type="number" name="stok" value="{{ $variant->stok }}" required min="0" placeholder="Stok" class="border px-2 py-1.5 rounded-lg w-20 text-sm text-blue-600 font-semibold outline-none focus:ring-1 focus:ring-blue-500 border-slate-300">
                                <button type="submit" class="text-xs bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-1.5 rounded-lg font-medium shadow-sm transition">Ubah</button>
                            </div>
                        </form>
                        <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus varian ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 hover:underline px-1 py-1 font-medium transition">Hapus Varian</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center p-6 bg-slate-50 rounded-lg border border-slate-100 border-dashed">
                <p class="text-slate-500">Belum ada varian warna untuk motor ini.</p>
            </div>
        @endif
    </div>

    <!-- Add New Variant Form -->
    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
        <h3 class="font-bold text-blue-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Warna Baru
        </h3>
        <form action="{{ route('products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Warna</label>
                    <input type="text" name="warna" required placeholder="Cth: Merah Doff"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Warna Ini</label>
                    <input type="number" name="stok" required min="0" placeholder="0"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Khusus Warna Ini</label>
                <input type="file" name="gambar" accept="image/*" required
                    class="w-full p-2 border border-slate-300 rounded-lg text-slate-600 bg-white">
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium shadow-sm hover:bg-blue-700 transition-colors">
                    Simpan Varian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
