@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow border border-slate-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Katalog Produk Internal</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar semua unit motor yang terdaftar di dealer beserta variannya untuk panduan karyawan.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 font-semibold text-slate-600">ID</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Produk Motor</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Total Stok Induk</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Harga Dasar</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Varian Warna & Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-4 text-slate-700">PRD-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4">
                        <div class="font-bold text-slate-800">{{ $product->nama_produk }}</div>
                        <div class="text-xs text-slate-500 truncate max-w-[200px]">{{ $product->deskripsi }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center justify-center px-2 py-1 rounded {{ $product->stok > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }} font-bold text-xs">
                            {{ $product->stok }} Unit
                        </span>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-bold">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-4">
                        @if($product->variants->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->variants as $variant)
                                    <span class="inline-block px-2 py-1 text-xs border border-slate-200 rounded shadow-sm bg-white">
                                        <span class="font-semibold text-slate-700">{{ $variant->warna }}</span>: 
                                        <span class="{{ $variant->stok > 0 ? 'text-blue-600' : 'text-red-500' }} font-bold">{{ $variant->stok }}</span>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">Tidak ada varian khusus</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada produk di database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
