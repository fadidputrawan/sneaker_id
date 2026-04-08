<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Sneaker ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background-color:#f8f9fa; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1); border-bottom:3px solid #000; }
        .navbar-brand { font-weight:700; font-size:24px; color:#000 !important; }
        .profile-wrapper { display:flex; flex-wrap:nowrap; align-items:flex-start; min-height:calc(100vh - 80px); }
        .sidebar { background:linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding:30px 0; width:260px; flex:0 0 260px; max-width:260px; min-width:260px; min-height:calc(100vh - 80px); position:sticky; top:80px; flex-shrink:0; }
        .sidebar h5 { color:#fff; padding:0 20px 20px 20px; font-weight:700; margin-bottom:0; }
        .sidebar-menu { list-style:none; margin-top:20px; padding-left:0; }
        .sidebar-menu li { margin:0; list-style:none; }
        .sidebar-menu a { display:flex; align-items:center; padding:15px 20px; color:rgba(255,255,255,0.9) !important; text-decoration:none !important; transition:all 0.3s ease; border-left:4px solid transparent; font-size:15px; }
        .sidebar-menu a:hover, .sidebar-menu a.active, .sidebar-menu a:focus, .sidebar-menu a:visited { background-color:#6c757d; color:#fff !important; font-weight:600; border-left-color:#6c757d; text-decoration:none !important; }
        .sidebar-menu a:focus-visible { outline:none; }
        .sidebar-menu i { margin-right:15px; width:20px; text-align:center; }
        .profile-content { flex:1; min-width:0; padding:40px; overflow-y:auto; }
        .card { border-radius:12px; box-shadow:0 2px 15px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-shoe-prints"></i> Sneaker ID
            </a>
            <div class="ms-auto">
                <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary me-2">Profil</a>
                <a href="{{ route('cart.index') }}" class="btn btn-sm btn-outline-primary">Keranjang</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="row gx-4 profile-wrapper">
            <div class="sidebar col-md-3">
                <h5><i class="fas fa-user-circle"></i> Akun Saya</h5>
                <ul class="sidebar-menu">
                <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Informasi Akun
                </a></li>
                <li><a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i> Pesanan
                </a></li>
                <li><a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a></li>
                <li><a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                </a></li>
            </ul>
            </div>

            <div class="profile-content col-md-9">
                <div class="card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h3 class="fw-bold">Detail Pesanan {{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-muted mb-1">Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p class="text-muted mb-0">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
                    </div>
                    <div class="text-end">
                        <p class="mb-1">Metode: <strong>{{ strtoupper($order->payment_method ?? '-') }}</strong></p>
                        <p class="mb-0">Total: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h5 class="mb-3">Informasi Pembeli</h5>
                            <p class="mb-1"><strong>Nama:</strong> {{ $order->nama }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->user?->email ?? '-' }}</p>
                            <p class="mb-0"><strong>Alamat:</strong> {{ $order->user?->address ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h5 class="mb-3">Ringkasan Pesanan</h5>
                            <p class="mb-1"><strong>Jumlah item:</strong> {{ count($order->items ?? []) }}</p>
                            <p class="mb-0"><strong>Status saat ini:</strong> {{ ucfirst($order->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-3">Detail Item</h5>

                @if(empty($order->items))
                    <p class="text-muted">Detail item tidak tersedia.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Foto</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            @if(!empty($item['image']))
                                                <img src="{{ asset($item['image']) }}" alt="Foto produk" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                                            @else
                                                <div style="width:60px; height:60px; background:#e9ecef; border-radius:8px;"></div>
                                            @endif
                                        </td>
                                        <td>{{ $item['name'] ?? 'Produk tidak dikenal' }}</td>
                                        <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $item['quantity'] ?? 0 }}</td>
                                        <td>Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if($order->status !== 'selesai' && $order->status !== 'dibatalkan' && $order->status !== 'dikirim')
                <div class="card p-4">
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                    </form>
                </div>
            @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
