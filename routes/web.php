<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ChatController; // Pastikan ChatController diimport
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
Route::get('/allproduct', [HomeController::class, 'allProducts'])->name('allproduct');
Route::get('/kontak', function () {
    return view('home.kontak');
})->name('kontak');


// Authentication routes (guest only)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('Auth/login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/registrasi', function () {
        return view('Auth/registrasi');
    })->name('registrasi');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');
    Route::get('/lupa_password', function () {
        return view('Auth/lupapassword');
    })->name('lupa_password'); // Pastikan view ini ada
});


// Authenticated routes for regular users
Route::middleware(['auth:web'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/riwayatbeli', [ProfileController::class, 'riwayat'])->name('riwayatbeli');
    Route::get('/profilekeamanan', [ProfileController::class, 'privasiKeamanan'])->name('profilekeamanan');

    // Profile - ubah email & telepon (Contoh rute, viewsnya perlu disiapkan)
    // Route::get('/ubah_email', [ProfileController::class, 'ubahEmail'])->name('ubah_email');
    // Route::get('/ubah_email_otp', [ProfileController::class, 'ubahEmailOTP'])->name('ubah_email_otp');
    // Route::get('/ubah_no_tlp', [ProfileController::class, 'tambahNoTelepon'])->name('ubah_no_tlp');
    // Route::get('/ubah_no_tlp_otp', [ProfileController::class, 'tambahNoTeleponOTP'])->name('ubah_no_tlp_otp');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add'); // Menggunakan Route Model Binding Product
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout route
    Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout'); // Memanggil method showCheckout di CartController
    // Optional: Route POST untuk memproses pembayaran jika tombol "Bayar Sekarang" adalah form submit
    // Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process'); // Perlu Controller/method terpisah


    // Customer chat
    // *** PERBAIKAN: HAPUS TANDA KOMENTAR PADA BARIS INI ***
    Route::get('/customer_support', [ChatController::class, 'customerChat'])->name('customer_support'); // Perlu method customerChat di ChatController


    // Logout for web guard
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

// Post-logout routes (Optional)
// Route::get('/profileout', function () { return view('profile/setelah_keluar'); })->name('profileout');
// Route::get('/setelah_logout', function () { return view('profile/setelah_logout'); })->name('setelah_logout');


// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login (no auth middleware)
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    // Route::get('/register', [AuthController::class, 'showAdminRegistrationForm'])->name('register'); // Registrasi admin sebaiknya tidak di public route
    // Route::post('/register', [AuthController::class, 'adminRegister'])->name('register.post');

    // Admin protected routes
    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard'); // Perlu DashboardController

        // Product management routes
        Route::get('/products', [ProductController::class, 'index'])->name('products'); // Pastikan ProductController ada
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/preview', [ProductController::class, 'preview']); // Preview needs a route if using AJAX/form submit

        // User management routes
        Route::get('/users', [UserController::class, 'index'])->name('users'); // Pastikan UserController ada
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Admin chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat'); // Pastikan ChatController ada
        Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

        // Admin logout
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
    });
});

// Pusher authentication (Jika menggunakan Websockets)
Route::post('/pusher/auth', function (Request $request) {
    // Pastikan Pusher\Pusher sudah terinstal via Composer dan di-import
    // use Pusher\Pusher; // <-- tambahkan ini di bagian atas file

    // Cek apakah user terautentikasi menggunakan guard 'web' atau 'admin'
    if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
         $pusher = new Pusher\Pusher(
             env('PUSHER_APP_KEY'),
             env('PUSHER_APP_SECRET'),
             env('PUSHER_APP_ID'),
             ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
         );

         // Dapatkan user yang sedang login
         $user = Auth::guard('admin')->user() ?? Auth::guard('web')->user();

         // Socket authentication for private channels
         // Channel name format expected: 'private-chat.user.<user_id>' (dari kode chat Anda)
         if (Str::startsWith($request->channel_name, 'private-chat.user.')) {
             $channelUserId = (int) Str::after($request->channel_name, 'private-chat.user.');
             if ($user && $user->id === $channelUserId) {
                  // User yang login adalah pemilik channel pribadi ini
                 return $pusher->socket_auth($request->channel_name, $request->socket_id);
             } else {
                  // User tidak memiliki akses ke channel pribadi ini
                 return response('Unauthorized', 403);
             }
         }

         // Tambahkan logika otorisasi untuk jenis channel lain (misalnya presence channels) jika ada

         // Jika channel type tidak dikenali atau user tidak diizinkan
         return response('Unauthorized', 403);

    }

     // Jika user tidak terautentikasi sama sekali
    return response('Unauthorized', 401);
});
