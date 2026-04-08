<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
        body{background:#f4f6f9;color:#333;min-height:100vh}
        .container{width:100%;min-height:100vh;display:flex;background:transparent;}
        .sidebar{width:240px;background:#f8f9fa;padding:30px 20px;border-right:1px solid #dde2e6;}
        .logo{font-size:18px;font-weight:bold;margin-bottom:35px;color:#1f2937}
        .menu a{display:block;padding:12px 14px;text-decoration:none;color:#1f2937;margin-bottom:8px;border-radius:8px;transition:0.2s;}
        .menu a:hover{background:#e2e8f0}
        .menu a.active{background:#dbeafe;font-weight:700;border-left:4px solid #2563eb;color:#111827}
        .main{flex:1;padding:30px 35px;}
        .topbar{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:25px;flex-wrap:wrap}
        .cards{display:flex;flex-wrap:wrap;gap:20px;margin-bottom:25px}
        .card{flex:1;min-width:180px;background:#fff;padding:22px;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,0.08);text-align:center}
        .card h4{font-size:14px;margin-bottom:10px;color:#6b7280}
        .card p{font-size:24px;font-weight:700;color:#111827}

        .content-header{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:18px;flex-wrap:wrap}
        .content-header h4{margin:0;font-size:18px;color:#111827}
        .btn-add{background:#2563eb;color:white;padding:11px 22px;border:none;border-radius:10px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-weight:600;box-shadow:0 8px 20px rgba(37,99,235,0.12)}
        .btn-add:hover{background:#1d4ed8}

        .table-box{background:#fff;padding:22px;border-radius:16px;box-shadow:0 10px 30px rgba(15,23,42,0.06)}
        table{width:100%;border-collapse:collapse;margin-top:18px}
        th,td{padding:14px 12px;text-align:left;border-bottom:1px solid #e5e7eb;font-size:14px;vertical-align:middle}
        th{background:#f8fafc;font-weight:700;color:#111827}
        tr:hover{background:#f8fafc}

        .product-image{width:60px;height:60px;border-radius:10px;overflow:hidden;background:#eff6ff;display:flex;align-items:center;justify-content:center}
        .product-image img{width:100%;height:100%;object-fit:cover}
        .no-image{color:#9ca3af;font-size:22px}

        .actions{display:flex;gap:8px;align-items:center;justify-content:flex-start;}
        .actions a,.actions button{display:inline-flex;align-items:center;justify-content:center;gap:6px;height:30px;padding:0 11px;border-radius:7px;font-size:12px;line-height:1.1;box-sizing:border-box;transition:0.3s;outline:none;border:1px solid transparent}
        .btn-edit{background:#2563eb;color:white;border-color:#2563eb;}
        .btn-edit:hover{background:#1d4ed8;border-color:#1d4ed8;box-shadow:0 5px 12px rgba(37,99,235,0.18)}
        .btn-delete{background:#ef4444;color:white;border-color:#ef4444;}
        .btn-delete:hover{background:#dc2626;border-color:#dc2626;box-shadow:0 5px 12px rgba(239,68,68,0.18)}

        .table-box table td:last-child{white-space:nowrap;border-bottom:none;}
        .table-box table th:nth-child(1),.table-box table td:nth-child(1){width:80px}
        .table-box table th:nth-child(5),.table-box table td:nth-child(5){width:120px}
        .table-box table th:nth-child(6),.table-box table td:nth-child(6){width:180px}

        .product-image{width:60px;height:60px;border-radius:5px;overflow:hidden;background:#f0f0f0;display:flex;align-items:center;justify-content:center}
        .product-image img{width:100%;height:100%;object-fit:cover}
        .no-image{color:#999;font-size:24px}

        .actions{display:flex;gap:8px;align-items:center;justify-content:center}
        .btn-edit,.btn-delete{display:inline-flex;align-items:center;justify-content:center;gap:6px;height:36px;padding:0 14px;border-radius:6px;font-size:13px;line-height:1;box-sizing:border-box;transition:0.3s;outline:none}
        .btn-edit{background:#007bff;color:white;border:1px solid #007bff;text-decoration:none;}
        .btn-edit:hover{background:#0056b3;border-color:#0056b3;box-shadow:0 2px 5px rgba(0,123,255,0.3)}
        .btn-delete{background:#dc3545;color:white;border:1px solid #dc3545;}
        .btn-delete:hover{background:#c82333;border-color:#c82333;box-shadow:0 2px 5px rgba(220,53,69,0.3)}

        /* Modal Styles */
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000}
        .modal-content{background:white;margin:5% auto;padding:0;width:90%;max-width:600px;border-radius:10px;max-height:90vh;overflow-y:auto}
        .modal-header{background:#f8f9fa;padding:20px;border-bottom:1px solid #dee2e6;border-radius:10px 10px 0 0;display:flex;justify-content:space-between;align-items:center}
        .modal-title{margin:0;font-size:20px}
        .close{cursor:pointer;font-size:24px;color:#6c757d}
        .modal-body{padding:20px}
        .form-group{margin-bottom:15px}
        .form-group label{display:block;margin-bottom:5px;font-weight:500}
        .form-group input,.form-group textarea,.form-group select{width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:14px}
        .form-group textarea{resize:vertical;min-height:80px}

        /* Image Upload Styles */
        .image-upload-section{margin-top:20px;padding-top:20px;border-top:1px solid #eee}
        .image-upload-section h4{margin-bottom:15px;color:#333}
        .image-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:15px;margin-bottom:15px}
        .image-slot{border:2px dashed #ddd;border-radius:8px;width:120px;height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;transition:all 0.3s;position:relative;overflow:hidden}
        .image-slot:hover{border-color:#007bff;background:#f8f9ff}
        .image-slot img{width:100%;height:100%;object-fit:cover;border-radius:6px}
        .image-slot .upload-icon{color:#999;font-size:24px;margin-bottom:5px}
        .image-slot .upload-text{color:#999;font-size:12px;text-align:center}
        .image-slot.filled{border-color:#28a745}
        .remove-image{position:absolute;top:5px;right:5px;background:#dc3545;color:white;border:none;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:12px;cursor:pointer}
        .remove-image:hover{background:#c82333}

        .modal-footer{background:#f8f9fa;padding:20px;border-top:1px solid #dee2e6;border-radius:0 0 10px 10px;text-align:right}
        .btn-save{background:#28a745;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin-left:10px}
        .btn-save:hover{background:#218838}
        .btn-cancel{background:#6c757d;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer}
        .btn-cancel:hover{background:#5a6268}

        .logout{color:red;text-decoration:none;font-size:14px}
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo">SNEAKER ID</div>
        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.produk.index') }}" class="{{ request()->is('admin/produk*') ? 'active' : '' }}">Kelola Produk</a>
            <a href="{{ route('admin.pesanan.index') }}" class="{{ request()->is('admin/pesanan*') ? 'active' : '' }}">Kelola Pesanan</a>
            <a href="{{ route('admin.user.index') }}" class="{{ request()->is('admin/user*') ? 'active' : '' }}">Kelola User</a>
            <a href="{{ route('admin.petugas.index') }}" class="{{ request()->is('admin/petugas*') ? 'active' : '' }}">Kelola Petugas</a>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <h2>Kelola Produk</h2>
            <div>Admin | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
        </div>

        <div class="cards">
            <div class="card"><h4>Total Produk</h4><p>{{ $totalProduk }}</p></div>
            <div class="card"><h4>Total Pesanan</h4><p>{{ $totalPesanan }}</p></div>
            <div class="card"><h4>Pendapatan</h4><p>Rp {{ number_format($pendapatan,0,',','.') }}</p></div>
            <div class="card"><h4>User Aktif</h4><p>{{ $totalUser }}</p></div>
        </div>

        <div class="table-box">
            <div class="content-header">
                <h4>Daftar Produk</h4>
                <a href="#" class="btn-add" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Tambah Produk
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Brand</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $p)
                    <tr>
                        <td>
                            <div class="product-image">
                                @php
                                    $images = json_decode($p->images ?? '[]', true) ?: [];
                                    if (empty($images) && !empty($p->image)) {
                                        $images[] = $p->image;
                                    }
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $p->nama }}">
                                @else
                                    <i class="fas fa-image no-image"></i>
                                @endif
                            </div>
                        </td>
                        <td>{{ $p->nama }}</td>
                        <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                        <td>{{ $p->stok ?? '-' }}</td>
                        <td>{{ $p->brand ?? '-' }}</td>
                        <td class="actions">
                            <button type="button" class="btn-edit" onclick='editProduct({{ $p->id }}, @json($p->nama), {{ $p->harga }}, {{ $p->stok ?? 0 }}, @json($p->brand ?? ''), @json($p->image ?? ""))'>
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn-delete" onclick='deleteProduct({{ $p->id }}, @json($p->nama))'>
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Produk -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Tambah Produk</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama">Nama Produk *</label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="harga">Harga *</label>
                    <input type="number" id="harga" name="harga" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stok">Stok *</label>
                    <input type="number" id="stok" name="stok" min="0" required>
                </div>

                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"></textarea>
                </div>

                <!-- Image Upload Section -->
                <div class="image-upload-section">
                    <h4>Foto Produk (Minimal 5 foto)</h4>
                    <div class="image-grid" id="imageGrid">
                        @for($i = 1; $i <= 8; $i++)
                            <div class="image-slot" onclick="document.getElementById('imageInput{{ $i }}').click()">
                                <i class="fas fa-camera upload-icon"></i>
                                <span class="upload-text">Foto {{ $i }}</span>
                                <input type="file" id="imageInput{{ $i }}" name="images[]" accept="image/*" style="display:none" onchange="previewImage(this, {{ $i }})">
                            </div>
                        @endfor
                    </div>
                    <small style="color:#666">Klik pada slot kosong untuk mengupload foto. Minimal 5 foto diperlukan.</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save" id="saveBtn">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content" style="max-width:400px">
        <div class="modal-header">
            <h2 class="modal-title">Konfirmasi Hapus</h2>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus produk "<span id="deleteProductName"></span>"?</p>
            <p style="color:#dc3545;margin-top:10px"><strong>Perhatian: Tindakan ini tidak dapat dibatalkan!</strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn-delete" id="confirmDeleteBtn" style="background:#dc3545;border:none;padding:10px 20px;border-radius:5px;color:white;cursor:pointer">Hapus</button>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>

<script>
let currentProductId = null;
let uploadedImages = [];
let deleteProductId = null;

// Modal functions
function openModal(productId = null) {
    document.getElementById('productModal').style.display = 'block';
    if (productId) {
        document.getElementById('modalTitle').textContent = 'Edit Produk';
        // Load product data will be handled by editProduct function
    } else {
        document.getElementById('modalTitle').textContent = 'Tambah Produk';
        resetForm();
    }
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
    resetForm();
}

function resetForm() {
    document.getElementById('productForm').reset();
    document.getElementById('productForm').action = '{{ route("admin.produk.store") }}';
    document.getElementById('productForm').method = 'POST';
    currentProductId = null;
    uploadedImages = [];

    // Reset image slots
    const slots = document.querySelectorAll('.image-slot');
    slots.forEach((slot, index) => {
        const slotNumber = index + 1;
        slot.classList.remove('filled');
        slot.innerHTML = `
            <i class="fas fa-camera upload-icon"></i>
            <span class="upload-text">Foto ${slotNumber}</span>
            <input type="file" id="imageInput${slotNumber}" name="images[]" accept="image/*" style="display:none" onchange="previewImage(this, ${slotNumber})">
        `;
        slot.onclick = function() {
            document.getElementById(`imageInput${slotNumber}`).click();
        };
    });
}

function editProduct(id, nama, harga, stok, brand, image) {
    currentProductId = id;
    document.getElementById('nama').value = nama;
    document.getElementById('harga').value = harga;
    document.getElementById('stok').value = stok;
    document.getElementById('brand').value = brand;

    // Set form action for update
    document.getElementById('productForm').action = `/admin/produk/${id}`;
    document.getElementById('productForm').method = 'POST';

    // Add method spoofing for PUT
    let methodInput = document.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('productForm').appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    openModal(id);
}

function deleteProduct(id, name) {
    deleteProductId = id;
    document.getElementById('deleteProductName').textContent = name;
    document.getElementById('deleteModal').style.display = 'block';
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteProductId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/produk/${deleteProductId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
});

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    deleteProductId = null;
}

// Image preview function
function previewImage(input, slotNumber) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            input.value = '';
            return;
        }

        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5MB!');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const slot = input.closest('.image-slot');
            slot.innerHTML = '';

            const previewImg = document.createElement('img');
            previewImg.src = e.target.result;
            previewImg.alt = 'Preview';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-image';
            removeBtn.textContent = '×';
            removeBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                removeImage(slotNumber);
            });

            slot.appendChild(previewImg);
            slot.appendChild(removeBtn);
            slot.appendChild(input);
            input.style.display = 'none';
            slot.classList.add('filled');
            uploadedImages[slotNumber - 1] = file;
            slot.onclick = function() {
                input.click();
            };
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(slotNumber) {
    const slot = document.querySelectorAll('.image-slot')[slotNumber - 1];
    const fileInput = slot.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.value = '';
    }

    slot.classList.remove('filled');
    slot.innerHTML = `
        <i class="fas fa-camera upload-icon"></i>
        <span class="upload-text">Foto ${slotNumber}</span>
    `;
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.id = `imageInput${slotNumber}`;
    newInput.name = 'images[]';
    newInput.accept = 'image/*';
    newInput.style.display = 'none';
    newInput.onchange = function() {
        previewImage(this, slotNumber);
    };

    slot.appendChild(newInput);
    slot.onclick = function() {
        newInput.click();
    };
    uploadedImages[slotNumber - 1] = null;
}

// Form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    const filledSlots = document.querySelectorAll('.image-slot.filled').length;

    if (!currentProductId && filledSlots < 5) {
        e.preventDefault();
        alert('Minimal 5 foto produk harus diupload!');
        return;
    }

    if (currentProductId && filledSlots > 0 && filledSlots < 5) {
        e.preventDefault();
        alert('Jika ingin mengganti foto produk, unggah minimal 5 foto!');
        return;
    }

    // Show loading state
    const saveBtn = document.getElementById('saveBtn');
    saveBtn.textContent = 'Menyimpan...';
    saveBtn.disabled = true;
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    const deleteModal = document.getElementById('deleteModal');
    if (event.target == modal) {
        closeModal();
    }
    if (event.target == deleteModal) {
        closeDeleteModal();
    }
}
</script>
</body>
</html>