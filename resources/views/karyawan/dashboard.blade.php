@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg border border-slate-100 p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard Karyawan</h2>
        <p class="text-slate-500 text-sm mt-1">Orderan terbaru dan penyelesaian transaksi pelanggan.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b border-slate-200">
                    <th class="px-4 py-3 font-semibold text-slate-600">ID Order</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Pembeli</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Motor</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Total Harga</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-600">Selesaikan Manual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4 text-slate-700 font-medium">ORD-{{ $order->id }}</td>
                    <td class="px-4 py-4 text-slate-800">{{ $order->nama_pembeli }} <br><span class="text-xs text-slate-500">Oleh: {{ $order->user->name ?? 'Guest' }}</span></td>
                    <td class="px-4 py-4 text-slate-700">
                        {{ $order->product->nama_produk ?? 'Deleted Product' }}
                        @if($order->variant)
                            <br><span class="text-xs text-blue-600 font-semibold">Warna: {{ $order->variant->warna }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-slate-800 font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-4">
                        @if($order->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                        @elseif($order->status == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed/Cancelled</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @if($order->status == 'pending')
                        <div class="flex items-center gap-2">
                            <form action="{{ route('transactions.store') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <select name="payment_type" class="border border-slate-300 rounded text-sm p-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                                    <option value="cash">Cash / Di Tempat</option>
                                    <option value="transfer_bank">Transfer Bank</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded text-sm font-medium transition" onclick="return confirm('Tandai pesanan ini lunas secara manual? Stok akan dipotong.')">Selesaikan</button>
                            </form>
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm font-medium transition" onclick="return confirm('Batalkan pesanan ini? (Tandai Gagal)')">Gagal</button>
                            </form>
                        </div>
                        @else
                            <span class="text-sm text-slate-400 italic">No Action Needed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada order.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
