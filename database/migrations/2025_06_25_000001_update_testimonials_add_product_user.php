<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            $table->unsignedBigInteger('user_id')->nullable()->after('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['product_id', 'user_id']);
        });
    }
};
