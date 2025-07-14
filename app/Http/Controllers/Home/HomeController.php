<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
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
        $phones = Product::phones()->latest()->take(12)->get();
        $accessories = Product::accessories()->latest()->take(12)->get();

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
                } elseif (!$max) {
                    $query->where('price', '<=', $max);
                }
            }
        }

        $products = $query->latest()->paginate(12);

        return view('home.allproduct', compact('products', 'phones', 'category', 'search', 'brand', 'priceRange', 'accessories'));
    }

    /**
     * Display a specific product.
     */
    public function showProduct(Product $product)
    {
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
            ->latest()
            ->take(6)
            ->get();

        $colors = $product->colors ?? [];

        $selectedColor = old('color', $product->color ?? (isset($colors[0]) ? trim($colors[0]) : ''));

        return view('Home.product', compact('product', 'relatedProducts', 'cartQuantity', 'testimonials', 'colors', 'selectedColor'));
    }
}
