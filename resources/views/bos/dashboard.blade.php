@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800">Overview Dashboard</h1>
    <p class="text-slate-500 mt-2">Ringkasan performa Dealer Showroom secara menyeluruh.</p>
</div>

<!-- Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow border md:col-span-1 border-slate-100 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Produk</h3>
        <p class="text-3xl font-bold text-slate-800">{{ $totalProducts }} <span class="text-lg text-slate-400 font-medium">Unit</span></p>
    </div>
    <div class="bg-white rounded-xl shadow border md:col-span-1 border-slate-100 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Semua Pesanan</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }} <span class="text-lg text-blue-400 font-medium">Trx</span></p>
    </div>
    <div class="bg-white rounded-xl shadow border md:col-span-1 border-slate-100 p-6 flex flex-col justify-center">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Menunggu Keputusan</h3>
        <p class="text-3xl font-bold text-amber-500">{{ $pendingOrders }} <span class="text-lg text-amber-300 font-medium">Pending</span></p>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg p-6 flex flex-col justify-center text-white">
        <h3 class="text-green-100 text-sm font-semibold uppercase tracking-wider mb-1">Total Pendapatan Bersih</h3>
        <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-xl shadow-lg border border-slate-100 p-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Tren Penjualan 7 Hari Terakhir</h2>
    <div class="relative h-[300px] w-full">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<script>
    const chartData = @json($chartData);
    
    const labels = chartData.map(item => item.date);
    const dataCount = chartData.map(item => item.count);

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pesanan Masuk',
                data: dataCount,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection
