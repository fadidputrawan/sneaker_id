<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->nama }} - Sneaker ID</title>
    @php
        $sizeStocks = [
            '39' => $product->stok_39 ?? 0,
            '40' => $product->stok_40 ?? 0,
            '41' => $product->stok_41 ?? 0,
            '42' => $product->stok_42 ?? 0,
            '43' => $product->stok_43 ?? 0,
            '44' => $product->stok_44 ?? 0
        ];
    @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="product-id" content="{{ $product->id }}">
    <meta name="is-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <meta name="size-stocks" content="{{ json_encode($sizeStocks) }}">
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

        .size-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
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
                        @php
                            $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?? []);
                            $defaultImage = !empty($images) ? asset('uploads/' . $images[0]) : asset('produk/sepatu1.jpg');
                        @endphp
                        @if(!empty($images))
                            @foreach($images as $index => $image)
                                <div class="thumbnail @if($index === 0) active @endif" data-src="{{ asset('uploads/' . $image) }}" onclick="changeMainImage(this.dataset.src)">
                                    <img src="{{ asset('uploads/' . $image) }}" alt="{{ $product->nama }} - View {{ $index + 1 }}" data-fallback="{{ asset('produk/sepatu1.jpg') }}" onload="if(!this.complete) this.src=this.dataset.fallback">
                                </div>
                            @endforeach
                        @else
                            <div class="thumbnail active" data-src="{{ asset('produk/sepatu1.jpg') }}" onclick="changeMainImage(this.dataset.src)">
                                <img src="{{ asset('produk/sepatu1.jpg') }}" alt="{{ $product->nama }}">
                            </div>
                        @endif
                    </div>
                    <div class="main-image">
                        <img id="mainImage" src="{{ $defaultImage }}" alt="{{ $product->nama }}" data-fallback="{{ asset('produk/sepatu1.jpg') }}" onload="if(!this.complete) this.src=this.dataset.fallback">
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

                    <!-- Stock Alert -->
                    <div id="stockAlert" style="background: #e7f3ff; border-left: 4px solid #2196F3; padding: 10px 15px; margin-bottom: 15px; border-radius: 4px; display: none;">
                        <span style="color: #1976d2; font-weight: bold;">Stok Tersedia: <span id="currentStock">0</span> pasang</span>
                    </div>

                    <!-- Size Selector -->
                    <div class="section-title">Ukuran</div>
                    <div class="size-selector">
                        @php
                            $sizes = [39, 40, 41, 42, 43, 44];
                            $selectedSize = 39;
                        @endphp
                        @foreach($sizes as $size)
                            @php
                                $stokForSize = $product->getStockForSize($size);
                                $isDisabled = $stokForSize === 0;
                            @endphp
                            <button class="size-btn @if($size === 39) active @endif @if($isDisabled) disabled @endif" 
                                    data-size="{{ $size }}"
                                    onclick="selectSize(this, parseInt(this.dataset.size))"
                                    data-stock="{{ $stokForSize }}"
                                    title="Stok: {{ $stokForSize }} pasang">
                                {{ $size }}
                                @if($isDisabled)
                                    <span style="font-size: 10px; display: block;">Habis</span>
                                @endif
                            </button>
                        @endforeach
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
        let selectedSize = 39;  // Default selected size
        
        // Size stocks data from product
        const sizeStocks = JSON.parse(document.querySelector('meta[name="size-stocks"]').content);
        
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            event.target.closest('.thumbnail').classList.add('active');
        }

        function selectSize(button, size) {
            // Check if button is disabled
            if (button.classList.contains('disabled')) {
                alert('Ukuran ' + size + ' sedang habis stok');
                return;
            }

            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            selectedSize = size;  // Store the selected size
            
            // Update stock display for selected size
            const stockForSize = sizeStocks[size] || 0;
            document.getElementById('currentStock').textContent = stockForSize;
            document.getElementById('stockAlert').style.display = 'block';
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

            fetch('/cart/add', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    size: selectedSize
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('content-type'));
                
                return response.json().catch(() => {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }).then(data => {
                    if (!response.ok && response.status >= 400) {
                        throw new Error(data.message || data.error || 'Gagal menambahkan ke keranjang');
                    }
                    return data;
                });
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    updateCartCount();
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert(error.message || 'Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        function parseJsonSafe(response) {
            const contentType = response.headers.get('content-type') || '';
            if (response.status >= 300 && response.status < 400) {
                return Promise.reject(new Error('Server mengarahkan ulang ke login atau halaman lain. Silakan login ulang.'));
            }
            if (response.url.includes('/login')) {
                return Promise.reject(new Error('Silakan login terlebih dahulu.'));
            }
            if (contentType.includes('application/json')) {
                return response.json();
            }
            return response.text().then(text => {
                if (text.includes('<!DOCTYPE html') || text.includes('<html')) {
                    if (text.toLowerCase().includes('login') || text.toLowerCase().includes('csrf')) {
                        throw new Error('Silakan login ulang atau refresh halaman, sesi/CSRF tidak valid.');
                    }
                    throw new Error('Server merespon dengan HTML. Silakan periksa sesi atau CSRF token.');
                }
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Server merespon dengan konten tidak valid.');
                }
            });
        }

        function buyNow() {
            if (!isAuthenticated) {
                alert('Silakan login terlebih dahulu untuk melakukan pembelian');
                window.location.href = '/login';
                return;
            }

            const quantity = parseInt(document.getElementById('quantity').value);

            fetch('/cart/add', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    size: selectedSize
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                return response.json().catch(() => {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }).then(data => {
                    if (!response.ok && response.status >= 400) {
                        throw new Error(data.message || data.error || 'Gagal menambahkan ke keranjang');
                    }
                    return data;
                });
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '/cart';
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert(error.message || 'Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        function updateCartCount() {
            fetch('/cart/count')
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
                window.location.href = '/login';
                return;
            }

            const toggle = document.getElementById('wishlist-toggle');

            fetch('/wishlist/toggle', {
                method: 'POST',
                credentials: 'same-origin',
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
            fetch('/wishlist/count')
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
            
            // Initialize stock display for default size (39)
            const defaultStockForSize = sizeStocks[39] || 0;
            document.getElementById('currentStock').textContent = defaultStockForSize;
            if (defaultStockForSize > 0) {
                document.getElementById('stockAlert').style.display = 'block';
            }
        });
    </script>
</body>
</html>
