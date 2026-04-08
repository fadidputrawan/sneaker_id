<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan - Admin</title>
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
        .card{background:#fff;padding:24px;border-radius:14px;box-shadow:0 10px 30px rgba(15,23,42,0.08);margin-bottom:20px}
        .section{margin-bottom:22px}
        .section h3{margin-bottom:16px;font-size:20px;color:#111827}
        .detail-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}
        .detail-item{background:#f8fafc;padding:18px;border-radius:12px;border:1px solid #e5e7eb}
        .label{font-size:13px;color:#6b7280}
        .value{font-size:16px;font-weight:700;color:#111827;margin-top:8px}
        .table{width:100%;border-collapse:collapse}
        .table th,.table td{padding:12px 14px;border-bottom:1px solid #e5e7eb;text-align:left}
        .table th{background:#f8fafc;color:#111827;font-weight:700}
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}
        .btn-action{padding:10px 18px;border:none;border-radius:10px;color:#fff;cursor:pointer;transition:0.2s}
        .btn-primary{background:#2563eb}
        .btn-primary:hover{background:#1d4ed8}
        .btn-success{background:#16a34a}
        .btn-success:hover{background:#15803d}
        .btn-danger{background:#dc2626}
        .btn-danger:hover{background:#b91c1c}
        .status-label{display:inline-flex;padding:10px 16px;border-radius:10px;background:#eef2ff;color:#1e3a8a;font-weight:600}
        .alert{margin-bottom:20px;padding:14px 16px;border-radius:10px}
        .alert.success{background:#d1fae5;color:#065f46}
        .alert.error{background:#fee2e2;color:#991b1b}
        .back-link{display:inline-block;margin-bottom:20px;color:#2563eb;text-decoration:none;font-weight:600}
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
            <h2>Detail Pesanan</h2>
            <div>Admin | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <a class="back-link" href="{{ route('admin.pesanan.index') }}">← Kembali ke Daftar Pesanan</a>

        <div class="card section">
            <h3>Informasi Pesanan</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="label">Nomor Pesanan</div>
                    <div class="value">{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Nama Pelanggan</div>
                    <div class="value">{{ $order->user?->name ?? $order->nama }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Email / Kontak</div>
                    <div class="value">{{ $order->user?->email ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Metode Pembayaran</div>
                    <div class="value">{{ strtoupper($order->payment_method ?? 'N/A') }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Status Pesanan</div>
                    <div class="value">{{ ucfirst($order->status) }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Tanggal</div>
                    <div class="value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="card section">
            <h3>Bukti Pembayaran</h3>
            @php
                $proofUrl = null;
                if ($order->payment_proof) {
                    if (Storage::disk('public')->exists($order->payment_proof)) {
                        $proofUrl = asset('storage/' . $order->payment_proof);
                    } elseif (str_starts_with($order->payment_proof, 'images/')) {
                        $proofUrl = asset($order->payment_proof);
                    }
                }
            @endphp
            @if($proofUrl)
                <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap">
                    <div style="width:320px;max-width:100%;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 3px 10px rgba(15,23,42,0.06);">
                        <img src="{{ $proofUrl }}" alt="Bukti Pembayaran" style="width:100%;height:auto;display:block;object-fit:cover;">
                    </div>
                    <div style="flex:1;min-width:220px;">
                        <p style="margin:0 0 8px;color:#6b7280;font-size:14px;">Foto bukti pembayaran yang dikirim oleh user.</p>
                        <p style="margin:0;font-weight:600;color:#111827;">Status saat ini: {{ ucfirst($order->status) }}</p>
                    </div>
                </div>
            @elseif($order->payment_proof)
                <p style="margin:0;color:#b91c1c;">Bukti pembayaran ditemukan, tetapi file tidak tersedia di lokasi yang diharapkan.</p>
            @else
                <p style="margin:0;color:#6b7280;">Belum ada bukti pembayaran yang diunggah oleh user.</p>
            @endif
        </div>

        <div class="card section">
            <h3>Detail Item</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items ?? [] as $item)
                        <tr>
                            <td>{{ $item['name'] ?? '-' }}</td>
                            <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] ?? 0 }}</td>
                            <td>Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;font-weight:700">Total</td>
                        <td style="font-weight:700">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card section">
            <h3>Aksi Admin</h3>
            <div class="actions">
                @if($order->status === 'diproses')
                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="process">
                        <button type="submit" class="btn-action btn-primary">Kirim Pesanan</button>
                    </form>
                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="cancel">
                        <button type="submit" class="btn-action btn-danger">Batalkan Pesanan</button>
                    </form>
                @elseif($order->status === 'dikirim')
                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="complete">
                        <button type="submit" class="btn-action btn-success">Tandai Selesai</button>
                    </form>
                @elseif($order->status === 'selesai')
                    <span class="status-label">Pesanan Selesai</span>
                @elseif($order->status === 'dibatalkan')
                    <span class="status-label">Pesanan Dibatalkan</span>
                @else
                    <span class="status-label">Tidak ada aksi tersedia</span>
                @endif
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</body>
</html>
