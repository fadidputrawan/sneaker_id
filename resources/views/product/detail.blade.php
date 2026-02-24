<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->nama }} - Sneaker ID</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="product-id" content="{{ $product->id }}">
    <meta name="is-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 30px;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }

        .search-container {
            flex: 1;
            margin: 0 30px;
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

        /* Product Detail */
        .product-detail-container {
            padding: 40px 0;
        }

        .product-gallery {
            display: flex;
            gap: 20px;
        }

        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .thumbnail {
            width: 100px;
            height: 100px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            overflow: hidden;
            transition: 0.3s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: #333;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .main-image {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .main-image img {
            max-width: 100%;
            height: auto;
        }

        .product-info {
            padding-left: 30px;
        }

        .product-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .stars {
            color: #ffc107;
        }

        .in-stock {
            color: #28a745;
            font-weight: bold;
            font-size: 14px;
        }

        .price {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .size-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .size-btn {
            width: 50px;
            height: 50px;
            border: 2px solid #ddd;
            background: white;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .size-btn:hover {
            border-color: #333;
        }

        .size-btn.active {
            background: #333;
            color: white;
            border-color: #333;
        }

        .shipping-info {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .shipping-info i {
            font-size: 24px;
            color: #333;
        }

        .shipping-text {
            font-size: 14px;
            color: #666;
        }

        .shipping-text strong {
            color: #333;
        }

        .quantity-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: fit-content;
        }

        .quantity-control button {
            background: none;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 18px;
            color: #666;
        }

        .quantity-control input {
            width: 50px;
            border: none;
            text-align: center;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn-buy,
        .btn-cart {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }

        .btn-buy {
            background: white;
            color: #333;
            border: 2px solid #333;
        }

        .btn-buy:hover {
            background: #f5f5f5;
        }

        .btn-cart {
            background: #dc3545;
            color: white;
        }

        .btn-cart:hover {
            background: #c82333;
        }

        .wishlist-btn {
            width: 50px;
            height: 50px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 24px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wishlist-btn:hover {
            border-color: #dc3545;
        }

        .wishlist-btn.liked {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        /* Details Section */
        .details-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-top: 40px;
        }

        .details-section h3 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .details-section p {
            line-height: 1.8;
            color: #666;
            margin-bottom: 15px;
        }

        .details-section strong {
            color: #333;
        }

        @media (max-width: 768px) {
            .product-gallery {
                flex-direction: column;
            }

            .product-info {
                padding-left: 0;
                margin-top: 20px;
            }

            .size-btn {
                width: 45px;
                height: 45px;
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="d-flex w-100 align-items-center">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <i class="bi bi-play-fill"></i> SNEAKER ID
            </a>

            <div class="search-container">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Produk...">
                    <button class="btn btn-dark" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <div class="navbar-icons">
                <a href="{{ route('profile') }}" class="text-dark">
                    <i class="bi bi-person"></i>
                </a>
                <a href="{{ route('wishlist') }}" class="text-dark position-relative">
                    <i class="bi bi-heart"></i>
                    <span id="wishlist-count-badge" style="display: none; position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">0</span>
                </a>
                <a href="{{ route('cart.index') }}" class="text-dark position-relative">
                    <i class="bi bi-cart"></i>
                    <span id="cart-count-badge" style="display: none; position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">0</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Product Detail -->
    <div class="container product-detail-container">
        <div class="row">
            <!-- Gallery -->
            <div class="col-md-5">
                <div class="product-gallery">
                    <div class="thumbnails">
                        <div class="thumbnail active" onclick="changeMainImage('{{ asset($product->image) }}')">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->nama }}">
                        </div>
                        <div class="thumbnail" onclick="changeMainImage(`{{ asset('detail/2.jpg') }}`)"> 
                            <img src="{{ asset('detail/2.jpg') }}" alt="View 2">
                        </div>
                        <div class="thumbnail" onclick="changeMainImage(`{{ asset('detail/3.jpg') }}`)">  
                            <img src="{{ asset('detail/3.jpg') }}" alt="View 3">
                        </div>
                        <div class="thumbnail" onclick="changeMainImage(`{{ asset('detail/4.jpg') }}`)">  
                            <img src="{{ asset('detail/4.jpg') }}" alt="View 4">
                        </div>
                    </div>
                    <div class="main-image">
                        <img id="mainImage" src="{{ asset($product->image) }}" alt="{{ $product->nama }}">
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="col-md-7">
                <div class="product-info">
                    <h1 class="product-name">{{ strtoupper($product->nama) }}</h1>

                    <div class="rating-section">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span>(160 Reviews)</span>
                        <span class="in-stock">In Stock</span>
                    </div>

                    <div class="price">Rp. {{ number_format($product->harga, 2, ',', '.') }}</div>

                    <!-- Size Selector -->
                    <div class="section-title">Ukuran</div>
                    <div class="size-selector">
                        <button class="size-btn active" onclick="selectSize(this, 39)">39</button>
                        <button class="size-btn" onclick="selectSize(this, 40)">40</button>
                        <button class="size-btn" onclick="selectSize(this, 41)">41</button>
                        <button class="size-btn" onclick="selectSize(this, 42)">42</button>
                        <button class="size-btn" onclick="selectSize(this, 43)">43</button>
                        <button class="size-btn" onclick="selectSize(this, 44)">44</button>
                    </div>

                    <!-- Shipping Info -->
                    <div class="shipping-info">
                        <i class="bi bi-truck"></i>
                        <div>
                            <div class="shipping-text"><strong>GRATIS ONGKIR</strong></div>
                            <div class="shipping-text">Biaya pesanan sekarang</div>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="quantity-section">
                        <span style="font-weight: bold; color: #333;">Jumlah</span>
                        <div class="quantity-control">
                            <button onclick="decreaseQty()">−</button>
                            <input type="text" id="quantity" value="1" readonly>
                            <button onclick="increaseQty()">+</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons" style="gap: 10px;">
                        <button class="wishlist-btn" id="wishlist-toggle" onclick="toggleWishlist()" title="Tambah ke Wishlist">
                            <i class="bi bi-heart"></i>
                        </button>
                        <button class="btn-buy" onclick="buyNow()">BELI SEKARANG</button>
                        <button class="btn-cart" onclick="addToCart()">TAMBAH KE KERANJANG</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="details-section">
                    <h3>DETAILS</h3>
                    <p>
                        <strong>{{ $product->nama }}</strong> - Detail Produk
                    </p>
                    <p>
                        Biarkan kepribadianmu terpancar dari Nike Air Max Plus, pengalaman Tuned Air yang menawarkan stabilitasi premium dan bantalan luar biasa. Dengan desain garis OG bergelombang, aksen TPU dan mesh sejak di bagian upper, sepatu ini merupakan bentuk pembedaan gaya.
                    </p>
                    <p>
                        <strong>Mengenai Ukuran:</strong><br>
                        Seliseh 1-2 cm mungkin terjadi dikarenakan proses pengembangan dan produksi.
                    </p>
                    <p>
                        <strong>Mengenai Warna:</strong><br>
                        Warna sesungguhnya mungkin dapat berbeda. Hal ini dikarenakan setiap layer memiliki kemampuan yang berbeda-beda untuk menampilkan warna, kami tidak dapat menjamin bahwa warna yang Anda lihat adalah warna akurat dari produk tersebut.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize variables from meta tags
        const isAuthenticated = document.querySelector('meta[name="is-authenticated"]').content === 'true';
        const productId = parseInt(document.querySelector('meta[name="product-id"]').content);
        
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            event.target.closest('.thumbnail').classList.add('active');
        }

        function selectSize(button, size) {
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        }

        function increaseQty() {
            let qty = parseInt(document.getElementById('quantity').value);
            document.getElementById('quantity').value = qty + 1;
        }

        function decreaseQty() {
            let qty = parseInt(document.getElementById('quantity').value);
            if (qty > 1) {
                document.getElementById('quantity').value = qty - 1;
            }
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    updateCartCount();
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function buyNow() {
            if (!isAuthenticated) {
                alert('Silakan login terlebih dahulu untuk melakukan pembelian');
                window.location.href = '{{ route("login") }}';
                return;
            }

            const quantity = parseInt(document.getElementById('quantity').value);

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect ke cart page setelah berhasil ditambahkan
                    window.location.href = '{{ route("cart.index") }}';
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cart-count-badge');
                    if (data.cart_count > 0) {
                        badge.textContent = data.cart_count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleWishlist() {
            if (!isAuthenticated) {
                alert('Silakan login terlebih dahulu');
                window.location.href = '{{ route("login") }}';
                return;
            }

            const toggle = document.getElementById('wishlist-toggle');

            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_liked) {
                        toggle.classList.add('liked');
                    } else {
                        toggle.classList.remove('liked');
                    }
                    updateWishlistCount();
                    alert(data.message);
                } else {
                    alert('Gagal memperbarui wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function updateWishlistCount() {
            fetch('{{ route("wishlist.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('wishlist-count-badge');
                    if (data.wishlist_count > 0) {
                        badge.textContent = data.wishlist_count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function checkWishlistStatus() {
            fetch(`/wishlist/is-liked/${productId}`)
                .then(response => response.json())
                .then(data => {
                    const toggle = document.getElementById('wishlist-toggle');
                    if (data.is_liked) {
                        toggle.classList.add('liked');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Load cart count and wishlist status on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            updateWishlistCount();
            checkWishlistStatus();
        });
    </script>
</body>
</html>
