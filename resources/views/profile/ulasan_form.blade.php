@extends('layouts.app')

@section('title', 'Beri Ulasan - PhoneKu')

@section('content')
<script src="//unpkg.com/alpinejs" defer></script>
<div class="container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Beri Ulasan Produk</h2>

        <!-- Produk yang akan diulas -->
        <div class="flex items-center gap-4 mb-6">
            <div class="w-24 h-24 rounded-lg overflow-hidden border">
                <img src="{{ $orderItem->product->image ? asset('storage/' . $orderItem->product->image) : asset('img/default_product.png') }}"
                    alt="{{ $orderItem->product->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $orderItem->product->name }}</h3>
                <p class="text-sm text-gray-500">Jumlah: {{ $orderItem->quantity }}</p>
            </div>
        </div>

        <!-- Form Ulasan -->
        <form action="{{ route('ulasan.storeFromOrder', $orderItem->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Rating -->
            <div x-data="{ rating: @json(old('rating', 0)) }">
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <div class="flex space-x-1 text-2xl text-gray-300 cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
                        :class="{ 'text-yellow-400': rating >= {{ $i }}, 'text-gray-300': rating < {{ $i }} }"
                        @click="rating = {{ $i }}"
                        class="w-8 h-8">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.232 3.794a1 1 0 00.95.69h3.989c.969 0 1.371 1.24.588 1.81l-3.223 2.339a1 1 0 00-.364 1.118l1.232 3.794c.3.921-.755 1.688-1.539 1.118l-3.223-2.339a1 1 0 00-1.176 0l-3.223 2.339c-.783.57-1.838-.197-1.539-1.118l1.232-3.794a1 1 0 00-.364-1.118L2.29 9.22c-.783-.57-.38-1.81.588-1.81h3.989a1 1 0 00.95-.69l1.232-3.794z" />
                        </svg>
                        @endfor
                </div>
                <input type="hidden" name="rating" :value="rating">
                @error('rating')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pesan -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Ulasan Anda</label>
                <textarea name="message" id="message" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis pengalaman Anda...">{{ old('message') }}</textarea>
                @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto opsional -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk (Opsional)</label>
                <input type="file" name="photo" id="photo"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-end items-center mt-6">
                <a href="{{ route('riwayatbeli') }}" class="text-gray-600 hover:underline mr-4">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>
@endsection
