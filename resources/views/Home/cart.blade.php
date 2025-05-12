@extends('layouts.app')

@section('title', 'Keranjang - PhoneKu')

@section('content')
<!-- Header Section with Wave -->
<div class="relative">
    <div class="bg-blue-500 pb-16">
        <div class="container mx-auto px-4 py-2 flex justify-end"></div>
        <div class="container mx-auto px-4"></div>
    </div>
</div>

<section class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold mb-8 text-center md:text-left md:ml-12">Keranjang</h2>

    <!-- Alert Messages Container -->
    <div id="alert-container">
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif
        @if (session('warning'))
        <div class="bg-orange-100 text-orange-700 p-4 rounded mb-6">
            {{ session('warning') }}
        </div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif
    </div>

    <form id="cart-form" action="{{ route('checkout') }}" method="GET">
        @csrf

        {{-- Main Cart Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 ml-4 mr-4 md:ml-8 md:mr-8">
            <!-- Daftar Produk di Keranjang -->
            <div id="cart-items-container" class="lg:col-span-2 space-y-6">
                @forelse($cartItems as $item)
                @if($item->product)
                <!-- Item Produk -->
                <div id="cart-item-{{ $item->id }}" class="cart-item flex flex-col sm:flex-row items-start p-4 border border-gray-200 rounded-lg shadow-sm bg-white">
                    <div class="flex items-start w-full sm:w-auto mb-4 sm:mb-0">
                        <label class="custom-checkbox-container flex-shrink-0 mt-1">
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="cart-checkbox"
                                checked data-price="{{ $item->product->price * min($item->quantity, $item->product->stock) }}">
                            <span class="custom-checkbox"></span>
                        </label>
                        <a href="{{ route('product.show', $item->product->id) }}" class="flex-shrink-0">
                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100x100' }}"
                                alt="{{ $item->product->name }}" class="rounded-lg object-cover" width="80" height="80">
                        </a>
                        <div class="ml-4 flex-grow">
                            <a href="{{ route('product.show', $item->product->id) }}"
                                class="text-lg font-semibold hover:text-blue-600 line-clamp-2">
                                {{ $item->product->name }}
                            </a>
                            @if($item->product->stock > 0)
                            <p class="text-sm text-green-600 font-medium">Stok: {{ $item->product->stock }} tersedia</p>
                            @else
                            <p class="text-sm text-red-600 font-medium">Stok habis!</p>
                            @endif
                        </div>
                    </div>

                    {{-- Harga & Aksi Kuantitas --}}
                    <div class="flex flex-col items-start sm:items-end w-full sm:w-auto mt-4 sm:mt-0">
                        <div class="flex justify-between sm:justify-end items-center w-full mb-4">
                            {{-- Harga Subtotal per item --}}
                            <p class="text-xl font-bold mr-2 text-gray-800 item-subtotal" 
                               data-price="{{ $item->product->price }}" 
                               data-id="{{ $item->id }}">
                                Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                            {{-- Tombol Hapus - Diubah menjadi button biasa untuk handling dengan JavaScript --}}
                            <button type="button" 
                                data-item-id="{{ $item->id }}"
                                class="delete-item-btn text-gray-500 hover:text-red-600 text-xl" 
                                title="Hapus Item">🗑️</button>
                        </div>

                        {{-- Form Update Kuantitas - Pindahkan keluar dari form checkout --}}
                        <div class="flex items-center border rounded-full px-1 py-0.5 w-max {{ $item->product->stock <= 0 ? 'opacity-50 pointer-events-none' : '' }}">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                @csrf
                                <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                    class="px-2 text-xl font-semibold text-gray-600 hover:bg-gray-100 rounded-l-full {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $item->quantity <= 1 ? 'disabled' : '' }} onclick="event.stopPropagation();">-</button>
                                <input type="number" name="quantity_display" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" readonly
                                    class="w-12 text-center border-y-0 border-x quantity-input appearance-none focus:outline-none focus:ring-0 font-medium bg-transparent">
                                <button type="submit" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}"
                                    class="px-2 text-xl font-semibold text-gray-600 hover:bg-gray-100 rounded-r-full {{ $item->quantity >= $item->product->stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }} onclick="event.stopPropagation();">+</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <div id="empty-cart-message" class="text-center py-8 col-span-full">
                    <p class="text-gray-500 text-lg">Keranjang Anda kosong.</p>
                    <a href="{{ route('allproduct') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                        Mulai Belanja
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Ringkasan Pesanan -->
            <div id="order-summary" class="lg:col-span-1 w-full">
                @if($cartItems->isNotEmpty())
                <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Ringkasan</h3>
                    <div class="flex justify-between mb-2 text-gray-700">
                        <span>Subtotal (Item Dipilih)</span>
                        <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-4 border-gray-200"/>
                    <div class="flex justify-between font-bold text-lg mb-6 text-gray-800">
                        <span>Total</span>
                        <span id="total">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" id="checkout-btn"
                        class="w-full bg-blue-500 text-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
                @endif
            </div>
        </div>
    </form>
</section>

<!-- Add CSRF token for AJAX calls -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('styles')
<style src="{{ asset('\css\cart.css') }}"></style>
@endsection

@section('scripts')
<script src="{{ asset('\js\cart.js') }}"></script>
@endsection