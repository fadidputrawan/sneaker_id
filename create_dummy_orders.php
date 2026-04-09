<?php
$root = __DIR__;
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update order status to selesai
\App\Models\Order::where('id', 1)->update(['status' => 'selesai']);

// Create some dummy orders for testing
$orders = [
    ['user_id' => 1, 'nama' => 'Test User 1', 'total' => 1500000, 'status' => 'selesai', 'payment_method' => 'transfer', 'items' => '[]', 'created_at' => now()->subDays(2)],
    ['user_id' => 1, 'nama' => 'Test User 2', 'total' => 800000, 'status' => 'selesai', 'payment_method' => 'transfer', 'items' => '[]', 'created_at' => now()->subDays(1)],
    ['user_id' => 1, 'nama' => 'Test User 3', 'total' => 2000000, 'status' => 'dibatalkan', 'payment_method' => 'transfer', 'items' => '[]', 'created_at' => now()],
];

foreach ($orders as $order) {
    \App\Models\Order::create($order);
}

echo 'Dummy orders created successfully' . PHP_EOL;