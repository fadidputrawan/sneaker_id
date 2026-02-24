<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.detail', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::where('nama', 'LIKE', '%' . $query . '%')
                            ->orWhere('brand', 'LIKE', '%' . $query . '%')
                            ->get();

        return response()->json($products);
    }
}
