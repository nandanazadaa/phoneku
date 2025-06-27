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
use App\Models\Courier;
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
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return view('home.checkout', ['cartItems' => collect(), 'subtotal' => 0, 'couriers' => collect(), 'shippingCost' => 0, 'serviceFee' => 0, 'total' => 0, 'user' => $user]);
        }

        $couriers = Courier::all();
        $subtotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
        $serviceFee = 5000;
        $defaultCourier = $couriers->first();
        $shippingCost = $defaultCourier ? $defaultCourier->shipping_cost : 20000;
        $total = $subtotal + $shippingCost + $serviceFee;

        return view('home.checkout', compact('cartItems', 'subtotal', 'couriers', 'shippingCost', 'serviceFee', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        Log::info('Checkout store request:', $request->all());

        try {
            $request->validate([
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'courier' => 'required|exists:couriers,courier',
                'courier_service' => 'required|exists:couriers,service_type',
                'shipping_cost' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
            ]);

            // Fetch the selected courier details
            $courier = Courier::where('courier', $request->courier)
                            ->where('service_type', $request->courier_service)
                            ->firstOrFail();
            $shippingCost = $request->shipping_cost; // Use the dynamically provided shipping cost
            $serviceFee = $request->service_fee ?? 5000; // Default to 5000 if not provided
            $applicationFee = $request->application_fee ?? 2000; // Default to 2000 if not provided
            $subtotal = 0;
            $itemDetails = [];
            $orderItems = [];

            foreach ($request->products as $prod) {
                $product = Product::findOrFail($prod['product_id']);
                $quantity = $prod['quantity'];

                $currentCartQuantity = Cart::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->sum('quantity');
                $availableStock = $product->stock - ($currentCartQuantity - $quantity);
                if ($quantity > $availableStock) {
                    return response()->json(['error' => "Stok tidak mencukupi untuk produk {$product->name}."], 400);
                }

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

            // Use the total provided by the client for consistency
            $total = $request->total;

            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . time(),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'service_fee' => $serviceFee,
                'application_fee' => $applicationFee,
                'total' => $total,
                'courier' => $request->courier,
                'courier_service' => $request->courier_service,
                'shipping_address' => $user->profile->address ?? 'No address set',
                'order_status' => 'dibuat',
            ]);

            foreach ($orderItems as $item) {
                OrderItem::create(array_merge($item, ['order_id' => $order->id]));
            }

            Cart::where('user_id', $user->id)->delete();

            // Tambahkan ongkir dan biaya layanan ke item_details
            if ($shippingCost > 0) {
                $itemDetails[] = [
                    'id' => 'SHIPPING',
                    'price' => $shippingCost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim (' . $request->courier . ' - ' . $request->courier_service . ')',
                ];
            }

            if ($serviceFee > 0) {
                $itemDetails[] = [
                    'id' => 'SERVICE_FEE',
                    'price' => $serviceFee,
                    'quantity' => 1,
                    'name' => 'Biaya Layanan',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $total, // Use the dynamically provided total
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->profile->phone ?? '',
                ],
                'item_details' => $itemDetails,
                'callbacks' => [
                    'finish' => url('/cart'),
                    'error' => url('/checkout'),
                    'pending' => url('/checkout'),
                ],
            ];

            Log::info('Midtrans Params:', $params);
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken, 'order_id' => $order->order_code]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first(), 'errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function buyNow(Request $request, $productId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $product = Product::findOrFail($productId);
        $quantity = $request->quantity;

        $currentCartQuantity = Cart::where('user_id', $user->id)->where('product_id', $productId)->sum('quantity');
        $availableStock = $product->stock - $currentCartQuantity;

        if ($quantity > $availableStock) {
            return redirect()->back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang diminta.']);
        }

        Cart::where('user_id', $user->id)->delete();
        Cart::create(['user_id' => $user->id, 'product_id' => $productId, 'quantity' => $quantity]);

        return redirect()->route('checkout');
    }

    public function midtransCallback(Request $request)
    {
        try {
            Log::info('Midtrans callback received:', $request->all());
            
            $notif = new \Midtrans\Notification();
            $order = Order::where('order_code', $notif->order_id)->first();
            
            if (!$order) {
                Log::error('Order not found for callback: ' . $notif->order_id);
                return response()->json(['error' => 'Order not found'], 404);
            }

            $oldPaymentStatus = $order->payment_status;
            $oldOrderStatus = $order->order_status;

            // Update payment status based on transaction status
            switch ($notif->transaction_status) {
                case 'capture':
                case 'settlement':
                    $order->payment_status = 'completed';
                    $order->order_status = 'diproses'; // Auto update order status to processed
                    break;
                    
                case 'pending':
                    $order->payment_status = 'pending';
                    $order->order_status = 'dibuat';
                    break;
                    
                case 'expire':
                case 'cancel':
                case 'deny':
                    $order->payment_status = 'failed';
                    $order->order_status = 'dibatalkan';
                    break;
                    
                case 'refund':
                    $order->payment_status = 'refunded';
                    $order->order_status = 'dibatalkan';
                    break;
                    
                default:
                    Log::warning('Unknown transaction status: ' . $notif->transaction_status);
                    break;
            }

            // Save midtrans transaction ID if available
            if (!empty($notif->transaction_id)) {
                $order->midtrans_transaction_id = $notif->transaction_id;
            }

            $order->save();

            // Log the status change
            Log::info('Midtrans callback processed successfully', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'transaction_id' => $notif->transaction_id,
                'transaction_status' => $notif->transaction_status,
                'old_payment_status' => $oldPaymentStatus,
                'new_payment_status' => $order->payment_status,
                'old_order_status' => $oldOrderStatus,
                'new_order_status' => $order->order_status,
                'fraud_status' => $notif->fraud_status ?? 'N/A'
            ]);

            return response()->json(['status' => 'ok']);
            
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}