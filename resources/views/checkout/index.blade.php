{{-- @var App\Models\User $user --}}
{{-- @var Illuminate\Database\Eloquent\Collection $cartItems --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sneaker ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Header */
        .checkout-header {
            background: white;
            padding: 20px 40px;
            border-bottom: 3px solid #007bff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #000;
        }
        
        .logo i {
            margin-right: 8px;
            font-size: 28px;
        }
        
        /* Steps */
        .steps-container {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 30px 40px;
        }
        
        .steps {
            display: flex;
            justify-content: center;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .step {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }
        
        .step.inactive .step-icon {
            background: #e0e0e0;
            color: #999;
        }
        
        .step-label {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .step-label .title {
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .step.inactive .title {
            color: #999;
        }
        
        /* Main Content */
        .checkout-content {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .card-section {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Shipping Method */
        .shipping-option {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .shipping-option:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }
        
        .shipping-option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .shipping-option.selected {
            border-color: #007bff;
            background: #e7f3ff;
        }
        
        .shipping-info {
            flex: 1;
        }
        
        .shipping-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .shipping-desc {
            font-size: 13px;
            color: #666;
        }
        
        /* Form Section */
        .form-section {
            margin-top: 30px;
        }
        
        .form-section .section-title {
            margin-bottom: 20px;
        }
        
        .address-box {
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .address-box.secondary {
            border-color: #e0e0e0;
        }
        
        .address-content {
            font-size: 13px;
            line-height: 1.6;
            color: #333;
        }
        
        .address-label {
            font-size: 12px;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .change-link {
            color: #007bff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 12px;
            text-decoration: none;
        }
        
        .change-link:hover {
            text-decoration: underline;
        }
        
        /* Order Summary */
        .order-summary {
            position: sticky;
            top: 20px;
        }
        
        .summary-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .summary-item:last-of-type {
            border-bottom: 2px solid #e0e0e0;
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            overflow: hidden;
            background: #f0f0f0;
            flex-shrink: 0;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .item-price {
            font-size: 13px;
            color: #666;
            margin-bottom: 3px;
        }
        
        .item-qty {
            font-size: 12px;
            color: #999;
        }
        
        .summary-total {
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .total-row.main {
            font-weight: 700;
            font-size: 18px;
            border-top: 2px solid #e0e0e0;
            padding-top: 15px;
            color: #dc3545;
        }
        
        .total-row label {
            color: #666;
        }
        
        .total-row.shipping label {
            color: #28a745;
        }
        
        /* Button */
        .btn-checkout {
            width: 100%;
            padding: 15px;
            background: #000;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-checkout:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr;
            }
            
            .steps {
                flex-wrap: wrap;
                gap: 20px;
            }
            
            .header-content {
                flex-wrap: wrap;
                gap: 15px;
                padding: 15px 20px;
            }
            
            .checkout-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="checkout-header">
        <div class="header-content">
            <a href="{{ route('dashboard') }}" class="logo">
                <i class="bi bi-shoe"></i> SNEAKER ID
            </a>
        </div>
    </div>

    <!-- Steps -->
    <div class="steps-container">
        <div class="steps">
            <div class="step">
                <div class="step-icon">1</div>
                <div class="step-label">
                    <span class="title">Pengiriman</span>
                </div>
            </div>
            <div class="step inactive">
                <div class="step-icon">2</div>
                <div class="step-label">
                    <span class="title">Pembayaran</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="checkout-content">
        <div class="row">
            <!-- Left Column -->
            <div>
                <!-- Shipping Method -->
                <div class="card-section">
                    <div class="section-title">Pilih Metode Pengiriman</div>
                    
                    <label class="shipping-option selected">
                        <input type="radio" name="shipping" value="home" checked>
                        <i class="bi bi-truck" style="font-size: 20px; color: #666;"></i>
                        <div class="shipping-info">
                            <div class="shipping-name">Home Delivery</div>
                            <div class="shipping-desc">Kami kirimkan order anda ke rumah</div>
                        </div>
                    </label>
                </div>

                <!-- Shipping Address -->
                <div class="card-section form-section">
                    <div class="section-title">Alamat Pengiriman</div>
                    
                    <!-- Primary Address -->
                    <div class="address-box">
                        <div class="address-label">{{ $user->name }}</div>
                        <div class="address-content">
                            {{ $user->address ?? 'Alamat tidak tersedia' }}<br>
                            {{ $user->city ?? '' }} {{ $user->postal_code ?? '' }}<br>
                            {{ $user->country ?? 'Indonesia' }}<br>
                            <strong>{{ $user->phone ?? '+62857...' }}</strong>
                        </div>
                        @if($user->address)
                            <input type="checkbox" checked style="margin-top: 12px;">
                            <span style="font-size: 12px;">Gunakan alamat ini</span>
                            <a href="{{ route('profile.edit-address') }}" class="change-link d-block">Ubah Alamat</a>
                        @endif
                    </div>

                    @if(!$user->address)
                        <div class="alert alert-warning" style="margin-top: 15px;">
                            <i class="bi bi-exclamation-triangle"></i> Alamat belum diatur. 
                            <a href="{{ route('profile.edit-address') }}" class="alert-link">Tambahkan alamat sekarang</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div>
                <div class="card-section order-summary">
                    <div class="section-title">Ringkasan Belanja</div>
                    
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div class="item-image">
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->nama }}">
                            </div>
                            <div class="item-details">
                                <div class="item-name">{{ $item->product->nama }}</div>
                                <div class="item-price">Rp. {{ number_format($item->product->harga, 0, ',', '.') }}</div>
                                <div class="item-qty">Jumlah: {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-total">
                        <div class="total-row">
                            <label>Subtotal Belanja</label>
                            <span>Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="total-row shipping">
                            <label>Pengiriman</label>
                            <span>Belum Terhitung</span>
                        </div>
                        <div class="total-row main">
                            <label>Total</label>
                            <span>Rp. {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button class="btn-checkout" onclick="proceedToPayment()">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store user address info
        const userAddress = "{{ $user->address ?? '' }}";
        const profileEditUrl = "{{ route('profile.edit-address') }}";

        function proceedToPayment() {
            if (!userAddress || userAddress.trim() === '') {
                alert('Silakan tambahkan alamat pengiriman terlebih dahulu');
                window.location.href = profileEditUrl;
                return;
            }
            
            // Redirect ke halaman pembayaran
            window.location.href = "{{ route('payment') }}";
        }

        // Handle shipping option selection
        document.querySelectorAll('input[name="shipping"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.shipping-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.closest('.shipping-option').classList.add('selected');
            });
        });
    </script>
</body>
</html>
