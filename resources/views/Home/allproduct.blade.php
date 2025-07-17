@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Semua Produk - PhoneKu') {{-- Judul halaman dinamis --}}

@section('content')
    <div class="container mx-auto px-4 pt-12 pb-8 max-w-7xl">
        {{-- Search Bar --}}
        <div class="relative w-full mb-6">
            <form action="{{ route('allproduct') }}" method="GET">
                <div class="flex items-center bg-blue-500 rounded-full overflow-hidden shadow">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none border-none focus:ring-0"
                        placeholder="Cari produk...">
                    @foreach (request()->except(['search', 'page']) as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $subValue)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $subValue }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white p-3 px-5 rounded-r-full transition duration-200">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Filters --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <form id="filter-form" action="{{ route('allproduct') }}" method="GET" class="contents">
                <input type="hidden" name="search" value="{{ request('search') }}"> {{-- Pertahankan search query --}}

                <div class="relative w-full">
                    <select name="category" onchange="document.getElementById('filter-form').submit()"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Kategori</option>
                        <option value="handphone" {{ request('category') == 'handphone' ? 'selected' : '' }}>Handphone
                        </option>
                        <option value="accessory" {{ request('category') == 'accessory' ? 'selected' : '' }}>Aksesoris
                        </option>
                    </select>
                    <i
                        class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>

                {{-- NEW: Dynamic Brand Filter --}}
                <div class="relative w-full">
                    <select name="brand" onchange="document.getElementById('filter-form').submit()"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Brand</option>
                        @foreach ($uniqueBrands as $brandName) {{-- Iterate over uniqueBrands fetched from DB --}}
                            <option value="{{ Str::slug($brandName) }}" {{ request('brand') == Str::slug($brandName) ? 'selected' : '' }}>
                                {{ $brandName }}
                            </option>
                        @endforeach
                    </select>
                    <i
                        class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>

                <div class="relative w-full">
                    <select name="price_range" onchange="document.getElementById('filter-form').submit()"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Harga</option>
                        <option value="0-1000000" {{ request('price_range') == '0-1000000' ? 'selected' : '' }}>Rp 0 - 1 jt
                        </option>
                        <option value="1000001-3000000" {{ request('price_range') == '1000001-3000000' ? 'selected' : '' }}>Rp 1 jt - 3 jt</option>
                        <option value="3000001-7000000" {{ request('price_range') == '3000001-7000000' ? 'selected' : '' }}>Rp 3 jt - 7 jt</option>
                        <option value="7000001-" {{ request('price_range') == '7000001-' ? 'selected' : '' }}> > Rp 7 jt
                        </option>
                    </select>
                    <i
                        class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            </form>
        </div>

        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold">
                    @if (request('category') == 'handphone')
                        Handphone
                    @elseif(request('category') == 'accessory')
                        Aksesoris
                    @else
                        Semua Produk
                    @endif
                </h2>
                <p class="text-sm text-gray-600">Produk kami yang tersedia</p>
            </div>
            @if (request()->hasAny(['category', 'brand', 'price_range', 'search']))
                <a href="{{ route('allproduct') }}" class="text-sm text-blue-600 hover:underline">Reset Filter</a>
            @endif
        </div>

        <div class="relative">
            <button
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white border rounded-full shadow p-2 z-10 hover:bg-gray-100"
                onclick="scrollSlider('product-slider', -1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white border rounded-full shadow p-2 z-10 hover:bg-gray-100"
                onclick="scrollSlider('product-slider', 1)">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div id="product-slider" class="overflow-x-auto scroll-smooth py-4 px-8">
                <div class="flex space-x-4 min-w-max">
                    @forelse($products as $product)
                        <div
                            class="w-72 flex-shrink-0 bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
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
                                <h3 class="font-semibold text-base flex-grow mb-2">
                                    <a href="{{ route('product.show', $product) }}"
                                        class="hover:text-blue-600 line-clamp-2"
                                        title="{{ $product->name }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-blue-600 font-bold text-lg">
                                    {{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}
                                </p>
                                @if ($product->original_price && $product->original_price > $product->price)
                                    <p class="text-gray-500 line-through text-sm">
                                        {{ $product->formatted_original_price ?? 'Rp ' . number_format($product->original_price, 0, ',', '.') }}
                                    </p>
                                @endif
                                <div class="flex mt-4 space-x-2">
                                    @if ($product->stock > 0)
                                        @auth('web')
                                            {{-- Hanya tampilkan tombol Beli --}}
                                            @if (!empty($product->valid_colors) && count($product->valid_colors) > 0)
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm w-full text-center no-underline hover:bg-blue-600 transition duration-200">
                                                    <i class="fas fa-shopping-bag"></i> Beli
                                                </a>
                                            @else
                                                <form action="{{ route('buy.now', $product->id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                        class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm w-full text-center no-underline hover:bg-blue-600 transition duration-200">
                                                        <i class="fas fa-shopping-bag"></i> Beli
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}"
                                               class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm w-full text-center no-underline hover:bg-blue-600 transition duration-200">
                                                <i class="fas fa-shopping-bag mr-1"></i> Beli
                                            </a>
                                        @endauth
                                    @else
                                        <button type="button"
                                                class="out-of-stock-btn text-center text-sm text-red-600 bg-red-100 border border-red-300 rounded-lg py-2 px-4 w-full hover:bg-red-200 transition duration-200">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center w-full py-8">
                            <p class="text-gray-500">Tidak ada produk yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('styles')
    <style>
        #product-slider::-webkit-scrollbar {
            height: 8px;
        }
        #product-slider::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }
        #product-slider::-webkit-scrollbar-thumb {
            background-color: #3b82f6;
            border-radius: 10px;
            border: 2px solid #f0f0f0;
        }
        #product-slider::-webkit-scrollbar-thumb:hover {
            background-color: #2563eb;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function scrollSlider(id, direction) {
            const slider = document.getElementById(id);
            const scrollAmount = 300; // Adjust scroll distance as needed

            slider.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const hasColorAttribute = this.dataset.hasColor;

                    if (hasColorAttribute === '1') {
                        // If the product has color options, redirect to detail page
                        e.preventDefault();
                        const detailUrl = this.closest('.w-72').querySelector('a[href*="/products/"]').href;

                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Warna',
                            text: 'Produk ini memiliki pilihan warna. Silakan pilih warna di halaman detail produk.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3500
                        });
                        setTimeout(() => { window.location.href = detailUrl; }, 1500); // Redirect after a short delay
                        return; // Stop further execution
                    }

                    // If no color options or already handled, proceed with AJAX add to cart
                    e.preventDefault();

                    const button = this.querySelector('.add-to-cart-btn');
                    const formData = new FormData(this);
                    const originalButtonText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menambah...';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token not found!');
                        button.disabled = false;
                        button.innerHTML = originalButtonText;
                        alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                        return;
                    }

                    fetch(this.action, {
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
                            return response.json().then(err => { throw err; }).catch(() => {
                                throw new Error('Invalid JSON response from server or network error.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Produk berhasil ditambahkan ke keranjang.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            const cartCountElement = document.getElementById('cart-count');
                            if (cartCountElement && data.cartCount !== undefined) {
                                cartCountElement.textContent = data.cartCount;
                                cartCountElement.classList.toggle('hidden', data.cartCount <= 0);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Tidak dapat menambahkan produk.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                    .catch(error => {
                        if (error.message !== 'Unauthorized') {
                            console.error('Add to Cart Error:', error);
                            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                            if (error.message && error.errors) { // Check for Laravel validation errors
                                for (const key in error.errors) {
                                    if (error.errors.hasOwnProperty(key)) {
                                        errorMessage = error.errors[key][0]; // Take the first error message
                                        break;
                                    }
                                }
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: errorMessage,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                    .finally(() => {
                        button.disabled = false;
                        button.innerHTML = originalButtonText;
                    });
                });
            });

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
        });
    </script>
@endsection
