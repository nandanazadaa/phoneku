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

