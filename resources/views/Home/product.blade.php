    @extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

    @section('title', $product->name . ' - PhoneKu') {{-- Judul halaman dinamis --}}

    @section('content')

        <!-- Product Detail Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                <!-- Product Image Section -->
                <div class="flex flex-col">
                    <!-- Main Image Container -->
                    <div
                        class="bg-gray-100 rounded-xl p-4 md:p-8 flex items-center justify-center mb-4 relative shadow-sm aspect-square overflow-hidden">
                        @php
                            // Filter gambar yang valid (tidak null atau string kosong)
                            $images = collect([$product->image, $product->image2, $product->image3])
                                ->filter()
                                ->values();
                            $hasMultipleImages = $images->count() > 1;
                        @endphp

                        @foreach($images as $index => $imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }} - Foto {{ $index + 1 }}"
                                data-index="{{ $index }}"
                                class="product-image absolute inset-0 w-full h-full object-contain transition-opacity duration-300 ease-in-out p-2"
                                style="opacity: {{ $index == 0 ? 1 : 0 }};">
                        @endforeach

                        @if ($hasMultipleImages)
                            <button type="button" class="slider-arrow left absolute top-1/2 left-2 md:left-4 transform -translate-y-1/2 z-10 bg-white bg-opacity-80 hover:bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center w-10 h-10 border border-gray-200">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button type="button" class="slider-arrow right absolute top-1/2 right-2 md:right-4 transform -translate-y-1/2 z-10 bg-white bg-opacity-80 hover:bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center w-10 h-10 border border-gray-200">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Image Navigation Dots -->
                    @if ($hasMultipleImages)
                        <div class="flex justify-center space-x-2 mt-2">
                            @foreach ($images as $index => $imagePath)
                                <button type="button"
                                    class="dot {{ $index == 0 ? 'active bg-blue-500 w-6 h-3' : 'bg-gray-300 w-3 h-3' }} rounded-full transition-all duration-300 ease-in-out hover:bg-blue-400 border border-gray-200"
                                    data-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info Section -->
                <div class="py-4">
                    <p class="text-sm text-gray-500 mb-1 uppercase tracking-wide">{{ $product->category ?? 'Produk' }}</p>
                    <h1 class="text-3xl md:text-4xl font-bold mb-3 text-gray-800">{{ $product->name }}</h1>

                    {{-- Rating (Contoh Statis - Ganti jika ada data rating) --}}
                    <div class="flex items-center mb-5">
                        <div class="star-rating flex text-lg">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star empty"><i class="far fa-star"></i></span> {{-- Use far for empty star --}}
                        </div>
                        <span class="text-gray-500 ml-2 text-sm">(15 Ulasan - Contoh)</span>
                        {{-- Tampilkan link ke ulasan jika ada --}}
                    </div>


                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-xs text-gray-500 font-semibold mb-1 uppercase">HARGA</h3>
                        <div class="flex items-baseline space-x-3">
                            <p class="text-3xl font-bold text-blue-600">
                                {{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                            @if ($product->original_price && $product->original_price > $product->price)
                                <p class="text-gray-400 line-through text-xl">
                                    {{ $product->formatted_original_price ?? 'Rp ' . number_format($product->original_price, 0, ',', '.') }}
                                </p>
                                @php $discountPercentage = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                                <span class="text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded">
                                    DISKON {{ $discountPercentage }}%
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Details/Description -->
                    <div class="mt-10 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 pb-2 mb-4 border-b border-gray-200">Deskripsi Produk</h3>
                        <div class="text-gray-700 prose prose-sm max-w-none leading-relaxed">
                            {!! nl2br(e($product->description ?? 'Tidak ada deskripsi untuk produk ini.')) !!}
                        </div>
                    </div>
                    <!-- Quantity & Stock -->
                    <div class="mb-6">
                        {{-- Form untuk Add to Cart & Beli Langsung --}}
                        <form id="product-action-form" action="{{ route('buy.now', $product->id) }}" method="POST">
    @csrf
    <input type="hidden" name="quantity" id="quantity-input" value="1" min="1" max="{{ $product->stock }}">
    <div class="flex items-center justify-between">
        <div class="flex-shrink-0">
            <h3 class="text-xs text-gray-500 font-semibold mb-2 uppercase">KUANTITAS</h3>
            <div class="flex items-center border border-gray-300 rounded-lg quantity-counter bg-white shadow-sm">
                <button type="button"
                    class="px-4 py-3 text-gray-600 quantity-btn minus-btn rounded-l-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200 border-r border-gray-200 flex items-center justify-center"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
                <input type="number" id="quantity-input-display" value="1" min="1"
                    max="{{ $product->stock }}"
                    class="w-16 text-center border-0 quantity-input appearance-none focus:outline-none focus:ring-0 font-semibold text-gray-800"
                    {{ $product->stock <= 0 ? 'readonly' : '' }} disabled>
                <button type="button"
                    class="px-4 py-3 text-gray-600 quantity-btn plus-btn rounded-r-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200 border-l border-gray-200 flex items-center justify-center"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="text-right">
            <h3 class="text-xs text-gray-500 font-semibold mb-1 uppercase">STOK</h3>
            <p
                class="text-sm {{ $product->stock > 5 ? 'text-green-600' : ($product->stock > 0 ? 'text-orange-600' : 'text-red-600') }} font-bold">
                {{ $product->stock > 0 ? $product->stock . ' Tersedia' : 'Habis' }}
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm text-gray-600 font-medium">TOTAL HARGA</p>
                <p class="text-2xl font-bold text-blue-600" id="total-price-display">
                    {{ $product->stock > 0 ? $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') : 'Rp 0' }}
                </p>
            </div>
            <div class="flex space-x-3">
                @if ($product->stock > 0)
                    @auth('web')
                        <button type="submit" form="product-action-form"
                            class="add-to-cart-btn border-2 border-blue-500 bg-white text-blue-600 py-3 px-5 rounded-lg flex items-center justify-center font-semibold hover:bg-blue-50 hover:border-blue-600 transition-all duration-200 shadow-sm hover:shadow-md"
                            title="Tambah ke Keranjang">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L3 3H1m6 10H7m0 0v4a1 1 0 001 1h1m4-5h8m-4 0h.01M15 16a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                        <button type="submit" form="product-action-form"
                            class="buy-now-btn bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold flex-grow hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <span>Beli Sekarang</span>
                        </button>
                    @else
                        <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}"
                            title="Login untuk tambah ke keranjang"
                            class="border-2 border-blue-500 bg-white text-blue-600 py-3 px-5 rounded-lg flex items-center justify-center font-semibold hover:bg-blue-50 hover:border-blue-600 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L3 3H1m6 10H7m0 0v4a1 1 0 001 1h1m4-5h8m-4 0h.01M15 16a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}"
                            title="Login untuk Beli"
                            class="bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold flex-grow hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <span>Beli Sekarang</span>
                        </a>
                    @endauth
                @else
                    <span
                        class="text-red-600 font-semibold py-3 px-6 border-2 border-red-300 rounded-lg bg-red-50 w-full text-center hover:bg-red-100 transition-all duration-200">
                        Stok Habis</span>
                @endif
            </div>
        </div>
    </div>
</form>
                    </div>

                  
                </div>
            </div> 


            {{-- Related Products Section --}}
            @if ($relatedProducts && $relatedProducts->isNotEmpty())
                <div class="container mx-auto px-4 py-12 mt-16 border-t border-gray-200">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Produk Lainnya</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $related)
                            <div
                                class="bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                                <a href="{{ route('product.show', $related) }}"
                                    class="block product-image-container bg-gray-100 w-full h-56 flex items-center justify-center flex-shrink-0 p-4 relative group">
                                    @if ($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                                            class="product-image max-h-full object-contain transition duration-500 ease-in-out transform group-hover:scale-105">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                            <i class="fa fa-image text-5xl"></i></div>
                                    @endif
                                    {{-- Discount Badge --}}
                                    @if ($related->original_price && $related->original_price > $related->price)
                                        @php $discountPercentage = round((($related->original_price - $related->price) / $related->original_price) * 100); @endphp
                                        <span
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">{{ $discountPercentage }}%
                                            OFF</span>
                                    @endif
                                </a>
                                <div class="p-4 text-gray-800 flex flex-col flex-grow">
                                    <h3 class="font-semibold text-base flex-grow mb-2">
                                        <a href="{{ route('product.show', $related) }}"
                                            class="hover:text-blue-600 line-clamp-2"
                                            title="{{ $related->name }}">{{ $related->name }}</a>
                                    </h3>
                                    <div class="mt-auto">
                                        <p class="text-xl font-bold text-blue-600 mt-1">
                                            {{ $related->formatted_price ?? 'Rp ' . number_format($related->price, 0, ',', '.') }}
                                        </p>
                                        @if ($related->original_price && $related->original_price > $related->price)
                                            <p class="text-gray-500 line-through text-sm">
                                                {{ $related->formatted_original_price ?? 'Rp ' . number_format($related->original_price, 0, ',', '.') }}
                                            </p>
                                        @endif
                                        <div class="flex mt-4 space-x-2">
                                            @if ($related->stock > 0)
                                                @auth('web')
                                                    <form action="{{ route('cart.add', $related->id) }}" method="POST"
                                                        class="flex-1">
                                                        @csrf
                                                        <button type="submit" data-cart-action="add"
                                                            data-product-id="{{ $related->id }}"
                                                            class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200"><i
                                                                class="fas fa-cart-plus mr-1"></i> Keranjang</button>
                                                    </form>
                                                    <a href="{{ route('product.show', $related) }}" title="Lihat Detail"
                                                        class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i
                                                            class="fas fa-eye mr-1"></i> Detail</a>
                                                @else
                                                    <a href="{{ route('login', ['redirect' => route('product.show', $related)]) }}"
                                                        title="Login untuk tambah"
                                                        class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-200 transition duration-200"><i
                                                            class="fas fa-cart-plus mr-1"></i> Keranjang</a>
                                                    <a href="{{ route('product.show', $related) }}" title="Lihat Detail"
                                                        class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i
                                                            class="fas fa-eye mr-1"></i> Detail</a>
                                                @endauth
                                            @else
                                                <span
                                                    class="text-center text-sm text-red-600 bg-red-100 border border-red-300 rounded-lg py-2 px-4 w-full">Stok
                                                    Habis</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- Akhir Related Products --}}

        </div> <!-- End Container -->

    @endsection


    @section('styles')
        {{-- Style dari view asli Anda + perbaikan --}}
        <style src="{{ asset('\css\product.css') }}"></style>
        <style>
            /* Custom styles for product page */
            .quantity-counter button:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            
            .color-option:hover .color-option-check {
                opacity: 1;
            }
            
            .btn-icon {
                transition: transform 0.2s ease;
            }
            
            .btn-icon:hover {
                transform: scale(1.1);
            }
            
            /* Star rating styles */
            .star-rating .star {
                color: #fbbf24;
            }
            
            .star-rating .star.empty {
                color: #d1d5db;
            }
        </style>
    @endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Price and quantity calculations
                const price = {{ $product->price }};
                const maxStock = {{ $product->stock }};
                const currentCartQuantity = {{ $cartQuantity ?? 0 }}; // Current quantity in cart
                const availableQuantity = maxStock - currentCartQuantity; // Available to add
                
                const quantityInput = document.getElementById('quantity-input');
                const totalPriceDisplay = document.getElementById('total-price-display');
                const minusBtn = document.querySelector('.minus-btn');
                const plusBtn = document.querySelector('.plus-btn');

                // Set max attribute untuk input
                quantityInput.max = availableQuantity > 0 ? availableQuantity : 0;

                // Update stock display
                function updateStockDisplay() {
                    const stockElement = document.querySelector('[class*="text-green-600"],[class*="text-orange-600"],[class*="text-red-600"]');
                    if (stockElement && currentCartQuantity > 0) {
                        const currentText = stockElement.textContent;
                        if (!currentText.includes('di keranjang')) {
                            stockElement.textContent = `${maxStock} Tersedia (${currentCartQuantity} di keranjang)`;
                        }
                    }
                }

                function updateTotalPrice() {
                    let qty = parseInt(quantityInput.value) || 1;
                    if (qty < 1) qty = 1;
                    if (qty > availableQuantity) qty = availableQuantity;
                    
                    quantityInput.value = qty;
                    const total = price * qty;
                    totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    
                    // Update button states
                    minusBtn.disabled = qty <= 1;
                    plusBtn.disabled = qty >= availableQuantity;
                }

                // Show warning if stock is limited
                if (availableQuantity <= 0) {
                    quantityInput.value = 0;
                    quantityInput.disabled = true;
                    minusBtn.disabled = true;
                    plusBtn.disabled = true;
                } else if (availableQuantity < maxStock) {
                    // Show warning about remaining stock
                    const warningDiv = document.createElement('div');
                    warningDiv.className = 'text-orange-600 text-xs mt-1';
                    warningDiv.textContent = `Tersisa ${availableQuantity} yang bisa ditambahkan`;
                    quantityInput.parentNode.appendChild(warningDiv);
                }

                quantityInput.addEventListener('input', updateTotalPrice);

                minusBtn.addEventListener('click', function () {
                    let qty = parseInt(quantityInput.value) || 1;
                    if (qty > 1) {
                        quantityInput.value = qty - 1;
                        updateTotalPrice();
                    }
                });

                plusBtn.addEventListener('click', function () {
                    let qty = parseInt(quantityInput.value) || 1;
                    if (qty < availableQuantity) {
                        quantityInput.value = qty + 1;
                        updateTotalPrice();
                    }
                });

                updateStockDisplay();
                updateTotalPrice();

                // SLIDER IMAGE
                const images = document.querySelectorAll('.product-image');
                const dots = document.querySelectorAll('.dot');
                const leftBtn = document.querySelector('.slider-arrow.left');
                const rightBtn = document.querySelector('.slider-arrow.right');
                let currentIndex = 0;

                function showImage(idx) {
                    images.forEach((img, i) => {
                        img.style.opacity = (i === idx) ? 1 : 0;
                    });
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('bg-blue-500', i === idx);
                        dot.classList.toggle('w-6', i === idx);
                        dot.classList.toggle('bg-gray-300', i !== idx);
                        dot.classList.toggle('w-3', i !== idx);
                    });
                    currentIndex = idx;
                }

                if (leftBtn && rightBtn && images.length > 1) {
                    leftBtn.addEventListener('click', function () {
                        let idx = (currentIndex - 1 + images.length) % images.length;
                        showImage(idx);
                    });
                    rightBtn.addEventListener('click', function () {
                        let idx = (currentIndex + 1) % images.length;
                        showImage(idx);
                    });
                }

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', function () {
                        showImage(i);
                    });
                });

                showImage(0);

                // Add to Cart AJAX dengan validasi yang lebih baik
                const addToCartBtn = document.querySelector('.add-to-cart-btn[data-product-id]');

                if (addToCartBtn) {
                    addToCartBtn.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Validate quantity before sending
                        let quantity = parseInt(quantityInput.value) || 1;
                        
                        if (quantity <= 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Kuantitas tidak valid'
                            });
                            return;
                        }
                        
                        if (quantity > availableQuantity) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: `Maksimal yang bisa ditambahkan: ${availableQuantity} items`
                            });
                            quantityInput.value = availableQuantity;
                            updateTotalPrice();
                            return;
                        }

                        const productId = this.getAttribute('data-product-id');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v4m0 12v4m8.485-8.485l-2.828 2.828M5.757 5.757L2.929 8.585M20 12h-4M8 12H4m16.485 3.515l-2.828-2.828M5.757 18.243l-2.828-2.829"></path></svg>';
                        this.disabled = true;

                        // Send AJAX request
                        fetch(`/cart/add/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                quantity: quantity,
                                _token: csrfToken
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                
                                // Update cart count
                                const cartCount = document.getElementById('cart-count');
                                if (cartCount && data.cartCount) {
                                    cartCount.textContent = data.cartCount;
                                    cartCount.classList.remove('hidden');
                                }
                                
                                // Refresh page after success to update cart quantities
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Gagal menambahkan ke keranjang'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan sistem'
                            });
                        })
                        .finally(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        });
                    });
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/product.js') }}"></script>
    @endsection
