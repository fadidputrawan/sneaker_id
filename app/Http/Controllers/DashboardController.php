<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();
        
        // Only 5 brands
        $brands = collect(['Puma', 'New Balance', 'Adidas', 'Nike', 'Salomon'])->sort();
        
        return view('dashboard', [
            'products' => $products,
            'brands' => $brands
        ]);
    }
}
