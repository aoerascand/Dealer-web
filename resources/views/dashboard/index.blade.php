<canvas id="revenueChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script>
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'line', // Grafik garis untuk tren pendapatan
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($data) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });
</script> -->