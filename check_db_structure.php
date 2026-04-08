<?php
require 'vendor/autoload.php';

$PDO = new PDO('mysql:host=localhost;dbname=sneaker_id', 'root', '');
$stmt = $PDO->query('DESCRIBE products');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "=== PRODUCTS TABLE STRUCTURE ===\n";
foreach($columns as $col) {
    echo $col['Field'] . " (" . $col['Type'] . ")\n";
}

echo "\n=== SAMPLE PRODUCT DATA ===\n";
$stmt = $PDO->query('SELECT id, nama, images FROM products LIMIT 1');
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if ($product) {
    echo "ID: " . $product['id'] . "\n";
    echo "Nama: " . $product['nama'] . "\n";
    echo "Images: " . $product['images'] . "\n";
} else {
    echo "No products found\n";
}
?>
