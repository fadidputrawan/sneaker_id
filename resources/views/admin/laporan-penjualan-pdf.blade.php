<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 18px;
            color: #555;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f0f0f0;
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 12px;
        }
        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 11px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SNEAKER ID</h1>
            <h2>Laporan Penjualan Bulanan</h2>
            <p>Data Penjualan 12 Bulan Terakhir</p>
        </div>

        <div class="info">
            <p><strong>Tanggal Laporan:</strong> {{ now()->format('d F Y H:i:s') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th class="text-right">Total Pesanan</th>
                    <th class="text-right">Total Revenue (Rp)</th>
                    <th class="text-right">Pesanan Selesai</th>
                    <th class="text-right">Pesanan Dibatalkan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salesReports as $report)
                <tr>
                    <td>{{ $report['periode'] }}</td>
                    <td class="text-right">{{ $report['total_pesanan'] }}</td>
                    <td class="text-right"><strong>{{ number_format($report['total_revenue'], 0, ',', '.') }}</strong></td>
                    <td class="text-right">{{ $report['pesanan_selesai'] }}</td>
                    <td class="text-right">{{ $report['pesanan_dibatalkan'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Belum ada data laporan penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Laporan ini digenerate secara otomatis dari sistem SNEAKER ID</p>
            <p>© {{ now()->year }} SNEAKER ID. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
