<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background:#4f4f4f;
            min-height:100vh;
        }

        .container{
            width:100%;
            min-height:100vh;
            display:flex;
            background:#e5e5e5;
        }

        /* ================= SIDEBAR ================= */

        .sidebar{
            width:240px;
            background:#d0d0d0;
            padding:25px 20px;
            border-right:2px solid #999;
        }

        .logo{
            font-size:18px;
            font-weight:bold;
            margin-bottom:35px;
        }

        .menu a{
            display:block;
            padding:12px 10px;
            text-decoration:none;
            color:#000;
            margin-bottom:8px;
            border-radius:6px;
            transition:0.2s;
        }

        .menu a:hover{
            background:#bcbcbc;
        }

        .menu a.active{
            background:#a8a8a8;
            font-weight:bold;
            border-left:5px solid #000;
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

        .logout{
            color:red;
            text-decoration:none;
            font-size:14px;
            margin-left:10px;
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

        tr:hover{
            background:#f9f9f9;
        }

    </style>
</head>
<body>

<div class="container">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <div class="logo">👟 SNEAKER ID</div>

        <div class="menu">
            <a href="{{ route('petugas.dashboard') }}"
               class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
               Dashboard
            </a>

            <a href="#"
               class="{{ request()->is('petugas/pesanan*') ? 'active' : '' }}">
               Kelola Pesanan
            </a>

            <a href="#"
               class="{{ request()->is('petugas/laporan*') ? 'active' : '' }}">
               Laporan
            </a>
        </div>
    </div>

    <!-- ================= MAIN ================= -->
    <div class="main">

        <div class="topbar">
            <h2>Dashboard</h2>
            <div>
                Petugas |
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
                <h4>Total Pesanan</h4>
                <p>{{ $totalPesanan }}</p>
            </div>

            <div class="card">
                <h4>Pesanan Diproses</h4>
                <p>{{ $diproses }}</p>
            </div>

            <div class="card">
                <h4>Pesanan Dikirim</h4>
                <p>{{ $dikirim }}</p>
            </div>

            <div class="card">
                <h4>Pesanan Selesai</h4>
                <p>{{ $selesai }}</p>
            </div>
        </div>

        <!-- TABEL -->
        <div class="table-box">
            <h4>Daftar Pesanan Terbaru</h4>

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
                    <tr>
                        <td>#001</td>
                        <td>Aku</td>
                        <td>1.200.000</td>
                        <td>02/02/2026</td>
                        <td>Diproses</td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Ryan</td>
                        <td>2.200.000</td>
                        <td>20/01/2026</td>
                        <td>Dikirim</td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>Sarul</td>
                        <td>1.500.000</td>
                        <td>31/01/2026</td>
                        <td>Selesai</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

</body>
</html>