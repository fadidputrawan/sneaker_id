<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$orders = App\Models\Order::whereNotNull('payment_proof')->take(10)->get();
foreach ($orders as $order) {
    echo $order->id . ' => ' . $order->payment_proof . PHP_EOL;
}
