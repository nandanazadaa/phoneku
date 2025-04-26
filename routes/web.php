<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Home\HomeController;

// Route yang dapat diakses semua orang
Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/tim', function () {
    return view('Home/tim');
})->name('tim');

Route::get('/aboutus', function () {
    return view('home.aboutus');
})->name('aboutus');

Route::get('/product/{product}', [HomeController::class, 'showProduct'])->name('product.show');
Route::get('/product', function () {
    return view('Home/product');
})->name('product');

Route::get('/kontak', function () {
    return view('home.kontak');
})->name('kontak');

Route::get('/allproduct', [HomeController::class, 'allProducts'])->name('allproduct');
// Route autentikasi
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('Auth/login');
    })->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/registrasi', function () {
        return view('Auth/registrasi');
    })->name('registrasi');
    
    Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');
});

// Route yang memerlukan login
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', function () {
        return view('profile/tentang_saya');
    })->name('profile');
    
    Route::get('/profilebayar', function () {
        return view('profile/atur_pembayaran');
    })->name('profilebayar');
    
    Route::get('/profilekeamanan', function () {
        return view('profile/keamanan_privasi');
    })->name('profilekeamanan');
    
    // Checkout dan Cart
    Route::get('/cart', function () {
        return view('Home/cart');
    })->name('cart');
    
    Route::get('/checkout', function () {
        return view('Home/checkout');
    })->name('checkout');
    
    Route::get('/riwayatpembelian', function () {
        return view('profile/riwayat_pembelian');
    })->name('riwayatpembelian');
    
    // Logout routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/logout', function () {
        return view('profile/logout');
    })->name('logout.page');
});

// Routes setelah logout
Route::get('/profileout', function () {
    return view('profile/setelah_keluar');
})->name('profileout');

Route::get('/setelah_logout', function () {
    return view('profile/setelah_logout');
})->name('setelah_logout');


Route::get('/lupa_password', function () {
    return view('Auth/lupapassword');
})->name('lupa_password');

Route::get('/customer_support', function () {
    return view('Home/customer_support');
})->name('customer_support');

Route::prefix('admin')->name('admin.')->group(function () {
    // Login & register admin - tanpa middleware auth
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showAdminRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'adminRegister'])->name('register.post');
    
    // Admin Routes protected by auth middleware saja
    Route::middleware(['auth'])->group(function() {
        // Controller sudah melakukan pengecekan admin sendiri
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        
        // Product Management Routes
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/preview', [ProductController::class, 'preview'])->name('products.preview');
        
        // Ubah dari GET menjadi POST
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
    });
});


