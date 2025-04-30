<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('profile_id');
            $table->unsignedBigInteger('user_id'); // <-- Tambahkan kolom user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('birth_day')->nullable();
            $table->integer('birth_month')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
