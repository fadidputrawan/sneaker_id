<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Terbaru</title>
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
        .header p {
            color: #666;
            font-size: 14px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 14px;
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
            font-size: 13px;
        }
        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }
        .status.selesai {
            background-color: #d4edda;
            color: #155724;
        }
        .status.dikirim {
            background-color: #fff3cd;
            color: #856404;
        }
        .status.diproses {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status.dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SNEAKER ID</h1>
            <h2>Laporan Transaksi Terbaru</h2>
            <p>Dokumen ini berisi informasi transaksi terbaru dari sistem</p>
        </div>

        <div class="info">
            <p><strong>Tanggal Laporan:</strong> {{ now()->format('d F Y H:i:s') }}</p>
            <p><strong>Total Transaksi:</strong> {{ count($transaksiTerbaru) }} pesanan</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Customer</th>
                    <th>Total (Rp)</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $order)
                <tr>
                    <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->user?->name ?? $order->nama }}</td>
                    <td style="text-align: right;">{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="status {{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada data transaksi</td>
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
