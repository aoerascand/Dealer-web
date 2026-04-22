@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto my-8">
    
    <!-- Action Bar (Not Printed) -->
    <div class="flex justify-between items-center mb-6 print:hidden">
        <a href="{{ route('my-orders') }}" class="text-blue-600 hover:underline font-medium flex items-center">
            &larr; Kembali ke Pesanan Saya
        </a>
        <button onclick="window.print()" class="bg-slate-800 hover:bg-black text-white px-5 py-2 rounded-lg text-sm font-semibold shadow flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Struk
        </button>
    </div>

    <!-- Receipt Format -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8 md:p-12 print:shadow-none print:border-none print:p-0">
        
        <!-- Header -->
        <div class="border-b-2 border-slate-100 pb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight">INVOICE</h1>
                <p class="text-slate-500 mt-1 font-medium">Order ID: <span class="text-slate-800">ORD-{{ $order->id }}</span></p>
                <div class="mt-4">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'gagal') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        @if($order->status == 'completed') LUNAS (SELESAI)
                        @elseif($order->status == 'gagal') DIBATALKAN / GAGAL
                        @else PENDING @endif
                    </span>
                </div>
            </div>
            <div class="text-right text-slate-600 text-sm">
                <h2 class="font-bold text-slate-800 text-xl mb-1">DealerAuto</h2>
                <p>Jl. Gatot Subroto No. 123</p>
                <p>Jakarta Selatan, 12345</p>
                <p class="mt-2 text-blue-600 font-semibold">Tgl: {{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <!-- Customer & Info -->
       <div class="py-8 border-b-2 border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-8">
    
    <div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
            DITAGIHKAN KEPADA:
        </h3>
        <p class="text-lg font-bold text-slate-800">{{ $order->nama_pembeli }}</p>
        <p class="text-slate-600 text-sm mt-1">
            Akun: {{ $order->user->name }} ({{ $order->user->email }})
        </p>
    </div>

    <div class="md:text-right">
        @if($order->status == 'gagal')

            <div class="inline-block p-3 bg-red-50 rounded-lg border border-red-200 text-left">
                <p class="text-sm text-red-800 font-medium">
                    Transaksi ini telah dibatalkan atau gagal diproses oleh pihak dealer.
                </p>
            </div>

        @elseif($order->status == 'completed')

            <div class="inline-block p-3 bg-green-50 rounded-lg border border-green-200 text-left">
                <p class="text-sm text-green-800 font-medium">
                    Pembayaran telah diterima. Unit siap diproses oleh dealer.
                </p>
            </div>

        @else

            <div class="inline-block p-3 bg-amber-50 rounded-lg border border-amber-200 text-left">
                <p class="text-sm text-amber-800 font-medium">
                    Bawa struk ini ke dealer untuk proses pembayaran.
                </p>
            </div>

        @endif
    </div>

</div>

        <!-- Product Table -->
        <div class="py-8">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">ITEM PESANAN</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-200">
                        <th class="py-3 px-4 font-semibold text-slate-700 text-sm">Produk Tambahan</th>
                        <th class="py-3 px-4 font-semibold text-slate-700 text-sm text-center">Qty</th>
                        <th class="py-3 px-4 font-semibold text-slate-700 text-sm text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="py-5 px-4">
                            <div class="font-bold text-slate-800 text-lg">{{ $order->product->nama_produk ?? 'Produk Dihapus' }}</div>
                            @if($order->variant)
                            <div class="text-sm font-medium text-blue-600 mt-1">Varian Warna: {{ $order->variant->warna }}</div>
                            @endif
                            @if($order->deskripsi_tambahan)
                            <div class="text-xs text-slate-500 mt-2 bg-slate-50 p-2 rounded">
                                <span class="font-semibold text-slate-600">Catatan Pembeli:</span><br>
                                {{ $order->deskripsi_tambahan }}
                            </div>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center font-medium text-slate-700">1</td>
                        <td class="py-4 px-4 text-right font-bold text-slate-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end pt-4 pb-8">
            <div class="w-full md:w-1/2">
                <div class="flex justify-between py-2 text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 text-slate-600 border-b border-slate-200">
                    <span>Biaya Layanan/Pajak</span>
                    <span class="font-medium">Rp 0</span>
                </div>
                <div class="flex justify-between py-4 text-slate-900 text-xl font-black">
                    <span>TOTAL TAGIHAN</span>
                    <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Footer Print -->
        <div class="border-t border-slate-200 pt-8 text-center text-slate-500 text-sm">
            <p class="font-medium text-slate-600 mb-1">Terima kasih atas pesanan Anda di DealerAuto.</p>
            <p>Struk ini sah sebagai bukti pemesanan unit kendaraan. Jika status PENDING, unit tidak otomatis ter-reservasi sebelum Anda menghubungi pihak dealer.</p>
        </div>

    </div>
</div>

<style>
/* Cetak styling khusus Print */
@media print {
    body {
        background-color: white !important;
    }
    nav, footer {
        display: none !important;
    }
    main {
        padding: 0 !important;
    }
}
</style>
@endsection
