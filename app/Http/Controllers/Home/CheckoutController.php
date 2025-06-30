<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $serverKey = config('midtrans.serverKey');
        $clientKey = config('midtrans.clientKey');
        $isProduction = config('midtrans.isProduction');
        $is3ds = config('midtrans.3ds');

        // Validate keys
        if (empty($serverKey) || empty($clientKey)) {
            throw new \Exception('Midtrans server or client key is not configured. Please check your .env file.');
        }
        Log::info('Midtrans Config - Server Key: ' . $serverKey . ', Client Key: ' . $clientKey . ', Is Production: ' . var_export($isProduction, true));

        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction ?? false;
        Config::$isSanitized = true;
        Config::$is3ds = $is3ds ?? true;
    }

    public function index()
    {
        $user = Auth::check() ? Auth::user() : null;
        $cartItems = $user ? Cart::where('user_id', $user->id)->with('product')->get() : collect();
        $subtotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
        $shippingCost = 20000;
        $serviceFee = 5000;
        $total = $subtotal + $shippingCost + $serviceFee;

        return view('home.checkout', compact('cartItems', 'subtotal', 'shippingCost', 'serviceFee', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::check() ? Auth::user() : null;
        if (!$user) {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        Log::info('Request data:', $request->all());

        try {
            $request->validate([
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'shipping_cost' => 'nullable|integer',
                'service_fee' => 'nullable|integer',
            ]);

            $shippingCost = $request->shipping_cost ?? 20000;
            $serviceFee = $request->service_fee ?? 5000;
            $subtotal = 0;
            $itemDetails = [];
            $orderItems = [];

            foreach ($request->products as $prod) {
                $product = \App\Models\Product::findOrFail($prod['product_id']);
                $quantity = $prod['quantity'];
                $subtotal += $product->price * $quantity;
                $itemDetails[] = [
                    'id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'name' => $product->name,
                ];
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }
            $total = $subtotal + $shippingCost + $serviceFee;

            $currentCartQuantity = Cart::where('user_id', $user->id)->where('product_id', $product->id)->sum('quantity');
            if ($quantity > ($product->stock - $currentCartQuantity)) {
                return response()->json(['error' => 'Stok tidak mencukupi untuk jumlah yang diminta.'], 400);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . time(),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'service_fee' => $serviceFee,
                'total' => $total,
                'courier' => $request->courier ?? 'jne',
                'courier_service' => $request->courier_service ?? 'REG',
                'shipping_address' => $user->profile->address ?? 'No address set',
                'payment_status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                \App\Models\OrderItem::create(array_merge($item, ['order_id' => $order->id]));
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->profile->phone ?? '',
                ],
                'item_details' => $itemDetails,
            ];

            Log::info('Midtrans Params:', $params);
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken, 'order_id' => $order->order_code]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first(), 'errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function buyNow(Request $request, $productId)
    {
        $user = Auth::check() ? Auth::user() : null;
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->quantity;

        $currentCartQuantity = $user ? Cart::where('user_id', $user->id)->where('product_id', $productId)->sum('quantity') : 0;
        $availableQuantity = $product->stock - $currentCartQuantity;

        if ($quantity > $availableQuantity) {
            return redirect()->back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang diminta.']);
        }

        if ($user) {
            Cart::where('user_id', $user->id)->delete();
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('checkout');
    }
}