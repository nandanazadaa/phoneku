@extends('layouts.app')

@section('title', 'Keranjang - PhoneKu')

@section('content')
    <section class="container mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Keranjang</h2>
            <a href="{{ route('allproduct') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                &larr; Lanjutkan Belanja
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('warning') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($cartItems->isEmpty())
            <!-- Empty cart state -->
            <div class="flex justify-center">
                <div class="text-center py-12 bg-white w-full max-w-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Keranjang Anda kosong</h3>
                    <p class="mt-1 text-gray-500">Mulai tambahkan beberapa produk menarik ke keranjang Anda</p>
                    <div class="mt-6">
                        <a href="{{ route('allproduct') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        @if ($item->product)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border border-gray-200 rounded-xl p-6 bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-start gap-6 w-full sm:w-auto">
                                    <div class="relative group">
                                        <a href="{{ route('product.show', $item->product) }}">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/150' }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-24 h-24 sm:w-28 sm:h-28 object-contain rounded-lg border border-gray-200 
                                                    transform group-hover:scale-105 transition duration-300 ease-in-out" />
                                        </a>
                                        @if ($item->quantity > $item->product->stock)
                                            <span
                                                class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 py-1 rounded-full transform translate-x-1/2 -translate-y-1/2">
                                                Stok kurang
                                            </span>
                                        @endif
                                    </div>
                                    <div class="space-y-1 flex-1">
                                        <a href="{{ route('product.show', $item->product) }}">
                                            <h3 class="font-bold text-lg text-gray-800 hover:text-blue-600 line-clamp-2">{{ $item->product->name }}</h3>
                                        </a>
                                        @if($item->product->brand)
                                            <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Brand: {{ ucfirst($item->product->brand) }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">{{ $item->product->category }}</p>
                                        <p class="text-sm text-gray-600 flex items-center gap-2">
                                            @if($item->color)
                                                @if(preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $item->color))
                                                    <span class="inline-block w-4 h-4 rounded-full border border-gray-300 align-middle mr-1" style="background: {{ $item->color }};"></span>
                                                @endif
                                                {{-- Hilangkan kode warna, hanya tampilkan swatch --}}
                                            @else
                                                -
                                            @endif
                                        </p>
                                        {{-- Hapus SKU, stok, dan 'yes' --}}
                                        {{-- <p class="text-sm text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</p> --}}
                                        {{-- <p class="text-sm font-medium {{ $item->product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item->product->stock > 0 ? 'Tersedia (' . $item->product->stock . ' unit)' : 'Stok habis!' }}
                                        </p> --}}
                                        {{-- @if ($item->quantity > $item->product->stock)
                                            <p class="text-xs text-red-500 mt-1">
                                                Anda memesan {{ $item->quantity }} unit, tetapi stok hanya
                                                {{ $item->product->stock }} unit
                                            </p>
                                        @endif --}}
                                        {{-- @if($item->product->description)
                                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ Str::limit($item->product->description, 80) }}</p>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="flex flex-col sm:items-end w-full sm:w-auto mt-4 sm:mt-0 gap-3">
                                    <div class="text-xl font-bold text-gray-800 text-right">
                                        Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        <div class="text-sm font-normal text-gray-500">
                                            @if ($item->quantity > 1)
                                                (Rp{{ number_format($item->product->price, 0, ',', '.') }} per unit)
                                            @endif
                                            @if ($item->product->original_price && $item->product->original_price > $item->product->price)
                                                <span class="line-through ml-2">Rp{{ number_format($item->product->original_price, 0, ',', '.') }}</span>
                                                @php $discountPercentage = round((($item->product->original_price - $item->product->price) / $item->product->original_price) * 100); @endphp
                                                <span class="ml-2 text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded">{{ $discountPercentage }}% OFF</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                                class="border px-3 py-1 rounded-l-full hover:bg-gray-100 font-bold text-gray-600 hover:text-gray-800 transition-colors">
                                                &minus;
                                            </button>
                                            <input type="text" readonly value="{{ $item->quantity }}"
                                                class="w-12 text-center border-t border-b py-1 text-sm bg-gray-50 focus:outline-none" />
                                            <button type="submit" name="quantity"
                                                value="{{ min($item->product->stock, $item->quantity + 1) }}"
                                                class="border px-3 py-1 rounded-r-full hover:bg-gray-100 font-bold text-gray-600 hover:text-gray-800 transition-colors
                                                {{ $item->quantity >= $item->product->stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                &plus;
                                            </button>
                                        </form>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded-full hover:bg-red-50"
                                                onclick="return confirm('Hapus item dari keranjang?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="border border-gray-200 rounded-2xl shadow-sm p-6 bg-white sticky top-4">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Ringkasan Pesanan</h3>
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>Subtotal</span>
                                <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>Pengiriman</span>
                                <span class="text-blue-600">Gratis</span>
                            </div>
                        </div>
                        <hr class="my-3 border-gray-200" />
                        <div class="flex justify-between text-lg font-bold text-gray-800 mb-6">
                            <span>Total</span>
                            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        @if ($cartItems->contains(function ($item) {
                            return $item->product && $item->quantity > $item->product->stock;
                        }))
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Beberapa produk melebihi stok yang tersedia. Silahkan perbarui jumlah pesanan
                                            sebelum checkout.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('checkout') }}" method="GET">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors text-base font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                                    Lanjutkan Pembayaran
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <div class="mt-4 text-center text-sm text-gray-500">
                            atau <a href="{{ route('allproduct') }}" class="text-blue-600 hover:text-blue-800">lanjutkan belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection