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

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(10);

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
            'brand' => 'required|string|in:samsung,apple,xiaomi,oppo,vivo,realme,other',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|in:handphone,accessory',
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'colors' => 'required|array|min:1|max:5', // Updated to handle array of colors
            'colors.*' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/', // Validate each color as hex
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        // Store colors as JSON array
        $data['colors'] = json_encode($data['colors']);

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
            'brand' => 'required|string|in:samsung,apple,xiaomi,oppo,vivo,realme,other',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|in:handphone,accessory',
            'is_featured' => 'boolean',
            'stock' => 'required|integer|min:0',
            'colors' => 'required|array|min:1|max:5', // Updated to handle array of colors
            'colors.*' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/', // Validate each color as hex
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'image2', 'image3']);

        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        // Store colors as JSON array
        $data['colors'] = json_encode($data['colors']);

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

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

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
            'brand' => $request->brand ?? 'Unknown',
            'price' => $request->price ?? 0,
            'original_price' => $request->original_price ?? null,
            'category' => $request->category ?? 'handphone',
            'colors' => $request->colors ? json_encode($request->colors) : json_encode(['#000000']), // Handle colors array
        ]);

        $product->formatted_price = 'Rp ' . number_format($product->price, 0, ',', '.');

        if ($product->original_price) {
            $product->formatted_original_price = 'Rp ' . number_format($product->original_price, 0, ',', '.');
            $product->has_discount = true;
        }

        $imagePreview = null;
        if ($request->has('image_preview')) {
            $imagePreview = $request->image_preview;
        }

        return view('admin.products.preview', compact('product', 'imagePreview'));
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            $testimonials = Testimonial::where('product_id', $product->id)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(6);

            $averageRating = $testimonials->isNotEmpty() ? $testimonials->avg('rating') : 0;

            $selectedColor = old('color', $product->colors[0] ?? '#000000'); // Default to first color

            return view('Home.product', [
                'product' => $product,
                'testimonials' => $testimonials,
                'averageRating' => (float) $averageRating,
                'selectedColor' => $selectedColor,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return abort(404);
        }
    }
}
