<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('Home/welcome');
});
Route::get('/tim', function () {
    return view('Home/tim');
});
Route::get('/cart', function () {
    return view('Home/cart');
});
Route::get('/login', function () {
    return view('Auth/login');
})->name('login');

Route::get('/registrasi', function () {
    return view('Auth/registrasi');
})->name('registrasi');

Route::get('/aboutus', function () {
    return view('home.aboutus');
});

Route::get('/product', function () {
    return view('Home/product');
})->name('product');

Route::get('/checkout', function () {
    return view('Home/checkout');
})->name('checkout');

Route::get('/profilebayar', function () {
    return view('profile/atur_pembayaran');
})->name('profilebayar');

Route::get('/kontak', function () {
    return view('home.kontak');
});

Route::get('/profile', function () {
    return view('profile/tentang_saya');
})->name('profile');

Route::get('/allproduct', function () {
    return view('home.allproduct');
});

Route::get('/riwayatpembelian', function () {
    return view('profile/riwayat_pembelian');
})->name('riwayatpembelian');

Route::get('/profilekeamanan', function () {
    return view('profile/keamanan_privasi');
})->name('profilekeamanan');

Route::get('/logout', function () {
    return view('profile/logout');
})->name('logout');

Route::get('/profileout', function () {
    return view('profile/setelah_keluar');
})->name('profileout');

Route::get('/setelah_logout', function () {
    return view('profile/setelah_logout');
})->name('setelah_logout');

