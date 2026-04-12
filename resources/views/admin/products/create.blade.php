@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-slate-100 p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Data Motor Baru</h2>
        <p class="text-slate-500 mt-1">Masukkan spesifikasi produk dealer di bawah ini.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Motor</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="grid grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Unit</label>
                <input type="number" name="stok" value="{{ old('stok') }}" required min="0" placeholder="0"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="e.g. 25000000"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Motor</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full p-2 border border-slate-300 rounded-lg text-slate-600 bg-slate-50">
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Spesifikasi</label>
            <textarea name="deskripsi" rows="4"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-lg font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg hover:bg-blue-700 transition-colors">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
