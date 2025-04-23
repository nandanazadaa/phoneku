<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handphone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'image',
        'category',
        'is_featured',
        'stock'
    ];

    /**
     * Get the formatted price with currency symbol
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the formatted original price with currency symbol
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'Rp ' . number_format($this->original_price, 0, ',', '.') : null;
    }

    /**
     * Check if the product has a discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Scope a query to only include phone products.
     */
    public function scopePhones($query)
    {
        return $query->where('category', 'handphone');
    }

    /**
     * Scope a query to only include accessory products.
     */
    // public function scopeAccessories($query)
    // {
    //     return $query->where('category', 'accessory');
    // }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}