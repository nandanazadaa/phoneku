<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
{
    try {
        Log::info('Attempting to add product to cart', ['productId' => $productId, 'userId' => Auth::id()]);

        $product = Product::findOrFail($productId);
        $user = Auth::user();

        if (!$user) {
            Log::warning('User not authenticated', ['productId' => $productId]);
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $cart->quantity += 1;
        if (!$cart->save()) {
            Log::error('Failed to save cart', ['cartId' => $cart->id]);
            throw new \Exception('Failed to save cart');
        }

        $cartCount = Cart::where('user_id', $user->id)->sum('quantity');

        Log::info('Product added to cart successfully', ['cartId' => $cart->id, 'cartCount' => $cartCount]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cartCount' => $cartCount
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error adding product to cart', [
            'error' => $e->getMessage(),
            'productId' => $productId,
            'userId' => Auth::id(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
        ], 500);
    }
}

public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login', ['redirect' => url()->current()]);
    }
    
    $user = Auth::user();
    
    $cartItems = Cart::where('user_id', $user->id)
        ->with('product')
        ->get();

    $subtotal = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    return view('Home.cart', [
        'cartItems' => $cartItems,
        'subtotal' => $subtotal,
    ]);
}

    /**
     * Update item quantity in the cart.
     */
    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        
        // Make sure this cart item belongs to the current user
        if ($cartItem->user_id != Auth::user()->id_user) {
            return redirect()->route('cart')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $product = $cartItem->product;
        // Cek jika produk sudah tidak ada
        if (!$product) {
            $cartItem->delete(); // Hapus item cart jika produk tidak ada
            return redirect()->route('cart')->with('warning', 'Produk tidak ditemukan dan telah dihapus dari keranjang.');
        }

        $newQuantity = (int) $request->input('quantity', $cartItem->quantity);

        // Validasi: minimal 1. Jika < 1, hapus item.
        if ($newQuantity < 1) {
             $cartItem->delete();
             return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }
        // Validasi: tidak melebihi stok. Jika melebihi, set ke stok maksimal.
        elseif ($newQuantity > $product->stock) {
            $newQuantity = $product->stock;
            if ($newQuantity == $cartItem->quantity) {
                 // Stok tersedia sama dengan kuantitas yang sudah ada di cart, tidak perlu update
                 return redirect()->route('cart')->with('warning', 'Kuantitas disesuaikan dengan stok yang tersedia (Stok: ' . $product->stock . '). Tidak ada perubahan pada jumlah saat ini.');
            }
            $message = 'Kuantitas disesuaikan dengan stok yang tersedia (Stok: ' . $product->stock . ')';
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            return redirect()->route('cart')->with('warning', $message);
        }

        // Jika valid dan ada perubahan kuantitas
        if ($newQuantity !== $cartItem->quantity) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            return redirect()->route('cart')->with('success', 'Kuantitas berhasil diperbarui!');
        }

        // Jika tidak ada perubahan kuantitas dan valid
        return redirect()->route('cart'); // Redirect tanpa pesan
    }


    /**
     * Remove item from cart.
     */
    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        
        // Make sure this cart item belongs to the current user
        if ($cartItem->user_id != Auth::user()->id_user) {
            return redirect()->route('cart')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $cartItem->delete();

        $cartItem->delete();
        return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Show the checkout page with cart items.
     */
    public function showCheckout()
    {
        $userId = Auth::guard('web')->id();
        if (!$userId) {
            return redirect()->route('login'); // Middleware 'auth:web' seharusnya sudah mencegah ini
        }

        // Ambil item cart yang produknya masih ada dan stoknya > 0
        $cartItems = Cart::where('user_id', $userId)
                        ->whereHas('product', function ($query) {
                            $query->where('stock', '>', 0); // Hanya item dengan stok > 0
                        })
                        ->with(['product' => function($query) {
                            $query->select('id', 'name', 'price', 'image', 'stock', 'description'); // Ambil kolom yang diperlukan
                        }])
                        ->get();

        // Filter lagi untuk memastikan semua item memiliki produk (double check, meskipun whereHas sudah bantu)
        $validCartItems = $cartItems->filter(function ($item) {
            return $item->product != null;
        });

        // Jika tidak ada item yang bisa dicheckout (setelah filter stok > 0)
        if ($validCartItems->isEmpty()) {
            // Cek apakah ada item di cart user yang stoknya habis untuk memberi pesan spesifik
            $hasItemsWithZeroStock = Cart::where('user_id', $userId)
                                         ->whereHas('product', function ($query) { $query->where('stock', '<=', 0); })
                                         ->exists();
            if ($hasItemsWithZeroStock) {
                 return redirect()->route('cart')->with('warning', 'Beberapa produk di keranjang Anda habis stok. Silakan perbarui keranjang Anda.');
            } else {
                 return redirect()->route('cart')->with('warning', 'Keranjang Anda kosong atau produk yang dipilih tidak tersedia untuk checkout.');
            }
        }

        // Hitung subtotal hanya dari item yang valid
        $subtotal = $validCartItems->sum(function ($item) {
            // Gunakan kuantitas yang bisa dibeli (min antara kuantitas cart dan stok produk saat ini - seharusnya sudah di filter di whereHas)
            $quantity = min($item->quantity, $item->product->stock);
            return $item->product->price * $quantity;
        });

        // Contoh biaya pengiriman dan service fee (buat lebih dinamis nanti)
        $shippingCost = 20000;
        $serviceFee = 1000;
        // Note: Logic voucher harus ditambahkan di sini jika ingin dihitung di backend

        $totalAmount = $subtotal + $shippingCost + $serviceFee;
        // Jika ada diskon voucher, kurangi dari totalAmount

        // Kirim data ke view checkout
        return view('Home.checkout', [
            'cartItems' => $validCartItems, // Kirim hanya item yang valid
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'serviceFee' => $serviceFee,
            'totalAmount' => $totalAmount,
            // Tambahkan data lain seperti alamat default user, daftar voucher, dll. jika ada
        ]);
    }

     // Tambahkan method untuk proses pembayaran jika ada
     // public function processCheckout(Request $request) { ... }
}