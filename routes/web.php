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
use App\Http\Controllers\Home\TestimonialController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\CourierController; // Add CourierController
use Pusher\Pusher;

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

// Password reset route
Route::get('/lupa_password', function () {
    return view('auth.lupapassword');
})->name('lupa_password');

// Guest-only routes (for unauthenticated users)
Route::middleware(['guest:web'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/registrasi', function () {
        return view('auth.registrasi');
    })->name('registrasi');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');
});

// Authenticated user routes
Route::middleware(['auth:web'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/riwayatbeli', [ProfileController::class, 'riwayat'])->name('riwayatbeli');
    Route::get('/profilekeamanan', [ProfileController::class, 'privasiKeamanan'])->name('profilekeamanan');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile - change email
    Route::get('/ubah_email', [ProfileController::class, 'ubahEmail'])->name('ubah_email');
    Route::get('/ubah_email_otp', [ProfileController::class, 'ubahEmailOTP'])->name('ubah_email_otp');
    Route::post('/kirim_otp_email_lama', [ProfileController::class, 'kirimOtpEmailLama'])->name('kirim_otp_email_lama');
    Route::post('/verifikasi_otp_ubah_email', [ProfileController::class, 'verifikasiOtpUbahEmail'])->name('verifikasi_otp_ubah_email');

    // Profile - change phone number
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

    // Purchase history
    Route::get('/riwayatpembelian', function () {
        return view('profile.riwayat_pembelian');
    })->name('riwayatpembelian');

    // Customer support chat
    Route::get('/customer_support', [ChatController::class, 'customerChat'])->name('customer_support');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');

    // Logout
    Route::get('/logout', function () {
        return view('profile.logout');
    })->name('profile.logout.confirm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('profile.logout');
});

// Testimonial routes
Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');

// Post-checkout route
Route::get('/thank-you', function () {
    return view('checkout.success');
})->name('thank-you');

// Post-logout route
Route::get('/setelah_keluar', function () {
    return view('profile.setelah_keluar');
})->name('profileout');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login (no auth middleware)
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');

    // Admin registration (guest-only)
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
        Route::post('/products/preview', [ProductController::class, 'preview'])->name('products.preview');

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Admin chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

        // Admin testimonial routes
        Route::resource('testimonials', AdminTestimonialController::class);
        Route::post('testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');

        // Admin courier management
        Route::resource('courier', CourierController::class)->except(['show']);
        Route::get('/courier', [\App\Http\Controllers\Admin\CourierController::class, 'index'])->name('courier');

        // Admin testimoni (moderasi)
        Route::get('/testimoni', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimoni');
        Route::post('/testimoni/{id}/approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'approve'])->name('testimoni.approve');
        Route::post('/testimoni/{id}/reject', [\App\Http\Controllers\Admin\TestimonialController::class, 'reject'])->name('testimoni.reject');

        // Admin order management
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        
        // Manual payment status update
        Route::post('/orders/{order}/update-payment-status', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        
        // Check Midtrans status for pending orders
        Route::post('/orders/check-midtrans-status', [\App\Http\Controllers\Admin\OrderController::class, 'checkMidtransStatus'])->name('orders.check-midtrans-status');
        
        // Search order by code
        Route::get('/orders/search-by-code', [\App\Http\Controllers\Admin\OrderController::class, 'searchByCode'])->name('orders.search-by-code');

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

// Midtrans callback route (no auth required)
Route::post('/midtrans/callback', [\App\Http\Controllers\Home\CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

// Test callback route for debugging
Route::get('/test-callback', [\App\Http\Controllers\Home\CheckoutController::class, 'testCallback'])->name('test.callback');

// Status consistency verification route
Route::get('/verify-status', [\App\Http\Controllers\Home\CheckoutController::class, 'verifyStatusConsistency'])->name('verify.status');

// Frontend payment status update route (alternative to callback)
Route::post('/update-payment-status', [\App\Http\Controllers\Home\CheckoutController::class, 'updatePaymentStatus'])->name('update.payment.status');