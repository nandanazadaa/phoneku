<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('courier'); // e.g., jne, pos, tiki
            $table->string('service_type'); // e.g., regular, express, economy
            $table->decimal('shipping_cost', 10, 2); // Supports up to 10 digits with 2 decimal places
            $table->timestamps();
            $table->unique(['courier', 'service_type']); // Ensure unique combinations
        });
    }

    public function down()
    {
        Schema::dropIfExists('couriers');
    }
}