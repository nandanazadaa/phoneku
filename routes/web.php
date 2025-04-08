<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Home/welcome');
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

Route::get('/kontak', function () {
    return view('home.kontak');
});



