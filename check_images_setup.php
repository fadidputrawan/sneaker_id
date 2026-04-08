<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

// Check storage
$disk = Storage::disk('public');

echo "=== CHECKING STORAGE SETUP ===\n";
echo "Public Disk Root: " . $disk->path('') . "\n";

// Check if products folder exists
$productsPath = $disk->path('products');
if (file_exists($productsPath)) {
    echo "Products folder exists: YES\n";
    $files = scandir($productsPath);
    echo "Files in products folder: " . (count($files) - 2) . "\n"; // -2 for . and ..
} else {
    echo "Products folder exists: NO\n";
    echo "Creating products folder...\n";
    $disk->makeDirectory('products', 0755, true);
    echo "Products folder created!\n";
}

// Check symlink
echo "\nSymlink check:\n";
$symlinkPath = public_path('storage');
if (is_link($symlinkPath)) {
    echo "Symlink exists and is valid\n";
    echo "Symlink target: " . readlink($symlinkPath) . "\n";
} else {
    echo "Symlink does not exist or is broken\n";
}

echo "\n=== PRODUCTS IN DATABASE ===\n";
$products = Product::all();
echo "Total products: " . count($products) . "\n";

if (count($products) > 0) {
    foreach ($products as $product) {
        echo "\nProduct: " . $product->nama . "\n";
        echo "Images (stored): ";
        if (is_array($product->images)) {
            print_r($product->images);
        } else {
            echo $product->images . "\n";
        }
    }
}

echo "\n=== TEST ACCESSIBLE URLS ===\n";
if (count($products) > 0) {
    $product = $products[0];
    $images = is_array($product->images) ? $product->images : json_decode($product->images ?? '[]', true);
    
    if (!empty($images)) {
        foreach ($images as $image) {
            $url = '/storage/' . $image;
            $fullPath = storage_path('app/public/' . $image);
            $fileExists = file_exists($fullPath);
            echo "Image: $image\n";
            echo "  URL: $url\n";
            echo "  Physical path: $fullPath\n";
            echo "  File exists: " . ($fileExists ? "YES" : "NO") . "\n";
        }
    }
}

echo "\n=== DONE ===\n";
?>
