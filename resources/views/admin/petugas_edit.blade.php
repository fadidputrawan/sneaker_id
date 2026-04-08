<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Petugas - Admin</title>
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
        .topbar h2{font-size:22px}
        .logout{color:red;text-decoration:none;font-size:14px}
        .card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1)}
        .form-group{margin-bottom:16px}
        label{display:block;margin-bottom:8px;font-weight:700;color:#374151}
        input{width:100%;padding:12px 14px;border:1px solid #d1d5db;border-radius:10px;background:#f8fafc;color:#111827}
        input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,0.15)}
        .button-group{display:flex;gap:12px;flex-wrap:wrap;margin-top:20px}
        .btn-primary{background:#2563eb;color:#fff;padding:12px 18px;border:none;border-radius:10px;cursor:pointer}
        .btn-primary:hover{background:#1d4ed8}
        .btn-secondary{background:#e5e7eb;color:#111827;padding:12px 18px;border:none;border-radius:10px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
        .alert-success{background:#d1fae5;color:#065f46;padding:14px 16px;border-radius:10px;margin-bottom:20px}
        .alert-error{background:#fee2e2;color:#991b1b;padding:14px 16px;border-radius:10px;margin-bottom:20px}
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
            <h2>Edit Petugas</h2>
            <div>Admin | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $petugas->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $petugas->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $petugas->phone) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Daftar</label>
                    <input type="text" value="{{ $petugas->created_at ? $petugas->created_at->format('d/m/Y') : '-' }}" disabled>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" value="{{ ucfirst($petugas->status) }}" disabled>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" value="{{ ucfirst($petugas->role) }}" disabled>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.petugas.index') }}" class="btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>
