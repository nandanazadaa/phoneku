<?php
use Illuminate\Support\Facades\Route;
?>

<!-- Top Navigation -->
<div class="bg-blue-500 relative z-50">
    <div class="container mx-auto px-4 py-2 flex justify-end text-white space-x-4 text-sm">
        @guest
            <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
            <span>|</span>
            <a href="{{ route('registrasi') }}" class="hover:underline">Daftar</a>
        @endguest

        @auth
            <div class="flex items-center">
                <form method="POST" action="{{ route('profile.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline flex items-center">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        @endauth
    </div>
    <!-- Main Navigation -->
    <div class="container mx-auto px-4 pb-4">
        <div class="relative bg-white rounded-xl py-4 px-6 flex items-center justify-between">

            <!-- Hamburger Menu Button (Mobile - Left) -->
            <div class="md:hidden">
                <button id="hamburger-button" class="text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Logo -->
            <div class="flex-1 flex justify-center md:hidden">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo2.png') }}" alt="PhoneKu Logo" class="h-10">
                </a>
            </div>

            <!-- Desktop logo -->
            <div class="hidden md:flex flex-shrink-0">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo2.png') }}" alt="PhoneKu Logo" class="h-10">
                </a>
            </div>

            <!-- Navigation Links (Centered on desktop) -->
            <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 space-x-8 items-center">
                <a href="{{ route('welcome') }}"
                    class="{{ Route::currentRouteName() == 'welcome' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Beranda
                </a>
                <a href="{{ route('aboutus') }}"
                    class="{{ Route::currentRouteName() == 'aboutus' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Tentang
                </a>
                <a href="{{ route('tim') }}"
                    class="{{ Route::currentRouteName() == 'tim' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Tim
                </a>
                <a href="{{ route('allproduct') }}"
                    class="{{ Route::currentRouteName() == 'allproduct' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Belanja
                </a>
                <a href="{{ route('kontak') }}"
                    class="{{ Route::currentRouteName() == 'kontak' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Kontak
                </a>
            </div>

            <!-- Icons (Right aligned) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('cart') }}"
                        class="{{ Route::currentRouteName() == 'cart' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count"
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>
                    @php
                        $activeRoutes = [
                            'profile',
                            'riwayatbeli',
                            'profilekeamanan',
                            'ubah_email',
                            'ubah_email_otp',
                            'ubah_no_tlp',
                            'ubah_no_tlp_otp',
                            'profile.logout.confirm',
                        ];
                        $isProfileActive = in_array(Route::currentRouteName(), $activeRoutes);
                    @endphp
                    <a href="{{ route('profile') }}"
                        class="{{ $isProfileActive ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }}">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                @else
                    <a href="{{ route('login', ['redirect' => route('cart')]) }}"
                        class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>



    <!-- Mobile Navigation Menu (Hidden by default) -->
    <div id="mobile-menu" class="mobile-navbar-menu hidden bg-white absolute w-full z-50 shadow-lg py-3">
        <div class="container mx-auto px-4">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('welcome') }}"
                    class="{{ Route::currentRouteName() == 'welcome' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                    Beranda
                </a>
                <a href="{{ route('aboutus') }}"
                    class="{{ Route::currentRouteName() == 'aboutus' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                    Tentang
                </a>
                <a href="{{ route('tim') }}"
                    class="{{ Route::currentRouteName() == 'tim' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                    Tim
                </a>
                <a href="{{ route('allproduct') }}"
                    class="{{ Route::currentRouteName() == 'allproduct' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                    Belanja
                </a>
                <a href="{{ route('kontak') }}"
                    class="{{ Route::currentRouteName() == 'kontak' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                    Kontak
                </a>

                <!-- Mobile-only navigation items -->
                @auth
                    <a href="{{ route('cart') }}"
                        class="{{ Route::currentRouteName() == 'cart' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                        <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                        @if ($cartCount > 0)
                            <span
                                class="ml-1 bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile') }}"
                        class="{{ in_array(Route::currentRouteName(), ['profile', 'riwayatpembelian', 'profilekeamanan', 'logout.page']) ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                        <i class="fas fa-user-circle mr-2"></i>Profil
                    </a>
                    <div class="py-2 text-center">
                        <form method="POST" action="{{ route('profile.logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-gray-600 hover:text-blue-500 w-full flex items-center justify-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login', ['redirect' => route('cart')]) }}"
                        class="text-gray-600 hover:text-blue-500 py-2 text-center border-b border-gray-100">
                        <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-500 py-2 text-center">
                        <i class="fas fa-user-circle mr-2"></i>Masuk / Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        // Hamburger menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerButton = document.getElementById('hamburger-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (hamburgerButton && mobileMenu) {
                hamburgerButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('active');

                    // Toggle hamburger icon between menu and X
                    const isOpen = !mobileMenu.classList.contains('hidden');
                    const svg = hamburgerButton.querySelector('svg');

                    if (isOpen) {
                        svg.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        `;
                    } else {
                        svg.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        `;
                    }
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    const isClickInside = hamburgerButton.contains(event.target) ||
                        mobileMenu.contains(event.target);

                    if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.classList.remove('active');
                        const svg = hamburgerButton.querySelector('svg');
                        svg.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        `;
                    }
                });
            }

            // Banner Slider Functionality
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

            // Add to Cart AJAX Functionality
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
                            window.location.href =
                                `/login?redirect=${encodeURIComponent(window.location.href)}`;
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
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (response.status === 401) {
                                throw new Error('User not authenticated');
                            }
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.message ||
                                        'Network response was not ok');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message ||
                                    'Produk berhasil ditambahkan ke keranjang!',
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
                            console.error('Fetch Error:', error);
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
                                    window.location.href =
                                        `/login?redirect=${encodeURIComponent(window.location.href)}`;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: error.message ||
                                        'Terjadi kesalahan saat menambahkan produk ke keranjang.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                });
                            }
                        });
                });
            });
        });
        function scrollSlider(id, direction) {
            const container = document.getElementById(id);
            const scrollAmount = 300; // px per click
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
@endsection
