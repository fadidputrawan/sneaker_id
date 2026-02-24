<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product')
                         ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->harga * $item->quantity;
        });

        $shippingCost = 0; // Free shipping
        $total = $subtotal + $shippingCost;

        return view('checkout.index', compact('user', 'cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function payment()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product')
                         ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->harga * $item->quantity;
        });

        $shippingCost = 0; // Free shipping
        $total = $subtotal + $shippingCost;

        return view('payment.index', compact('user', 'cartItems', 'subtotal', 'shippingCost', 'total'));
    }
}
