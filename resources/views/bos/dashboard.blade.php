@extends('layouts.app')

@section('content')
<!-- Header & Print Trigger -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 print:mb-4 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Menyeluruh (Bos)</h1>
        <p class="text-slate-500 mt-2 print:hidden">Ringkasan performa Dealer Showroom berdasarkan periode.</p>
        <p class="hidden print:block text-slate-500 mt-1">Periode Filter: {{ strtoupper($filter) }} | Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>
    <div class="print:hidden flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('dashboard') }}" class="flex bg-white shadow-sm border border-slate-200 rounded-lg p-1 overflow-x-auto w-full md:w-auto">
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

<!-- Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 print:grid-cols-4">
    <!-- Pendapatan Filter -->
    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg p-6 flex flex-col justify-center text-white">
        <h3 class="text-green-100 text-xs font-bold uppercase tracking-wider mb-1">TOTAL PENDAPATAN</h3>
        <p class="text-2xl font-black truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <!-- Jumlah Pesanan Dibuat Filter -->
    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">PESANAN BERHASIL</h3>
        <p class="text-3xl font-bold text-slate-800">{{ $completedOrdersCount }} <span class="text-sm font-medium text-slate-500">Trx</span></p>
    </div>
    <!-- Menunggu (Pending) -->
    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">PESANAN PENDING</h3>
        <p class="text-3xl font-bold text-amber-500">{{ $pendingOrders }} <span class="text-sm font-medium text-amber-300">Order</span></p>
    </div>
    <!-- Produk / Katalog Global -->
    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">JUMLAH KATALOG MOTOR</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }} <span class="text-sm font-medium text-slate-500">Unit Induk</span></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart Section (Spans 2 columns) -->
    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 lg:col-span-2">
        <h2 class="text-lg font-bold text-slate-800 border-b pb-3 mb-4">Tren Pembuatan Pesanan {{ $filter == 'year' ? '(Per Bulan)' : '(Berdasarkan Hari)' }}</h2>
        <div class="relative h-[250px] w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 lg:col-span-1">
        <h2 class="text-lg font-bold text-slate-800 border-b pb-3 mb-4">5 Motor Paling Laris</h2>
        <div class="space-y-4">
           @forelse($topProducts as $item)
<div class="flex items-center justify-between border-b border-slate-50 pb-2">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded bg-slate-100 flex items-center justify-center flex-shrink-0">
            @if(optional($item->product)->default_gambar)
                <img src="{{ asset('storage/' . $item->product->default_gambar) }}" 
                     class="w-full h-full object-cover rounded">
            @else
                <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"></path>
                </svg>
            @endif
        </div>

        <div>
            <h4 class="font-bold text-sm text-slate-800">
                {{ optional($item->product)->nama_produk ?? 'Produk Dihapus' }}
            </h4>
            <p class="text-xs text-slate-500">
                Sisa Stok: {{ optional($item->product)->total_stok ?? 0 }}
            </p>
        </div>
    </div>

    <div class="text-right">
        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-black px-2 py-1 rounded">
            {{ $item->total_sales ?? 0 }}x
        </span>
    </div>
</div>
@empty
<div class="text-center text-sm py-4 text-slate-500 italic">
    Belum ada data penjualan.
</div>
@endforelse
        </div>
    </div>
</div>



<style>
/* Cetak styling khusus Print */
@media print {
    body { background-color: white !important; }
    nav, footer { display: none !important; }
    main { padding: 0 !important; }
    .shadow-lg, .shadow-md, .shadow { box-shadow: none !important; }
    .border-slate-200 { border-color: #e2e8f0 !important; }
    canvas { max-height: 200px !important; }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartData = @json($chartData ?? []);
    const canvas = document.getElementById('salesChart');

    if (canvas && chartData.length > 0) {
        const labels = chartData.map(item => item.date);
        const dataCount = chartData.map(item => item.count);

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Pesanan Dibuat',
                    data: dataCount,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

    } else if (canvas) {
        canvas.parentElement.innerHTML =
            '<div class="flex items-center justify-center h-full text-slate-400 italic">Data grafik kosong</div>';
    }
</script>
@endsection
