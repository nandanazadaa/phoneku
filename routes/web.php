<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/profilepage', function () {
    return view('Home/profilepage');
});


Route::get('/kontak', function () {
    return view('home.kontak');
});
Route::get('/profile', function () {
    return view('profile/tentang_saya');
})->name('profile');




