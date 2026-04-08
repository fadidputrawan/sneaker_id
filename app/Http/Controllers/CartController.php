<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|integer|in:39,40,41,42,43,44'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $size = $request->size;

        // Check product stock for the selected size
        $product = Product::findOrFail($productId);
        $sizeStockColumn = 'stok_' . $size;
        $availableStock = $product->$sizeStockColumn ?? 0;

        if ($availableStock === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ukuran ' . $size . ' sudah habis stok'
            ]);
        }

        if ($quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok untuk ukuran ' . $size . ' hanya tersisa ' . $availableStock . ' pasang'
            ]);
        }

        // Check if cart item already exists with same product and size
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->where('size', $size)
                        ->first();

        if ($cartItem) {
            // Check if adding quantity exceeds available stock
            if (($cartItem->quantity + $quantity) > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup. Hanya tersisa ' . ($availableStock - $cartItem->quantity) . ' pasang'
                ]);
            }
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'size' => $size
            ]);
        }

        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount
        ]);
    }

    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['cart_count' => 0]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json(['cart_count' => $cartCount]);
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product')
                         ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->product->harga * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function updateQuantity(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('id', $request->cart_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $total = Cart::where('user_id', Auth::id())
                     ->with('product')
                     ->get()
                     ->sum(function ($item) {
                         return $item->product->harga * $item->quantity;
                     });

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'total' => $total,
            'cart_count' => $cartCount
        ]);
    }

    public function removeItem(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        $cartItem = Cart::where('id', $request->cart_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $cartItem->delete();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount
        ]);
    }
}
