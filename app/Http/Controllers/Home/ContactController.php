<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KontakMasukMail;

class ContactController extends Controller
{
    public function kirim(Request $request)
    {
        // 1. Validasi data
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email',
            'subjek' => 'required|string|max:200',
            'pesan' => 'required|string',
        ]);

        // 2. Panggil Mailable dan kirim datanya
        Mail::to(config('mail.mail_to_admin'))->send(new KontakMasukMail($data));

        // 3. Kembali dengan pesan sukses
        return back()->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim.');
    }
}