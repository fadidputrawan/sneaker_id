<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $totalUser = User::where('role', 'user')->count();

        $pendapatan = Order::where('status', 'selesai')->sum('total');

        $transaksiTerbaru = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalUser',
            'pendapatan',
            'transaksiTerbaru'
        ));
    }
}