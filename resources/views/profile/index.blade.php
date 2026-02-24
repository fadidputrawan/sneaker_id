<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar bg-light px-4">
    <h4>SNEAKER ID</h4>

    <div>
        <a href="/profile">Profil</a> |
        <a href="/logout">Logout</a>
    </div>
</nav>

<div class="container mt-5">

    <h3>INFORMASI AKUN & ALAMAT</h3>
    <hr>

    <h5>Informasi Kontak</h5>
    <p>Nama : {{ $user->name }}</p>
    <p>Email : {{ $user->email }}</p>

    <h5 class="mt-4">Informasi Alamat</h5>
    <p>Alamat belum diisi</p>

</div>

</body>
</html>
