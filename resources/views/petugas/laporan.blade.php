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
			<div class="card"><h4>Total Pesanan</h4><p>0</p></div>
			<div class="card"><h4>Total Revenue</h4><p>Rp 0</p></div>
			<div class="card"><h4>Pesanan Selesai</h4><p>0</p></div>
			<div class="card"><h4>Pesanan Dibatalkan</h4><p>0</p></div>
		</div>

		<div class="table-box">
			<h4>Ringkasan Laporan</h4>
			<p style="color:#666;margin-bottom:15px;">Fitur laporan akan segera tersedia. Untuk saat ini, Anda dapat melihat detail pesanan di halaman Kelola Pesanan.</p>
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
						<td colspan="5" style="text-align:center;color:#999;">Belum ada data laporan</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>
