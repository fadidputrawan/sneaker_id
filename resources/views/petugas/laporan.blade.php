<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Laporan - Petugas</title>
	<style>
		*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
		body{background:#f4f6f9;color:#333;min-height:100vh}
		.container{width:100%;min-height:100vh;display:flex;background:transparent}
		.sidebar{width:240px;background:#f8f9fa;padding:30px 20px;border-right:1px solid #dde2e6}
		.logo{font-size:18px;font-weight:bold;margin-bottom:35px;color:#1f2937}
		.menu a{display:block;padding:12px 14px;text-decoration:none;color:#1f2937;margin-bottom:8px;border-radius:8px;transition:0.2s}
		.menu a:hover{background:#e2e8f0}
		.menu a.active{background:#dbeafe;font-weight:700;border-left:4px solid #2563eb;color:#111827}
		.main{flex:1;padding:30px}
		.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
		.logout{color:#2563eb;text-decoration:none;font-size:14px;margin-left:10px}
		.cards{display:flex;gap:20px;margin-bottom:30px}
		.card{flex:1;background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1);text-align:center}
		.card h4{font-size:14px;margin-bottom:8px;color:#555}
		.card p{font-size:20px;font-weight:bold}
		.table-box{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1)}
		table{width:100%;border-collapse:collapse}
		th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;font-size:14px}
		th{background:#f1f1f1}
		tr:hover{background:#f9f9f9}
	</style>
</head>
<body>
<div class="container">
	<div class="sidebar">
		<div class="logo">SNEAKER ID</div>
		<div class="menu">
			<a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a>
			<a href="{{ route('petugas.produk.index') }}" class="{{ request()->is('petugas/produk*') ? 'active' : '' }}">Kelola Produk</a>
			<a href="{{ route('petugas.pesanan.index') }}" class="{{ request()->is('petugas/pesanan*') ? 'active' : '' }}">Kelola Pesanan</a>
			<a href="{{ route('petugas.laporan') }}" class="{{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">Laporan</a>
		</div>
	</div>

	<div class="main">
		<div class="topbar">
			<h2>Laporan</h2>
			<div>Petugas | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
		</div>

		<div class="cards">
			<div class="card"><h4>Total Pesanan</h4><p>{{ $totalPesanan }}</p></div>
			<div class="card"><h4>Total Revenue</h4><p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p></div>
			<div class="card"><h4>Pesanan Selesai</h4><p>{{ $pesananSelesai }}</p></div>
			<div class="card"><h4>Pesanan Dibatalkan</h4><p>{{ $pesananDibatalkan }}</p></div>
		</div>

		<div class="table-box">
			<h4>Ringkasan Laporan Bulanan</h4>
			<table>
				<thead>
					<tr>
						<th>Periode</th>
						<th>Total Pesanan</th>
						<th>Total Revenue</th>
						<th>Pesanan Selesai</th>
						<th>Pesanan Dibatalkan</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $bulanIni['periode'] }}</td>
						<td>{{ $bulanIni['total_pesanan'] }}</td>
						<td>Rp {{ number_format($bulanIni['total_revenue'], 0, ',', '.') }}</td>
						<td>{{ $bulanIni['pesanan_selesai'] }}</td>
						<td>{{ $bulanIni['pesanan_dibatalkan'] }}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-box" style="margin-top: 30px;">
			<h4>Laporan Harian (7 Hari Terakhir)</h4>
			<table>
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Total Pesanan</th>
						<th>Total Revenue</th>
						<th>Pesanan Selesai</th>
						<th>Pesanan Dibatalkan</th>
					</tr>
				</thead>
				<tbody>
					@forelse($dailyReports as $report)
					<tr>
						<td>{{ $report['periode'] }}</td>
						<td>{{ $report['total_pesanan'] }}</td>
						<td>Rp {{ number_format($report['total_revenue'], 0, ',', '.') }}</td>
						<td>{{ $report['pesanan_selesai'] }}</td>
						<td>{{ $report['pesanan_dibatalkan'] }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="5" style="text-align:center;color:#999;">Belum ada data laporan harian</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div class="table-box" style="margin-top: 30px;">
			<h4>Top Customers (Berdasarkan Revenue)</h4>
			<table>
				<thead>
					<tr>
						<th>Nama Customer</th>
						<th>Total Pesanan</th>
						<th>Total Nilai Pesanan</th>
						<th>Total Revenue</th>
					</tr>
				</thead>
				<tbody>
					@forelse($topCustomers as $customer)
					<tr>
						<td>{{ $customer->nama }}</td>
						<td>{{ $customer->total_pesanan }}</td>
						<td>Rp {{ number_format($customer->total_nilai_pesanan, 0, ',', '.') }}</td>
						<td>Rp {{ number_format($customer->total_revenue, 0, ',', '.') }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="4" style="text-align:center;color:#999;">Belum ada data customer</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div class="table-box" style="margin-top: 30px;">
			<h4>Detail Pesanan Terbaru per Customer</h4>
			@forelse($recentOrdersByUser as $userId => $orders)
				<h5 style="margin-top: 20px; margin-bottom: 10px; color: #333;">{{ $orders->first()->nama }} ({{ $orders->count() }} pesanan)</h5>
				<table style="margin-bottom: 20px;">
					<thead>
						<tr>
							<th>ID Pesanan</th>
							<th>Tanggal</th>
							<th>Total</th>
							<th>Status</th>
							<th>Metode Pembayaran</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
						<tr>
							<td>#{{ $order->id }}</td>
							<td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
							<td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
							<td>
								<span style="padding: 4px 8px; border-radius: 4px; font-size: 12px;
									@if($order->status == 'selesai') background: #d4edda; color: #155724;
									@elseif($order->status == 'dibatalkan') background: #f8d7da; color: #721c24;
									@elseif($order->status == 'dikirim') background: #fff3cd; color: #856404;
									@else background: #e2e3e5; color: #383d41; @endif">
									{{ ucfirst($order->status) }}
								</span>
							</td>
							<td>{{ ucfirst($order->payment_method) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@empty
				<p style="text-align:center;color:#999;margin:20px 0;">Belum ada data pesanan</p>
			@endforelse
		</div>
	</div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>
