@extends('layouts.app')

@section('title', 'Beranda - PhoneKu Handphone & Aksesoris')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative bg-blue-500">
        <!-- Banner Container -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-xl overflow-hidden" id="banner-slider">
                <div class="slide-container">
                    <div class="slides">
                        <div class="slide active">
                            <img src="img/banner1.png" alt="PhoneKu Banner 1" class="banner-image">
                        </div>
                        <div class="slide">
                            <img src="img/banner2.png" alt="PhoneKu Banner 2" class="banner-image">
                        </div>
                        <div class="slide">
                            <img src="img/banner3.png" alt="PhoneKu Banner 3" class="banner-image">
                        </div>
                    </div>
                </div>

                <!-- Banner Navigation Dots -->
                <div class="flex justify-center space-x-2 py-4">
                    <button class="w-4 h-4 rounded-full bg-blue-500 slider-dot active" data-slide="0"></button>
                    <button class="w-4 h-4 rounded-full bg-gray-300 slider-dot" data-slide="1"></button>
                    <button class="w-4 h-4 rounded-full bg-gray-300 slider-dot" data-slide="2"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Transition -->
    <div class="bg-blue-500 wave-section">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave-svg" preserveAspectRatio="none">
            <path fill="#ffffff" fill-opacity="1"
                d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,149.3C1120,160,1280,128,1360,112L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Handphone Section -->
    <div class="container mx-auto px-4 pt-32 pb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-sm text-gray-600">Produk kami</p>
                <h2 class="text-2xl font-bold">Handphone</h2>
            </div>

            <div class="relative max-w-md w-full">
                <form action="{{ route('allproduct') }}" method="GET">
                    <div class="flex items-center bg-blue-500 rounded-full overflow-hidden">
                        <input type="text" name="search"
                            class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none"
                            placeholder="Cari barang yang anda inginkan....">
                        <button type="submit" class="bg-blue-500 text-white p-3">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                    <input type="hidden" name="category" value="handphone">
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($phones as $product)
                <!-- Product Card -->
                <div class="bg-blue-500 rounded-xl overflow-hidden">
                    <div class="product-image-container bg-blue w-full h-64 flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-image max-h-56 object-contain px-4">
                        @else
                            <div class="flex items-center justify-center h-full w-full bg-blue-400">
                                <i class="fa fa-image text-white text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-white">
                        <h3 class="font-medium">{{ $product->name }}</h3>
                        <p class="text-2xl font-bold mt-1">{{ $product->formatted_price }}</p>
                        @if ($product->has_discount)
                            <p class="text-white/70 line-through">{{ $product->formatted_original_price }}</p>
                        @endif
                        <div class="flex mt-4 space-x-2">
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" data-cart-action="add" data-product-id="{{ $product->id }}"
                                        class="bg-white text-blue-500 rounded py-2 px-4 text-sm w-full text-center">+Keranjang</button>
                                </form>
                                <a href="{{ route('product.show', $product) }}"
                                    class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                    class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center no-underline">+Keranjang</a>
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                    class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8">
                    <p class="text-gray-500">Tidak ada produk handphone tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('allproduct', ['category' => 'handphone']) }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-12 rounded-md no-underline">
                Lihat Semua Produk
            </a>
        </div>
    </div>

    <!-- Accessories Section -->
    <div class="container mx-auto px-4 py-8 border-t border-gray-200">
        <div class="mb-6">
            <p class="text-sm text-gray-600">Produk kami</p>
            <h2 class="text-2xl font-bold">Aksesoris</h2>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($accessories as $product)
                <!-- Product Card -->
                <div class="bg-blue-500 rounded-xl overflow-hidden">
                    <div class="bg-blue w-full h-64 flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="max-h-64 max-w-full object-contain">
                        @else
                            <div class="bg-blue-400 flex items-center justify-center h-64 w-full">
                                <i class="fa fa-image text-white text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-white">
                        <h3 class="font-medium">{{ $product->name }}</h3>
                        <p class="text-2xl font-bold mt-1">{{ $product->formatted_price }}</p>
                        @if ($product->has_discount)
                            <p class="text-white/70 line-through">{{ $product->formatted_original_price }}</p>
                        @endif
                        <div class="flex mt-4 space-x-2">
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" data-cart-action="add" data-product-id="{{ $product->id }}"
                                        class="bg-white text-blue-500 rounded py-2 px-4 text-sm w-full text-center">+Keranjang</button>
                                </form>
                                <a href="{{ route('product.show', $product) }}"
                                    class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                    class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center no-underline">+Keranjang</a>
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                    class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8">
                    <p class="text-gray-500">Tidak ada produk aksesoris tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('allproduct', ['category' => 'accessory']) }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-12 rounded-md no-underline">
                Lihat Semua Produk
            </a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .product-image-container {
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image {
            max-width: 90%;
            max-height: 220px;
            object-fit: contain;
        }

        .wave-section {
            position: relative;
            height: 150px;
            margin-top: -1px;
            width: 100%;
            overflow: hidden;
        }

        .wave-svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100vw;
            min-width: 100%;
            height: 100%;
            transform: translateY(1px);
        }

        .banner-image {
            width: 100%;
            object-fit: cover;
            max-height: 400px;
        }
    </style>
@endsection

@section('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner slider functionality
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach(slide => {
            slide.style.display = 'none';
            slide.classList.remove('active');
        });
        dots.forEach(dot => {
            dot.classList.remove('active');
            dot.classList.remove('bg-blue-500');
            dot.classList.add('bg-gray-300');
        });

        slides[index].style.display = 'block';
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        dots[index].classList.remove('bg-gray-300');
        dots[index].classList.add('bg-blue-500');
        currentSlide = index;
    }

    function startSlideShow() {
        slideInterval = setInterval(function() {
            let nextSlide = (currentSlide + 1) % slides.length;
            showSlide(nextSlide);
        }, 5000);
    }

    if (slides.length > 0 && dots.length > 0) {
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                let slideIndex = parseInt(this.getAttribute('data-slide'));
                showSlide(slideIndex);
                clearInterval(slideInterval);
                startSlideShow();
            });
        });

        showSlide(0);
        startSlideShow();
    }

    // Add to Cart AJAX functionality
    document.querySelectorAll('[data-cart-action="add"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('form');
            const productId = this.getAttribute('data-product-id');
            
            // Check if user is logged in before proceeding
            const isLoggedIn = document.body.classList.contains('user-logged-in') || 
                               document.querySelector('meta[name="user-logged-in"]') !== null;
            
            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Diperlukan',
                    text: 'Silakan login untuk menambahkan produk ke keranjang.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = `/login?redirect=${encodeURIComponent(window.location.href)}`;
                });
                return;
            }
                
            const formData = new FormData(form);

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin' // Include cookies in the request
            })
            .then(response => {
                if (response.status === 401) {
                    throw new Error('User not authenticated');
                }
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Produk berhasil ditambahkan ke keranjang!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });

                const cartCount = document.getElementById('cart-count');
                if (cartCount && data.cartCount !== undefined) {
                    cartCount.textContent = data.cartCount;
                }
            })
            .catch(error => {
                if (error.message === 'User not authenticated') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Login Diperlukan',
                        text: 'Silakan login untuk menambahkan produk ke keranjang.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).then(() => {
                        window.location.href = `/login?redirect=${encodeURIComponent(window.location.href)}`;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan produk ke keranjang.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                }
                console.error('Error:', error);
            });
        });
    });
});
    </script>
@endsection