<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
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
            'image' => 'nullable|image|mimes:png|max:2048',
        ]);
    
        $data = $request->except('image');
        
        // Set is_featured to false if not provided
        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }
        
        // Handle image upload with improved error handling
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                
                // Check if the file is valid
                if (!$image->isValid()) {
                    return redirect()->back()
                        ->with('error', 'Uploaded file is not valid.')
                        ->withInput();
                }
                
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
                
                // Store with explicit public disk
                $path = $image->storeAs('products', $imageName, 'public');
                
                // For debugging
                if (!$path) {
                    return redirect()->back()
                        ->with('error', 'Failed to save image to storage.')
                        ->withInput();
                }
                
                // Set the image path correctly
                $data['image'] = $path;
                
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Error uploading image: ' . $e->getMessage())
                    ->withInput();
            }
        }
    
        Product::create($data);
    
        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Product created successfully.');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');
        
        // Set is_featured to false if not provided
        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete product image if exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products', ['tab' => 'list'])
            ->with('success', 'Product deleted successfully.');
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
}