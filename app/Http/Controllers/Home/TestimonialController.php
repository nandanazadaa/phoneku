<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\OrderItem;

class TestimonialController extends Controller
{
    /**
     * Formulir untuk mengisi ulasan.
     */
    public function create($orderItemId)
    {
        $orderItem = OrderItem::with('product')->findOrFail($orderItemId);
        return view('profile.ulasan_form', compact('orderItem'));
    }

    /**
     * Simpan ulasan dari halaman riwayat pembelian.
     */
    public function storeFromOrder(Request $request, $orderItemId)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek apakah user sudah memberikan ulasan untuk order_item_id ini
        $alreadyReviewed = Testimonial::where('user_id', auth()->id())
            ->where('order_item_id', $orderItem->id) // Ganti product_id dengan order_item_id
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('riwayatbeli')->with('error', 'Anda sudah memberikan ulasan untuk pembelian ini.');
        }

        // Simpan testimonial
        $testimonial = new Testimonial();
        $testimonial->user_id = auth()->id();
        $testimonial->product_id = $orderItem->product_id;
        $testimonial->order_item_id = $orderItem->id; // Simpan order_item_id
        $testimonial->name = auth()->user()->name;
        $testimonial->city = auth()->user()->profile->city ?? null;
        $testimonial->rating = $request->rating;
        $testimonial->message = $request->message;
        $testimonial->is_approved = true;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('testimonials', 'public');
            $testimonial->photo = $path;
        }

        $testimonial->save();

        return redirect()->route('riwayatbeli')->with('success', 'Ulasan berhasil dikirim.');
    }
    /**
     * Simpan ulasan umum (bukan dari order item, jika ada route ini).
     */
    public function store(Request $request)
    {
        $user = auth('web')->user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Pastikan user pernah membeli produk
        $hasBought = OrderItem::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', 'selesai');
        })->where('product_id', $request->product_id)->exists();

        if (!$hasBought) {
            return back()->with('error', 'Anda hanya bisa memberi testimoni untuk produk yang sudah dibeli.');
        }

        $testimonial = new Testimonial();
        $testimonial->user_id = $user->id;
        $testimonial->product_id = $request->product_id;
        $testimonial->name = $user->name;
        $testimonial->city = $user->profile->city ?? null;
        $testimonial->rating = $request->rating;
        $testimonial->message = $request->message;
        $testimonial->is_approved = false;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('testimonials', 'public');
            $testimonial->photo = $path;
        }

        $testimonial->save();

        return back()->with('success', 'Testimoni Anda berhasil dikirim dan menunggu persetujuan admin.');
    }
}
