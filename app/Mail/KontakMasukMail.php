<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class KontakMasukMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Properti untuk menyimpan data dari controller

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Mengatur "amplop" email: subjek, balasan-ke, dll.
    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->data['email'], $this->data['nama_lengkap'])
            ],
            subject: 'Pesan Kontak Baru: ' . $this->data['subjek'],
        );
    }

    // Mengatur "isi" email: menunjuk ke file view mana yang akan digunakan
    public function content(): Content
    {
        return new Content(
            view: 'emails.kontak-form', // Ini akan menjadi file HTML kita
        );
    }
}