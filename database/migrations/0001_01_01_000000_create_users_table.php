<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id_user'); // Menyesuaikan dengan nama di gambar
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('new_password')->nullable();
            $table->string('role'); // Bisa diubah ke enum/integer sesuai kebutuhan
            $table->string('otp')->nullable();
            $table->timestamps(); // Tetap disertakan untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
