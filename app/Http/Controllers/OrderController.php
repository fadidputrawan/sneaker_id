<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $rules = [
            'payment_method' => 'required|in:qris',
        ];

        if ($request->input('payment_method') === 'qris') {
            $rules['proof_file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        }

        $request->validate($rules);

        $paymentProofPath = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('payment_proofs', $fileName, 'public');
            $paymentProofPath = $filePath;
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product')
                         ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Keranjang belanja kosong'], 422);
        }

        $items = $cartItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->nama,
                'price' => $item->product->harga,
                'quantity' => $item->quantity,
                'subtotal' => $item->product->harga * $item->quantity,
                'image' => $item->product->image ?? null,
            ];
        })->toArray();

        $total = array_sum(array_column($items, 'subtotal'));

        $order = Order::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'total' => $total,
            'status' => 'diproses',
            'payment_method' => $request->payment_method,
            'items' => $items,
            'payment_proof' => $paymentProofPath,
        ]);

        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'id' => $order->id,
            'status' => $order->status,
            'total' => $order->total,
            'payment_method' => $order->payment_method,
            'created_at' => $order->created_at->format('d/m/Y H:i'),
            'show_url' => route('orders.show', $order->id),
        ]);
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->latest()
                       ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (in_array($order->status, ['selesai', 'dikirim', 'dibatalkan'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan lagi.');
        }

        $order->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
