<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Di file ini kamu bisa register semua channel yang aplikasi kamu gunakan.
| Channel broadcasting akan dipakai buat fitur realtime, kayak chat, notifikasi, dll.
|
*/

Broadcast::channel('private-chat', function ($user) {
    return Auth::check();
});