<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Profile;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Auto-create profile jika belum ada
        if (!$user->profile) {
            Profile::create([
                'user_id' => $user->id,
                'recipient_name' => $user->name,
                'label' => 'Rumah',
                'address' => '',
                'phone' => '',
            ]);
            $user->refresh(); // Refresh relasi
        }
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 20000; // contoh
        $serviceFee = 5000; // contoh
        return view('Home.checkout', compact('user', 'cartItems', 'subtotal', 'shippingCost', 'serviceFee'));
    }
} 