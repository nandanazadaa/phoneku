<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Number; // Ensure this is imported for formatted prices in Product model (if used directly here, otherwise Product model handles it)

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'list');
        $search = $request->query('search');

        // Get products for the list tab
        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(10);

        // Handle edit tab
        $editProduct = null;
        if ($tab === 'edit' && $request->has('id')) {
            $editProduct = Product::findOrFail($request->id);
        }

        return view('admin.product_card', compact('products', 'tab', 'editProduct'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|in:handphone,accessory',
            'brand' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string', // Incoming from form as comma-separated string
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        // Set color to an empty string if not provided, ensures it's not null before casting to array
        $data['color'] = $request->input('color', '');
        // Use boolean helper to ensure true/false
        $data['is_featured'] = $request->boolean('is_featured');

        $imageFields = ['image', 'image2', 'image3'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $image = $request->file($field);
                    if (!$image->isValid()) {
                        return redirect()->back()
                            ->with('error', "File {$field} tidak valid.")
                            ->withInput();
                    }
                    $imageName = Str::slug($request->name) . '-' . $field . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('products', $imageName, 'public');
                    if (!$path) {
                        return redirect()->back()
                            ->with('error', "Gagal menyimpan {$field} ke storage.")
                            ->withInput();
                    }
                    $data[$field] = $path;
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', "Error upload {$field}: " . $e->getMessage())
                        ->withInput();
                }
            }
        }

        Product::create($data);

        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Produk berhasil dibuat.');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|in:handphone,accessory',
            'brand' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string', // Incoming from form as comma-separated string
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        // Set color to an empty string if not provided
        $data['color'] = $request->input('color', '');
        // Use boolean helper to ensure true/false
        $data['is_featured'] = $request->boolean('is_featured');

        $imageFields = ['image', 'image2', 'image3'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($product->$field) {
                    Storage::disk('public')->delete($product->$field);
                }
                $image = $request->file($field);
                $imageName = Str::slug($request->name) . '-' . $field . '-' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $imageName, 'public');
                $data[$field] = $path;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Produk berhasil diupdate.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete product images if exist
        $imageFields = ['image', 'image2', 'image3'];
        foreach ($imageFields as $field) {
            if ($product->$field) {
                Storage::disk('public')->delete($product->$field);
            }
        }

        $product->delete();

        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Preview the product card.
     */
    public function preview(Request $request)
    {
        $product = new Product([
            'name' => $request->name ?? 'Product Name',
            'description' => $request->description ?? null,
            'price' => $request->price ?? 0,
            'original_price' => $request->original_price ?? null,
            'category' => $request->category ?? 'handphone',
            'brand' => $request->brand ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'stock' => $request->stock ?? 0,
            'color' => $request->color ?? '', // This will be cast to array by model
        ]);

        $imagePreview = null;
        if ($request->has('image_preview')) {
            $imagePreview = $request->image_preview;
        }

        return view('admin.products.preview', compact('product', 'imagePreview'));
    }

    /**
     * Display a specific product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Fetch related products (e.g., from the same category, excluding the current product)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4) // Limit to 4 related products
            ->get();

        // Calculate cart quantity for authenticated users
        $cartQuantity = 0;
        if (Auth::guard('web')->check()) {
            $cartQuantity = Cart::where('user_id', Auth::guard('web')->id())
                ->where('product_id', $product->id)
                ->sum('quantity');
        }

        // Fetch testimonials for this product
        $testimonials = Testimonial::where('product_id', $product->id)
            ->where('is_approved', true) // Only approved testimonials
            ->with('user') // Eager load the user relationship to get user's name/photo
            ->orderBy('created_at', 'desc') // Order by latest
            ->paginate(6); // Paginate testimonials, 6 per page

        $averageRating = $testimonials->avg('rating') ?? 0;

        $colors = $product->valid_colors;

        $selectedColor = old('color', !empty($colors) ? $colors[0] : '');

        return view('Home.product', compact('product', 'relatedProducts', 'cartQuantity', 'testimonials', 'colors', 'selectedColor', 'averageRating'));
    }
}
