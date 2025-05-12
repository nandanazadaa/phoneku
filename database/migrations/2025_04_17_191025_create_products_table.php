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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->enum('category', ['handphone', 'accessory']);
            $table->boolean('is_featured')->default(false);
            $table->integer('stock');
            // PERBAIKAN: Menggunakan string untuk 1 gambar utama
            $table->string('image')->nullable();
            // Jika Anda benar-benar butuh multi-image, Anda perlu model terpisah (ProductImage)
            // dan relasi hasMany, serta menyesuaikan Controller & View
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};