<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $pendapatan = Order::where('status', 'selesai')->sum('total');
        $totalUser = User::where('role', 'user')->count();

        $transaksiTerbaru = Order::with('user')->latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'pendapatan',
            'totalUser',
            'transaksiTerbaru'
        ));
    }

    public function pesanan()
    {
        $orders = Order::with('user')->latest()->get();

        $totalPesanan = Order::count();
        $diproses = Order::where('status', 'diproses')->count();
        $dikirim = Order::where('status', 'dikirim')->count();
        $selesai = Order::where('status', 'selesai')->count();

        return view('petugas.pesanan_index', compact('orders', 'totalPesanan', 'diproses', 'dikirim', 'selesai'));
    }

    public function orderShow($id)
    {
        $order = Order::findOrFail($id);

        return view('petugas.order_show', compact('order'));
    }

    public function orderStatus($id)
    {
        $order = Order::findOrFail($id);
        $action = request('action');

        if ($action === 'process' && $order->status === 'diproses') {
            $order->update(['status' => 'dikirim']);
            return back()->with('success', 'Pesanan berhasil diubah menjadi dikirim.');
        }

        if ($action === 'complete' && $order->status === 'dikirim') {
            $order->update(['status' => 'selesai']);
            return back()->with('success', 'Pesanan berhasil diselesaikan.');
        }

        if ($action === 'cancel' && !in_array($order->status, ['selesai', 'dibatalkan'])) {
            $order->update(['status' => 'dibatalkan', 'cancelled_by' => 'admin']);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Aksi tidak valid untuk status pesanan ini.');
    }

    public function downloadTransaksiPdf()
    {
        $transaksiTerbaru = Order::with('user')->latest()->take(10)->get();

        $pdf = Pdf::loadView('petugas.transaksi-pdf', compact('transaksiTerbaru'));
        
        return $pdf->download('Transaksi-Terbaru-' . now()->format('d-m-Y-H-i-s') . '.pdf');
    }

    public function laporan()
    {
        // Statistik umum
        $totalPesanan = Order::count();
        $totalRevenue = Order::where('status', 'selesai')->sum('total');
        $pesananSelesai = Order::where('status', 'selesai')->count();
        $pesananDibatalkan = Order::where('status', 'dibatalkan')->count();

        // Data laporan per periode (bulan ini)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $bulanIni = [
            'total_pesanan' => Order::whereMonth('created_at', $currentMonth)
                                   ->whereYear('created_at', $currentYear)
                                   ->count(),
            'total_revenue' => Order::where('status', 'selesai')
                                   ->whereMonth('created_at', $currentMonth)
                                   ->whereYear('created_at', $currentYear)
                                   ->sum('total'),
            'pesanan_selesai' => Order::where('status', 'selesai')
                                     ->whereMonth('created_at', $currentMonth)
                                     ->whereYear('created_at', $currentYear)
                                     ->count(),
            'pesanan_dibatalkan' => Order::where('status', 'dibatalkan')
                                        ->whereMonth('created_at', $currentMonth)
                                        ->whereYear('created_at', $currentYear)
                                        ->count(),
            'periode' => 'Bulan ' . now()->format('F Y')
        ];

        // Data laporan harian (7 hari terakhir)
        $dailyReports = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyReports[] = [
                'periode' => $date->format('d/m/Y'),
                'total_pesanan' => Order::whereDate('created_at', $date)->count(),
                'total_revenue' => Order::where('status', 'selesai')
                                       ->whereDate('created_at', $date)
                                       ->sum('total'),
                'pesanan_selesai' => Order::where('status', 'selesai')
                                         ->whereDate('created_at', $date)
                                         ->count(),
                'pesanan_dibatalkan' => Order::where('status', 'dibatalkan')
                                            ->whereDate('created_at', $date)
                                            ->count()
            ];
        }

        // Laporan per user (top customers)
        $topCustomers = Order::selectRaw('user_id, nama, COUNT(*) as total_pesanan, SUM(total) as total_nilai_pesanan, SUM(CASE WHEN status = "selesai" THEN total ELSE 0 END) as total_revenue')
                            ->where('status', '!=', 'dibatalkan')
                            ->groupBy('user_id', 'nama')
                            ->orderBy('total_revenue', 'desc')
                            ->limit(10)
                            ->get();

        // Detail pesanan terbaru per user
        $recentOrdersByUser = Order::with('user')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(20)
                                  ->get()
                                  ->groupBy('user_id');

        return view('petugas.laporan', compact(
            'totalPesanan',
            'totalRevenue',
            'pesananSelesai',
            'pesananDibatalkan',
            'bulanIni',
            'dailyReports',
            'topCustomers',
            'recentOrdersByUser'
        ));
    }

    public function produk()
    {
        $products = Product::all();

        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $pendapatan = Order::where('status', 'selesai')->sum('total');
        $totalUser = User::where('role', 'user')->count();

        return view('petugas.produk_index', compact('products', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok_39' => 'nullable|integer|min:0',
            'stok_40' => 'nullable|integer|min:0',
            'stok_41' => 'nullable|integer|min:0',
            'stok_42' => 'nullable|integer|min:0',
            'stok_43' => 'nullable|integer|min:0',
            'stok_44' => 'nullable|integer|min:0',
            'images' => 'required|array|min:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = Storage::disk('public')->putFileAs('products', $image, $imageName);
                    if ($path) {
                        $imagePaths[] = $path;
                    }
                }
            }
        }

        if (count($imagePaths) < 5) {
            return redirect()->back()->with('error', 'Minimal 5 foto harus berhasil diupload!');
        }

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'brand' => $request->brand,
            'deskripsi' => $request->deskripsi,
            'images' => $imagePaths,
            'stok_39' => $request->stok_39 ?? 0,
            'stok_40' => $request->stok_40 ?? 0,
            'stok_41' => $request->stok_41 ?? 0,
            'stok_42' => $request->stok_42 ?? 0,
            'stok_43' => $request->stok_43 ?? 0,
            'stok_44' => $request->stok_44 ?? 0,
        ]);

        return redirect()->route('petugas.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateProduk(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok_39' => 'nullable|integer|min:0',
            'stok_40' => 'nullable|integer|min:0',
            'stok_41' => 'nullable|integer|min:0',
            'stok_42' => 'nullable|integer|min:0',
            'stok_43' => 'nullable|integer|min:0',
            'stok_44' => 'nullable|integer|min:0',
            'images' => 'nullable|array|min:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePaths = is_array($product->images) ? $product->images : (json_decode($product->images ?? '[]', true) ?: []);

        if ($request->hasFile('images')) {
            $uploadedFiles = array_filter($request->file('images'));
            
            if (count($uploadedFiles) >= 5) {
                if (!empty($imagePaths)) {
                    foreach ($imagePaths as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                $imagePaths = [];
                foreach ($uploadedFiles as $image) {
                    if ($image && $image->isValid()) {
                        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('products', $image, $imageName);
                        if ($path) {
                            $imagePaths[] = $path;
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Jika ingin mengganti gambar, upload minimal 5 foto!');
            }
        }

        $product->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'brand' => $request->brand,
            'deskripsi' => $request->deskripsi,
            'images' => $imagePaths,
            'stok_39' => $request->stok_39 ?? $product->stok_39,
            'stok_40' => $request->stok_40 ?? $product->stok_40,
            'stok_41' => $request->stok_41 ?? $product->stok_41,
            'stok_42' => $request->stok_42 ?? $product->stok_42,
            'stok_43' => $request->stok_43 ?? $product->stok_43,
            'stok_44' => $request->stok_44 ?? $product->stok_44,
        ]);

        return redirect()->route('petugas.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduk($id)
    {
        $product = Product::findOrFail($id);

        $imagePaths = is_array($product->images) ? $product->images : (json_decode($product->images ?? '[]', true) ?: []);
        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('petugas.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}