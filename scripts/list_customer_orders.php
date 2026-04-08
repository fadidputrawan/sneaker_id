<?php
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\Order::with('user')->whereHas('user', function($q){ $q->where('role','user'); })->get();

echo "customer orders: " . $orders->count() . PHP_EOL;
foreach ($orders as $o) {
    echo "id={$o->id} user=" . ($o->user?->email ?? $o->nama) . " total={$o->total} status={$o->status} date=" . $o->created_at . PHP_EOL;
}
