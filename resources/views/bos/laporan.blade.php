@extends('layouts.app')

@section('content')
<!-- Header & Print Trigger -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 print:mb-4 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Menyeluruh (Bos)</h1>
        <p class="text-slate-500 mt-2 print:hidden">Daftar Laporan Transaksi Masuk.</p>
        <p class="hidden print:block text-slate-500 mt-1">Periode Filter: {{ strtoupper($filter) }} | Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>
    <div class="print:hidden flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('boss.laporan') }}" class="flex bg-white shadow-sm border border-slate-200 rounded-lg p-1 overflow-x-auto w-full md:w-auto">
            <button type="submit" name="filter" value="today" class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap {{ $filter == 'today' ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">Hari Ini</button>
            <button type="submit" name="filter" value="month" class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap {{ $filter == 'month' ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">Bulan Ini</button>
            <button type="submit" name="filter" value="year" class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap {{ $filter == 'year' ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">Tahun Ini</button>
            <button type="submit" name="filter" value="all" class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap {{ $filter == 'all' ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">Semua Waktu</button>
        </form>
        
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow flex items-center transition w-full md:w-auto justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak
        </button>
    </div>
</div>



<!-- Laporan Transaksi Keuangan -->
<div class="bg-white rounded-xl shadow border border-slate-200">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center print:hidden">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Pemasukan (Lunas)</h2>
            <p class="text-sm text-slate-500 mt-1">Riwayat uang kasir masuk dari pelanggan dealer berdasarkan filter.</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 print:bg-transparent">
                <tr>
                    <th class="px-6 py-4 print:py-2 print:border-b print:text-black">Waktu Lunas</th>
                    <th class="px-6 py-4 print:py-2 print:border-b print:text-black">Nama Pembeli (User)</th>
                    <th class="px-6 py-4 print:py-2 print:border-b print:text-black">Produk Tagihan</th>
                    <th class="px-6 py-4 print:py-2 print:border-b print:text-black">Metode Bayar</th>
                    <th class="px-6 py-4 print:py-2 print:border-b print:text-black text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 print:divide-gray-400">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50 transition-colors print:hover:bg-transparent">
                    <td class="px-6 py-4 print:py-2 text-sm font-medium text-slate-700 print:text-black">
                        {{ \Carbon\Carbon::parse($trx->payment_time)->translatedFormat('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 print:py-2 text-sm print:text-black">
                        <div class="font-semibold text-slate-800 print:font-normal print:text-black">{{ $trx->order->nama_pembeli ?? '-' }}</div>
                        <div class="text-xs text-slate-500 print:text-gray-600">{{ $trx->order->user->name ?? 'Deleted User' }}</div>
                    </td>
                    <td class="px-6 py-4 print:py-2 text-sm text-slate-700 print:text-black">
                        {{ $trx->order->product->nama_produk ?? 'Deleted Product' }}
                        @if($trx->order->variant)
                            <span class="text-xs text-blue-600 print:text-black block">({{ $trx->order->variant->warna }})</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 print:py-2 print:text-black">
                        <span class="inline-flex px-2 py-1 text-xs font-bold rounded bg-slate-200 text-slate-700 print:bg-transparent print:p-0 print:border-none uppercase whitespace-nowrap">
                            {{ str_replace('_', ' ', $trx->payment_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 print:py-2 text-sm font-black text-emerald-600 print:text-black text-right whitespace-nowrap">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic print:text-black">Belum ada transaksi tervalidasi masuk pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transactions->hasPages())
    <div class="p-6 border-t border-slate-100 print:hidden">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

<style>
/* Cetak styling khusus Print */
@media print {
    body { background-color: white !important; }
    nav, footer { display: none !important; }
    main { padding: 0 !important; }
    .shadow-lg, .shadow-md, .shadow { box-shadow: none !important; }
    .border-slate-200 { border-color: #e2e8f0 !important; }
    .bg-white { background: transparent !important; }
    table { width: 100% !important; border-collapse: collapse !important; }
    th { border-bottom: 2px solid black !important; }
    td { border-bottom: 1px solid #ccc !important; }
}
</style>
@endsection
