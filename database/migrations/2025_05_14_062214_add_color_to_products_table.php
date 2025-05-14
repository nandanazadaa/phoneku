<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'color')) {
                $table->string('color')->nullable()->after('stock'); // atau sesuaikan posisi
            }
             // Pastikan kolom image2 dan image3 juga ada jika belum
            if (!Schema::hasColumn('products', 'image2')) {
                $table->string('image2')->nullable()->after('image');
            }
            if (!Schema::hasColumn('products', 'image3')) {
                $table->string('image3')->nullable()->after('image2');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('products', 'image2')) {
                $table->dropColumn('image2');
            }
            if (Schema::hasColumn('products', 'image3')) {
                $table->dropColumn('image3');
            }
        });
    }
}