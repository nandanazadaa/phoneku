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
use Illuminate\Support\Number;

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
            'brand' => 'nullable|string|max:255', // <-- Add validation for brand
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        $data['color'] = $request->input('color', '');
        $data['is_featured'] = $request->boolean('is_featured');
        // 'brand' is already included in $data from $request->except() since it's not an image field.
        // No explicit setting needed here as long as it's passed via the form.

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
            'brand' => 'nullable|string|max:255', // <-- Add validation for brand
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        $data['color'] = $request->input('color', '');
        $data['is_featured'] = $request->boolean('is_featured');
        // 'brand' is already included in $data from $request->except() since it's not an image field.

        $imageFields = ['image', 'image2', 'image3'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
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

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Jika ada file gambar, hapus dari storage (opsional)
        if ($product->image) {
            \Storage::delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }

    // ... (rest of your controller methods)

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
            'brand' => $request->brand ?? null, // <-- Pass brand to preview
            'is_featured' => $request->boolean('is_featured'),
            'stock' => $request->stock ?? 0,
            'color' => $request->color ?? '',
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

        $testimonials = Testimonial::where('product_id', $product->id)
            ->where('is_approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $averageRating = $testimonials->avg('rating') ?? 0;

        $colors = $product->valid_colors; // Use the accessor to get validated colors

        $selectedColor = old('color', !empty($colors) ? $colors[0] : '');

        return view('Home.product', compact('product', 'relatedProducts', 'cartQuantity', 'testimonials', 'colors', 'selectedColor', 'averageRating'));
    }
}
