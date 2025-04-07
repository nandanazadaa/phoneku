<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('Auth/login');
});

Route::get('/registrasi', function () {
    return view('Auth/registrasi');
});
