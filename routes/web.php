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
use App\Http\Controllers\Home\CheckoutController;
use App\Http\Controllers\Home\ContactController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/tim', function () {
    return view('Home/tim');
})->name('tim');
Route::get('/aboutus', function () {
    return view('home.aboutus');
})->name('aboutus');
Route::get('/product/{product}', [HomeController::class, 'showProduct'])->name('product.show');
Route::get('/allproduct', [HomeController::class, 'allProducts'])->name('allproduct');
Route::get('/kontak', function () {
    return view('home.kontak');
})->name('kontak');
Route::post('/kontak/kirim', [ContactController::class, 'kirim'])->name('kontak.kirim');

// Route lupa password dipisah karena agar saat login masih bisa masuk ke pagi
Route::get('/lupa_password', function () {
    return view('Auth/lupapassword');
})->name('lupa_password');

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
    Route::get('/riwayatbeli', [ProfileController::class, 'riwayat'])->name('riwayatbeli');
    Route::get('/profilekeamanan', [ProfileController::class, 'privasiKeamanan'])->name('profilekeamanan');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile - ubah email
    Route::get('/ubah_email', [ProfileController::class, 'ubahEmail'])->name('ubah_email');
    Route::get('/ubah_email_otp', [ProfileController::class, 'ubahEmailOTP'])->name('ubah_email_otp');
    Route::post('/kirim_otp_email_lama', [ProfileController::class, 'kirimOtpEmailLama'])->name('kirim_otp_email_lama');
    Route::post('/verifikasi_otp_ubah_email', [ProfileController::class, 'verifikasiOtpUbahEmail'])->name('verifikasi_otp_ubah_email');

    // Profile - ubah nomer telepon
    Route::get('/ubah_no_tlp', [ProfileController::class, 'tambahNoTelepon'])->name('ubah_no_tlp');
    Route::get('/ubah_no_tlp_otp', [ProfileController::class, 'tambahNoTeleponOTP'])->name('ubah_no_tlp_otp');
    Route::post('/kirim_otp', [ProfileController::class, 'kirimOtpAturNotlp'])->name('kirim_otp');
    Route::post('/verifikasi_otp', [ProfileController::class, 'verifikasiOtpAturNoTlp'])->name('verifikasi_otp');

    // Cart and checkout
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/buy-now/{productId}', [CheckoutController::class, 'buyNow'])->name('buy.now');


    Route::get('/riwayatpembelian', function () {
        return view('profile/riwayat_pembelian');
    })->name('riwayatpembelian');

    Route::get('/customer_support', [ChatController::class, 'customerChat'])->name('customer_support');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');

    // Logout
    Route::get('/logout', function () {
        return view('profile.logout');
    })->name('profile.logout.confirm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('profile.logout');
});

// Testimonial user
Route::post('/testimonial', [\App\Http\Controllers\Home\TestimonialController::class, 'store'])->name('testimonial.store');

// Post-checkout routes
Route::get('/thank-you', function () {
    return view('checkout.success');
})->name('thank-you');


// Route untuk menampilkan halaman setelah keluar
Route::get('/setelah_keluar', function () {
    return view('profile.setelah_keluar');
})->name('profileout');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login (no auth middleware)
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/register', [AuthController::class, 'showAdminRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'adminRegister'])->name('register.post');
    });

    // Admin protected routes
    Route::middleware(['auth:admin'])->group(function () {
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

        // Admin chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

        // Admin testimonial
        Route::middleware(['auth:web', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
            Route::post('testimonials/{testimonial}/approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'approve'])->name('testimonials.approve');
        });

        // Admin testimoni (moderasi)
        Route::get('/testimoni', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimoni');
        Route::post('/testimoni/{id}/approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'approve'])->name('testimoni.approve');
        Route::post('/testimoni/{id}/reject', [\App\Http\Controllers\Admin\TestimonialController::class, 'reject'])->name('testimoni.reject');

        // Admin order management
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/update', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');

        // Admin logout
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