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
use App\Models\User;

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
                // Ambil warna dari cart
                $cartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();
                $color = $cartItem ? $cartItem->color : null;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'color' => $color, // <-- tambahkan ini
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
                    'finish' => url('/checkout/success?order_id=' . $order->order_code),
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
            Log::error('Midtrans Error: ' . $e->getMessage());
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
        $color = $request->input('color'); // Ambil warna dari request

        $currentCartQuantity = Cart::where('user_id', $user->id)->where('product_id', $productId)->sum('quantity');
        $availableStock = $product->stock - $currentCartQuantity;

        if ($quantity > $availableStock) {
            return redirect()->back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang diminta.']);
        }

        Cart::where('user_id', $user->id)->delete();
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'color' => $color, // Simpan warna ke cart
        ]);

        return redirect()->route('checkout');
    }

    public function midtransCallback(Request $request)
    {
        try {
            Log::info('Midtrans callback received:', $request->all());
            Log::info('Request headers:', $request->headers->all());
            
            // Tambahkan debugging untuk melihat raw input
            $rawInput = file_get_contents('php://input');
            Log::info('Raw input:', ['raw' => $rawInput]);
            
            $notif = new \Midtrans\Notification();
            Log::info('Notification object created:', [
                'order_id' => $notif->order_id ?? 'null',
                'transaction_status' => $notif->transaction_status ?? 'null',
                'transaction_id' => $notif->transaction_id ?? 'null',
                'fraud_status' => $notif->fraud_status ?? 'null'
            ]);
            
            $order = Order::where('order_code', $notif->order_id)->first();
            
            if (!$order) {
                Log::error('Order not found for callback: ' . $notif->order_id);
                Log::info('Available orders:', Order::pluck('order_code')->toArray());
                return response()->json(['error' => 'Order not found'], 404);
            }

            $oldPaymentStatus = $order->payment_status;
            $oldOrderStatus = $order->order_status;

            // Update payment status based on transaction status
            switch ($notif->transaction_status) {
                case 'capture':
                case 'settlement':
                    $order->payment_status = Order::PAYMENT_STATUS_COMPLETED;
                    $order->order_status = Order::ORDER_STATUS_DIPROSES;
                    
                    // Reduce stock when payment is successful
                    $this->reduceProductStock($order);
                    break;
                    
                case 'pending':
                    $order->payment_status = Order::PAYMENT_STATUS_PENDING;
                    $order->order_status = Order::ORDER_STATUS_DIBUAT;
                    break;
                    
                case 'expire':
                case 'cancel':
                case 'deny':
                    $order->payment_status = Order::PAYMENT_STATUS_FAILED;
                    $order->order_status = Order::ORDER_STATUS_DIBATALKAN;
                    break;
                    
                case 'refund':
                    $order->payment_status = Order::PAYMENT_STATUS_REFUNDED;
                    $order->order_status = Order::ORDER_STATUS_DIBATALKAN;
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

    public function testCallback(Request $request)
    {
        try {
            Log::info('Test callback endpoint called');
            
            // Simulate Midtrans callback data
            $testData = [
                'order_id' => 'ORD-' . time(),
                'transaction_status' => 'settlement',
                'transaction_id' => 'TEST-' . time(),
                'fraud_status' => 'accept'
            ];
            
            Log::info('Test data:', $testData);
            
            // Create a test order if needed
            $order = Order::where('order_code', $testData['order_id'])->first();
            if (!$order) {
                // Create a test order
                $user = Auth::user() ?? User::first();
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_code' => $testData['order_id'],
                    'subtotal' => 100000,
                    'shipping_cost' => 10000,
                    'service_fee' => 5000,
                    'total' => 115000,
                    'courier' => 'JNE',
                    'courier_service' => 'REG',
                    'shipping_address' => 'Test Address',
                    'order_status' => Order::ORDER_STATUS_DIBUAT,
                    'payment_status' => Order::PAYMENT_STATUS_PENDING
                ]);
            }
            
            // Process the test callback
            $order->payment_status = Order::PAYMENT_STATUS_COMPLETED;
            $order->order_status = Order::ORDER_STATUS_DIPROSES;
            $order->midtrans_transaction_id = $testData['transaction_id'];
            $order->save();
            
            Log::info('Test callback processed successfully', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'payment_status' => $order->payment_status,
                'order_status' => $order->order_status
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Test callback processed successfully',
                'order' => $order
            ]);
            
        } catch (\Exception $e) {
            Log::error('Test callback error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verifyStatusConsistency()
    {
        try {
            $results = [];
            
            // Define expected status values using constants
            $expectedPaymentStatuses = [
                Order::PAYMENT_STATUS_PENDING,
                Order::PAYMENT_STATUS_COMPLETED,
                Order::PAYMENT_STATUS_FAILED,
                Order::PAYMENT_STATUS_REFUNDED
            ];
            $expectedOrderStatuses = [
                Order::ORDER_STATUS_DIBUAT,
                Order::ORDER_STATUS_DIPROSES,
                Order::ORDER_STATUS_DIKIRIMKAN,
                Order::ORDER_STATUS_DALAM_PENGIRIMAN,
                Order::ORDER_STATUS_TELAH_SAMPAI,
                Order::ORDER_STATUS_SELESAI,
                Order::ORDER_STATUS_DIBATALKAN
            ];
            
            // Check database values
            $dbPaymentStatuses = Order::distinct()->pluck('payment_status')->toArray();
            $dbOrderStatuses = Order::distinct()->pluck('order_status')->toArray();
            
            // Check for inconsistencies
            $invalidPaymentStatuses = array_diff($dbPaymentStatuses, $expectedPaymentStatuses);
            $invalidOrderStatuses = array_diff($dbOrderStatuses, $expectedOrderStatuses);
            
            $results['payment_status'] = [
                'expected' => $expectedPaymentStatuses,
                'found_in_db' => $dbPaymentStatuses,
                'invalid' => $invalidPaymentStatuses,
                'is_consistent' => empty($invalidPaymentStatuses)
            ];
            
            $results['order_status'] = [
                'expected' => $expectedOrderStatuses,
                'found_in_db' => $dbOrderStatuses,
                'invalid' => $invalidOrderStatuses,
                'is_consistent' => empty($invalidOrderStatuses)
            ];
            
            // Check callback mapping
            $callbackMapping = [
                'capture' => ['payment_status' => Order::PAYMENT_STATUS_COMPLETED, 'order_status' => Order::ORDER_STATUS_DIPROSES],
                'settlement' => ['payment_status' => Order::PAYMENT_STATUS_COMPLETED, 'order_status' => Order::ORDER_STATUS_DIPROSES],
                'pending' => ['payment_status' => Order::PAYMENT_STATUS_PENDING, 'order_status' => Order::ORDER_STATUS_DIBUAT],
                'expire' => ['payment_status' => Order::PAYMENT_STATUS_FAILED, 'order_status' => Order::ORDER_STATUS_DIBATALKAN],
                'cancel' => ['payment_status' => Order::PAYMENT_STATUS_FAILED, 'order_status' => Order::ORDER_STATUS_DIBATALKAN],
                'deny' => ['payment_status' => Order::PAYMENT_STATUS_FAILED, 'order_status' => Order::ORDER_STATUS_DIBATALKAN],
                'refund' => ['payment_status' => Order::PAYMENT_STATUS_REFUNDED, 'order_status' => Order::ORDER_STATUS_DIBATALKAN]
            ];
            
            $results['callback_mapping'] = $callbackMapping;
            
            // Check validation rules
            $validationRules = [
                'payment_status' => 'in:pending,completed,failed,refunded',
                'order_status' => 'in:dibuat,diproses,dikirimkan,dalam pengiriman,telah sampai,selesai,dibatalkan'
            ];
            
            $results['validation_rules'] = $validationRules;
            
            // Overall consistency check
            $results['overall_consistent'] = $results['payment_status']['is_consistent'] && $results['order_status']['is_consistent'];
            
            Log::info('Status consistency check completed', $results);
            
            return response()->json($results);
            
        } catch (\Exception $e) {
            Log::error('Status consistency check error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|string',
                'transaction_status' => 'required|string',
                'transaction_id' => 'nullable|string'
            ]);

            $order = Order::where('order_code', $request->order_id)->first();
            
            if (!$order) {
                Log::error('Order not found for frontend update: ' . $request->order_id);
                return response()->json(['error' => 'Order not found'], 404);
            }

            $oldPaymentStatus = $order->payment_status;
            $oldOrderStatus = $order->order_status;

            // Update status berdasarkan transaction status
            switch ($request->transaction_status) {
                case 'capture':
                case 'settlement':
                    $order->payment_status = Order::PAYMENT_STATUS_COMPLETED;
                    $order->order_status = Order::ORDER_STATUS_DIPROSES;
                    
                    // Reduce stock when payment is successful
                    $this->reduceProductStock($order);
                    break;
                    
                case 'pending':
                    $order->payment_status = Order::PAYMENT_STATUS_PENDING;
                    $order->order_status = Order::ORDER_STATUS_DIBUAT;
                    break;
                    
                case 'expire':
                case 'cancel':
                case 'deny':
                    $order->payment_status = Order::PAYMENT_STATUS_FAILED;
                    $order->order_status = Order::ORDER_STATUS_DIBATALKAN;
                    break;
                    
                case 'refund':
                    $order->payment_status = Order::PAYMENT_STATUS_REFUNDED;
                    $order->order_status = Order::ORDER_STATUS_DIBATALKAN;
                    break;
                    
                default:
                    Log::warning('Unknown transaction status from frontend: ' . $request->transaction_status);
                    break;
            }

            // Save transaction ID if available
            if ($request->transaction_id) {
                $order->midtrans_transaction_id = $request->transaction_id;
            }

            $order->save();

            // Log the status change
            Log::info('Payment status updated via frontend', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'transaction_id' => $request->transaction_id,
                'transaction_status' => $request->transaction_status,
                'old_payment_status' => $oldPaymentStatus,
                'new_payment_status' => $order->payment_status,
                'old_order_status' => $oldOrderStatus,
                'new_order_status' => $order->order_status
            ]);

            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Update payment status error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Reduce product stock when order is confirmed
     */
    private function reduceProductStock(Order $order)
    {
        try {
            $order->load('orderItems.product');
            
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $oldStock = $product->stock;
                    $newStock = max(0, $oldStock - $item->quantity);
                    
                    $product->stock = $newStock;
                    $product->save();
                    
                    Log::info('Product stock reduced', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'order_id' => $order->id,
                        'order_code' => $order->order_code,
                        'quantity_ordered' => $item->quantity,
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error reducing product stock: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_code' => $order->order_code
            ]);
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('cart');
        }

        return view('checkout.success', compact('orderId'));
    }
}