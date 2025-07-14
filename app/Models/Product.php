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
        'brand',
        'is_featured',
        'stock',
        'image',
        'image2',
        'image3',
        'colors',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'is_featured' => 'boolean',
        'stock' => 'integer',
        'colors' => 'array',
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
     * Get valid hex colors only
     */
    public function getValidColorsAttribute()
    {
        return array_filter($this->colors ?? [], function($color) {
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color);
        });
    }

    /**
     * Convert hex color to a user-friendly color name.
     * @param string $hex The hex color code.
     * @return string The color name or the hex code if not found.
     */
    public function getFriendlyColorName(string $hex): string
    {
        $colorNames = [
            '#FFFFFF' => 'Putih',
            '#000000' => 'Hitam',
            '#FF0000' => 'Merah',
            '#00FF00' => 'Hijau',
            '#0000FF' => 'Biru',
            '#FFFF00' => 'Kuning',
            '#FF00FF' => 'Magenta',
            '#00FFFF' => 'Cyan',
            '#FFA500' => 'Orange',
            '#800080' => 'Ungu',
            '#FFC0CB' => 'Pink',
            '#A52A2A' => 'Coklat',
            '#808080' => 'Abu-abu',
            '#C0C0C0' => 'Silver',
            '#FFD700' => 'Emas',
            '#800000' => 'Maroon',
            '#008000' => 'Hijau Tua',
            '#000080' => 'Navy',
            '#008080' => 'Teal',
            '#808000' => 'Olive',
            // Add more common colors as needed
        ];

        $hex = strtoupper($hex);

        // Normalize 3-digit hex to 6-digit for better matching if needed
        if (strlen($hex) === 4) { // e.g., #FFF
            $hex = '#' . $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
        }

        return $colorNames[$hex] ?? $hex; // Return name if found, otherwise return the hex
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
