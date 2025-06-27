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
        if ($request->has('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }
        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('order_code', 'like', "%$q%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name', 'like', "%$q%")
                          ->orWhere('email', 'like', "%$q%");
                    });
            });
        }
        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // Show detail order
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:dibuat,diproses,dikirimkan,dalam pengiriman,telah sampai,selesai,dibatalkan',
            'payment_status' => 'nullable|in:pending,completed,failed,refunded',
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
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}