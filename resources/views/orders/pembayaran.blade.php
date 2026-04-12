@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-slate-100 p-8 text-center">
    <div class="mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-slate-800">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mt-2">ID Pesanan Anda: <span class="font-bold text-slate-700">ORD-{{ $order->id }}</span></p>
    </div>

    <div class="bg-slate-50 rounded-lg p-6 mb-8 text-left border border-slate-100">
        <h3 class="font-semibold text-slate-700 border-b pb-2 mb-4">Rincian Pembayaran</h3>
        <div class="flex justify-between mb-2">
            <span class="text-slate-600">Produk</span>
            <span class="font-medium text-slate-800">{{ $order->product->nama_produk ?? '-' }}</span>
        </div>
        <div class="flex justify-between mb-2">
            <span class="text-slate-600">Nama Pemesan</span>
            <span class="font-medium text-slate-800">{{ $order->nama_pembeli }}</span>
        </div>
        <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
            <span class="text-slate-800">Total Tagihan</span>
            <span class="text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->status == 'pending')
        <button id="pay-button" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-transform transform active:-translate-y-1 mb-4">
            Bayar Sekarang dengan Midtrans
        </button>
        <p class="text-sm text-slate-400">Atau bayar langsung di dealer, kasir akan menyelesaikan pesanan Anda.</p>
    @else
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg font-semibold">
            Pesanan ini sudah selesai.
        </div>
        <a href="{{ route('my-orders') }}" class="mt-4 block text-blue-600 underline">Kembali ke Daftar Pesanan</a>
    @endif
</div>

<!-- Snap Midtrans JS -->
@if($order->status == 'pending')
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.clientKey', env('MIDTRANS_CLIENT_KEY')) }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Pembayaran berhasil!"); window.location.href = "{{ route('my-orders') }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!"); window.location.href = "{{ route('my-orders') }}";
            },
            onError: function(result){
                alert("Pembayaran gagal!"); window.location.href = "{{ route('my-orders') }}";
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>
@endif
@endsection
