@extends('admin.layouts.app')

@section('title', 'Tambah Testimoni')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Tambah Testimoni</h1>
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Kota</label>
            <input type="text" name="city" value="{{ old('city') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Rating</label>
            <select name="rating" class="w-full border rounded px-3 py-2" required>
                @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}">{{ $i }} Bintang</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Pesan</label>
            <textarea name="message" class="w-full border rounded px-3 py-2" required>{{ old('message') }}</textarea>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Foto</label>
            <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_approved" value="1">
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
