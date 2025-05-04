<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Add product to cart.
     * Menggunakan Route Model Binding untuk $product.
     */
    public function addToCart(Request $request, Product $product)
    {
        if (!Auth::guard('web')->check()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Silakan login untuk menambahkan produk.'], 401);
            }
            Session::put('redirect_url', route('product.show', $product->id));
            return redirect()->route('login')->with('warning', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $user = Auth::guard('web')->user();
        $userId = $user->id; // Gunakan ID user yang sedang login

        if ($product->stock <= 0) {
             if ($request->ajax()) {
                 return response()->json(['success' => false, 'message' => 'Stok produk habis.'], 400);
             }
             return redirect()->back()->with('error', 'Stok produk habis.');
        }

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                 if ($request->ajax()) {
                     return response()->json(['success' => false, 'message' => 'Gagal menambahkan, jumlah di keranjang (' . $cartItem->quantity . ') + jumlah tambah (' . $quantity . ') melebihi stok (' . $product->stock . ')'], 400);
                 }
                return redirect()->back()->with('error', 'Gagal menambahkan, jumlah di keranjang (' . $cartItem->quantity . ') + jumlah tambah (' . $quantity . ') melebihi stok (' . $product->stock . ')');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            $message = 'Kuantitas produk di keranjang diperbarui!';
        } else {
             if ($quantity > $product->stock) {
                 if ($request->ajax()) {
                      return response()->json(['success' => false, 'message' => 'Jumlah yang diminta (' . $quantity . ') melebihi stok (' . $product->stock . ')'], 400);
                  }
                 return redirect()->back()->with('error', 'Jumlah yang diminta (' . $quantity . ') melebihi stok (' . $product->stock . ')');
             }
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        $cartCount = Cart::where('user_id', $userId)->sum('quantity'); // Hitung total kuantitas di cart

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cartCount' => $cartCount,
            ]);
        }

        // Redirect ke halaman keranjang setelah berhasil
        return redirect()->route('cart')->with('success', $message);
    }

    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $userId = Auth::guard('web')->id();
        if (!$userId) {
            return redirect()->route('login');
        }

        // Mengambil item cart beserta data produk terkait
        $cartItems = Cart::where('user_id', $userId)
            ->whereHas('product') // Hanya ambil item yang produknya masih ada di DB
            ->with(['product' => function ($query) {
                // Pilih kolom yang relevan dari tabel produk untuk efisiensi
                $query->select('id', 'name', 'price', 'image', 'stock', 'original_price'); // Pastikan kolom yang dibutuhkan ada
            }])
            ->latest() // Urutkan berdasarkan yang terbaru ditambahkan/diupdate
            ->get();

        // Hitung subtotal berdasarkan item yang valid (produk ada & stok > 0)
        $subtotal = $cartItems->sum(function ($item) {
            // Pastikan produk ada dan stok cukup
            if ($item->product && $item->product->stock > 0 && $item->quantity > 0) {
                 // Gunakan kuantitas yang bisa dibeli (min antara kuantitas di cart dan stok)
                 $quantityToCalculate = min($item->quantity, $item->product->stock);
                return $item->product->price * $quantityToCalculate;
            }
            return 0; // Abaikan item jika produk tidak valid atau stok habis
        });

        // Redirect ke checkout jika subtotal > 0
        // if ($subtotal > 0) {
        //     // Logika opsional: Jika user langsung ke /cart dan ada item valid, bisa langsung arahkan ke checkout
        //     // Tapi biasanya user melihat cart dulu. Jadi, ini di-comment.
        //     // return redirect()->route('checkout');
        // }

        return view('Home.cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal, // Subtotal item yang valid
        ]);
    }

    /**
     * Update item quantity in the cart.
     */
    public function updateQuantity(Request $request, $id)
    {
        $userId = Auth::guard('web')->id();
        $cartItem = Cart::where('id', $id)
                        ->where('user_id', $userId)
                        ->firstOrFail(); // Gagal jika item tidak ditemukan atau bukan milik user

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
        $userId = Auth::guard('web')->id();
        // Gunakan findOrFail untuk item milik user yang sedang login
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->firstOrFail();

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