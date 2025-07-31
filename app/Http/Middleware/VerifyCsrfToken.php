<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Tambahkan baris ini untuk mengizinkan notifikasi dari Midtrans
        // agar status pembayaran bisa ter-update secara otomatis.
        'midtrans/callback'
    ];
}
