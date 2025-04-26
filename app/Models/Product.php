<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'category',
        'is_featured',
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'is_featured' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Get formatted price with Rp prefix
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price with Rp prefix
     */
    public function getFormattedOriginalPriceAttribute()
    {
        if (!$this->original_price) {
            return null;
        }
        
        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    /**
     * Check if product has a discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Scope a query to only include handphones.
     */
    public function scopePhones($query)
    {
        return $query->where('category', 'handphone');
    }

    /**
     * Scope a query to only include accessories.
     */
    public function scopeAccessories($query)
    {
        return $query->where('category', 'accessory');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}