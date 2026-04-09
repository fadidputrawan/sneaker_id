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
.hero-slider{
    position: relative;
    width: 100%;
    height: 970px;
    overflow: hidden;
}
.hero-slide{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.hero-slide.active{
    opacity: 1;
}
.hero-slide img{
    width: 100%;
    max-height: 970px;
    object-fit: cover;
    display: block;
}
.hero-slider::-webkit-scrollbar{
    display: none;
}
.slider-controls{
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    padding: 0 20px;
}
.slider-button{
    pointer-events: all;
    background: rgba(0, 0, 0, 0.45);
    border: none;
    color: white;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.3rem;
    transition: background 0.25s ease, transform 0.25s ease;
}
.slider-button:hover{
    background: rgba(0, 0, 0, 0.65);
    transform: scale(1.1);
}

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
<div class="hero-slider" id="heroSlider">
    <div class="hero-slide active">
        <img src="/banner/banner.jpg" alt="Banner 1" onerror="console.error('Banner 1 failed to load')">
    </div>
    <div class="hero-slide">
        <img src="/banner/banner2.jpg" alt="Banner 2" onerror="console.error('Banner 2 failed to load')">
    </div>
    <div class="slider-controls">
        <button type="button" class="slider-button" id="sliderPrev">&#8249;</button>
        <button type="button" class="slider-button" id="sliderNext">&#8250;</button>
    </div>
</div>

<!-- BRAND LOGO -->
<div class="brand-logo text-center">
    @foreach($brands as $brand)
    <div class="brand-item" onclick="filterByBrand('{{ $brand }}', this)">
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
        @php
            $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?? []);
            $fallbackImage = !empty($images) ? '/uploads/' . $images[0] : ($product->image ?? '/produk/sepatu1.jpg');
        @endphp
        <div class="col-md-3 mb-4 product-card" data-brand="{{ $product->brand }}">
            <div style="position: relative;">
                <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="card" style="cursor: pointer; height: 100%;">
                        <img src="{{ $fallbackImage }}" alt="{{ $product->nama }}">
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
const baseAssetUrl = "{{ asset('') }}";

function buildProductImagePath(image) {
    if (!image) {
        return baseAssetUrl + 'produk/sepatu1.jpg';
    }

    const normalizedImage = image.replace(/^\/+/, '');
    if (normalizedImage.match(/^https?:\/\//)) {
        return normalizedImage;
    }

    if (normalizedImage.startsWith('produk/')) {
        return baseAssetUrl + normalizedImage;
    }

    if (normalizedImage.startsWith('uploads/')) {
        return baseAssetUrl + normalizedImage;
    }

    return baseAssetUrl + 'uploads/' + normalizedImage;
}

function filterByBrand(brand, element) {
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
    if (element) {
        element.classList.add('active');
    }
    
    // Show loading
    productsContainer.innerHTML = '<div class="col-12 loading"><i class="bi bi-hourglass-split"></i> Loading...</div>';
    
    // Fetch products by brand
    fetch(`/api/products/brand/${encodeURIComponent(brand)}`)
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
                const productImage = product.image || (product.images && product.images.length ? product.images[0] : 'produk/sepatu1.jpg');
                const imagePath = buildProductImagePath(productImage);
                html += `
                    <div class="col-md-3 mb-4 product-card">
                        <div style="position: relative;">
                            <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                <div class="card" style="cursor: pointer; height: 100%;">
                                    <img src="${imagePath}" alt="${product.nama}">
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

// Banner slider button controls + auto slide
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('heroSlider');
    if (!slider) {
        console.error('Hero slider not found');
        return;
    }

    const slides = slider.querySelectorAll('.hero-slide');
    console.log('Found slides:', slides.length);

    const prevButton = document.getElementById('sliderPrev');
    const nextButton = document.getElementById('sliderNext');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });
        console.log('Showing slide:', index);
    }

    function scrollSlide(direction) {
        currentIndex = (currentIndex + direction + slides.length) % slides.length;
        showSlide(currentIndex);
    }

    // Show first slide initially
    showSlide(0);

    if (prevButton) prevButton.addEventListener('click', () => scrollSlide(-1));
    if (nextButton) nextButton.addEventListener('click', () => scrollSlide(1));

    // Auto slide
    setInterval(() => {
        scrollSlide(1);
    }, 8000);

    console.log('Slider initialized');
});

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
