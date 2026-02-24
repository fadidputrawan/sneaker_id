<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Nike
            ['nama' => 'Nike Air Max 90', 'harga' => 1200000, 'stok' => 10, 'brand' => 'Nike', 'image' => 'produk/sepatu4.jpg'],
            ['nama' => 'Nike Air Force 1', 'harga' => 900000, 'stok' => 15, 'brand' => 'Nike', 'image' => 'produk/sepatu6.jpg'],
            
            // Adidas
            ['nama' => 'Adidas Ultraboost', 'harga' => 1500000, 'stok' => 8, 'brand' => 'Adidas', 'image' => 'produk/sepatu3.jpg'],
            ['nama' => 'Adidas Stan Smith', 'harga' => 850000, 'stok' => 12, 'brand' => 'Adidas', 'image' => 'produk/sepatu7.jpg'],
            
            // Puma
            ['nama' => 'Puma RS-X', 'harga' => 950000, 'stok' => 10, 'brand' => 'Puma', 'image' => 'produk/sepatu1.jpg'],
            ['nama' => 'Puma Suede Classic', 'harga' => 750000, 'stok' => 14, 'brand' => 'Puma', 'image' => 'produk/sepatu8.jpg'],
            
            // New Balance
            ['nama' => 'New Balance 574', 'harga' => 1100000, 'stok' => 11, 'brand' => 'New Balance', 'image' => 'produk/sepatu2.jpg'],
            ['nama' => 'New Balance 990v5', 'harga' => 1800000, 'stok' => 6, 'brand' => 'New Balance', 'image' => 'produk/sepatu9.jpg'],
            
            // Salomon
            ['nama' => 'Salomon Speedcross', 'harga' => 1300000, 'stok' => 9, 'brand' => 'Salomon', 'image' => 'produk/sepatu5.jpg'],
            ['nama' => 'Salomon XA Pro 3D', 'harga' => 1400000, 'stok' => 7, 'brand' => 'Salomon', 'image' => 'produk/sepatu10.jpg'],
        ];
        
        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
