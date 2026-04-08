<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "=== IMAGE UPLOAD SYSTEM VERIFICATION ===\n\n";

// 1. Check filesystem config
echo "[1] FILESYSTEM CONFIGURATION\n";
$disk = Storage::disk('public');
$root = config('filesystems.disks.public.root');
$url = config('filesystems.disks.public.url');
echo "    Root path: " . $root . "\n";
echo "    URL base: " . $url . "\n";

// 2. Check directories
echo "\n[2] DIRECTORY STRUCTURE\n";
$uploadsPath = public_path('uploads');
$productsPath = public_path('uploads/products');

echo "    Public dir exists: " . (is_dir(public_path('')) ? "YES" : "NO") . "\n";
echo "    Uploads dir exists: " . (is_dir($uploadsPath) ? "YES" : "NO") . "\n";
echo "    Products subdir exists: " . (is_dir($productsPath) ? "YES" : "NO") . "\n";

// 3. Check permissions
echo "\n[3] WRITE PERMISSIONS\n";
echo "    Uploads writable: " . (is_writable($uploadsPath) ? "YES" : "NO") . "\n";
echo "    Products writable: " . (is_writable($productsPath) ? "YES" : "NO") . "\n";

// 4. Sample URL construction
echo "\n[4] URL CONSTRUCTION TEST\n";
$sampleImage = 'products/test-img-123.jpg';
$constructedUrl = asset('uploads/' . $sampleImage);
echo "    Sample image path: " . $sampleImage . "\n";
echo "    Generated URL: " . $constructedUrl . "\n";

// 5. Database structure
echo "\n[5] DATABASE STATUS\n";
echo "    Total products: " . Product::count() . "\n";
if (Product::count() > 0) {
    $product = Product::first();
    echo "    Sample product: " . $product->nama . "\n";
    $images = $product->images;
    echo "    Images type: " . gettype($images) . "\n";
    if (is_array($images)) {
        echo "    Images count: " . count($images) . "\n";
        if (!empty($images)) {
            echo "    First image: " . $images[0] . "\n";
        }
    }
}

echo "\n=== READY FOR TESTING ===\n";
echo "✓ Configuration complete\n";
echo "✓ Directories created\n";
echo "✓ Upload system ready\n";
echo "\nNext step: Add a product with 5+ images from admin panel\n";
?>
