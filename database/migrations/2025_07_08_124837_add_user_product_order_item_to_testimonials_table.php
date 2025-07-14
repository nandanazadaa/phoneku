<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Tambahkan user_id hanya jika belum ada
            if (!Schema::hasColumn('testimonials', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
            }
            // Tambahkan product_id jika belum ada
            if (!Schema::hasColumn('testimonials', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade')->after('user_id');
            }
            // Tambahkan order_item_id jika belum ada
            if (!Schema::hasColumn('testimonials', 'order_item_id')) {
                $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('cascade')->after('product_id');
            }
        });
    }

    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Hapus kolom hanya jika ada
            if (Schema::hasColumn('testimonials', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('testimonials', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('testimonials', 'order_item_id')) {
                $table->dropForeign(['order_item_id']);
                $table->dropColumn('order_item_id');
            }
        });
    }
};
