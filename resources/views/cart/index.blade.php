<!DOCTYPE html>
<html>
<head>
    <title>Keranjang - Sneaker ID</title>
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

        /* Cart Container */
        .profile-content {
            flex: 1;
            min-width: 0;
            padding: 40px;
        }

        .cart-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
        }

        .empty-cart i {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart p {
            font-size: 18px;
            color: #999;
            margin-bottom: 30px;
        }

        .empty-cart a {
            background: #333;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .empty-cart a:hover {
            background: #555;
        }

        .cart-wrapper {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .cart-items {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .cart-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            gap: 20px;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 120px;
            height: 120px;
            background: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .cart-item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: fit-content;
        }

        .qty-control button {
            background: none;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            color: #666;
            font-size: 14px;
        }

        .qty-control input {
            width: 40px;
            border: none;
            text-align: center;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            padding: 5px;
            font-size: 14px;
        }

        .item-subtotal {
            font-weight: bold;
            color: #333;
            min-width: 100px;
            text-align: right;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
        }

        /* Summary */
        .cart-summary {
            background: white;
            border-radius: 8px;
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
            font-size: 14px;
        }

        .summary-row.total {
            border-top: 2px solid #e0e0e0;
            padding-top: 15px;
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        .checkout-btn:hover {
            background: #c82333;
        }

        .continue-shopping-btn {
            width: 100%;
            padding: 12px;
            background: white;
            color: #333;
            border: 2px solid #333;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .continue-shopping-btn:hover {
            background: #f5f5f5;
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

            .cart-wrapper {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .item-subtotal {
                text-align: center;
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
            <a href="{{ route('wishlist') }}" class="text-dark">
                <i class="bi bi-heart"></i>
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
            <div class="cart-title">Keranjang Belanja</div>

        @if($cartItems->isEmpty())
            <div class="empty-cart">
                <i class="bi bi-bag"></i>
                <p>Keranjang Anda kosong</p>
                <a href="{{ route('dashboard') }}">Lanjut Belanja</a>
            </div>
        @else
            <div class="cart-wrapper">
                <!-- Cart Items -->
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="cart-item" data-cart-id="{{ $item->id }}" data-product-price="{{ $item->product->harga }}">
                            <div class="cart-item-image">
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->nama }}">
                            </div>

                            <div class="cart-item-details">
                                <div class="cart-item-name">{{ $item->product->nama }}</div>
                                <div class="cart-item-price">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</div>
                                <div class="cart-item-actions">
                                    <div class="qty-control">
                                        <button type="button" onclick="decreaseQty(`{{ $item->id }}`)">−</button>
                                        <input type="text" value="{{ $item->quantity }}" readonly id="qty-{{ $item->id }}">
                                        <button type="button" onclick="increaseQty(`{{ $item->id }}`)">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="item-subtotal" id="subtotal-{{ $item->id }}">
                                Rp {{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}
                            </div>

                            <button type="button" class="remove-btn" onclick="removeFromCart(`{{ $item->id }}`)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="cart-summary">
                    <div class="summary-title">Ringkasan Pesanan</div>

                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Ongkir:</span>
                        <span>Rp 0</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" class="checkout-btn" onclick="checkout()">Checkout</button>
                    <button type="button" class="continue-shopping-btn" onclick="window.location=`{{ route('dashboard') }}`">Lanjut Belanja</button>
                </div>
            </div>
        @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQty(cartId) {
            const input = document.getElementById(`qty-${cartId}`);
            let qty = parseInt(input.value);
            qty += 1;
            updateQuantity(cartId, qty);
        }

        function decreaseQty(cartId) {
            const input = document.getElementById(`qty-${cartId}`);
            let qty = parseInt(input.value);
            if (qty > 1) {
                qty -= 1;
                updateQuantity(cartId, qty);
            }
        }

        function updateQuantity(cartId, quantity) {
            fetch('{{ route("cart.updateQuantity") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update input value
                    document.getElementById(`qty-${cartId}`).value = quantity;

                    // Update subtotal
                    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                    const price = parseInt(cartItem.dataset.productPrice);
                    const subtotal = price * quantity;
                    document.getElementById(`subtotal-${cartId}`).textContent = 
                        'Rp ' + subtotal.toLocaleString('id-ID', { minimumFractionDigits: 0 });

                    // Update total and cart count
                    updateCartSummary(data.total);
                    updateCartCount();
                    
                    console.log('Quantity updated successfully');
                } else {
                    alert('Gagal mengubah quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function removeFromCart(cartId) {
            if (confirm('Hapus produk dari keranjang?')) {
                fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify({
                        cart_id: cartId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove cart item from DOM
                        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                        cartItem.parentElement.removeChild(cartItem);

                        // Refresh page to update totals
                        setTimeout(() => {
                            location.reload();
                        }, 500);

                        updateCartCount();
                    } else {
                        alert('Gagal menghapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
            }
        }

        function updateCartSummary(total) {
            // Update all summary rows with the new total
            const summaryRows = document.querySelectorAll('.summary-row');
            summaryRows.forEach(row => {
                if (row.textContent.includes('Total:')) {
                    row.querySelector('span:last-child').textContent = 
                        'Rp ' + parseInt(total).toLocaleString('id-ID', { minimumFractionDigits: 0 });
                }
            });
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

        function checkout() {
            window.location.href = '{{ route("checkout") }}';
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>
</body>
</html>
