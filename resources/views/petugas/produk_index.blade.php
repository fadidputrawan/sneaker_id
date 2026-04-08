<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - Petugas</title>
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
        .actions a,.actions button{display:inline-flex;align-items:center;justify-content:center;gap:6px;height:30px;padding:0 11px;border-radius:7px;font-size:12px;line-height:1.1;box-sizing:border-box;transition:0.3s;outline:none;border:1px solid transparent;cursor:pointer;pointer-events:auto;position:relative;z-index:1}
        .btn-edit{background:#2563eb;color:white;border-color:#2563eb;cursor:pointer}
        .btn-edit:hover{background:#1d4ed8;border-color:#1d4ed8;box-shadow:0 5px 12px rgba(37,99,235,0.18)}
        .btn-delete{background:#ef4444;color:white;border-color:#ef4444;cursor:pointer}
        .btn-delete:hover{background:#dc2626;border-color:#dc2626;box-shadow:0 5px 12px rgba(239,68,68,0.18)}

        .table-box table td:last-child{white-space:nowrap;border-bottom:none;}
        .table-box table th:nth-child(1),.table-box table td:nth-child(1){width:80px}
        .table-box table th:nth-child(5),.table-box table td:nth-child(5){width:120px}
        .table-box table th:nth-child(6),.table-box table td:nth-child(6){width:180px}

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
        .image-slot:hover{border-color:#2563eb;background:#f8f9ff}
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

        .alert{margin-bottom:18px;padding:14px 16px;border-radius:10px}
        .alert.success{background:#d1fae5;color:#065f46}
        .alert.error{background:#fee2e2;color:#991b1b}
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo">SNEAKER ID</div>
        <div class="menu">
            <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('petugas.produk.index') }}" class="{{ request()->is('petugas/produk*') ? 'active' : '' }}">Kelola Produk</a>
            <a href="{{ route('petugas.pesanan.index') }}" class="{{ request()->is('petugas/pesanan*') ? 'active' : '' }}">Kelola Pesanan</a>
            <a href="{{ route('petugas.laporan') }}" class="{{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">Laporan</a>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <h2>Kelola Produk</h2>
            <div>Petugas | <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <div class="cards">
            <div class="card"><h4>Total Produk</h4><p>{{ $totalProduk }}</p></div>
            <div class="card"><h4>Total Pesanan</h4><p>{{ $totalPesanan }}</p></div>
            <div class="card"><h4>Pendapatan</h4><p>Rp {{ number_format($pendapatan,0,',','.') }}</p></div>
            <div class="card"><h4>User Aktif</h4><p>{{ $totalUser }}</p></div>
        </div>

        <div class="table-box">
            <div class="content-header">
                <h4>Daftar Produk</h4>
                <button class="btn-add" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Tambah Produk
                </button>
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
                                    $images = is_array($p->images) ? $p->images : (json_decode($p->images, true) ?? []);
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('uploads/' . $firstImage) }}" alt="{{ $p->nama }}">
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
                            <button type="button" class="btn-edit" onclick="editProductFromButton(this)" data-id="{{ $p->id }}" data-nama="@json($p->nama)" data-harga="{{ $p->harga }}" data-stok39="{{ $p->stok_39 ?? 0 }}" data-stok40="{{ $p->stok_40 ?? 0 }}" data-stok41="{{ $p->stok_41 ?? 0 }}" data-stok42="{{ $p->stok_42 ?? 0 }}" data-stok43="{{ $p->stok_43 ?? 0 }}" data-stok44="{{ $p->stok_44 ?? 0 }}" data-brand="@json($p->brand ?? '')" data-deskripsi="@json($p->deskripsi ?? '')" data-images="@json($p->images ?? [])">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn-delete" onclick="deleteProductFromButton(this)" data-id="{{ $p->id }}" data-nama="@json($p->nama)">
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
                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Stok Per Ukuran</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                        <div>
                            <label for="stok_39" style="font-size: 12px;">Ukuran 39</label>
                            <input type="number" id="stok_39" name="stok_39" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                        <div>
                            <label for="stok_40" style="font-size: 12px;">Ukuran 40</label>
                            <input type="number" id="stok_40" name="stok_40" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                        <div>
                            <label for="stok_41" style="font-size: 12px;">Ukuran 41</label>
                            <input type="number" id="stok_41" name="stok_41" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                        <div>
                            <label for="stok_42" style="font-size: 12px;">Ukuran 42</label>
                            <input type="number" id="stok_42" name="stok_42" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                        <div>
                            <label for="stok_43" style="font-size: 12px;">Ukuran 43</label>
                            <input type="number" id="stok_43" name="stok_43" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                        <div>
                            <label for="stok_44" style="font-size: 12px;">Ukuran 44</label>
                            <input type="number" id="stok_44" name="stok_44" min="0" value="0" style="width: 100%;" onchange="updateTotalStock()">
                        </div>
                    </div>
                    <div style="background: #f0f0f0; padding: 10px; border-radius: 5px; margin-top: 15px; text-align: center;">
                        <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Total Stok (Auto-Calculate)</div>
                        <div style="font-size: 24px; font-weight: bold; color: #333;" id="totalStockDisplay">0</div>
                        <input type="hidden" id="stok" name="stok" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"></textarea>
                </div>

                <div class="image-upload-section">
                    <h4>Foto Produk (Minimal 5 foto)</h4>
                    <div class="image-grid" id="imageGrid">
                        @for($i = 1; $i <= 8; $i++)
                            <div class="image-slot" data-input-id="{{ $i }}" onclick="document.getElementById('imageInput' + this.dataset.inputId).click()">
                                <i class="fas fa-camera upload-icon"></i>
                                <span class="upload-text">Foto {{ $i }}</span>
                                <input type="file" id="imageInput{{ $i }}" name="images[]" accept="image/*" style="display:none" data-slot="{{ $i }}" onchange="previewImage(this, parseInt(this.dataset.slot))">
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
<form id="deleteForm" method="POST" style="display:none;">@csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

<script>
let currentProductId = null;
let deleteProductId = null;

function parseData(value) {
    if (value === null || value === undefined) return null;
    try {
        return JSON.parse(value);
    } catch (e) {
        return value;
    }
}

function openModal() {
    document.getElementById('productModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Tambah Produk';
    resetForm();
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
    resetForm();
}

function updateTotalStock() {
    const stok39 = parseInt(document.getElementById('stok_39').value) || 0;
    const stok40 = parseInt(document.getElementById('stok_40').value) || 0;
    const stok41 = parseInt(document.getElementById('stok_41').value) || 0;
    const stok42 = parseInt(document.getElementById('stok_42').value) || 0;
    const stok43 = parseInt(document.getElementById('stok_43').value) || 0;
    const stok44 = parseInt(document.getElementById('stok_44').value) || 0;
    
    const totalStock = stok39 + stok40 + stok41 + stok42 + stok43 + stok44;
    
    document.getElementById('totalStockDisplay').textContent = totalStock;
    document.getElementById('stok').value = totalStock;
}

function resetForm() {
    document.getElementById('productForm').reset();
    document.getElementById('productForm').action = '{{ route("petugas.produk.store") }}';
    document.getElementById('productForm').method = 'POST';
    
    // Remove _method input if exists
    const methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();
    
    currentProductId = null;
    updateTotalStock();

    const slots = document.querySelectorAll('.image-slot');
    slots.forEach((slot, index) => {
        const slotNumber = index + 1;
        slot.classList.remove('filled');
        slot.innerHTML = `
            <i class="fas fa-camera upload-icon"></i>
            <span class="upload-text">Foto ${slotNumber}</span>
            <input type="file" id="imageInput${slotNumber}" name="images[]" accept="image/*" style="display:none" data-slot="${slotNumber}" onchange="previewImage(this, ${slotNumber})">
        `;
        slot.onclick = function() {
            document.getElementById(`imageInput${slotNumber}`).click();
        };
    });
}

function editProductFromButton(button) {
    const id = button.getAttribute('data-id');
    const nama = parseData(button.getAttribute('data-nama'));
    const harga = parseInt(button.getAttribute('data-harga'));
    const stok39 = parseInt(button.getAttribute('data-stok39'));
    const stok40 = parseInt(button.getAttribute('data-stok40'));
    const stok41 = parseInt(button.getAttribute('data-stok41'));
    const stok42 = parseInt(button.getAttribute('data-stok42'));
    const stok43 = parseInt(button.getAttribute('data-stok43'));
    const stok44 = parseInt(button.getAttribute('data-stok44'));
    const brand = parseData(button.getAttribute('data-brand'));
    const deskripsi = parseData(button.getAttribute('data-deskripsi'));
    let images = parseData(button.getAttribute('data-images'));
    if (typeof images === 'string' && images.startsWith('[')) {
        images = parseData(images);
    }

    currentProductId = id;
    document.getElementById('nama').value = nama;
    document.getElementById('harga').value = harga;
    document.getElementById('stok_39').value = stok39;
    document.getElementById('stok_40').value = stok40;
    document.getElementById('stok_41').value = stok41;
    document.getElementById('stok_42').value = stok42;
    document.getElementById('stok_43').value = stok43;
    document.getElementById('stok_44').value = stok44;
    document.getElementById('brand').value = brand;
    document.getElementById('deskripsi').value = deskripsi;

    if (images && Array.isArray(images)) {
        images.forEach((image, index) => {
            if (index < 8) {
                const slotNumber = index + 1;
                const slot = document.querySelector(`.image-slot:nth-child(${slotNumber})`);
                if (slot) {
                    slot.classList.add('filled');
                    slot.innerHTML = `
                        <img src="{{ asset('uploads/') }}/${image}" alt="Foto ${slotNumber}" style="width:100%;height:100%;object-fit:cover;border-radius:5px;">
                        <button type="button" class="remove-image" onclick="event.stopPropagation(); removeImageSlot(${slotNumber})">×</button>
                        <input type="file" id="imageInput${slotNumber}" name="images[]" accept="image/*" style="display:none" data-slot="${slotNumber}" onchange="previewImage(this, ${slotNumber})">
                    `;
                }
            }
        });
    }

    updateTotalStock();
    document.getElementById('productForm').action = `/petugas/produk/${id}`;
    
    let methodInput = document.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('productForm').appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    document.getElementById('modalTitle').textContent = 'Edit Produk';
    openModal();
}

function deleteProductFromButton(button) {
    const id = button.getAttribute('data-id');
    const name = parseData(button.getAttribute('data-nama'));
    deleteProductId = id;
    document.getElementById('deleteProductName').textContent = name;
    document.getElementById('deleteModal').style.display = 'block';
}

function removeImageSlot(slotNumber) {
    const slot = document.querySelector(`.image-slot:nth-child(${slotNumber})`);
    if (slot) {
        slot.classList.remove('filled');
        slot.innerHTML = `
            <i class="fas fa-camera upload-icon"></i>
            <span class="upload-text">Foto ${slotNumber}</span>
            <input type="file" id="imageInput${slotNumber}" name="images[]" accept="image/*" style="display:none" data-slot="${slotNumber}" onchange="previewImage(this, ${slotNumber})">
        `;
        slot.onclick = function() {
            document.getElementById(`imageInput${slotNumber}`).click();
        };
    }
}

function previewImage(input, slotNumber) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            input.value = '';
            return;
        }

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
            previewImg.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:5px;';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-image';
            removeBtn.textContent = '×';
            removeBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                removeImageSlot(slotNumber);
            });

            slot.appendChild(previewImg);
            slot.appendChild(removeBtn);
            slot.appendChild(input);
            input.style.display = 'none';
            slot.classList.add('filled');
        };
        reader.readAsDataURL(file);
    }
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteProductId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/petugas/produk/${deleteProductId}`;

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

window.onclick = function(event) {
    const productModal = document.getElementById('productModal');
    const deleteModal = document.getElementById('deleteModal');
    if (event.target == productModal) {
        closeModal();
    }
    if (event.target == deleteModal) {
        closeDeleteModal();
    }
}
</script>
</body>
</html>
