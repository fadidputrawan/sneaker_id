<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Kelola Pesanan - Admin</title>
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
		.cards{display:flex;gap:20px;margin-bottom:30px}
		.card{flex:1;background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1);text-align:center}
		.card h4{font-size:14px;margin-bottom:8px;color:#555}
		.card p{font-size:20px;font-weight:bold}
		.table-box{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1)}
		table{width:100%;border-collapse:collapse}
		th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;font-size:14px}
		th{background:#f1f1f1}
		.inline-form{display:inline-block;margin-left:6px}
		.btn-detail, .btn-action{display:inline-flex;align-items:center;justify-content:center;padding:8px 12px;border:none;border-radius:8px;font-size:13px;cursor:pointer;text-decoration:none;transition:0.2s}
		.btn-detail{background:#2563eb;color:#fff;margin-right:6px}
		.btn-detail:hover{background:#1d4ed8}
		.btn-action{color:#fff}
		.btn-primary{background:#2563eb}
		.btn-primary:hover{background:#1d4ed8}
		.btn-success{background:#16a34a}
		.btn-success:hover{background:#15803d}
		.btn-danger{background:#dc2626}
		.btn-danger:hover{background:#b91c1c}
		.status-label{display:inline-flex;padding:6px 10px;border-radius:8px;background:#eef2ff;color:#1e3a8a;font-weight:600}
		.alert{margin-bottom:18px;padding:14px 16px;border-radius:10px}
		.alert.success{background:#d1fae5;color:#065f46}
		.alert.error{background:#fee2e2;color:#991b1b}
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
			<a href="{{ route('admin.laporan-penjualan-bulanan') }}" class="{{ request()->routeIs('admin.laporan-penjualan-bulanan') ? 'active' : '' }}">Laporan Penjualan</a>
		</div>
	</div>

	<div class="main">
		<div class="topbar">
			<h2>Kelola Pesanan</h2>
			<div>Admin | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
		</div>

		<div class="cards">
			<div class="card"><h4>Total Produk</h4><p>{{ $totalProduk }}</p></div>
			<div class="card"><h4>Total Pesanan</h4><p>{{ $totalPesanan }}</p></div>
			<div class="card"><h4>Pendapatan</h4><p>Rp {{ number_format($pendapatan,0,',','.') }}</p></div>
			<div class="card"><h4>User Aktif</h4><p>{{ $totalUser }}</p></div>
		</div>

		<div class="table-box">
			<h4>Daftar Pesanan</h4>
			<table>
				<thead>
					<tr><th>ID</th><th>Nama</th><th>Total</th><th>Metode</th><th>Status</th><th>Aksi</th></tr>
				</thead>
				<tbody>
				@foreach($orders as $o)
					<tr>
						<td><a href="{{ route('admin.order.show', $o->id) }}" style="text-decoration:none;color:#fff;">{{ $o->id }}</a></td>
						<td>{{ $o->user?->name ?? $o->nama }}</td>
						<td>Rp {{ number_format($o->total,0,',','.') }}</td>
						<td>{{ strtoupper($o->payment_method ?? 'N/A') }}</td>
						<td>
						{{ ucfirst($o->status) }}
						@if($o->cancelled_by === 'user')
							<span style="display:inline-block;margin-left:8px;padding:4px 8px;background:#fee2e2;color:#991b1b;border-radius:4px;font-size:12px;font-weight:600;">Dibatalkan oleh User</span>
						@elseif($o->cancelled_by === 'admin')
							<span style="display:inline-block;margin-left:8px;padding:4px 8px;background:#fef3c7;color:#92400e;border-radius:4px;font-size:12px;font-weight:600;">Dibatalkan oleh Admin</span>
						@endif
					</td>
						<td>
							<a href="{{ route('admin.order.show', $o->id) }}" class="btn-detail">Detail</a>
							@if($o->status === 'diproses')
								<form action="{{ route('admin.order.status', $o->id) }}" method="POST" class="inline-form">
									@csrf
									<input type="hidden" name="action" value="process">
									<button type="submit" class="btn-action btn-primary">Kirim</button>
								</form>
								<form action="{{ route('admin.order.status', $o->id) }}" method="POST" class="inline-form">
									@csrf
									<input type="hidden" name="action" value="cancel">
									<button type="submit" class="btn-action btn-danger">Batalkan</button>
								</form>
							@elseif($o->status === 'dikirim')
								<form action="{{ route('admin.order.status', $o->id) }}" method="POST" class="inline-form">
									@csrf
									<input type="hidden" name="action" value="complete">
									<button type="submit" class="btn-action btn-success">Selesai</button>
								</form>
							@else
								<span class="status-label">{{ ucfirst($o->status) }}</span>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>