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

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        
        // Make sure this cart item belongs to the current user
        if ($cartItem->user_id != Auth::user()->id_user) {
            return redirect()->route('cart')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart')->with('success', 'Kuantitas berhasil diperbarui!');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        
        // Make sure this cart item belongs to the current user
        if ($cartItem->user_id != Auth::user()->id_user) {
            return redirect()->route('cart')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}