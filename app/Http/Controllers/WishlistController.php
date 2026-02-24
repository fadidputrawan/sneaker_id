<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        $wishlistItem = Wishlist::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $isLiked = false;
            $message = 'Produk dihapus dari wishlist';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $isLiked = true;
            $message = 'Produk ditambahkan ke wishlist';
        }

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_liked' => $isLiked,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['wishlist_count' => 0]);
        }

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json(['wishlist_count' => $wishlistCount]);
    }

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
                                 ->with('product')
                                 ->get();

        return view('wishlist', compact('wishlistItems'));
    }

    public function isLiked($productId)
    {
        if (!Auth::check()) {
            return response()->json(['is_liked' => false]);
        }

        $isLiked = Wishlist::where('user_id', Auth::id())
                           ->where('product_id', $productId)
                           ->exists();

        return response()->json(['is_liked' => $isLiked]);
    }
}
