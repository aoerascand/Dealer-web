@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg border border-slate-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Produk</h2>
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow transition-colors block">
            + Tambah Motor
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b border-slate-200">
                    <th class="px-4 py-3 font-semibold text-slate-600">ID</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Gambar</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Nama Motor</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Stok</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Harga</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4 text-slate-700">{{ $product->id }}</td>
                    <td class="px-4 py-4 text-slate-700">
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-20 h-16 object-cover rounded-md shadow-sm">
                        @else
                            <div class="w-20 h-16 bg-slate-200 rounded-md flex items-center justify-center text-xs text-slate-400">No Img</div>
                        @endif
                    </td>
                    <td class="px-4 py-4 font-medium text-slate-800">{{ $product->nama_produk }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stok }} Tersedia
                        </span>
                    </td>
                    <td class="px-4 py-4 text-slate-700 font-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="text-sm bg-amber-100 hover:bg-amber-200 text-amber-800 px-3 py-1.5 rounded-md font-medium transition-colors">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1.5 rounded-md font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada data produk tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
