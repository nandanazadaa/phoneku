@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Semua Produk - PhoneKu') {{-- Judul halaman dinamis --}}

@section('content')

    <div class="container mx-auto px-4 pt-12 pb-8">
        {{-- Search Bar --}}
        <div class="relative w-full mb-6">
            <form action="{{ route('allproduct') }}" method="GET">
                <div class="flex items-center bg-blue-500 rounded-full overflow-hidden shadow">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none border-none focus:ring-0"
                        placeholder="Cari produk...">
                    {{-- Sertakan parameter filter lain jika ada --}}
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

        {{-- Filters (Contoh) --}}
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
                        {{-- Tambah kategori lain dari database jika perlu --}}
                    </select>
                    <i
                        class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>

                <div class="relative w-full">
                    {{-- Anda bisa mengambil daftar brand unik dari produk yang ada --}}
                    @php
                        // Daftar brand HP populer (statis, bisa diganti sesuai kebutuhan)
                        $brands = [
                            'Samsung', 'Xiaomi', 'Oppo', 'Apple', 'Realme', 'Vivo', 'Asus', 'Infinix', 'Nokia', 'Huawei', 'Sony', 'Lenovo', 'Advan', 'Evercoss', 'OnePlus', 'Google', 'Motorola', 'Meizu', 'Honor', 'Sharp', 'Polytron'
                        ];
                    @endphp
                    <select name="brand" onchange="document.getElementById('filter-form').submit()"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ Str::slug($brand) }}" {{ request('brand') == Str::slug($brand) ? 'selected' : '' }}>{{ $brand }}</option>
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
                        <option value="1000001-3000000"
                            {{ request('price_range') == '1000001-3000000' ? 'selected' : '' }}>Rp 1 jt - 3 jt</option>
                        <option value="3000001-7000000"
                            {{ request('price_range') == '3000001-7000000' ? 'selected' : '' }}>Rp 3 jt - 7 jt</option>
                        <option value="7000001-" {{ request('price_range') == '7000001-' ? 'selected' : '' }}> > Rp 7 jt
                        </option>
                    </select>
                    <i
                        class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            </form>
        </div>

    </div>

    <div class="container mx-auto px-4 pt-4 pb-8">
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
                <p class="text-sm text-gray-600">Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari
                    {{ $products->total() }} produk</p>
            </div>
            {{-- Tombol Reset Filter --}}
            @if (request()->hasAny(['category', 'brand', 'price_range', 'search']))
                <a href="{{ route('allproduct') }}" class="text-sm text-blue-600 hover:underline">Reset Filter</a>
            @endif
        </div>

        <div class="relative">
            <div id="product-grid" class="px-6 py-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @forelse($products as $product)
                        <div
                            class="w-72 bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                            {{-- Link ke halaman detail produk --}}
                            <a href="{{ route('product.show', $product) }}"
                                class="product-image-container bg-gray-100 w-full h-56 flex items-center justify-center flex-shrink-0 p-4 relative group">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="product-image max-h-full object-contain transition duration-500 ease-in-out transform group-hover:scale-105">
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
                            </a>

                            <div class="p-4 text-gray-800 flex flex-col flex-grow">
                                <h3 class="font-semibold text-base flex-grow mb-2">
                                    <a href="{{ route('product.show', $product) }}"
                                        class="hover:text-blue-600 line-clamp-2"
                                        title="{{ $product->name }}">{{ $product->name }}</a>
                                </h3>

                                <div class="mt-auto">
                                    <p class="text-xl font-bold text-blue-600 mt-1">
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
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                        class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200">
                                                        <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                                    </button>
                                                </form>
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200">
                                                    <i class="fas fa-eye mr-1"></i> Detail
                                                </a>
                                            @else
                                                <a href="{{ route('login', ['redirect' => route('allproduct', request()->query())]) }}"
                                                    class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-200 transition duration-200">
                                                    <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                                </a>
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200">
                                                    <i class="fas fa-eye mr-1"></i> Detail
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
                        </div>
                    @empty
                    <div class="col-span-full flex items-center justify-center min-h-[60vh] px-4">
                        <div class="text-center max-w-md mx-auto">
                            <div class="mb-6">
                                <i class="fas fa-box-open text-8xl text-gray-300 mb-4"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">
                                Oops! Produk tidak ditemukan
                            </h3>
                            @if (request()->hasAny(['category', 'brand', 'price_range', 'search']))
                                <p class="text-gray-500 text-base mb-4 leading-relaxed">
                                    Coba ubah filter atau kata kunci pencarian Anda untuk menemukan produk yang sesuai.
                                </p>
                                <a href="{{ route('allproduct') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-sm shadow-sm">
                                    <i class="fas fa-sync-alt mr-2"></i> 
                                    Reset Semua Filter
                                </a>
                            @else
                                <p class="text-gray-500 text-base mb-4 leading-relaxed">
                                    Saat ini belum ada produk yang tersedia. Silakan coba lagi nanti.
                                </p>
                                <a href="{{ route('home') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-sm shadow-sm">
                                    <i class="fas fa-home mr-2"></i> 
                                    Kembali ke Beranda
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
        @if ($products->hasPages())
            <div class="flex justify-center mt-10">
                <nav role="navigation" aria-label="Pagination Navigation"
                    class="inline-flex rounded-md shadow-sm overflow-hidden border border-gray-200">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"
                            class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">←</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->links()->elements[0] as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="px-4 py-2 text-sm bg-blue-500 text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"
                            class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">→</a>
                    @else
                        <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">→</span>
                    @endif
                </nav>
            </div>
        @endif

    </div>

@endsection

@section('scripts')
    {{-- Tambahkan script JS jika perlu, misal untuk AJAX add to cart --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Contoh: SweetAlert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX Add to Cart
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah form redirect
                    
                    const button = this.querySelector('.add-to-cart-btn');
                    const formData = new FormData(this);
                    const originalButtonText = button.innerHTML; // Simpan teks tombol asli
                    button.disabled = true; // Disable tombol
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menambah...'; // Loading state

                    // Dapatkan CSRF token dari meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token not found!');
                        button.disabled = false;
                        button.innerHTML = originalButtonText;
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
                        if (response.status === 401) { // Unauthorized
                            window.location.href = "{{ route('login', ['redirect' => url()->full()]) }}";
                            throw new Error('Unauthorized');
                        }
                        return response.json().catch(() => {
                            throw new Error('Invalid JSON response from server.');
                        });
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
                            // Update cart count (sesuaikan selector jika perlu)
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                    .finally(() => {
                        // Kembalikan state tombol setelah selesai
                        button.disabled = false;
                        button.innerHTML = originalButtonText;
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
        });

        function scrollSlider(id, direction) {
            const slider = document.getElementById(id);
            if (slider) {
                const scrollAmount = 300 * direction;
                slider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>
@endsection

@section('styles')
    {{-- Tambahkan style khusus jika perlu --}}
    <style>
        /* Anda bisa menambahkan style khusus di sini jika diperlukan */
    </style>
@endsection