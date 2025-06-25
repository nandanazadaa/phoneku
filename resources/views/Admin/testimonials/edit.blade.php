@extends('admin.layouts.app')

@section('title', 'Edit Testimoni')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit Testimoni</h1>
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Kota</label>
            <input type="text" name="city" value="{{ old('city', $testimonial->city) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Rating</label>
            <select name="rating" class="w-full border rounded px-3 py-2" required>
                @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Pesan</label>
            <textarea name="message" class="w-full border rounded px-3 py-2" required>{{ old('message', $testimonial->message) }}</textarea>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Foto</label>
            @if($testimonial->photo)
                <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="Foto Testimoni" class="w-20 h-20 object-cover rounded mb-2">
            @endif
            <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_approved" value="1" {{ $testimonial->is_approved ? 'checked' : '' }}>
                <span class="ml-2">Disetujui</span>
            </label>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.testimonials.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>
@endsection
