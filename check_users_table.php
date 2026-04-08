<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "=== USERS TABLE STRUCTURE ===\n";
$columns = DB::select("DESCRIBE users");
foreach ($columns as $col) {
    echo $col->Field . " - " . $col->Type . " - " . ($col->Null == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}

echo "\n=== USERS DATA ===\n";
$users = User::all(['id', 'name', 'email', 'status']);
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Status: " . ($user->status ?? 'NULL') . "\n";
}
