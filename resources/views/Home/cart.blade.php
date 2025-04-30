@extends('layouts.app')

@section('title', 'Cart - PhoneKu')

@section('content')
<!-- Header Section with Wave -->
<div class="relative">
    <div class="bg-blue-500 pb-16">
        <div class="container mx-auto px-4 py-2 flex justify-end"></div>
        <div class="container mx-auto px-4"></div>
    </div>
    <section class="container mx-auto px-4 py-10">
        <h2 class="text-3xl font-bold mb-8 text-center md:text-left md:ml-12">Keranjang</h2>

        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <form id="cart-form" action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 ml-8">
                <!-- Daftar Produk -->
                <div class="lg:col-span-2 space-y-8">
                    @forelse($cartItems as $item)
                    <!-- Item Produk -->
                    <div class="flex sm:flex-row items-start">
                        <label class="custom-checkbox-container">
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="cart-checkbox"
                                checked data-price="{{ $item->product->price * $item->quantity }}">
                            <span class="custom-checkbox"></span>
                        </label>
                        <a href="{{ route('product.show', $item->product->id) }}">
                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $item->product->name }}" class="rounded-lg object-cover" width="100">
                        </a>
                        <div class="ml-4">
                            <a href="{{ route('product.show', $item->product->id) }}"
                                class="text-xl font-semibold hover:text-blue-600">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-base text-gray-600">Warna: {{ $item->product->color ?? 'N/A' }}</p>
                            <p class="text-base text-green-600 font-medium">Tersedia</p>
                        </div>
                    </div>

                    <!-- Harga & Aksi -->
                    <div class="flex flex-col items-start gap-3 w-full md:w-auto">
                        <div class="flex justify-between items-center w-full">
                            <p class="text-xl font-semibold mr-2">
                                Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 hover:text-red-600 text-xl">🗑️</button>
                            </form>
                        </div>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                            class="flex items-center border rounded-full px-3 py-1 md:mt-12">
                            @csrf
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                class="px-2 text-xl font-semibold {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            <span class="px-4 text-lg">{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                class="px-2 text-xl font-semibold">+</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">Keranjang Anda kosong.</p>
                </div>
                @endforelse
            </div>

            <!-- Ringkasan -->
            <div class="w-full">
                <div class="bg-white shadow rounded-xl p-6 border">
                    <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
                    <div class="flex justify-between mb-2 text-gray-700">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-2" />
                    <div class="flex justify-between font-bold text-lg mb-6">
                        <span>Total</span>
                        <span id="total">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-400 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                        Lanjutkan Pembayaran
                    </button>
                </div>
            </div>
</div>
</form>
</section>
</div>
@endsection

@section('styles')
<style>
/* Custom Checkbox Styling */
.custom-checkbox-container {
    display: inline-block;
    vertical-align: middle;
    position: relative;
    padding-left: 30px;
    cursor: pointer;
    user-select: none;
    margin-right: 16px;
    margin-top: 8px;
}

.custom-checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.custom-checkbox {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #e5e7eb;
    /* Tailwind gray-200 */
    border: 2px solid #9ca3af;
    /* Tailwind gray-400 */
    border-radius: 4px;
    transition: all 0.2s ease;
}

.custom-checkbox-container:hover input~.custom-checkbox {
    background-color: #d1d5db;
    /* Tailwind gray-300 */
}

.custom-checkbox-container input:checked~.custom-checkbox {
    background-color: #3b82f6;
    /* Tailwind blue-500 */
    border-color: #3b82f6;
}

.custom-checkbox:after {
    content: '';
    position: absolute;
    display: none;
}

.custom-checkbox-container input:checked~.custom-checkbox:after {
    display: block;
}

.custom-checkbox-container .custom-checkbox:after {
    left: 6px;
    top: 2px;
    width: 6px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');

    // Format number to Indonesian Rupiah
    function formatRupiah(number) {
        return 'Rp' + number.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
    }

    // Calculate total price based on checked items
    function updateTotalPrice() {
        let total = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.getAttribute('data-price'));
            }
        });
        subtotalElement.textContent = formatRupiah(total);
        totalElement.textContent = formatRupiah(total);
    }

    // Add event listener to each checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    // Initialize total price on page load
    updateTotalPrice();
});
</script>
@endsection