<?php
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

$totalProduk = Product::count();
$totalPesanan = Order::whereHas('user', function($q){ $q->where('role','user'); })->count();
$totalUser = User::where('role','user')->count();
$pendapatan = Order::whereHas('user', function($q){ $q->where('role','user'); })->where('status','selesai')->sum('total');

echo "totalProduk: {$totalProduk}\n";
echo "totalPesanan (customer orders): {$totalPesanan}\n";
echo "pendapatan (customer selesai): {$pendapatan}\n";
echo "user aktif (role=user): {$totalUser}\n";

$orders = Order::with('user')->whereHas('user', function($q){ $q->where('role','user'); })->latest()->take(5)->get();

echo "\ntransaksiTerbaru (showing up to 5):\n";
foreach($orders as $o){
    echo "#{$o->id} - user=" . ($o->user?->email ?? $o->nama) . " total=" . $o->total . " status=" . $o->status . " date=" . $o->created_at . "\n";
}
