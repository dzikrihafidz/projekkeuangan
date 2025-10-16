@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">📊 Dashboard Keuangan</h2>
    </div>

    <!-- Ringkasan Saldo -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-xl shadow text-center">
            <h3 class="text-gray-800 dark:text-gray-100 text-lg font-semibold">💰 Total Saldo</h3>
            <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-xl shadow text-center">
            <h3 class="text-gray-800 dark:text-gray-100 text-lg font-semibold">📈 Pemasukan</h3>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">
                Rp {{ number_format(\App\Models\Transaksi::where('jenis', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-red-100 dark:bg-red-900 p-4 rounded-xl shadow text-center">
            <h3 class="text-gray-800 dark:text-gray-100 text-lg font-semibold">📉 Pengeluaran</h3>
            <p class="text-2xl font-bold text-red-700 dark:text-red-300">
                Rp {{ number_format(\App\Models\Transaksi::where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Grafik Alokasi Pengeluaran -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">📈 Alokasi Pengeluaran per Kategori</h3>
        <div class="flex justify-center">
            <canvas id="chartKategori" class="w-full max-w-md"></canvas>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="flex justify-end">
        <button id="downloadChart"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
            🖨️ Cetak Grafik
        </button>
    </div>
</div>

<div class="flex justify-end mt-4">
    <a href="{{ route('laporan.cetak') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all">
       🧾 Cetak Laporan Bulanan (PDF)
    </a>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartKategori').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                data: {!! json_encode($totals) !!},
                backgroundColor: [
                    '#22c55e', '#3b82f6', '#f97316', '#eab308', '#ef4444', '#8b5cf6'
                ],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: document.documentElement.classList.contains('dark') ? '#fff' : '#000' }
                }
            }
        }
    });

    // Tombol cetak jadi gambar PNG
    document.getElementById('downloadChart').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'grafik_pengeluaran.png';
        link.href = chart.toBase64Image();
        link.click();
    });
</script>
@endsection
