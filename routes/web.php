<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Sudah Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::get('/payment', [OrderController::class, 'payment'])->name('payment');

    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');

    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');

    Route::get('/wishlist/is-liked/{productId}', [WishlistController::class, 'isLiked'])->name('wishlist.isLiked');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/profile/edit-address', [ProfileController::class, 'editAddress'])->name('profile.edit-address');

    Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('profile.update-address');

    Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');

    Route::get('/api/products/brand/{brand}', function ($brand) {
        // Map brand aliases
        $brandMap = [
            'nb' => 'New Balance',
            'new balance' => 'New Balance'
        ];
        
        $searchBrand = $brandMap[strtolower($brand)] ?? $brand;
        
        $products = \App\Models\Product::whereRaw('LOWER(brand) = ?', [strtolower($searchBrand)])->get();
        return response()->json($products);
    })->name('api.products.byBrand');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| LOGIN TERPISAH ADMIN & PETUGAS
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'loginAdmin'])
    ->name('admin.login.process');

Route::get('/petugas/login', function () {
    return view('auth.petugas-login');
})->name('petugas.login');

Route::post('/petugas/login', [AuthController::class, 'loginPetugas'])
    ->name('petugas.login.process');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (DATABASE VERSION)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

});


/*
|--------------------------------------------------------------------------
| PETUGAS ROUTES (DATABASE VERSION)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])
        ->name('petugas.dashboard');

});