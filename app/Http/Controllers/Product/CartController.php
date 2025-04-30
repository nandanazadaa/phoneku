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
        // Check if user is authenticated
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Silakan login untuk menambahkan produk ke keranjang.'], 401);
            }
            return redirect()->route('login', ['redirect' => url()->current()]);
        }

        // Get authenticated user
        $user = Auth::user();
        
        // Debug: Make sure we have a valid user ID
        if (!$user || !$user->id_user) {
            Log::error('User ID is missing', ['user' => $user]);
            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }

        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', $user->id_user)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Create new cart item with explicit user_id
            Cart::create([
                'user_id' => $user->id_user,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $cartCount = Cart::where('user_id', $user->id_user)->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect' => url()->current()]);
        }
        
        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', $user->id_user)
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