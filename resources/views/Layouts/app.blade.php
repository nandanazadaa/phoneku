<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body class="{{ Auth::check() ? 'user-logged-in' : '' }}">
    <!-- Top Navigation -->
    <div class="bg-blue-500 relative">
        <div class="container mx-auto px-4 py-2 flex justify-end text-white space-x-4 text-sm">
            @guest
                <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
                <span>|</span>
                <a href="{{ route('registrasi') }}" class="hover:underline">Daftar</a>
            @endguest
            @auth
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
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
            <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between relative">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}"><img src="{{ asset('img/logo2.png') }}" alt="PhoneKu Logo" class="h-10"></a>
                </div>

                <!-- Navigation Links -->
                <div class="navbar-menu hidden md:flex space-x-8">
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

                <!-- Icons for Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('cart') }}" 
                            class="{{ Route::currentRouteName() == 'cart' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                                {{ $cartCount }}
                            </span>
                        </a>
                        @php
                            $activeRoutes = ['profile', 'riwayatpembelian', 'profilekeamanan', 'logout.page'];
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
                        <a href="{{ route('login') }}" 
                            class="text-gray-600 hover:text-blue-500">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    @endauth
                </div>

                <!-- Hamburger Menu Button (Mobile) -->
                <div class="hamburger md:hidden flex flex-col justify-between w-8 h-6 cursor-pointer">
                    <span class="bg-gray-800 h-1 w-full rounded"></span>
                    <span class="bg-gray-800 h-1 w-full rounded"></span>
                    <span class="bg-gray-800 h-1 w-full rounded"></span>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu (Hidden by default) -->
        <div class="mobile-navbar-menu hidden bg-white w-full shadow-lg py-3">
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
                    @auth
                        <a href="{{ route('cart') }}" 
                            class="{{ Route::currentRouteName() == 'cart' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                            <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                            @if($cartCount > 0)
                                <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('profile') }}" 
                            class="{{ in_array(Route::currentRouteName(), ['profile', 'riwayatpembelian', 'profilekeamanan', 'logout.page']) ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} py-2 text-center border-b border-gray-100">
                            <i class="fas fa-user-circle mr-2"></i>Profil
                        </a>
                        <div class="py-2 text-center">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-blue-500 w-full flex items-center justify-center">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login', ['redirect' => route('cart')]) }}" 
                            class="text-gray-600 hover:text-blue-500 py-2 text-center border-b border-gray-100">
                            <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                        </a>
                        <a href="{{ route('login') }}" 
                            class="text-gray-600 hover:text-blue-500 py-2 text-center">
                            <i class="fas fa-user-circle mr-2"></i>Masuk / Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>