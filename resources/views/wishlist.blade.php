<!DOCTYPE html>
<html>
<head>
    <title>Wishlist - Sneaker ID</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .navbar {
            background: white;
            border-bottom: 3px solid #000;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .navbar-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-icons i {
            font-size: 20px;
            color: #333;
            cursor: pointer;
            transition: 0.3s;
        }

        .navbar-icons i:hover {
            color: #dc3545;
        }

        .navbar-icons a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .navbar-icons a:hover i {
            color: #dc3545;
        }

        /* Main Wrapper */
        .profile-wrapper {
            display: flex;
            flex-wrap: nowrap;
            align-items: flex-start;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 30px 0;
            width: 260px;
            flex: 0 0 260px;
            max-width: 260px;
            min-width: 260px;
            min-height: calc(100vh - 70px);
            position: sticky;
            top: 70px;
            flex-shrink: 0;
        }

        .sidebar h5 {
            color: #fff;
            padding: 0 20px 20px 20px;
            font-weight: 700;
            margin-bottom: 0;
            font-size: 14px;
        }

        .sidebar-menu {
            list-style: none;
            margin-top: 20px;
            padding-left: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255,255,255,0.9) !important;
            text-decoration: none !important;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 15px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active,
        .sidebar-menu a:focus,
        .sidebar-menu a:visited {
            background-color: #6c757d;
            color: #fff !important;
            font-weight: 600;
            border-left-color: #6c757d;
            text-decoration: none !important;
        }

        .sidebar-menu a:focus-visible { outline: none; }

        .sidebar-menu i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* Container */
        .profile-content {
            flex: 1;
            min-width: 0;
            padding: 40px;
        }

        .wishlist-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }

        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
        }

        .empty-wishlist i {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-wishlist p {
            font-size: 18px;
            color: #999;
            margin-bottom: 30px;
        }

        .empty-wishlist a {
            background: #333;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .empty-wishlist a:hover {
            background: #555;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: #f5f5f5;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .product-price {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .product-actions a,
        .product-actions button {
            flex: 1;
            padding: 10px;
            background: #333;
            color: white;
            text-align: center;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
        }

        .product-actions a:hover {
            background: #555;
        }

        .product-actions button:hover {
            background: #dc3545;
        }

        @media (max-width: 768px) {
            .profile-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
                top: 0;
            }

            .profile-content {
                padding: 20px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <i class="fas fa-shoe-prints"></i> SNEAKER ID
        </a>

        <div class="navbar-icons">
            <a href="{{ route('profile') }}" class="text-dark">
                <i class="bi bi-person"></i>
            </a>
            <a href="{{ route('wishlist') }}" class="text-dark position-relative">
                <i class="bi bi-heart-fill"></i>
            </a>
            <a href="{{ route('cart.index') }}" class="text-dark position-relative">
                <i class="bi bi-cart"></i>
            </a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="profile-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h5><i class="fas fa-user-circle"></i> Akun Saya</h5>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="bi bi-person"></i>
                        Informasi Akun
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">
                        <i class="bi bi-heart"></i>
                        Wishlist
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i>
                        Keranjang
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="profile-content">
            <div class="wishlist-title">Wishlist</div>

            @if($wishlistItems->isEmpty())
                <div class="empty-wishlist">
                    <i class="bi bi-heart"></i>
                    <p>Wishlist Anda kosong</p>
                    <a href="{{ route('dashboard') }}">Mulai Belanja</a>
                </div>
            @else
                <div class="product-grid">
                    @foreach($wishlistItems as $item)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->nama }}">
                            </div>
                            <div class="product-info">
                                <h4 class="product-name">{{ $item->product->nama }}</h4>
                                <p class="product-price">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                <div class="product-actions">
                                    <a href="{{ route('product.show', $item->product->id) }}">Lihat</a>
                                    <button type="button" onclick="removeFromWishlist(`{{ $item->product->id }}`)" style="background: #dc3545;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function removeFromWishlist(productId) {
            if (confirm('Hapus dari wishlist?')) {
                fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cart-count-badge');
                    if (data.cart_count > 0) {
                        badge.textContent = data.cart_count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateWishlistCount() {
            fetch('{{ route("wishlist.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('wishlist-count-badge');
                    if (data.wishlist_count > 0) {
                        badge.textContent = data.wishlist_count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            updateWishlistCount();
        });
    </script>
</body>
</html>
