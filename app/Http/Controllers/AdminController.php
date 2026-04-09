<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Product::count();

        // Count orders that belong to actual customers (role = 'user')
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();

        // Count active users with role 'user'
        $totalUser = User::where('role', 'user')->count();

        // Revenue only from customer orders with status 'selesai'
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        $transaksiTerbaru = Order::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'user');
            })
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalUser',
            'pendapatan',
            'transaksiTerbaru'
        ));
    }

    public function showOrder($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.order_show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'process' && $order->status === 'diproses') {
            $order->update(['status' => 'dikirim']);
            return back()->with('success', 'Pesanan berhasil dikirim.');
        }

        if ($action === 'complete' && $order->status === 'dikirim') {
            $order->update(['status' => 'selesai']);
            return back()->with('success', 'Pesanan berhasil diselesaikan.');
        }

        if ($action === 'cancel' && !in_array($order->status, ['selesai', 'dibatalkan'])) {
            $order->update(['status' => 'dibatalkan', 'cancelled_by' => 'admin']);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Aksi tidak valid untuk status pesanan saat ini.');
    }

    public function produk()
    {
        $products = Product::all();

        $totalProduk = Product::count();
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();
        $totalUser = User::where('role', 'user')->count();
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        return view('admin.produk_index', compact('products', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    // Store to public disk so images are accessible via web
                    $path = Storage::disk('public')->putFileAs('products', $image, $imageName);
                    if ($path) {
                        $imagePaths[] = $path;
                    }
                }
            }
        }

        // Ensure we have at least 5 images
        if (count($imagePaths) < 5) {
            return redirect()->back()->with('error', 'Minimal 5 foto harus berhasil diupload!');
        }

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'brand' => $request->brand,
            'deskripsi' => $request->deskripsi,
            'images' => $imagePaths, // Store as array (will be cast to JSON automatically)
            'stok_39' => $request->stok_39 ?? 0,
            'stok_40' => $request->stok_40 ?? 0,
            'stok_41' => $request->stok_41 ?? 0,
            'stok_42' => $request->stok_42 ?? 0,
            'stok_43' => $request->stok_43 ?? 0,
            'stok_44' => $request->stok_44 ?? 0,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
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

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $uploadedFiles = array_filter($request->file('images'));
            
            if (count($uploadedFiles) >= 5) {
                // Delete old images if new ones are uploaded
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

        // Update product
        $product->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'brand' => $request->brand,
            'deskripsi' => $request->deskripsi,
            'images' => $imagePaths, // Will be cast to JSON automatically
            'stok_39' => $request->stok_39 ?? $product->stok_39,
            'stok_40' => $request->stok_40 ?? $product->stok_40,
            'stok_41' => $request->stok_41 ?? $product->stok_41,
            'stok_42' => $request->stok_42 ?? $product->stok_42,
            'stok_43' => $request->stok_43 ?? $product->stok_43,
            'stok_44' => $request->stok_44 ?? $product->stok_44,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduk($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        $imagePaths = is_array($product->images) ? $product->images : (json_decode($product->images ?? '[]', true) ?: []);
        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function pesanan()
    {
        $orders = Order::with('user')->latest()->get();

        $totalProduk = Product::count();
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();
        $totalUser = User::where('role', 'user')->count();
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        return view('admin.pesanan_index', compact('orders', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
    }

    public function users()
    {
        // Only show regular users (exclude admins)
        $users = User::where('role', 'user')->get();

        $totalProduk = Product::count();
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();
        $totalUser = User::where('role', 'user')->count();
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        return view('admin.user_index', compact('users', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
    }

    public function editUser($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);

        $totalProduk = Product::count();
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();
        $totalUser = User::where('role', 'user')->count();
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        return view('admin.user_edit', compact('user', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('role', 'user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }

    public function editPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugas_edit', compact('petugas'));
    }

    public function updatePetugas(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $petugas->id,
        ]);

        $petugas->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroyPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }

    public function petugas()
    {
        $petugas = User::where('role', 'petugas')->get();

        $totalProduk = Product::count();
        $totalPesanan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();
        $totalUser = User::where('role', 'user')->count();
        $pendapatan = Order::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->where('status', 'selesai')->sum('total');

        return view('admin.petugas_index', compact('petugas', 'totalProduk', 'totalPesanan', 'totalUser', 'pendapatan'));
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

        // Data laporan penjualan bulanan (12 bulan terakhir)
        $salesReports = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $salesReports[] = [
                'periode' => $date->format('F Y'),
                'bulan_tahun' => $date->format('m/Y'),
                'total_pesanan' => Order::whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->count(),
                'total_revenue' => Order::where('status', 'selesai')
                                       ->whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->sum('total'),
                'pesanan_selesai' => Order::where('status', 'selesai')
                                         ->whereMonth('created_at', $month)
                                         ->whereYear('created_at', $year)
                                         ->count(),
                'pesanan_dibatalkan' => Order::where('status', 'dibatalkan')
                                            ->whereMonth('created_at', $month)
                                            ->whereYear('created_at', $year)
                                            ->count()
            ];
        }

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

        return view('admin.laporan', compact(
            'totalPesanan',
            'totalRevenue',
            'pesananSelesai',
            'pesananDibatalkan',
            'bulanIni',
            'salesReports',
            'dailyReports',
            'topCustomers',
            'recentOrdersByUser'
        ));
    }

    public function laporanPenjualanBulanan()
    {
        // Data laporan penjualan bulanan (12 bulan terakhir)
        $salesReports = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $salesReports[] = [
                'periode' => $date->format('F Y'),
                'bulan_tahun' => $date->format('m/Y'),
                'total_pesanan' => Order::whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->count(),
                'total_revenue' => Order::where('status', 'selesai')
                                       ->whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->sum('total'),
                'pesanan_selesai' => Order::where('status', 'selesai')
                                         ->whereMonth('created_at', $month)
                                         ->whereYear('created_at', $year)
                                         ->count(),
                'pesanan_dibatalkan' => Order::where('status', 'dibatalkan')
                                            ->whereMonth('created_at', $month)
                                            ->whereYear('created_at', $year)
                                            ->count()
            ];
        }

        return view('admin.laporan-penjualan-bulanan', compact('salesReports'));
    }

    public function downloadLaporanPenjualanPdf()
    {
        // Data laporan penjualan bulanan (12 bulan terakhir)
        $salesReports = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $salesReports[] = [
                'periode' => $date->format('F Y'),
                'bulan_tahun' => $date->format('m/Y'),
                'total_pesanan' => Order::whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->count(),
                'total_revenue' => Order::where('status', 'selesai')
                                       ->whereMonth('created_at', $month)
                                       ->whereYear('created_at', $year)
                                       ->sum('total'),
                'pesanan_selesai' => Order::where('status', 'selesai')
                                         ->whereMonth('created_at', $month)
                                         ->whereYear('created_at', $year)
                                         ->count(),
                'pesanan_dibatalkan' => Order::where('status', 'dibatalkan')
                                            ->whereMonth('created_at', $month)
                                            ->whereYear('created_at', $year)
                                            ->count()
            ];
        }

        $pdf = Pdf::loadView('admin.laporan-penjualan-pdf', compact('salesReports'));
        return $pdf->download('Laporan-Penjualan-Bulanan-' . now()->format('d-m-Y') . '.pdf');
    }
}