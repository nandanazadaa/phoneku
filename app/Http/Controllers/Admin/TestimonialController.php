<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'city' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $data['is_approved'] = $request->input('is_approved', false);
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'city' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $data['is_approved'] = $request->input('is_approved', false);
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diupdate!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus!');
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->is_approved = true;
        $testimonial->save();
        return redirect()->back()->with('success', 'Testimoni disetujui!');
    }
}
