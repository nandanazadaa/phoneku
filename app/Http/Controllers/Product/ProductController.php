<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        // Set is_featured to false if not provided
        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        // Handle image uploads
        $imageFields = ['image', 'image2', 'image3'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $image = $request->file($field);

                    // Check if the file is valid
                    if (!$image->isValid()) {
                        return redirect()->back()
                            ->with('error', "File {$field} tidak valid.")
                            ->withInput();
                    }

                    $imageName = Str::slug($request->name) . '-' . $field . '-' . time() . '.' . $image->getClientOriginalExtension();

                    // Store with explicit public disk
                    $path = $image->storeAs('products', $imageName, 'public');

                    // For debugging
                    if (!$path) {
                        return redirect()->back()
                            ->with('error', "Gagal menyimpan {$field} ke storage.")
                            ->withInput();
                    }

                    // Set the image path correctly
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
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        // Set is_featured to false if not provided
        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        // Handle image uploads
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
        // Create a temporary product object with the provided data
        $product = new Product([
            'name' => $request->name ?? 'Product Name',
            'price' => $request->price ?? 0,
            'original_price' => $request->original_price ?? null,
            'category' => $request->category ?? 'handphone',
            'color' => $request->color ?? '',
        ]);

        // For proper display in the template
        $product->formatted_price = 'Rp ' . number_format($product->price, 0, ',', '.');

        if ($product->original_price) {
            $product->formatted_original_price = 'Rp ' . number_format($product->original_price, 0, ',', '.');
            $product->has_discount = true;
        }

        // Handle temporary image preview
        $imagePreview = null;
        if ($request->has('image_preview')) {
            $imagePreview = $request->image_preview;
        }

        return view('admin.products.preview', compact('product', 'imagePreview'));
    }

    public function show($id) {
        $product = Product::findOrFail($id);

        $testimonials = Testimonial::where('product_id', $product->id)
                    ->with('user')
                    ->paginate(6);

        $averageRating = $testimonials->avg('rating') ?? 0; // hitung rata-rata

        return view('Home.product', [
            'product' => $product,
            'testimonials' => $testimonials,
            'averageRating' => $averageRating,
        ]);
    }
}
