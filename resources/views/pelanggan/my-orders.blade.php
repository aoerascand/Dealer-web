@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg border border-slate-100 p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Pesanan Saya</h2>
        <p class="text-slate-500 text-sm mt-1">Lacak status pesanan Anda di bawah ini.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b border-slate-200">
                    <th class="px-4 py-3 font-semibold text-slate-600">ID Order</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Produk</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Total Harga</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4 text-slate-700 font-medium">ORD-{{ $order->id }}</td>
                    <td class="px-4 py-4 text-slate-800">{{ $order->product->nama_produk ?? 'Deleted Product' }}</td>
                    <td class="px-4 py-4 text-slate-800 font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-slate-600">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-4">
                        @if($order->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Proses Dealer</span>
                        @elseif($order->status == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berhasil (Selesai)</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Gagal</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @if($order->status == 'pending')
                            <span class="text-sm font-semibold text-amber-600">Hubungi Staff</span>
                        @else
                            <span class="text-sm text-slate-400 italic">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">Anda belum pernah membuat pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
