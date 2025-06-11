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
                            <img src="img/banner1.png" alt="PhoneKu Banner 1" class="w-full h-auto object-cover">
                        </div>
                        <div class="slide">
                            <img src="img/banner2.png" alt="PhoneKu Banner 2" class="w-full h-auto object-cover">
                        </div>
                        <div class="slide">
                            <img src="img/banner3.png" alt="PhoneKu Banner 3" class="w-full h-auto object-cover">
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
    <div class="container mx-auto px-4 pt-16 pb-8 border-t border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold">Handphone</h2>
                <p class="text-sm text-gray-600">Produk kami yang tersedia</p>
            </div>

            <div class="w-full md:w-auto max-w-md">
                <form action="{{ route('allproduct') }}" method="GET" class="search-form">
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
        <!-- Handphone Slider with Navigation -->
        <div class="relative">
            <!-- Tombol Navigasi -->
            <button
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white border rounded-full shadow p-2 z-10 hover:bg-gray-100"
                onclick="scrollSlider('handphone-slider', -1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white border rounded-full shadow p-2 z-10 hover:bg-gray-100"
                onclick="scrollSlider('handphone-slider', 1)">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Produk Slider -->
            <div id="handphone-slider" class="overflow-x-auto hide-scrollbar scroll-smooth py-4 px-8">
                <div class="flex space-x-4 min-w-max">
                    @forelse($phones as $product)
                        <!-- Product Card -->
                        <div
                            class="w-64 flex-shrink-0 bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                            <div class="bg-gray-100 w-full h-56 flex items-center justify-center p-4 relative group">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="max-h-full object-contain transition transform group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                        <i class="fa fa-image text-5xl"></i>
                                    </div>
                                @endif
                                @if ($product->original_price && $product->original_price > $product->price)
                                    @php
                                        $discountPercentage = round(
                                            (($product->original_price - $product->price) / $product->original_price) *
                                                100,
                                        );
                                    @endphp
                                    <span
                                        class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $discountPercentage }}% OFF
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-semibold text-base text-gray-800 mb-2">{{ $product->name }}</h3>
                                <p class="text-blue-600 font-bold text-lg">{{ $product->formatted_price }}</p>
                                @if ($product->original_price && $product->original_price > $product->price)
                                    <p class="text-gray-500 line-through text-sm">
                                        {{ $product->formatted_original_price }}
                                    </p>
                                @endif
                                <div class="flex mt-4 space-x-2">
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-4 text-center text-sm w-full hover:bg-blue-200">
                                            <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                            </button>
                                        </form>
                                        <a href="{{ route('product.show', $product) }}"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-8 text-sm text-center hover:bg-blue-600"><i
                                                class="fas fa-shopping-bag mr-1"></i>Beli</a>
                                    @else
                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                            class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-4 text-center text-sm w-full hover:bg-blue-200">
                                            <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                        </a>
                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-10 text-sm text-center hover:bg-blue-600"><i
                                                class="fas fa-shopping-bag mr-1"></i>Beli</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center w-full py-8">
                            <p class="text-gray-500">Tidak ada produk handphone tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
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
            <h2 class="text-2xl font-bold">Aksesoris</h2>
            <p class="text-sm text-gray-600">Produk kami yang tersedia</p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($accessories as $product)
                <!-- Product Card -->
                <div
                    class="bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                    <div
                        class="product-image-container bg-gray-100 w-full h-56 flex items-center justify-center flex-shrink-0 p-4 relative group">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-image max-h-full object-contain transition duration-500 ease-in-out transform group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                <i class="fa fa-image text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-blue-600 flex flex-col flex-grow">
                        <h3 class="font-semibold text-base text-gray-800 flex-grow mb-2">{{ $product->name }}</h3>
                        <p class="text-2xl font-bold mt-1">{{ $product->formatted_price }}</p>
                        @if ($product->has_discount)
                            <p class="text-white/70 line-through">{{ $product->formatted_original_price }}</p>
                        @endif
                        <div class="flex mt-4 space-x-2">
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" data-cart-action="add" data-product-id="{{ $product->id }}"
                                        class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200">
                                        <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                    </button>
                                </form>
                                <a href="{{ route('product.show', $product) }}"
                                    class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i
                                        class="fas fa-shopping-bag mr-1"></i>Beli</a>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                    class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200">
                                    <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                    <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                        class="bg-blue-500 text-white rounded-lg py-2 px-10 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i
                                            class="fas fa-shopping-bag mr-1"></i>Beli</a>
                                @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-8">
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
    <style src="{{ asset('\css\welcome.css') }}"></style>
@endsection
