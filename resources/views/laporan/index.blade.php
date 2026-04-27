@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 print:mb-4 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
            Laporan Transaksi
        </h1>
        <p class="text-slate-500 mt-2 print:hidden">
            Daftar laporan pemasukan berdasarkan transaksi.
        </p>
        <p class="hidden print:block text-slate-500 mt-1">
            Periode: {{ strtoupper($filter) }} | Dicetak: {{ now()->format('d M Y, H:i') }}
        </p>
    </div>

    <div class="print:hidden flex flex-wrap items-center gap-3 w-full md:w-auto">

        <!-- FILTER -->
        <form method="GET" action="{{ route('laporan') }}" class="flex bg-white shadow-sm border border-slate-200 rounded-lg p-1 overflow-x-auto w-full md:w-auto">
            @foreach(['today' => 'Hari Ini', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini', 'all' => 'Semua'] as $key => $label)
                <button type="submit" name="filter" value="{{ $key }}"
                    class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap
                    {{ $filter == $key ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>

        <!-- PRINT -->
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow flex items-center transition w-full md:w-auto justify-center">
            Cetak
        </button>
    </div>
</div>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow border border-slate-200">
    <div class="p-6 border-b border-slate-100 print:hidden">
        <h2 class="text-lg font-bold text-slate-800">Daftar Pemasukan</h2>
        <p class="text-sm text-slate-500 mt-1">
            Transaksi pembayaran yang telah selesai.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 print:bg-transparent">
                <tr>
                    <th class="px-6 py-4 print:border-b">Waktu</th>
                    <th class="px-6 py-4 print:border-b">Pembeli</th>
                    <th class="px-6 py-4 print:border-b">Produk</th>
                    <th class="px-6 py-4 print:border-b">Metode</th>
                    <th class="px-6 py-4 print:border-b text-right">Nominal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50 print:hover:bg-transparent">

                    <!-- WAKTU -->
                    <td class="px-6 py-4 text-sm">
                        {{ \Carbon\Carbon::parse($trx->payment_time)->format('d M Y, H:i') }}
                    </td>

                    <!-- USER -->
                    <td class="px-6 py-4 text-sm">
                        <div class="font-semibold">
                            {{ $trx->order->nama_pembeli ?? '-' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $trx->order->user->name ?? 'User hilang' }}
                        </div>
                    </td>

                    <!-- PRODUK -->
                    <td class="px-6 py-4 text-sm">

                        {{-- Kalau pakai multi item --}}
                        @if(isset($trx->order->items))
                            @foreach($trx->order->items as $item)
                                <div>
                                    {{ $item->product->nama_produk ?? 'Produk hilang' }}
                                    <span class="text-xs text-gray-500">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        @else
                            {{-- fallback kalau masih single product --}}
                            {{ $trx->order->product->nama_produk ?? 'Produk hilang' }}
                        @endif

                    </td>

                    <!-- METODE -->
                    <td class="px-6 py-4 text-sm uppercase">
                        {{ str_replace('_', ' ', $trx->payment_type) }}
                    </td>

                    <!-- NOMINAL -->
                    <td class="px-6 py-4 text-right font-bold text-emerald-600">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        Tidak ada transaksi pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($transactions->hasPages())
    <div class="p-6 border-t print:hidden">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

<style>
@media print {
    nav, footer { display: none !important; }
    body { background: white !important; }
    table { border-collapse: collapse; }
    th { border-bottom: 2px solid black; }
    td { border-bottom: 1px solid #ccc; }
}
</style>
@endsection