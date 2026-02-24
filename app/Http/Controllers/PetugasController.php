<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalPesanan = Order::count();

        $diproses = Order::where('status', 'diproses')->count();
        $dikirim = Order::where('status', 'dikirim')->count();
        $selesai = Order::where('status', 'selesai')->count();

        $pesananTerbaru = Order::latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'totalPesanan',
            'diproses',
            'dikirim',
            'selesai',
            'pesananTerbaru'
        ));
    }
}