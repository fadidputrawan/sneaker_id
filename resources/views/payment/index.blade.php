{{-- @var App\Models\User $user --}}
{{-- @var Illuminate\Database\Eloquent\Collection $cartItems --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Sneaker ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #3a3a3a;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Header */
        .payment-header {
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
            background: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }
        
        .step.inactive .step-icon {
            background: #007bff;
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
        
        /* Main Content */
        .payment-content {
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
        
        /* Payment Method */
        .payment-option {
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
        
        .payment-option:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }
        
        .payment-option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .payment-option.selected {
            border-color: #007bff;
            background: #e7f3ff;
        }
        
        .payment-info {
            flex: 1;
        }
        
        .payment-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .payment-logo {
            font-size: 18px;
            font-weight: 700;
            color: #007bff;
        }
        
        /* Address Section */
        .address-box {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
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
        
        /* Shipping Method */
        .shipping-method {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .shipping-text {
            font-size: 13px;
            color: #333;
        }
        
        /* Order Summary */
        .order-summary {
            position: sticky;
            top: 20px;
        }
        
        .summary-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
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
            color: #999;
        }
        
        /* Button */
        .btn-order {
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
        
        .btn-order:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .disclaimer {
            font-size: 11px;
            color: #999;
            margin-top: 15px;
            line-height: 1.5;
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
            
            .payment-content {
                padding: 20px;
            }
        }

        /* QRIS Modal */
        .qris-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .qris-modal-overlay.active {
            display: flex;
        }

        .qris-modal {
            background: white;
            border-radius: 12px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            text-align: center;
        }

        .qris-modal .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #000;
            margin-bottom: 5px;
        }

        .qris-modal .modal-subtitle {
            font-size: 13px;
            color: #666;
            margin-bottom: 30px;
        }

        .qris-qrcode {
            background: white;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qris-qrcode canvas {
            max-width: 250px;
        }

        .qris-info {
            font-size: 13px;
            margin-bottom: 20px;
        }

        .qris-info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .qris-info-row:last-of-type {
            border-bottom: none;
        }

        .qris-info-label {
            color: #999;
            font-weight: 500;
        }

        .qris-info-value {
            color: #000;
            font-weight: 600;
        }

        .qris-info-value.total {
            color: #10b981;
            font-size: 16px;
        }

        .qris-timer {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 12px;
            margin: 20px 0;
            font-size: 13px;
            color: #856404;
        }

        .qris-timer strong {
            color: #000;
        }

        .qris-button {
            width: 100%;
            padding: 12px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .qris-button:hover {
            background: #059669;
        }

        .qris-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .close-modal:hover {
            color: #000;
        }

        .qris-qrcode {
            background: white;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qris-qrcode canvas {
            max-width: 250px;
        }

        #proofFile {
            display: none;
        }

        #uploadIcon,
        #uploadText {
            transition: all 0.3s ease;
        }

        /* Success Modal */
        .success-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .success-modal-overlay.active {
            display: flex;
        }

        .success-modal {
            background: white;
            border-radius: 12px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 45px;
            color: white;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        .success-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .success-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .success-details {
            background: #f5f7fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .success-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .success-detail-row:last-child {
            border-bottom: none;
        }

        .success-detail-label {
            color: #666;
            font-weight: 500;
        }

        .success-detail-value {
            color: #1a1a1a;
            font-weight: 600;
        }

        .success-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .success-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .success-button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="payment-header">
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
                <div class="step-icon">✓</div>
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
    <div class="payment-content">
        <div class="row">
            <!-- Left Column -->
            <div>
                <!-- Payment Method -->
                <div class="card-section">
                    <div class="section-title">Metode Pembayaran</div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Pilih metode pembayaran anda</p>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="qris">
                        <div class="payment-info">
                            <div class="payment-name">QRIS</div>
                            <div style="font-size: 12px; color: #666;">Scan & Bayar dengan QR Code</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod">
                        <div class="payment-info">
                            <div class="payment-name">Cash On Delivery</div>
                            <div style="font-size: 12px; color: #666;">Bayar saat produk tiba</div>
                        </div>
                    </label>

                    <div class="disclaimer">
                        <input type="checkbox" id="agree-terms" style="margin-right: 8px;">
                        <label for="agree-terms">Dengan memilih "Lanjut", saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi Footlocker Indonesia</label>
                    </div>

                    <button class="btn-order" id="proceedBtn" disabled style="opacity:0.6; cursor:not-allowed;">Lanjut</button>
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
                </div>

                <!-- Delivery Address -->
                <div class="card-section" style="margin-top: 25px;">
                    <div class="section-title">Kirim Ke</div>
                    <div class="address-box">
                        <div class="address-label">{{ $user->name }}</div>
                        <div class="address-content">
                            {{ $user->address ?? 'Alamat tidak tersedia' }}<br>
                            {{ $user->city ?? '' }}/{{ $user->postal_code ?? '' }},<br>
                            {{ $user->country ?? 'Indonesia' }}<br>
                            <strong>{{ $user->phone ?? '+62857...' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="card-section" style="margin-top: 25px;">
                    <div class="section-title">Metode Pengiriman</div>
                    <div class="shipping-method">
                        <div class="shipping-text">
                            <strong>Regular - Regular Delivery</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QRIS Payment Modal -->
    <div class="qris-modal-overlay" id="qrisModal">
        <div class="qris-modal">
            <button class="close-modal" onclick="closeQRISModal()">×</button>
            
            <!-- QR Code Step -->
            <div id="qrisStep">
                <div class="modal-title">QRIS Payment</div>
                <div class="modal-subtitle">Scan QR code to complete your payment</div>
                
                <div class="qris-qrcode" id="qrcodeContainer"></div>
                
                <div class="qris-info">
                    <div class="qris-info-row">
                        <span class="qris-info-label">Merchant</span>
                        <span class="qris-info-value">SNEAKER ID</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Total Payment</span>
                        <span class="qris-info-value total">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="qris-timer">
                    Pembayaran hangus dalam <strong id="timer">14:59</strong>
                </div>
                
                <button class="qris-button" onclick="completePayment()">Saya Sudah Bayar</button>
            </div>

            <!-- Payment Pending Step -->
            <div id="pendingStep" style="display: none;">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="font-size: 50px; color: #ffc107; margin-bottom: 15px;">⏳</div>
                    <div class="modal-title">Pembayaran Tertunda</div>
                </div>
                
                <div class="qris-info">
                    <div class="qris-info-row">
                        <span class="qris-info-label">Transaction ID</span>
                        <span class="qris-info-value" id="transactionId">TRX-983421</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Date</span>
                        <span class="qris-info-value" id="transactionDate">29 Jan 2026 14:32</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Payment Method</span>
                        <span class="qris-info-value">QRIS</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Merchant</span>
                        <span class="qris-info-value">SNEAKER ID</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Items</span>
                        <span class="qris-info-value" id="itemsInfo">NIKE FX AIR MAX x1</span>
                    </div>
                    <div class="qris-info-row" style="border-bottom: 2px solid #e0e0e0;">
                        <span class="qris-info-label">Total Payment</span>
                        <span class="qris-info-value total" id="totalPayment">Rp. 2.350.000</span>
                    </div>
                </div>

                <div style="background: #f5f5f5; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center; cursor: pointer;" onclick="document.getElementById('proofFile').click()">
                    <div id="uploadIcon" style="margin-bottom: 15px;">
                        <div style="font-size: 40px; color: #999;">+</div>
                    </div>
                    <div id="uploadText" style="font-size: 13px; color: #666; line-height: 1.6;">
                        <strong>Upload Bukti Pembayaran</strong><br>
                        <span style="font-size: 12px; display: block; margin-top: 8px;">*Pembayaran QRIS akan diproses selain sistem mengkonfirmasi saldo masuk. Selama proses ini, pesanan dalam tertunda sementara.</span>
                    </div>
                    <img id="previewImage" src="" alt="Preview" style="display: none; max-width: 100%; max-height: 200px; margin-top: 15px; border-radius: 6px;">
                </div>
                <input type="file" id="proofFile" accept="image/*" style="display: none;">
                
                <button class="qris-button" id="submitProofBtn" onclick="submitPaymentProof()" style="opacity: 0.5; cursor: not-allowed;" disabled>Sudah Bayar</button>
            </div>

            <!-- Payment Success Step -->
            <div id="successStep" style="display: none;">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="font-size: 60px; color: #10b981; margin-bottom: 15px;">✓</div>
                    <div class="modal-title">Pembayaran Berhasil</div>
                </div>
                
                <div class="qris-info">
                    <div class="qris-info-row">
                        <span class="qris-info-label">Transaction ID</span>
                        <span class="qris-info-value" id="successTransactionId">TRX-983421</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Date</span>
                        <span class="qris-info-value" id="successTransactionDate">29 Jan 2026 14:32</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Payment Method</span>
                        <span class="qris-info-value">QRIS</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Merchant</span>
                        <span class="qris-info-value">SNEAKER ID</span>
                    </div>
                    <div class="qris-info-row">
                        <span class="qris-info-label">Items</span>
                        <span class="qris-info-value" id="successItemsInfo">NIKE FX AIR MAX x1</span>
                    </div>
                    <div class="qris-info-row" style="border-bottom: 2px solid #e0e0e0;">
                        <span class="qris-info-label">Total Payment</span>
                        <span class="qris-info-value total" id="successTotalPayment">Rp. 2.350.000</span>
                    </div>
                </div>
                
                <button class="qris-button" onclick="finalizeOrder()" style="background: #10b981; margin-top: 20px;">Selesai</button>
            </div>
        </div>
    </div>

    <!-- Hidden holder for QRIS data to avoid inline Blade in JS -->
    <div id="qrisDataHolder" data-qris="{{ $qrisCode ?? '00020126360014com.midtrans0215992092108152520400005303360406100710003024050302159207SNEAKER10300089701021000600009100520431005406500007627402231621234567890123456789012345678901263041D63047B7A' }}" style="display:none"></div>

    <!-- Success Modal (untuk COD) -->
    <div class="success-modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-icon">✓</div>
            <div class="success-title">Pesanan Berhasil!</div>
            <div class="success-subtitle" id="successMessage">
                Terima kasih telah berbelanja di SNEAKER ID
            </div>

            <div class="success-details">
                <div class="success-detail-row">
                    <span class="success-detail-label">Nomor Pesanan</span>
                    <span class="success-detail-value" id="successOrderId">ORD-123456</span>
                </div>
                <div class="success-detail-row">
                    <span class="success-detail-label">Metode Pembayaran</span>
                    <span class="success-detail-value" id="successPaymentMethod">COD</span>
                </div>
                <div class="success-detail-row">
                    <span class="success-detail-label">Total Pembayaran</span>
                    <span class="success-detail-value">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="success-detail-row">
                    <span class="success-detail-label">Tanggal Pesanan</span>
                    <span class="success-detail-value" id="successOrderDate">29 Jan 2026</span>
                </div>
            </div>

            <button class="success-button" onclick="closeSuccessAndRedirect()">Kembali ke Dashboard</button>
        </div>
    </div>

    <script>
        let qrisTimer = null;
        let timeRemaining = 14 * 60 + 59; // 14:59 in seconds
        let proofFileSelected = false;

        function generateTransactionID() {
            return 'TRX-' + Math.random().toString(36).substr(2, 6).toUpperCase();
        }

        const qrisImageUrl = (window.location.origin || '') + '/qris/qrcode.png';

        function generateQRCode() {
            const container = document.getElementById('qrcodeContainer');
            container.innerHTML = ''; // Clear previous QR code

            // Try to load user's uploaded QR image first (on-demand).
            const img = new Image();
            img.onload = function() {
                // image exists and loaded, append to container
                img.style.maxWidth = '250px';
                img.style.maxHeight = '250px';
                img.alt = 'QRIS';
                container.appendChild(img);
            };
            img.onerror = function() {
                // image not available or failed to load — fallback to generating QR from data
                const qrisHolder = document.getElementById('qrisDataHolder');
                const qrisData = (qrisHolder && qrisHolder.dataset && qrisHolder.dataset.qris) ? qrisHolder.dataset.qris : '00020126360014com.midtrans0215992092108152520400005303360406100710003024050302159207SNEAKER10300089701021000600009100520431005406500007627402231621234567890123456789012345678901263041D63047B7A';

                new QRCode(container, {
                    text: qrisData,
                    width: 250,
                    height: 250,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            };

            // Start loading the image (bust cache)
            img.src = qrisImageUrl + '?v=' + Date.now();
        }

        function openQRISModal() {
            console.log('Opening QRIS Modal');
            // Reset to QR step
            document.getElementById('qrisStep').style.display = 'block';
            document.getElementById('pendingStep').style.display = 'none';
            document.getElementById('successStep').style.display = 'none';
            document.getElementById('qrisModal').classList.add('active');
            try {
                generateQRCode();
            } catch (err) {
                console.error('generateQRCode error', err);
            }
            startTimer();
        }

        function closeQRISModal() {
            document.getElementById('qrisModal').classList.remove('active');
            if (qrisTimer) clearInterval(qrisTimer);
        }

        function startTimer() {
            if (qrisTimer) clearInterval(qrisTimer);
            timeRemaining = 14 * 60 + 59;

            qrisTimer = setInterval(() => {
                timeRemaining--;
                
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                document.getElementById('timer').textContent = 
                    String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                
                if (timeRemaining <= 0) {
                    clearInterval(qrisTimer);
                    alert('QR Code telah kadaluarsa. Silakan coba lagi.');
                    closeQRISModal();
                }
            }, 1000);
        }

        function completePayment() {
            if (qrisTimer) clearInterval(qrisTimer);
            
            // Generate transaction details
            const transactionId = generateTransactionID();
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' }) + ' ' + 
                           String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            
            // Update modal with transaction details
            document.getElementById('transactionId').textContent = transactionId;
            document.getElementById('transactionDate').textContent = dateStr;
            document.getElementById('totalPayment').textContent = "Rp. {{ number_format($total, 0, ',', '.') }}";
            
            // Get cart items info
            const itemsText = document.querySelectorAll('.item-name');
            let itemsInfo = '';
            itemsText.forEach((item, index) => {
                if (index < 2) {
                    itemsInfo += item.textContent.trim().substr(0, 20) + ' x1';
                    if (index < itemsText.length - 1 && index < 1) itemsInfo += ', ';
                }
            });
            if (itemsText.length > 2) itemsInfo += ` +${itemsText.length - 2} more`;
            document.getElementById('itemsInfo').textContent = itemsInfo || 'NIKE FX AIR MAX x1';
            
            // Reset file upload
            proofFileSelected = false;
            document.getElementById('proofFile').value = '';
            document.getElementById('previewImage').src = '';
            document.getElementById('previewImage').style.display = 'none';
            document.getElementById('uploadIcon').style.display = 'block';
            document.getElementById('uploadText').style.display = 'block';
            document.getElementById('submitProofBtn').disabled = true;
            document.getElementById('submitProofBtn').style.opacity = '0.5';
            document.getElementById('submitProofBtn').style.cursor = 'not-allowed';
            
            // Reset success step
            document.getElementById('successStep').style.display = 'none';
            
            // Switch from QR step to pending step
            document.getElementById('qrisStep').style.display = 'none';
            document.getElementById('pendingStep').style.display = 'block';
        }

        function submitPaymentProof() {
            if (!proofFileSelected) {
                alert('Silakan upload bukti pembayaran terlebih dahulu');
                return;
            }
            
            // Get current transaction details from pending step
            const transactionId = document.getElementById('transactionId').textContent;
            const transactionDate = document.getElementById('transactionDate').textContent;
            const itemsInfo = document.getElementById('itemsInfo').textContent;
            const totalPayment = document.getElementById('totalPayment').textContent;
            
            // Update success step with same details
            document.getElementById('successTransactionId').textContent = transactionId;
            document.getElementById('successTransactionDate').textContent = transactionDate;
            document.getElementById('successItemsInfo').textContent = itemsInfo;
            document.getElementById('successTotalPayment').textContent = totalPayment;
            
            // Switch from pending step to success step
            document.getElementById('pendingStep').style.display = 'none';
            document.getElementById('successStep').style.display = 'block';
        }

        function finalizeOrder() {
            // Close modal
            closeQRISModal();
            
            // Redirect to dashboard immediately
            setTimeout(() => {
                window.location.href = '{{ route("dashboard") }}';
            }, 300);
        }

        function createOrder() {
            const agreeTerms = document.getElementById('agree-terms').checked;
            
            if (!agreeTerms) {
                alert('Silakan setujui Syarat & Ketentuan untuk melanjutkan');
                return;
            }
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            // Show success modal with order details
            const orderId = 'ORD-' + Math.random().toString(36).substr(2, 6).toUpperCase();
            const today = new Date();
            const dateStr = today.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            
            document.getElementById('successOrderId').textContent = orderId;
            document.getElementById('successPaymentMethod').textContent = paymentMethod.toUpperCase();
            document.getElementById('successOrderDate').textContent = dateStr;
            
            if (paymentMethod === 'qris') {
                document.getElementById('successMessage').textContent = 'Pesanan QRIS Anda telah kami terima. Mohon tunggu konfirmasi pembayaran.';
            } else {
                document.getElementById('successMessage').textContent = 'Pesanan COD Anda telah kami terima. Driver kami akan segera menghubungi Anda.';
            }
            
            // Show modal
            document.getElementById('successModal').classList.add('active');
        }

        function closeSuccessAndRedirect() {
            window.location.href = '{{ route("dashboard") }}';
        }

        // Handle file selection
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('proofFile');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file type
                        if (!file.type.startsWith('image/')) {
                            alert('Silakan pilih file gambar');
                            this.value = '';
                            return;
                        }
                        
                        // Validate file size (max 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Ukuran file tidak boleh lebih dari 5MB');
                            this.value = '';
                            return;
                        }
                        
                        // Show preview
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('previewImage').src = event.target.result;
                            document.getElementById('previewImage').style.display = 'block';
                            document.getElementById('uploadIcon').style.display = 'none';
                            document.getElementById('uploadText').style.display = 'none';
                            
                            // Enable submit button
                            proofFileSelected = true;
                            document.getElementById('submitProofBtn').disabled = false;
                            document.getElementById('submitProofBtn').style.opacity = '1';
                            document.getElementById('submitProofBtn').style.cursor = 'pointer';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            console.log('DOM Loaded');
            
            // Handle payment method selection: enable 'Lanjut' only after a choice
            const proceedBtn = document.getElementById('proceedBtn');
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.payment-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    this.closest('.payment-option').classList.add('selected');

                    // Enable the proceed button
                    if (proceedBtn) {
                        proceedBtn.disabled = false;
                        proceedBtn.style.opacity = '1';
                        proceedBtn.style.cursor = 'pointer';
                    }
                });
            });

            // Handle proceed button click: open QRIS only after user confirms by clicking 'Lanjut'
            if (proceedBtn) {
                proceedBtn.addEventListener('click', function(e) {
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                    if (!paymentMethod) {
                        alert('Silakan pilih metode pembayaran terlebih dahulu');
                        return;
                    }

                    if (paymentMethod.value === 'qris') {
                        openQRISModal();
                        return;
                    }

                    // For COD or other methods, create order immediately
                    createOrder();
                });
            }
        });
    </script>
</body>
</html>
