<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Petugas - Admin</title>
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
        .btn-edit{background:#2563eb;color:#fff;padding:8px 12px;border:none;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer}
        .btn-edit:hover{background:#1d4ed8}
        .btn-delete{background:#ef4444;color:#fff;padding:8px 12px;border:none;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer}
        .btn-delete:hover{background:#dc2626}
        .action-cell{display:flex;gap:8px;align-items:center;}
        .alert-success{background:#d1fae5;color:#065f46;padding:14px 16px;border-radius:10px;margin-bottom:20px}
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
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <h2>Kelola Petugas</h2>
            <div>Admin | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
        </div>

        <div class="cards">
            <div class="card"><h4>Total Produk</h4><p>{{ $totalProduk }}</p></div>
            <div class="card"><h4>Total Pesanan</h4><p>{{ $totalPesanan }}</p></div>
            <div class="card"><h4>Pendapatan</h4><p>Rp {{ number_format($pendapatan,0,',','.') }}</p></div>
            <div class="card"><h4>User Aktif</h4><p>{{ $totalUser }}</p></div>
        </div>

        <div class="table-box">
            <h4>Daftar Petugas</h4>
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($petugas as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->phone ?? '-' }}</td>
                        <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($p->status == 'active')
                                <span style="color: green; font-weight: bold;">Aktif</span>
                            @else
                                <span style="color: red; font-weight: bold;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
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