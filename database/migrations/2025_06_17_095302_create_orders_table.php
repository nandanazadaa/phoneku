<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateOrdersTable extends Migration
  {
      public function up()
      {
          Schema::create('orders', function (Blueprint $table) {
              $table->id();
              $table->unsignedBigInteger('user_id');
              $table->string('order_code')->unique();
              $table->decimal('subtotal', 10, 2);
              $table->decimal('shipping_cost', 10, 2);
              $table->decimal('service_fee', 10, 2);
              $table->decimal('total', 10, 2);
              $table->string('courier');
              $table->string('courier_service');
              $table->text('shipping_address');
              $table->string('order_status')->default('dibuat');
              $table->string('payment_status')->default('pending');
              $table->text('notes')->nullable();
              $table->string('midtrans_transaction_id')->nullable();
              $table->timestamps();

              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          });
      }

      public function down()
      {
          Schema::dropIfExists('orders');
      }
  }