<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'product'])->latest()->get();
        return view('admin.testimoni', compact('testimonials'));
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

            if (Storage::disk('public')->exists($data['photo'])) {
                Log::info('Photo stored successfully at: ' . $data['photo']);
            } else {
                Log::error('Photo storage failed for path: ' . $data['photo']);
            }
        }

        $data['is_approved'] = $request->boolean('is_approved', false);

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
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
            // Hapus foto lama jika ada
            if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
                Storage::disk('public')->delete($testimonial->photo);
            }

            $data['photo'] = $request->file('photo')->store('testimonials', 'public');

            if (Storage::disk('public')->exists($data['photo'])) {
                Log::info('Photo updated and stored at: ' . $data['photo']);
            } else {
                Log::error('Photo storage failed for path: ' . $data['photo']);
            }
        }

        $data['is_approved'] = $request->boolean('is_approved', false);

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diupdate!');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Hapus foto dari storage jika ada
        if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus!');
    }

    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = true;
        $testimonial->save();

        return redirect()
            ->back()
            ->with('success', 'Testimoni berhasil disetujui.');
    }

    public function reject($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()
            ->back()
            ->with('success', 'Testimoni berhasil ditolak dan dihapus.');
    }
}