<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f6f9;
            color:#333;
            min-height:100vh;
        }

        .container{
            width:100%;
            min-height:100vh;
            display:flex;
            background:transparent;
        }

        /* ================= SIDEBAR ================= */

        .sidebar{
            width:240px;
            background:#f8f9fa;
            padding:30px 20px;
            border-right:1px solid #dde2e6;
        }

        .logo{
            font-size:18px;
            font-weight:bold;
            margin-bottom:35px;
            color:#1f2937;
        }

        .menu a{
            display:block;
            padding:12px 14px;
            text-decoration:none;
            color:#1f2937;
            margin-bottom:8px;
            border-radius:8px;
            transition:0.2s;
        }

        .menu a:hover{
            background:#e2e8f0;
        }

        .menu a.active{
            background:#dbeafe;
            font-weight:700;
            border-left:4px solid #2563eb;
            color:#111827;
        }

        /* ================= MAIN ================= */

        .main{
            flex:1;
            padding:30px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .topbar h2{
            font-size:22px;
        }

        .logout{
            color:red;
            text-decoration:none;
            font-size:14px;
        }

        /* ================= CARDS ================= */

        .cards{
            display:flex;
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            flex:1;
            background:#fff;
            padding:20px;
            border-radius:10px;
            box-shadow:0 3px 8px rgba(0,0,0,0.1);
            text-align:center;
        }

        .card h4{
            font-size:14px;
            margin-bottom:8px;
            color:#555;
        }

        .card p{
            font-size:20px;
            font-weight:bold;
        }

        /* ================= TABLE ================= */

        .table-box{
            background:#fff;
            padding:20px;
            border-radius:10px;
            box-shadow:0 3px 8px rgba(0,0,0,0.1);
        }

        .table-box h4{
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th, td{
            padding:10px;
            text-align:center;
            border-bottom:1px solid #ddd;
            font-size:14px;
        }

        th{
            background:#f1f1f1;
        }

        .order-id-link {
            color:#333;
            text-decoration:none;
        }

        tr:hover{
            background:#f9f9f9;
        }

    </style>
</head>
<body>

<div class="container">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <div class="logo">SNEAKER ID</div>

        <div class="menu">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
               Dashboard
            </a>

                <a href="{{ route('admin.produk.index') }}"
                    class="{{ request()->is('admin/produk*') ? 'active' : '' }}">
                    Kelola Produk
                </a>

                <a href="{{ route('admin.pesanan.index') }}"
                    class="{{ request()->is('admin/pesanan*') ? 'active' : '' }}">
                    Kelola Pesanan
                </a>

                <a href="{{ route('admin.user.index') }}"
                    class="{{ request()->is('admin/user*') ? 'active' : '' }}">
                    Kelola User
                </a>

                <a href="{{ route('admin.petugas.index') }}"
                    class="{{ request()->is('admin/petugas*') ? 'active' : '' }}">
                    Kelola Petugas
                </a>
        </div>
    </div>

    <!-- ================= MAIN ================= -->
    <div class="main">

        <div class="topbar">
            <h2>Dashboard</h2>
            <div>
                Admin |
                <a class="logout"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Logout
                </a>
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="cards">
            <div class="card">
                <h4>Total Produk</h4>
                <p>{{ $totalProduk }}</p>
            </div>

            <div class="card">
                <h4>Total Pesanan</h4>
                <p>{{ $totalPesanan }}</p>
            </div>

            <div class="card">
                <h4>Pendapatan</h4>
                <p>Rp {{ number_format($pendapatan,0,',','.') }}</p>
            </div>

            <div class="card">
                <h4>User Aktif</h4>
                <p>{{ $totalUser }}</p>
            </div>
        </div>

        <!-- TABEL -->
        @if($transaksiTerbaru->isNotEmpty())
        <div class="table-box">
            <h4>Transaksi Terbaru</h4>

            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiTerbaru as $order)
                        <tr>
                            <td><a href="{{ route('admin.order.show', $order->id) }}" class="order-id-link">{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</a></td>
                            <td>{{ $order->user?->name ?? $order->nama }}</td>
                            <td>{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

</body>
</html>