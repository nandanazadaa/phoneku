<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Make sure you import your Product model
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Testimonial; // Assuming you might use this elsewhere in the HomeController

class HomeController extends Controller
{
    public function index()
    {
        // ... (your existing index method code) ...
        $featuredPhones = Product::phones()->featured()->take(12)->get();
        $featuredAccessories = Product::accessories()->featured()->take(12)->get();

        $phones = Product::phones()->latest()->take(12)->get();
        $accessories = Product::accessories()->latest()->take(12)->get();

        return view('home.welcome', compact('featuredPhones', 'featuredAccessories', 'phones', 'accessories'));
    }

    /**
     * Display all products.
     */
    public function allProducts(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');
        $brand = $request->input('brand');
        $priceRange = $request->input('price_range');

        $query = Product::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($brand) {
            // Note: Your existing filtering logic for 'brand' is quite specific.
            // It slugifies the DB 'brand' column and compares it to the incoming slugged brand from request.
            // This is compatible with the changes below as long as brands are stored as human-readable strings.
            $query->whereRaw('LOWER(REPLACE(REPLACE(brand, " ", "-"), ".", "")) = ?', [strtolower($brand)]);
        }

        if ($priceRange) {
            $range = explode('-', $priceRange);
            if (count($range) == 2) {
                $min = (int) $range[0];
                $max = $range[1] !== '' ? (int) $range[1] : null;
                if ($min && $max) {
                    $query->whereBetween('price', [$min, $max]);
                } elseif ($min && !$max) {
                    $query->where('price', '>=', $min);
                } elseif (!$min && $max) { // Added this condition for price range like "-5000000" (up to 5jt)
                    $query->where('price', '<=', $max);
                }
            }
        }

        $products = $query->latest()->paginate(12);

        // --- NEW: Fetch unique brands from the database ---
        $uniqueBrands = Product::select('brand')
                            ->whereNotNull('brand') // Only get products that actually have a brand set
                            ->distinct() // Get only unique brand names
                            ->orderBy('brand') // Order alphabetically for readability
                            ->pluck('brand'); // Get as a simple array (e.g., ['Samsung', 'Apple', 'Xiaomi'])

        return view('home.allproduct', compact('products', 'uniqueBrands')); // Pass uniqueBrands to the view
    }

    /**
     * Display a specific product.
     * (This method is from ProductController, not HomeController.
     * I'm including it here only for context of your previous snippet.
     * Ensure this is in app/Http/Controllers/Product/ProductController.php if it's not already.)
     */
    public function showProduct(Product $product)
    {
        // This method should ideally be in ProductController, not HomeController.
        // Assuming it's here for now based on your previous provided code.
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $cartQuantity = 0;
        if (Auth::guard('web')->check()) {
            $cartQuantity = Cart::where('user_id', Auth::guard('web')->id())
                ->where('product_id', $product->id)
                ->sum('quantity');
        }

        $testimonials = Testimonial::where('is_approved', true)
            ->where('product_id', $product->id)
            ->with('user')
            ->latest()
            ->paginate(6);

        $averageRating = $testimonials->avg('rating') ?? 0;

        // $product->color is cast to array by Product model
        $colors = $product->valid_colors; // Use the accessor for valid hex colors

        $selectedColor = old('color', !empty($colors) ? $colors[0] : '');

        return view('Home.product', compact('product', 'relatedProducts', 'cartQuantity', 'testimonials', 'colors', 'selectedColor', 'averageRating'));
    }
}
