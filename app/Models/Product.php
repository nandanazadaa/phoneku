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
        'brand',
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
        'color' => 'array', // This is correct and crucial
    ];

    /**
     * Get formatted price with Rp prefix.
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . Number::format($this->price, locale: 'id');
    }

    /**
     * Get formatted original price with Rp prefix.
     */
    public function getFormattedOriginalPriceAttribute()
    {
        if (!$this->original_price) {
            return null;
        }
        return 'Rp ' . Number::format($this->original_price, locale: 'id');
    }

    /**
     * Check if product has a discount.
     */
    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get valid hex colors only from the 'color' attribute.
     * This accessor is derived from the 'color' attribute after it's cast to an array.
     */
    public function getValidColorsAttribute()
    {
        // FIX: Ensure $this->color is an array before using array_filter
        // If $this->color is unexpectedly null or a string, this ensures it's an array.
        $colors = $this->color ?? []; // If $this->color is null, default to an empty array

        // If for some reason $this->color is still a string (e.g., direct database read before casting happens fully)
        // you might need to manually explode it, though casting should prevent this.
        // As a fallback for problematic legacy data or unusual access patterns:
        if (!is_array($colors) && is_string($colors)) {
            $colors = explode(',', $colors);
        } elseif (!is_array($colors)) {
            // If it's neither an array nor a string, make it an empty array to prevent further errors
            $colors = [];
        }


        return array_filter($colors, function($color) {
            // Basic hex validation for both 3-digit and 6-digit hex codes
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', trim($color));
        });
    }

    /**
     * Convert hex color to a user-friendly color name.
     * @param string $hex The hex color code.
     * @return string The color name or the hex code if not found.
     */
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
