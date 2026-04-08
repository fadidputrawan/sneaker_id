<?php
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all();
foreach ($users as $user) {
    if ($user->role !== 'admin') {
        $user->role = 'admin';
        $user->save();
        echo "Set user {$user->email} (id={$user->id}) to role=admin\n";
    } else {
        echo "User {$user->email} already admin\n";
    }
}

echo "Done. Total users: " . $users->count() . "\n";
