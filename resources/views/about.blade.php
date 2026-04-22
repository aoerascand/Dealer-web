@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12 text-center max-w-4xl mx-auto my-12">
    <h2 class="text-3xl font-bold text-slate-800 mb-6">Tentang Kami</h2>
    <p class="text-slate-600 leading-relaxed text-lg mb-6">
        DealerMotor adalah penyedia kendaraan bermotor terkemuka dan terpercaya di Indonesia. Berdiri dengan semangat memberikan pelayanan maksimal, kami bertujuan menyediakan koleksi motor terbaik dengan harga yang bersaing, proses transparan, dan jaminan after-sales yang berkualitas untuk Anda.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-slate-800">
        <div class="p-4 bg-slate-50 rounded-xl">
            <h4 class="font-bold text-xl text-green-600 mb-2">3+ Tahun</h4>
            <p class="text-sm">Pengalaman</p>
        </div>
        <div class="p-4 bg-slate-50 rounded-xl">
            <h4 class="font-bold text-xl text-green-600 mb-2">50+</h4>
            <p class="text-sm">Pelanggan Puas</p>
        </div>
        <div class="p-4 bg-slate-50 rounded-xl">
            <h4 class="font-bold text-xl text-green-600 mb-2">Official</h4>
            <p class="text-sm">Dealer Resmi</p>
        </div>
    </div>
</div>
@endsection
