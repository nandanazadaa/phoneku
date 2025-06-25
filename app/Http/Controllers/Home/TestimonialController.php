<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\OrderItem;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $user = auth('web')->user();
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);
        // Cek apakah user pernah membeli produk ini
        $hasBought = OrderItem::whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', 'selesai');
        })->where('product_id', $request->product_id)->exists();
        if (!$hasBought) {
            return back()->with('error', 'Anda hanya bisa memberi testimoni untuk produk yang sudah dibeli.');
        }
        $data = [
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'name' => $user->name,
            'city' => $user->profile->city ?? null,
            'rating' => $request->rating,
            'message' => $request->message,
            'is_approved' => false,
        ];
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        \App\Models\Testimonial::create($data);
        return back()->with('success', 'Testimoni Anda berhasil dikirim dan menunggu persetujuan admin.');
    }
}
