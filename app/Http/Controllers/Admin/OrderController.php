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
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'order_status' => 'required|in:dibuat,dikirimkan,telah sampai',
        ]);
        $order->order_status = $request->order_status;
        $order->save();
        return redirect()->back()->with('success', 'Status order berhasil diupdate.');
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}