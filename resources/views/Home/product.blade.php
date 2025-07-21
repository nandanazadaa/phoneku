@extends('layouts.app') {{-- Adjust to your main layout --}}

@section('title', $product->name . ' - PhoneKu') {{-- Dynamic page title --}}

@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="flex flex-col items-center">
                <div class="relative w-full flex justify-center">
                    <button class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full shadow p-2 hover:bg-gray-100" id="slider-left">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="bg-white rounded-xl overflow-hidden flex items-center justify-center w-[350px] h-[350px] md:w-[400px] md:h-[400px] shadow border mx-8">
                        @php
                            // Filter out any null or empty image paths
                            $images = collect([$product->image, $product->image2, $product->image3])->filter()->values();
                        @endphp
                        @foreach($images as $index => $imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }} - Foto {{ $index + 1 }}"
                                class="product-image absolute w-full h-full object-contain transition-opacity duration-300 ease-in-out p-4" style="opacity: {{ $index == 0 ? 1 : 0 }};">
                        @endforeach
                    </div>
                    <button class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full shadow p-2 hover:bg-gray-100" id="slider-right">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="flex justify-center space-x-2 mt-4">
                    @foreach ($images as $index => $imagePath)
                        <button type="button" class="dot {{ $index == 0 ? 'bg-blue-500 w-6 h-3' : 'bg-gray-300 w-3 h-3' }} rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>
            <div class="w-full max-w-lg mx-auto lg:mx-0">
                {{-- Display Brand here --}}
                @if ($product->brand)
                    <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Brand: {{ ucfirst($product->brand) }}</p>
                @endif
                <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">{{ $product->category }}</p>
                <h1 class="text-2xl md:text-3xl font-bold mb-2 text-gray-800">{{ $product->name }}</h1>
                <div class="flex items-center mb-4">
                    <div class="star-rating flex text-lg">
                        @php $rounded = round($averageRating * 2) / 2; @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($rounded))
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif ($i - 0.5 == $rounded)
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-500 ml-2 text-sm">
                        ({{ $testimonials->total() }} Ulasan) {{-- Use total() for paginated results --}}
                    </span>
                </div>

                <div class="mb-2">
                    <span class="text-xs text-gray-500 font-semibold uppercase">HARGA</span>
                    <div class="flex items-baseline space-x-3 mt-1">
                        <span class="text-2xl font-bold text-blue-600" id="unit-price">{{ $product->formatted_price }}</span>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <span class="text-gray-400 line-through text-lg">{{ $product->formatted_original_price }}</span>
                            @php $discountPercentage = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                            <span class="text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded">{{ $discountPercentage }}% OFF</span>
                        @endif
                    </div>
                </div>


                <div class="mb-2">
                    <span class="text-xs text-gray-500 font-semibold uppercase">DESKRIPSI PRODUK</span>
                    <div class="prose prose-sm max-w-none text-gray-700 mt-1">
                        {!! nl2br(e($product->description ?? '-')) !!}
                    </div>
                </div>
                                                {{-- $colors is now $product->valid_colors from the controller --}}
                @if(!empty($colors) && is_array($colors))
                    <div class="mb-4 flex items-center gap-2">
                        <span class="text-xs text-gray-500 font-semibold uppercase mr-2">WARNA</span>
                        <div class="flex items-center gap-2" id="color-options">
                            @foreach($colors as $color)
                                @php
                                    $cleanColor = trim($color);
                                    // $cleanColor is already validated as a hex code by valid_colors accessor
                                    $displayColor = $cleanColor;
                                @endphp
                                <label class="w-6 h-6 rounded-full border-2 flex items-center justify-center cursor-pointer relative"
                                    style="border-color: {{ $selectedColor === $cleanColor ? '#3b82f6' : '#d1d5db' }};"
                                    title="{{ $product->getFriendlyColorName($cleanColor) }}">
                                    <input type="radio" name="color" value="{{ $cleanColor }}" class="sr-only color-radio" {{ $selectedColor === $cleanColor ? 'checked' : '' }}>
                                    <span class="block w-4 h-4 rounded-full" style="background: {{ $displayColor }};"></span>
                                    <span class="absolute inset-0 border-2 border-blue-500 rounded-full pointer-events-none" style="display: {{ $selectedColor === $cleanColor ? 'block' : 'none' }};"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="flex items-center gap-8 mt-4 mb-2">
                    <div>
                        <span class="text-xs text-gray-500 font-semibold uppercase">KUANTITAS</span>
                        <div class="flex items-center border border-gray-300 rounded-lg bg-white shadow-sm mt-1">
                            <button type="button" class="px-3 py-2 text-gray-600 quantity-btn minus-btn rounded-l-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200 border-r border-gray-200 flex items-center justify-center" id="qty-minus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                            <input type="number" id="quantity-input" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-0 quantity-input appearance-none focus:outline-none font-semibold text-gray-800" style="-moz-appearance: textfield;">
                            <button type="button" class="px-3 py-2 text-gray-600 quantity-btn plus-btn rounded-r-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200 border-l border-gray-200 flex items-center justify-center" id="qty-plus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></button>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500 font-semibold uppercase">STOK</span>
                        <p class="text-sm {{ $product->stock > 5 ? 'text-green-600' : ($product->stock > 0 ? 'text-orange-600' : 'text-red-600') }} font-bold mt-1">{{ $product->stock > 0 ? $product->stock . ' Tersedia' : 'Habis' }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <span class="text-xs text-gray-500 font-semibold uppercase">TOTAL HARGA</span>
                    <span class="text-xl font-bold text-blue-600 ml-2" id="total-price">{{ $product->formatted_price }}</span>
                </div>
                <div class="flex items-center gap-4 mt-2">
                    @if ($product->stock > 0)
                        @auth('web')
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                <input type="hidden" name="color" id="cart-color" value="{{ $selectedColor }}">
                                <button type="submit" class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-6 text-center text-base font-semibold hover:bg-blue-200 flex items-center gap-2"><i class="fas fa-cart-plus"></i> Keranjang</button>
                            </form>
                            <form action="{{ route('buy.now', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                                <input type="hidden" name="color" id="buy-color" value="{{ $selectedColor }}">
                                <button type="submit" class="bg-blue-600 text-white rounded-lg py-2 px-8 text-base font-semibold hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-shopping-bag"></i> Beli</button>
                            </form>
                        @else
                            <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}" class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-6 text-center text-base font-semibold hover:bg-blue-200 flex items-center gap-2"><i class="fas fa-cart-plus"></i> Keranjang</a>
                            <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}" class="bg-blue-600 text-white rounded-lg py-2 px-8 text-base font-semibold hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-shopping-bag"></i> Beli</a>
                        @endauth
                    @else
                        <button type="button" class="out-of-stock-btn text-red-600 font-semibold py-2 px-6 border-2 border-red-300 rounded-lg bg-red-50 w-full text-center hover:bg-red-100 transition-all duration-200">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 py-12 mt-10">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Testimoni Pelanggan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
            @forelse($testimonials as $testi)
                <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center shadow-sm">
                    <div class="flex items-center justify-center mb-2 overflow-hidden h-32">
                        @if($testi->photo)
                            <img src="{{ asset('storage/' . $testi->photo) }}" alt="{{ $testi->user->name ?? 'User' }}" class="object-cover w-full h-32">
                        @else
                            <i class="fas fa-image text-5xl text-gray-400"></i>
                        @endif
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">
                        {{ $testi->user->name ?? '-' }}
                    </h4>
                    @if($testi->city)
                        <p class="text-xs text-gray-500 mb-2">{{ $testi->city }}</p>
                    @endif
                    <div class="flex items-center justify-center mb-2">
                        <span class="star-rating flex text-base">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $testi->rating ? 'fas fa-star text-yellow-400' : 'far fa-star text-gray-300' }}"></i>
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-700 text-sm mb-2">"{{ $testi->message }}"</p>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">Belum ada testimoni.</div>
            @endforelse
        </div>
        @if ($testimonials->hasPages())
            <div class="flex justify-center mt-10">
                <nav role="navigation" aria-label="Pagination Navigation"
                    class="inline-flex rounded-md shadow-sm overflow-hidden border border-gray-200">

                    {{-- Previous Page Link --}}
                    @if ($testimonials->onFirstPage())
                        <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $testimonials->previousPageUrl() }}"
                            class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">←</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($testimonials->links()->elements[0] as $page => $url)
                        @if ($page == $testimonials->currentPage())
                            <span class="px-4 py-2 text-sm bg-blue-500 text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($testimonials->hasMorePages())
                        <a href="{{ $testimonials->nextPageUrl() }}"
                            class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">→</a>
                    @else
                        <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">→</span>
                    @endif
                </nav>
            </div>
        @endif

    </div>
    @auth('web')
        @php
            $user = auth('web')->user();
            $hasBought = \App\Models\OrderItem::whereHas('order', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'selesai');
            })->where('product_id', $product->id)->exists();
            $hasTesti = \App\Models\Testimonial::where('user_id', $user->id)->where('product_id', $product->id)->exists();
        @endphp
        @if($hasBought && !$hasTesti)
        <div class="max-w-xl mx-auto mt-12">
            <h3 class="text-lg font-bold mb-4 text-center">Kirim Testimoni Anda</h3>
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div>
            @endif
            <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div>
                    <select name="rating" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Rating</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Bintang</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <textarea name="message" class="w-full border rounded px-3 py-2" placeholder="Pesan Anda" required></textarea>
                </div>
                <div>
                    <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Kirim Testimoni</button>
                </div>
            </form>
        </div>
        @endif
    @endauth
@endsection

@section('styles')
    {{-- This assumes you have a product.css file in your public/css directory. --}}
    {{-- If you don't have this file and all your CSS is inline, you can remove this line. --}}
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <style>
        /* Custom styles for product page */
        .quantity-counter button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
{{-- Include SweetAlert2 from CDN as it's used in the script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Cegah duplikasi
    if (!window.__hamburgerMenuFixed) {
        window.__hamburgerMenuFixed = true;
        const hamburgerButton = document.getElementById('hamburger-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (hamburgerButton && mobileMenu) {
            hamburgerButton.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('active');
                // Toggle icon
                const isOpen = !mobileMenu.classList.contains('hidden');
                const svg = hamburgerButton.querySelector('svg');
                if (svg) {
                    if (isOpen) {
                        svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`;
                    } else {
                        svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                    }
                }
            });
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!hamburgerButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.classList.remove('active');
                        const svg = hamburgerButton.querySelector('svg');
                        if (svg) {
                            svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                        }
                    }
                }
            });
            // Close menu when clicking a link
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('active');
                    const svg = hamburgerButton.querySelector('svg');
                    if (svg) {
                        svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                    }
                });
            });
        }
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Harga dinamis
    const unitPrice = @json($product->price);
    const maxStock = @json($product->stock);
    const quantityInput = document.getElementById('quantity-input');
    const totalPrice = document.getElementById('total-price');
    const minusBtn = document.getElementById('qty-minus');
    const plusBtn = document.getElementById('qty-plus');

    function updateTotalPrice() {
        let qty = parseInt(quantityInput.value) || 1;
        if (qty < 1) qty = 1;
        if (qty > maxStock) qty = maxStock;
        quantityInput.value = qty;
        totalPrice.textContent = 'Rp ' + (unitPrice * qty).toLocaleString('id-ID');
        minusBtn.disabled = qty <= 1;
        plusBtn.disabled = qty >= maxStock;
        document.getElementById('cart-quantity').value = qty;
        document.getElementById('buy-quantity').value = qty;
    }

    minusBtn.addEventListener('click', function () {
        let qty = parseInt(quantityInput.value) || 1;
        if (qty > 1) {
            quantityInput.value = qty - 1;
            updateTotalPrice();
        }
    });

    plusBtn.addEventListener('click', function () {
        let qty = parseInt(quantityInput.value) || 1;
        if (qty < maxStock) {
            quantityInput.value = qty + 1;
            updateTotalPrice();
        }
    });

    quantityInput.addEventListener('input', updateTotalPrice);
    updateTotalPrice();

    // Slider gambar
    let images = document.querySelectorAll('.product-image');
    let dots = document.querySelectorAll('.dot');
    let leftBtn = document.getElementById('slider-left');
    let rightBtn = document.getElementById('slider-right');
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

    // Color selection sync
    document.querySelectorAll('.color-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('cart-color').value = this.value;
            document.getElementById('buy-color').value = this.value;
            // Update border highlight
            document.querySelectorAll('#color-options label').forEach(function(label) {
                label.style.borderColor = '#d1d5db'; // Default gray border
                label.querySelector('.absolute').style.display = 'none'; // Hide blue ring
            });
            this.closest('label').style.borderColor = '#3b82f6'; // Blue border for selected
            this.closest('label').querySelector('.absolute').style.display = 'block'; // Show blue ring for selected
        });
    });

    // Handle initial color selection visual state on page load
    // This ensures the correct color swatch is highlighted if $selectedColor is set.
    const initialSelectedColor = "{{ $selectedColor }}";
    if (initialSelectedColor) {
        document.querySelectorAll('.color-radio').forEach(function(radio) {
            if (radio.value === initialSelectedColor) {
                radio.checked = true;
                radio.closest('label').style.borderColor = '#3b82f6';
                radio.closest('label').querySelector('.absolute').style.display = 'block';
            }
        });
    }


    // AJAX Add to Cart
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('form');
            if (!form) {
                console.error('Form not found for add to cart button');
                return;
            }

            const formData = new FormData(form);
            const originalButtonText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menambah...';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                this.disabled = false;
                this.innerHTML = originalButtonText;
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            // Check if a color is selected before submitting if colors are available
            const colorRadios = document.querySelectorAll('.color-radio');
            if (colorRadios.length > 0) {
                let selectedColorValue = document.getElementById('cart-color').value;
                if (!selectedColorValue) {
                    this.disabled = false;
                    this.innerHTML = originalButtonText;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Warna',
                        text: 'Silakan pilih warna terlebih dahulu sebelum menambahkan ke keranjang.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return; // Stop execution if no color is selected
                }
            }


            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('login', ['redirect' => url()->full()]) }}";
                    throw new Error('Unauthorized');
                }
                if (!response.ok) {
                    // Try to parse JSON error message from response
                    return response.json().then(err => { throw err; }).catch(() => {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Produk berhasil ditambahkan ke keranjang.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        alert(data.message || 'Produk berhasil ditambahkan ke keranjang.');
                    }

                    // Update cart count
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement && data.cartCount !== undefined) {
                        cartCountElement.textContent = data.cartCount;
                        cartCountElement.classList.toggle('hidden', data.cartCount <= 0);
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Tidak dapat menambahkan produk ke keranjang.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        alert(data.message || 'Tidak dapat menambahkan produk ke keranjang.');
                    }
                }
            })
            .catch(error => {
                if (error.message !== 'Unauthorized') {
                    console.error('Add to Cart Error:', error);
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (error.message && error.message.includes("Silakan pilih warna terlebih dahulu")) {
                        errorMessage = error.message; // Use specific message if available
                    } else if (error.errors) {
                        // Check for Laravel validation errors
                        for (const key in error.errors) {
                            if (error.errors.hasOwnProperty(key)) {
                                errorMessage = error.errors[key][0]; // Take the first error message
                                break;
                            }
                        }
                    }

                    if (typeof Swal !== 'undefined') {
                         Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        alert(errorMessage);
                    }
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = originalButtonText;
            });
        });
    });

    // Add event listener for out of stock items
    document.querySelectorAll('.out-of-stock-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis',
                text: 'Maaf, produk ini sedang tidak tersedia.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    });

    // Validation for buy now button
    document.querySelectorAll('form[action*="buy"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var colorRadios = document.querySelectorAll('.color-radio');
            if (colorRadios.length > 0) {
                var checked = false;
                colorRadios.forEach(function(radio) {
                    if (radio.checked) checked = true;
                });
                if (!checked) {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Warna',
                            text: 'Silakan pilih warna terlebih dahulu sebelum membeli.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        alert('Silakan pilih warna terlebih dahulu sebelum membeli.');
                    }
                }
            }
        });
    });
});
</script>
@endsection
