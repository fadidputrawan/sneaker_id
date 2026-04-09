<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Laporan Penjualan Bulanan - Admin</title>
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
		.btn-download{display:inline-flex;align-items:center;gap:8px;background:#2563eb;color:white;padding:10px 16px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:600;transition:0.3s;border:none;cursor:pointer}
		.btn-download:hover{background:#1d4ed8;transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.15)}
		.stats{display:flex;gap:20px;margin-bottom:30px}
		.stat-card{flex:1;background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1);text-align:center}
		.stat-card h4{font-size:14px;margin-bottom:8px;color:#555}
		.stat-card p{font-size:20px;font-weight:bold}
		.table-box{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1);margin-bottom:30px}
		table{width:100%;border-collapse:collapse}
		th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;font-size:14px}
		th{background:#f1f1f1;font-weight:bold}
		tr:hover{background:#f9f9f9}
		.text-right{text-align:right}
	</style>
</head>
<body>
<div class="container">
	<div class="sidebar">
		<div class="logo">SNEAKER ID</div>
		<div class="menu">
			<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
			<a href="{{ route('admin.produk.index') }}" class="{{ request()->is('admin/produk*') ? 'active' : '' }}">Kelola Produk</a>
			<a href="{{ route('admin.pesanan.index') }}" class="{{ request()->is('admin/pesanan*') ? 'active' : '' }}">Kelola Pesanan</a>
			<a href="{{ route('admin.user.index') }}" class="{{ request()->is('admin/user*') ? 'active' : '' }}">Kelola User</a>
			<a href="{{ route('admin.petugas.index') }}" class="{{ request()->is('admin/petugas*') ? 'active' : '' }}">Kelola Petugas</a>
			<a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">Laporan</a>
			<a href="{{ route('admin.laporan-penjualan-bulanan') }}" class="{{ request()->routeIs('admin.laporan-penjualan-bulanan') ? 'active' : '' }}">Laporan Penjualan</a>
		</div>
	</div>

	<div class="main">
		<div class="topbar">
			<h2>Laporan Penjualan Bulanan</h2>
			<div>
				<a href="{{ route('admin.download-laporan-penjualan-pdf') }}" class="btn-download">
					<i class="bi bi-download"></i> Download PDF
				</a>
				<a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
			</div>
		</div>

		<div class="table-box">
			<h3 style="margin-bottom:20px;">Penjualan 12 Bulan Terakhir</h3>
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
						<td colspan="5" style="text-align:center;color:#999;">Belum ada data laporan penjualan</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div style="text-align:right; margin-top:20px; color:#666; font-size:12px;">
			<p>Laporan ini dibuat pada: {{ now()->format('d F Y H:i:s') }}</p>
		</div>
	</div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>
