@extends('layouts.app')

@section('title', 'Keranjang - PhoneKu')

@section('content')
<div class="bg-blue-500 pb-10">
    <div class="container mx-auto px-4 py-2 flex justify-end"></div>
</div>

<section class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold mb-8 text-center md:text-left md:ml-12">Keranjang</h2>

    <!-- Alert Messages Container -->
    <div id="alert-container">
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
        @endif
        @if (session('warning'))
        <div class="bg-orange-100 text-orange-700 p-4 rounded mb-6">{{ session('warning') }}</div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
        <!-- Daftar Produk di Keranjang (DI LUAR FORM CHECKOUT) -->
        <div id="cart-items-container" class="lg:col-span-2 space-y-6">
            @forelse($cartItems as $item)
            @if($item->product)
            <div id="cart-item-{{ $item->id }}" class="cart-item flex flex-col md:flex-row items-center p-4 border border-gray-200 rounded-lg shadow-sm bg-white gap-4">
                <div class="flex items-center w-full md:w-auto gap-4">
                    <label class="custom-checkbox-container flex-shrink-0 mt-1">
                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="cart-checkbox" checked data-price="{{ $item->product->price * min($item->quantity, $item->product->stock) }}">
                        <span class="custom-checkbox"></span>
                    </label>
                    <a href="{{ route('product.show', $item->product->id) }}" class="flex-shrink-0">
                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100x100' }}" alt="{{ $item->product->name }}" class="rounded-lg object-cover w-20 h-20 border">
                    </a>
                    <div class="flex flex-col flex-grow min-w-0">
                        <a href="{{ route('product.show', $item->product->id) }}" class="text-base font-semibold hover:text-blue-600 truncate">{{ $item->product->name }}</a>
                        @if($item->product->stock > 0)
                            <span class="text-xs text-green-600 font-medium">Stok: {{ $item->product->stock }}</span>
                        @else
                            <span class="text-xs text-red-600 font-medium">Stok habis!</span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col items-end w-full md:w-auto gap-2 mt-4 md:mt-0">
                    <!-- TOMBOL + DAN - (TERPISAH DARI FORM CHECKOUT) -->
                    <div class="flex items-center gap-2">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                class="px-4 py-2 text-xl font-bold text-gray-700 bg-gray-100 rounded-l-lg border-r border-gray-200 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">-</button>
                        </form>
                        <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" readonly
                            class="w-14 text-center border-0 font-medium bg-transparent text-lg" style="background: #f9fafb;">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}"
                                class="px-4 py-2 text-xl font-bold text-gray-700 bg-gray-100 rounded-r-lg border-l border-gray-200 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 transition {{ $item->quantity >= $item->product->stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
                        </form>
                        <button type="button" data-item-id="{{ $item->id }}" class="delete-item-btn text-gray-400 hover:text-red-600 text-xl ml-2" title="Hapus Item">🗑️</button>
                    </div>
                    <div class="text-right">
                        <span class="text-lg font-bold text-gray-800">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div id="empty-cart-message" class="text-center py-8 col-span-full">
                <p class="text-gray-500 text-lg">Keranjang Anda kosong.</p>
                <a href="{{ route('allproduct') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">Mulai Belanja</a>
            </div>
            @endforelse
        </div>
        
        <!-- FORM CHECKOUT TERPISAH (HANYA UNTUK CHECKOUT) -->
        <div id="order-summary" class="lg:col-span-1 w-full sticky top-24 self-start">
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
                
                <!-- FORM CHECKOUT HANYA UNTUK TOMBOL CHECKOUT -->
                <form id="cart-form" action="{{ route('checkout') }}" method="GET">
                    @csrf
                    <!-- Hidden inputs untuk item yang dipilih (akan diisi oleh JavaScript) -->
                    <div id="selected-items-inputs"></div>
                    <button type="submit" id="checkout-btn" class="w-full bg-blue-500 text-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">Lanjutkan ke Pembayaran</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('styles')
<style>
.cart-item { transition: box-shadow 0.2s; }
.cart-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
input[type='number']::-webkit-inner-spin-button, input[type='number']::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type='number'] { -moz-appearance: textfield; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Update hidden inputs sebelum checkout
    const checkoutForm = document.getElementById('cart-form');
    const selectedItemsContainer = document.getElementById('selected-items-inputs');
    
    checkoutForm.addEventListener('submit', function(e) {
        selectedItemsContainer.innerHTML = '';
        const checkboxes = document.querySelectorAll('.cart-checkbox:checked');
        checkboxes.forEach(function(checkbox) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = checkbox.value;
            selectedItemsContainer.appendChild(input);
        });
    });
    
    // Tombol hapus item
    document.querySelectorAll('.delete-item-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var itemId = this.getAttribute('data-item-id');
            if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/cart/remove/' + itemId;
                var csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>
@endsection