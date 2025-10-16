<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Bulanan - {{ $bulan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .summary {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .chart {
            text-align: center;
            margin-top: 20px;
        }
        img {
            width: 60%;
        }
    </style>
</head>
<body>
    <h1>Laporan Keuangan Bulanan</h1>
    <h2>{{ $bulan }}</h2>

    <div class="summary">
        <p><strong>Total Saldo Akhir:</strong> Rp {{ number_format($saldo, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $t->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ ucfirst($t->jenis) }}</td>
                <td>{{ $t->deskripsi ?? '-' }}</td>
                <td>{{ number_format($t->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="chart">
        <h3>Grafik Pengeluaran per Kategori</h3>
        @php
            $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
                'type' => 'pie',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [[
                        'data' => $totals,
                        'backgroundColor' => ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2'],
                    ]]
                ],
                'options' => ['plugins' => ['legend' => ['position' => 'bottom']]]
            ]));
        @endphp
        <img src="{{ $chartUrl }}" alt="Grafik Pengeluaran">
    </div>
</body>
</html>
