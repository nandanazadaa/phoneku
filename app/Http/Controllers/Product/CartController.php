<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Silakan login untuk menambahkan produk ke keranjang.'], 401);
            }
            return redirect()->route('login', ['redirect' => url()->current()]);
        }

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', $user->id_user)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
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
        $cartItems = Cart::where('user_id', Auth::user()->id_user)
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
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart')->with('success', 'Kuantitas berhasil diperbarui!');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}