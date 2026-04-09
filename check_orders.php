<?php
$root = __DIR__;
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\Order::all();
echo 'Total orders: ' . $orders->count() . PHP_EOL;
foreach ($orders as $order) {
    echo 'ID: ' . $order->id . ' - Status: ' . $order->status . ' - Total: ' . $order->total . ' - Date: ' . $order->created_at->format('Y-m-d') . PHP_EOL;
}