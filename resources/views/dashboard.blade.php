<!DOCTYPE html>
<html>
<head>
<title>Sneaker ID</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="is-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
.hero img{
    width:100%;
    max-height:970px;
    object-fit:cover;
}

/* Brand logo */
.brand-logo{
    background:#f5f5f5;
    padding:25px 0;
    display: flex;
    justify-content: center;
    gap: 20px;
    overflow-x: auto;
    padding-right: 20px;
    padding-left: 20px;
}
.brand-logo .brand-item{
    cursor: pointer;
    transition: 0.3s;
    padding: 15px;
    border-radius: 8px;
    flex-shrink: 0;
}
.brand-logo .brand-item img{
    height:150px;
    margin:0;
    transition:0.3s;
    min-width: 150px;
}
.brand-logo .brand-item:hover{
    background: #e0e0e0;
}
.brand-logo .brand-item:hover img{
    transform:scale(1.1);
}
.brand-logo .brand-item.active{
    background: #ddd;
    border: 2px solid #666;
}

/* Produk */
.card {
    border: 1px solid #e0e0e0 !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s ease !important;
    overflow: hidden;
}
.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    transform: translateY(-2px);
}
.card img {
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid #e0e0e0;
}
.card-body {
    padding: 15px !important;
    text-align: center;
}
.card-body h6 {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 10px;
    font-size: 14px;
}
.card-body p {
    color: #e74c3c;
    font-weight: 700;
    margin-bottom: 0;
    font-size: 15px;
}

/* Navbar Icons */
.navbar i{
    font-size:26px;
    color:black;
    transition:0.3s;
}
.navbar i:hover{
    color:#dc3545;
}

/* Filter Title */
.filter-title{
    text-align: center;
    margin: 20px 0;
    padding: 10px;
    background: #f0f0f0;
    border-radius: 8px;
    font-weight: bold;
    color: #555;
}

.loading{
    text-align: center;
    padding: 40px;
    font-size: 18px;
    color: #999;
}

/* Wishlist Button */
.wishlist-btn-card {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.95) !important;
    border: none !important;
    border-radius: 50% !important;
    width: 40px !important;
    height: 40px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer;
    transition: all 0.3s ease !important;
    font-size: 18px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}
.wishlist-btn-card:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-light px-4">

    <!-- Logo -->
    <b class="fs-4">SNEAKER ID</b>

    <!-- Search -->
    <form class="d-flex w-50" onsubmit="return false;">
        <input class="form-control" placeholder="Cari Produk" id="searchInput">
    </form>

    <!-- Menu Icon -->
    <div class="d-flex align-items-center gap-4">

        <!-- Profile -->
        <a href="{{ route('profile') }}" class="text-dark">
            <i class="bi bi-person"></i>
        </a>



        <!-- Wishlist -->
        <a href="{{ route('wishlist') }}" class="text-dark position-relative">
            <i class="bi bi-heart" id="navbar-wishlist-icon"></i>
            <span id="wishlist-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none; font-size: 10px;">0</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="text-dark position-relative">
            <i class="bi bi-cart"></i>
            <span id="cart-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none; font-size: 10px;">0</span>
        </a>

    </div>

</nav>

<!-- BANNER -->
<div class="hero">
<img src="{{ asset('banner/banner.jpg') }}">
</div>

<!-- BRAND LOGO -->
<div class="brand-logo text-center">
    @foreach($brands as $brand)
    <div class="brand-item" onclick="filterByBrand('{{ $brand }}')">
        @php
            $brandLower = strtolower($brand);
            // Map brand names to file names
            $brandFileMap = [
                'new balance' => 'nb',
                'puma' => 'puma',
                'adidas' => 'adidas',
                'nike' => 'nike',
                'salomon' => 'salomon'
            ];
            $fileName = $brandFileMap[$brandLower] ?? $brandLower;
            $imagePath = "brand/" . $fileName . ".png";
        @endphp
        <img src="{{ asset($imagePath) }}" alt="{{ $brand }}" title="Klik untuk filter {{ $brand }}">
    </div>
    @endforeach
</div>

<!-- Filter Title -->
<div id="filterTitle" class="filter-title" style="display: none;">
    <span id="filterType" style="display: none;">Menampilkan produk brand: </span><span id="selectedBrand"></span>
</div>

<!-- PRODUK -->
<div class="container mt-4">
    <div class="row" id="productsContainer">
        @forelse($products as $product)
        <div class="col-md-3 mb-4 product-card" data-brand="{{ $product->brand }}">
            <div style="position: relative;">
                <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="card" style="cursor: pointer; height: 100%;">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->nama }}">
                        <div class="card-body">
                            <h6>{{ $product->nama }}</h6>
                            <p>Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
                <button class="wishlist-btn-card" data-product-id="{{ $product->id }}" onclick="toggleWishlistCard(event, this.dataset.productId)">
                    <i class="bi bi-heart" id="wishlist-icon-{{ $product->id }}"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="mt-5">Belum ada produk</p>
        </div>
        @endforelse
    </div>
</div>

<script>
function filterByBrand(brand) {
    const productsContainer = document.getElementById('productsContainer');
    const filterTitle = document.getElementById('filterTitle');
    const selectedBrandSpan = document.getElementById('selectedBrand');
    const filterType = document.getElementById('filterType');
    const brandItems = document.querySelectorAll('.brand-item');
    
    // Remove active class from all brand items
    brandItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Add active class to clicked brand item
    event.target.closest('.brand-item').classList.add('active');
    
    // Show loading
    productsContainer.innerHTML = '<div class="col-12 loading"><i class="bi bi-hourglass-split"></i> Loading...</div>';
    
    // Fetch products by brand
    fetch(`/api/products/brand/${brand}`)
        .then(response => response.json())
        .then(products => {
            selectedBrandSpan.textContent = brand;
            filterType.style.display = 'inline';
            filterTitle.style.display = 'block';
            
            if (products.length === 0) {
                productsContainer.innerHTML = '<div class="col-12 text-center"><p class="mt-5">Produk ' + brand + ' tidak tersedia</p></div>';
                return;
            }
            
            let html = '';
            products.forEach(product => {
                html += `
                    <div class="col-md-3 mb-4 product-card">
                        <div style="position: relative;">
                            <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                <div class="card" style="cursor: pointer; height: 100%;">
                                    <img src="{{ asset('') }}${product.image}" alt="${product.nama}">
                                    <div class="card-body">
                                        <h6>${product.nama}</h6>
                                        <p>Rp ${new Intl.NumberFormat('id-ID').format(product.harga)}</p>
                                    </div>
                                </div>
                            </a>
                            <button class="wishlist-btn-card" data-product-id="${product.id}" onclick="toggleWishlistCard(event, this.dataset.productId)">
                                <i class="bi bi-heart" id="wishlist-icon-${product.id}"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            productsContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            productsContainer.innerHTML = '<div class="col-12 text-center"><p class="mt-5 text-danger">Terjadi error saat memuat produk</p></div>';
        });
}

function showAllProducts() {
    const filterTitle = document.getElementById('filterTitle');
    const productsContainer = document.getElementById('productsContainer');
    const brandItems = document.querySelectorAll('.brand-item');
    const searchInput = document.getElementById('searchInput');
    
    // Clear search input
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Remove active class from all brand items
    brandItems.forEach(item => {
        item.classList.remove('active');
    });
    
    filterTitle.style.display = 'none';
    
    // Reload page to show all products
    location.reload();
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

// Load cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    updateWishlistCountBadge();
    checkAllWishlistStatus();
    
    // Add search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const query = this.value.trim();
            
            if (query.length === 0) {
                // Reset to show all products if search is empty
                showAllProducts();
                return;
            }
            
            performSearch(query);
        });
    }
});

function updateWishlistCountBadge() {
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

function toggleWishlistCard(event, productId) {
    event.preventDefault();
    event.stopPropagation();
    
    const isAuthenticated = document.querySelector('meta[name="is-authenticated"]')?.content === 'true';
    
    if (!isAuthenticated) {
        alert('Silakan login terlebih dahulu');
        window.location.href = '{{ route("login") }}';
        return;
    }

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
            const icon = document.getElementById(`wishlist-icon-${productId}`);
            if (data.is_liked) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                icon.style.color = '#dc3545';
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                icon.style.color = 'inherit';
            }
            updateWishlistCountBadge();
        } else {
            alert('Gagal memperbarui wishlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function checkAllWishlistStatus() {
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const link = card.querySelector('a');
        const productId = parseInt(link.href.split('/').pop());
        
        fetch(`/wishlist/is-liked/${productId}`)
            .then(response => response.json())
            .then(data => {
                const icon = document.getElementById(`wishlist-icon-${productId}`);
                if (icon && data.is_liked) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    icon.style.color = '#dc3545';
                }
            })
            .catch(error => console.error('Error:', error));
    });
}

function performSearch(query) {
    const productsContainer = document.getElementById('productsContainer');
    const filterTitle = document.getElementById('filterTitle');
    const selectedBrandSpan = document.getElementById('selectedBrand');
    const filterType = document.getElementById('filterType');
    const brandItems = document.querySelectorAll('.brand-item');
    
    // Remove active class from all brand items
    brandItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Show loading
    productsContainer.innerHTML = '<div class="col-12 loading"><i class="bi bi-hourglass-split"></i> Mencari produk...</div>';
    
    // Fetch search results
    fetch(`/api/products/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(products => {
            selectedBrandSpan.textContent = `"${query}"`;
            filterType.style.display = 'none';
            filterTitle.style.display = 'block';
            
            if (products.length === 0) {
                productsContainer.innerHTML = '<div class="col-12 text-center"><p class="mt-5">Produk "<strong>' + query + '</strong>" tidak ditemukan. Coba cari dengan nama atau brand lain.</p></div>';
                return;
            }
            
            let html = '';
            products.forEach(product => {
                html += `
                    <div class="col-md-3 mb-4 product-card">
                        <div style="position: relative;">
                            <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                <div class="card" style="cursor: pointer; height: 100%;">
                                    <img src="{{ asset('') }}${product.image}" alt="${product.nama}">
                                    <div class="card-body">
                                        <h6>${product.nama}</h6>
                                        <p>Rp ${new Intl.NumberFormat('id-ID').format(product.harga)}</p>
                                    </div>
                                </div>
                            </a>
                            <button class="wishlist-btn-card" data-product-id="${product.id}" onclick="toggleWishlistCard(event, this.dataset.productId)">
                                <i class="bi bi-heart" id="wishlist-icon-${product.id}"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            productsContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            productsContainer.innerHTML = '<div class="col-12 text-center"><p class="mt-5 text-danger">Terjadi error saat mencari produk</p></div>';
        });
}
</script>

</body>
</html>
