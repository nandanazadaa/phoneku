<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah tabel users ada
        if (!Schema::hasTable('users')) {
            // Jika tabel tidak ada, buat tabel users
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('new_password')->nullable();
                $table->string('role')->default('user');
                $table->string('otp')->nullable();
                $table->timestamps();
            });
        } else {
            // Jika tabel ada, cek dan tambahkan kolom yang hilang
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'new_password')) {
                    $table->string('new_password')->nullable();
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('user');
                }
                if (!Schema::hasColumn('users', 'otp')) {
                    $table->string('otp')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $columns = ['new_password', 'role', 'otp'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('users', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};