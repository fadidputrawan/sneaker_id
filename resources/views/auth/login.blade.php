<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sneaker ID</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(200, 200, 200, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        body::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(220, 220, 220, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 40px rgba(255, 0, 110, 0.2);
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.6s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #999, #666);
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #f0f0f0;
            padding: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: #999;
            box-shadow: 0 0 0 3px rgba(150, 150, 150, 0.1);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            border-left: 4px solid #999;
        }

        .btn-login {
            background: linear-gradient(135deg, #888 0%, #666 100%);
            color: white;
            border: none;
            padding: 13px;
            font-weight: 700;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(100, 100, 100, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(100, 100, 100, 0.4);
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, #777 0%, #555 100%);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .auth-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .auth-links p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .auth-links a {
            color: #666;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #666;
            transition: width 0.3s ease;
        }

        .auth-links a:hover::after {
            width: 100%;
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }

            .login-header h2 {
                font-size: 24px;
            }

            body::before {
                width: 200px;
                height: 200px;
            }

            body::after {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-shoe-prints"></i> SNEAKER ID</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        @if(session('login_error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('login_error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email"
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       placeholder="nama@example.com" 
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password"
                       name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Masukkan password Anda" 
                       required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>MASUK SEKARANG
            </button>
        </form>

        <div class="auth-links">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>