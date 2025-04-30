<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\CartController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ProfileController;

// Public routes
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

// Authentication routes (guest only)
Route::middleware(['guest:web'])->group(function () {
    Route::get('/login', function () {
        return view('Auth/login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/registrasi', function () {
        return view('Auth/registrasi');
    })->name('registrasi');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');
});

// Authenticated routes
Route::middleware(['auth:web'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profilebayar', function () {
        return view('profile/atur_pembayaran');
    })->name('profilebayar');

    Route::get('/profilekeamanan', [ProfileController::class, 'profileKeamanan'])->name('profilekeamanan');
    
    // Cart and checkout
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/checkout', function () {
        return view('Home/checkout');
    })->name('checkout');

    Route::get('/riwayatpembelian', function () {
        return view('profile/riwayat_pembelian');
    })->name('riwayatpembelian');
    
    Route::get('/customer_support', [ChatController::class, 'customerChat'])->name('customer_support');
    
    // Add routes for customers to send and fetch messages
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        return view('profile/logout');
    })->name('logout.page');
});

// Post-logout routes
Route::get('/profileout', function () {
    return view('profile/setelah_keluar');
})->name('profileout');
Route::get('/setelah_logout', function () {
    return view('profile/setelah_logout');
})->name('setelah_logout');
Route::get('/lupa_password', function () {
    return view('Auth/lupapassword');
})->name('lupa_password');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login/register (no auth middleware)
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    Route::middleware(['guest:admin'])->group(function () {
        
        Route::get('/register', [AuthController::class, 'showAdminRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'adminRegister'])->name('register.post');
    });
    
    // Admin protected routes
    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/preview', [ProductController::class, 'preview']); 
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
    });
});

// Pusher authentication
Route::post('/pusher/auth', function (Request $request) {
    $pusher = new Pusher\Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
    );
    return $pusher->socket_auth($request->channel_name, $request->socket_id);
})->middleware('auth:web,admin');