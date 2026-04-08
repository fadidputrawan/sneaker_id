<?php
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

function ensureUser($email, $name, $role, $password) {
    $user = User::where('email', $email)->first();
    if ($user) {
        echo "User {$email} already exists (id={$user->id}).\n";
        return $user;
    }

    $user = User::create([
        'name' => $name,
        'email' => $email,
        'phone' => '081234567890',
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'role' => $role,
    ]);

    echo "Created user {$email} (id={$user->id}) with role={$role}.\n";
    return $user;
}

ensureUser('admin@gmail.com', 'Admin', 'admin', 'Admin1234');
ensureUser('petugas@gmail.com', 'Petugas', 'petugas', 'Petugas1234');
