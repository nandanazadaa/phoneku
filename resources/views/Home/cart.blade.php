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
    border: 2px solid #9ca3af;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.custom-checkbox-container:hover input~.custom-checkbox {
    background-color: #d1d5db;
}

.custom-checkbox-container input:checked~.custom-checkbox {
    background-color: #3b82f6;
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

/* Quantity input visual adjustment */
.quantity-input {
    -moz-appearance: textfield;
    text-align: center;
    border-left: 1px solid #d1d5db;
    border-right: 1px solid #d1d5db;
    background-color: #fff;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Add more padding to quantity buttons */
.quantity-counter button {
    padding-left: 12px;
    padding-right: 12px;
}

/* Line clamp utility */
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Button hover effects */
.quantity-btn:not([disabled]):hover {
    background-color: #f3f4f6;
}

.delete-item-btn:hover {
    transform: scale(1.1);
    transition: transform 0.2s;
}

/* Animation for removing cart items */
@keyframes fadeOut {
    from { opacity: 1; height: auto; margin-bottom: 1.5rem; }
    to { opacity: 0; height: 0; margin-bottom: 0; padding: 0; border: none; }
}

.fade-out {
    animation: fadeOut 0.5s forwards;
    overflow: hidden;
}

/* Alert animations */
.alert-slide-in {
    animation: slideIn 0.3s forwards;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-fade-out {
    animation: fadeOut 0.5s forwards;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all needed elements
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const checkoutButton = document.getElementById('checkout-btn');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const deleteButtons = document.querySelectorAll('.delete-item-btn');
    const alertContainer = document.getElementById('alert-container');
    const orderSummary = document.getElementById('order-summary');
    
    // Set CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Format number to Indonesian Rupiah
    function formatRupiah(number) {
        if (isNaN(number)) return 'Rp0';
        return 'Rp' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Calculate total price based on checked items
    function updateTotalPrice() {
        let total = 0;
        let checkedCount = 0;
        const currentCheckboxes = document.querySelectorAll('.cart-checkbox');
        
        currentCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.getAttribute('data-price'));
                checkedCount++;
            }
        });

        // Update texts
        if (subtotalElement && totalElement) {
            subtotalElement.textContent = formatRupiah(total);
            totalElement.textContent = formatRupiah(total);

            // Update the subtotal label in the summary based on checked count
            const subtotalLabel = subtotalElement.previousElementSibling;
            if (subtotalLabel && subtotalLabel.tagName === 'SPAN') {
                subtotalLabel.textContent = `Subtotal (${checkedCount} Item Dipilih)`;
            }
        }

        // Enable/disable checkout button if no items are selected
        if (checkoutButton) {
            checkoutButton.disabled = (checkedCount === 0);
            if (checkedCount === 0) {
                checkoutButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                checkoutButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            } else {
                checkoutButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                checkoutButton.classList.add('bg-blue-500', 'hover:bg-blue-600');
            }
        }
    }

    // Show an alert message
    function showAlert(message, type = 'success') {
        // Create alert div
        const alertDiv = document.createElement('div');
        alertDiv.className = `bg-${type === 'success' ? 'green' : type === 'warning' ? 'orange' : 'red'}-100 
                              text-${type === 'success' ? 'green' : type === 'warning' ? 'orange' : 'red'}-700 
                              p-4 rounded mb-6 alert-slide-in`;
        alertDiv.textContent = message;
        
        // Add to container
        alertContainer.appendChild(alertDiv);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            alertDiv.classList.add('alert-fade-out');
            setTimeout(() => {
                alertContainer.removeChild(alertDiv);
            }, 500);
        }, 3000);
    }

    // Check if cart is empty and update UI accordingly
    function checkEmptyCart() {
        const items = document.querySelectorAll('.cart-item');
        
        if (items.length === 0) {
            // Create empty cart message if it doesn't exist
            if (!document.getElementById('empty-cart-message')) {
                const emptyMessage = document.createElement('div');
                emptyMessage.id = 'empty-cart-message';
                emptyMessage.className = 'text-center py-8 col-span-full';
                emptyMessage.innerHTML = `
                    <p class="text-gray-500 text-lg">Keranjang Anda kosong.</p>
                    <a href="{{ route('allproduct') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                        Mulai Belanja
                    </a>
                `;
                cartItemsContainer.appendChild(emptyMessage);
            }
            
            // Hide order summary
            if (orderSummary) {
                orderSummary.style.display = 'none';
            }
        }
    }

    // Handle item deletion with AJAX
    function setupDeleteHandlers() {
        document.querySelectorAll('.delete-item-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!confirm('Yakin ingin menghapus item ini?')) {
                    return;
                }
                
                const itemId = this.getAttribute('data-item-id');
                const cartItem = document.getElementById(`cart-item-${itemId}`);
                
                // Start fade out animation
                cartItem.classList.add('fade-out');
                
                // Send AJAX request to delete item
                fetch(`{{ url('cart') }}/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Wait for animation to complete then remove element
                    setTimeout(() => {
                        cartItem.remove();
                        
                        // Show success message
                        showAlert(data.message || 'Item berhasil dihapus dari keranjang');
                        
                        // Update the cart totals
                        updateTotalPrice();
                        
                        // Check if cart is empty
                        checkEmptyCart();
                    }, 500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    cartItem.classList.remove('fade-out'); // Remove animation if failed
                    showAlert('Gagal menghapus item dari keranjang', 'error');
                });
            });
        });
    }

    // Add event listener to each checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });
    
    // Setup delete handlers
    setupDeleteHandlers();

    // Initialize total price on page load
    updateTotalPrice();
});
</script>
@endsection