<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // List all orders with optional filters
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Filter by status (only if status is not empty)
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter by search query
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('order_code', 'like', "%$q%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%$q%")
                            ->orWhere('email', 'like', "%$q%");
                    });
            });
        }

        $orders = $query->latest()->get();

        // Debug logging
        Log::info('Order search/filter', [
            'status' => $request->status,
            'search_query' => $request->q,
            'total_orders' => $orders->count()
        ]);

        return view('Admin.orders.index', compact('orders'));
    }

    // Show detail order
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('Admin.orders.show', compact('order'));
    }

    // Update order status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:' . implode(',', array_keys(Order::getOrderStatusOptions())),
            'payment_status' => 'nullable|in:' . implode(',', array_keys(Order::getPaymentStatusOptions())),
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->order_status;

        $order->order_status = $request->order_status;

        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        if ($request->has('notes')) {
            $order->notes = $request->notes;
        }

        $order->save();

        // Reduce stock when order status is changed to "diproses"
        if ($request->order_status === 'diproses' && $oldStatus !== 'diproses') {
            $this->reduceProductStock($order);
        }

        // Log the status change
        Log::info("Order status updated", [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'old_status' => $oldStatus,
            'new_status' => $order->order_status,
            'updated_by' => auth()->user()->name ?? 'Admin'
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate.');
    }

    // Delete order
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('Admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }

    // Manual update payment status
    public function updatePaymentStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'payment_status' => 'required|in:pending,completed,failed,refunded',
                'transaction_id' => 'nullable|string'
            ]);

            $oldPaymentStatus = $order->payment_status;
            $oldOrderStatus = $order->order_status;

            // Update payment status
            $order->payment_status = $request->payment_status;

            // Update order status based on payment status
            if ($request->payment_status === 'completed') {
                $order->order_status = Order::ORDER_STATUS_DIPROSES;

                // Reduce stock when payment is completed
                $this->reduceProductStock($order);
            } elseif ($request->payment_status === 'failed' || $request->payment_status === 'refunded') {
                $order->order_status = Order::ORDER_STATUS_DIBATALKAN;
            }

            // Save transaction ID if provided
            if ($request->transaction_id) {
                $order->midtrans_transaction_id = $request->transaction_id;
            }

            $order->save();

            // Log the status change
            Log::info("Payment status manually updated by admin", [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'old_payment_status' => $oldPaymentStatus,
                'new_payment_status' => $order->payment_status,
                'old_order_status' => $oldOrderStatus,
                'new_order_status' => $order->order_status,
                'updated_by' => auth()->user()->name ?? 'Admin'
            ]);

            return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Manual payment status update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate status pembayaran: ' . $e->getMessage());
        }
    }

    // Check Midtrans status for pending orders
    public function checkMidtransStatus()
    {
        try {
            $pendingOrders = Order::where('payment_status', 'pending')
                ->where('created_at', '>=', now()->subDays(1))
                ->get();

            $updatedCount = 0;

            foreach ($pendingOrders as $order) {
                try {
                    // Use Midtrans API to check status
                    $status = \Midtrans\Transaction::status($order->order_code);

                    if ($status->transaction_status === 'settlement') {
                        $order->payment_status = Order::PAYMENT_STATUS_COMPLETED;
                        $order->order_status = Order::ORDER_STATUS_DIPROSES;
                        $order->midtrans_transaction_id = $status->transaction_id;
                        $order->save();

                        // Reduce stock when payment is completed
                        $this->reduceProductStock($order);

                        $updatedCount++;

                        Log::info("Order status updated via Midtrans API check", [
                            'order_code' => $order->order_code,
                            'payment_status' => $order->payment_status,
                            'order_status' => $order->order_status
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Error checking Midtrans status for order {$order->order_code}: " . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', "Berhasil mengupdate {$updatedCount} order dari {$pendingOrders->count()} pending orders.");
        } catch (\Exception $e) {
            Log::error('Check Midtrans status error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengecek status Midtrans: ' . $e->getMessage());
        }
    }

    // Search order by order code
    public function searchByCode(Request $request)
    {
        try {
            $request->validate([
                'order_code' => 'required|string'
            ]);

            $order = Order::where('order_code', $request->order_code)->first();

            if ($order) {
                return response()->json([
                    'success' => true,
                    'order' => [
                        'id' => $order->id,
                        'order_code' => $order->order_code,
                        'payment_status' => $order->payment_status,
                        'order_status' => $order->order_status,
                        'customer_name' => $order->user ? $order->user->name : 'N/A'
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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

                    Log::info('Product stock reduced by admin', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'order_id' => $order->id,
                        'order_code' => $order->order_code,
                        'quantity_ordered' => $item->quantity,
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock,
                        'updated_by' => auth()->user()->name ?? 'Admin'
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
}
