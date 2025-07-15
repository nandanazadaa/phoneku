<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'category',
        'brand', // <-- Add 'brand' here
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
        'color' => 'array',
    ];

    // ... (rest of your model code remains the same)

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . Number::format($this->price, locale: 'id');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        if (!$this->original_price) {
            return null;
        }
        return 'Rp ' . Number::format($this->original_price, locale: 'id');
    }

    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    public function getValidColorsAttribute()
    {
        $colors = $this->color ?? [];
        if (!is_array($colors) && is_string($colors)) {
            $colors = explode(',', $colors);
        } elseif (!is_array($colors)) {
            $colors = [];
        }
        return array_filter($colors, function($color) {
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', trim($color));
        });
    }

    public function getFriendlyColorName($hexColor)
    {
        $hexColor = strtoupper(trim($hexColor));
        $colorNames = [
            '#F44336' => 'Red', '#E91E63' => 'Pink', '#9C27B0' => 'Purple', '#673AB7' => 'Deep Purple',
            '#3F51B5' => 'Indigo', '#2196F3' => 'Blue', '#03A9F4' => 'Light Blue', '#00BCD4' => 'Cyan',
            '#009688' => 'Teal', '#4CAF50' => 'Green', '#8BC34A' => 'Light Green', '#CDDC39' => 'Lime',
            '#FFEB3B' => 'Yellow', '#FFC107' => 'Amber', '#FF9800' => 'Orange', '#FF5722' => 'Deep Orange',
            '#795548' => 'Brown', '#9E9E9E' => 'Gray', '#607D8B' => 'Blue Grey', '#000000' => 'Black', '#FFFFFF' => 'White'
        ];
        return $colorNames[$hexColor] ?? $hexColor;
    }

    public function scopePhones($query)
    {
        return $query->where('category', 'handphone');
    }

    public function scopeAccessories($query)
    {
        return $query->where('category', 'accessory');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
