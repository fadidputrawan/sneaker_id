{{-- @var App\Models\User $user --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - Sneaker ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
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
        
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 3px solid #000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: #000 !important;
        }
        
        .container-fluid {
            padding: 0;
        }
        
        .profile-wrapper {
            display: flex;
            min-height: calc(100vh - 80px);
        }
        
        .sidebar {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 30px 0;
            min-height: calc(100vh - 80px);
            position: sticky;
            top: 80px;
        }
        
        .sidebar h5 {
            color: #fff;
            padding: 0 20px 20px 20px;
            font-weight: 700;
            border-bottom: 2px solid rgba(255,255,255,0.2);
            margin-bottom: 0;
        }
        
        .sidebar-menu {
            list-style: none;
            margin-top: 20px;
        }
        
        .sidebar-menu li {
            margin: 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 15px;
        }
        
        .sidebar-menu a:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: #ffc107;
        }
        
        .sidebar-menu a.active {
            background-color: #ffc107;
            color: #1a1a1a;
            font-weight: 600;
            border-left-color: #ffc107;
        }
        
        .sidebar-menu i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        .profile-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }
        
        .profile-header {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .profile-header h2 {
            color: #1a1a1a;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .profile-header p {
            color: #666;
            margin-bottom: 0;
            font-size: 14px;
        }
        
        .info-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .info-card h5 {
            color: #1a1a1a;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ffc107;
            display: inline-block;
        }
        
        .info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }
        
        .info-item label {
            display: block;
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .info-item p {
            color: #1a1a1a;
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }
        
        .info-item p.empty {
            color: #ccc;
            font-style: italic;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #1a1a1a;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .btn-edit:hover {
            background-color: #ffb300;
            color: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,193,7,0.3);
        }
        

        
        @media (max-width: 768px) {
            .profile-wrapper {
                flex-direction: column;
            }
            
            .sidebar {
                min-height: auto;
                display: flex;
                flex-direction: row;
                padding: 15px;
                overflow-x: auto;
                border-bottom: 1px solid #ddd;
            }
            
            .sidebar h5 {
                display: none;
            }
            
            .sidebar-menu {
                display: flex;
                flex-direction: row;
                margin-top: 0;
                width: 100%;
            }
            
            .sidebar-menu a {
                padding: 10px 15px;
                white-space: nowrap;
            }
            
            .profile-content {
                padding: 20px;
            }
            
            .info-row {
                grid-template-columns: 1fr;
            }
            
            .profile-header {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-shoe-prints"></i> Sneaker ID
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <span class="me-3">{{ $user->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="profile-wrapper">
        <!-- SIDEBAR -->
        <div class="sidebar col-md-3">
            <h5><i class="fas fa-user-circle"></i> Akun Saya</h5>
            <ul class="sidebar-menu">
                <li><a href="{{ route('profile') }}" class="active">
                    <i class="fas fa-user"></i> Informasi Akun
                </a></li>
                <li><a href="{{ route('dashboard') }}">
                    <i class="fas fa-shopping-bag"></i> Pesanan
                </a></li>
                <li><a href="{{ route('wishlist') }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a></li>
                <li><a href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                </a></li>
            </ul>
        </div>

        <!-- CONTENT -->
        <div class="profile-content col-md-9">
            <div class="profile-header">
                <h2>Profil Akun</h2>
                <p>Kelola informasi akun dan pengaturan pribadi Anda</p>
            </div>

            <!-- Informasi Kontak -->
            <div class="info-card">
                <h5><i class="fas fa-id-card"></i> Informasi Kontak</h5>
                <div class="info-row">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-item">
                        <label>Nomor Telepon</label>
                        <p class="{{ !$user->phone ? 'empty' : '' }}">
                            {{ $user->phone ?? 'Belum diisi' }}
                        </p>
                    </div>
                    <div class="info-item">
                        <label>Role</label>
                        <p><span class="badge bg-info">{{ ucfirst($user->role ?? 'user') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Informasi Alamat -->
            <div class="info-card">
                <h5><i class="fas fa-map-marker-alt"></i> Informasi Alamat</h5>
                <div class="info-row">
                    <div class="info-item">
                        <label>Alamat</label>
                        <p class="{{ !$user->address ? 'empty' : '' }}">
                            {{ $user->address ?? 'Belum diisi' }}
                        </p>
                    </div>
                    <div class="info-item">
                        <label>Kota</label>
                        <p class="{{ !$user->city ? 'empty' : '' }}">
                            {{ $user->city ?? 'Belum diisi' }}
                        </p>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-item">
                        <label>Kode Pos</label>
                        <p class="{{ !$user->postal_code ? 'empty' : '' }}">
                            {{ $user->postal_code ?? 'Belum diisi' }}
                        </p>
                    </div>
                    <div class="info-item">
                        <label>Negara</label>
                        <p class="{{ !$user->country ? 'empty' : '' }}">
                            {{ $user->country ?? 'Belum diisi' }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('profile.edit-address') }}" class="btn btn-edit">
                    <i class="fas fa-map-marker-alt"></i> Tambah Alamat
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
