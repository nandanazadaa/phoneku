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
        'image2',
        'image3',
        'color',
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
     * Get colors as array with hex and name
     */
    public function getColorsArrayAttribute()
    {
        if (!$this->color) {
            return [];
        }
        
        $colors = array_filter(array_map('trim', explode(',', $this->color)));
        $result = [];
        
        foreach ($colors as $color) {
            if (strpos($color, '|') !== false) {
                // Format: #FFFFFF|Putih
                list($hex, $name) = explode('|', $color, 2);
                $result[] = [
                    'hex' => trim($hex),
                    'name' => trim($name)
                ];
            } else {
                // Hanya hex code, konversi ke nama warna
                $result[] = [
                    'hex' => trim($color),
                    'name' => $this->hexToColorName(trim($color))
                ];
            }
        }
        
        return $result;
    }

    /**
     * Get valid hex colors only
     */
    public function getValidColorsAttribute()
    {
        $colors = $this->colors_array;
        return array_filter($colors, function($color) {
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color['hex']);
        });
    }

    /**
     * Convert hex color to color name
     */
    private function hexToColorName($hex)
    {
        // Daftar warna umum
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
        ];

        $hex = strtoupper($hex);
        
        // Cek exact match
        if (isset($colorNames[$hex])) {
            return $colorNames[$hex];
        }
        
        // Jika tidak ada exact match, coba cari yang mirip atau return hex
        return $hex;
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