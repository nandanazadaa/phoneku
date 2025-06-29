<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Order extends Model
  {
      // Payment Status Constants
      const PAYMENT_STATUS_PENDING = 'pending';
      const PAYMENT_STATUS_COMPLETED = 'completed';
      const PAYMENT_STATUS_FAILED = 'failed';
      const PAYMENT_STATUS_REFUNDED = 'refunded';
      
      // Order Status Constants
      const ORDER_STATUS_DIBUAT = 'dibuat';
      const ORDER_STATUS_DIPROSES = 'diproses';
      const ORDER_STATUS_DIKIRIMKAN = 'dikirimkan';
      const ORDER_STATUS_DALAM_PENGIRIMAN = 'dalam pengiriman';
      const ORDER_STATUS_TELAH_SAMPAI = 'telah sampai';
      const ORDER_STATUS_SELESAI = 'selesai';
      const ORDER_STATUS_DIBATALKAN = 'dibatalkan';
      
      // Payment Status Options
      public static function getPaymentStatusOptions()
      {
          return [
              self::PAYMENT_STATUS_PENDING => 'Pending',
              self::PAYMENT_STATUS_COMPLETED => 'Completed',
              self::PAYMENT_STATUS_FAILED => 'Failed',
              self::PAYMENT_STATUS_REFUNDED => 'Refunded'
          ];
      }
      
      // Order Status Options
      public static function getOrderStatusOptions()
      {
          return [
              self::ORDER_STATUS_DIBUAT => 'Dibuat',
              self::ORDER_STATUS_DIPROSES => 'Diproses',
              self::ORDER_STATUS_DIKIRIMKAN => 'Dikirimkan',
              self::ORDER_STATUS_DALAM_PENGIRIMAN => 'Dalam Pengiriman',
              self::ORDER_STATUS_TELAH_SAMPAI => 'Telah Sampai',
              self::ORDER_STATUS_SELESAI => 'Selesai',
              self::ORDER_STATUS_DIBATALKAN => 'Dibatalkan'
          ];
      }

      protected $fillable = [
          'user_id', 'order_code', 'subtotal', 'shipping_cost', 'service_fee', 'total',
          'courier', 'courier_service', 'shipping_address', 'order_status', 'payment_status', 
          'midtrans_transaction_id', 'notes'
      ];

      public function user()
      {
          return $this->belongsTo(User::class);
      }

      public function items()
      {
          return $this->hasMany(OrderItem::class);
      }
      public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
  }