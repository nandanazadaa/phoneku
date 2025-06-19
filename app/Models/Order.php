<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Order extends Model
  {
      protected $fillable = [
          'user_id', 'order_code', 'subtotal', 'shipping_cost', 'service_fee', 'total',
          'courier', 'courier_service', 'shipping_address', 'payment_status', 'midtrans_transaction_id'
      ];

      public function user()
      {
          return $this->belongsTo(User::class);
      }

      public function items()
      {
          return $this->hasMany(OrderItem::class);
      }
  }