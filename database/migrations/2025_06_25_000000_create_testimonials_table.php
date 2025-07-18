<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->text('message')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};
