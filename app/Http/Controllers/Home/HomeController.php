<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class HomeController extends Controller
{
    public function index()
    {
        $featuredPhones = Product::phones()->featured()->take(4)->get();
        $featuredAccessories = Product::accessories()->featured()->take(4)->get();
        $phones = Product::phones()->latest()->take(4)->get();
        $accessories = Product::accessories()->latest()->take(4)->get();

        return view('home.welcome', compact('featuredPhones', 'featuredAccessories', 'phones', 'accessories'));
    }

    /**
     * Display all products.
     */
    public function allProducts(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');
        
        $query = Product::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        $products = $query->latest()->paginate(12);
        
        return view('home.allproduct', compact('products'));
    }


    /**
     * Display a specific product.
     */
    public function showProduct(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('home.product', compact('product', 'relatedProducts'));
    }
}
