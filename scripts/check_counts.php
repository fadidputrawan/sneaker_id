<?php
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'products:' . \App\Models\Product::count() . PHP_EOL;
echo 'wishlists:' . \App\Models\Wishlist::count() . PHP_EOL;
echo 'carts:' . \App\Models\Cart::count() . PHP_EOL;
