<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    // List all orders with optional filters
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }
        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('order_code', 'like', "%$q%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name', 'like', "%$q%")
                          ->orWhere('email', 'like', "%$q%") ;
                    });
            });
        }
        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // Show detail order
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Update status order (payment_status atau shipping_status)
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'payment_status' => 'nullable|in:pending,completed,failed',
            'shipping_status' => 'nullable|in:processing,shipped,delivered,cancelled',
        ]);
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }
        if ($request->has('shipping_status')) {
            $order->shipping_status = $request->shipping_status;
        }
        $order->save();
        return redirect()->back()->with('success', 'Status order berhasil diupdate.');
    }
}
