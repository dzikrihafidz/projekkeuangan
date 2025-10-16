@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold flex items-center gap-2">
            📊 Data Transaksi
        </h2>
        <a href="{{ route('laporan.cetak') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition-all">
            🧾 Cetak Laporan Bulanan
        </a>
    </div>

    <!-- Table Transaksi -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 font-semibold">Tanggal</th>
                    <th class="px-6 py-3 font-semibold">Kategori</th>
                    <th class="px-6 py-3 font-semibold">Jenis</th>
                    <th class="px-6 py-3 font-semibold">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($transaksis as $t)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $t->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $t->jenis === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($t->jenis) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Grafik Alokasi -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
        <h3 class="text-lg font-semibold mb-4">📈 Alokasi Pengeluaran per Kategori</h3>
        <canvas id="chartAlokasi" height="120"></canvas>
    </div>

    <!-- Saldo -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 text-right">
        <p class="text-lg font-semibold">Saldo Saat Ini:</p>
        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartAlokasi');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            data: {!! json_encode($totals) !!},
            backgroundColor: ['#60A5FA','#F87171','#34D399','#FBBF24','#A78BFA','#F472B6'],
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Persentase Alokasi Keuangan Bulan Ini'
            }
        }
    }
});
</script>
@endsection
