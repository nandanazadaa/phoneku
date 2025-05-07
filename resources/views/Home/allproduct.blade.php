@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Semua Produk - PhoneKu') {{-- Judul halaman dinamis --}}

@section('content')

    <div class="container mx-auto px-4 pt-12 pb-8">
        {{-- Search Bar --}}
        <div class="relative w-full mb-6">
            <form action="{{ route('allproduct') }}" method="GET">
                <div class="flex items-center bg-blue-500 rounded-full overflow-hidden shadow">
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none border-none focus:ring-0" placeholder="Cari produk...">
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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 px-5 rounded-r-full transition duration-200">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Filters (Contoh) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
             <form id="filter-form" action="{{ route('allproduct') }}" method="GET" class="contents">
                 <input type="hidden" name="search" value="{{ request('search') }}"> {{-- Pertahankan search query --}}

                <!-- Dropdown Kategori -->
                <div class="relative w-full">
                    <select name="category" onchange="document.getElementById('filter-form').submit()" class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Kategori</option>
                        <option value="handphone" {{ request('category') == 'handphone' ? 'selected' : '' }}>Handphone</option>
                        <option value="accessory" {{ request('category') == 'accessory' ? 'selected' : '' }}>Aksesoris</option>
                        {{-- Tambah kategori lain dari database jika perlu --}}
                    </select>
                    <i class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>

                <!-- Dropdown Brand (Contoh - Idealnya diambil dari DB) -->
                <div class="relative w-full">
                    {{-- Anda bisa mengambil daftar brand unik dari produk yang ada --}}
                    @php
                        // $brands = App\Models\Product::distinct()->pluck('brand')->filter()->sort(); // Contoh ambil brand dari DB
                        $brands = ['Samsung', 'Xiaomi', 'Oppo', 'Apple', 'Realme', 'Vivo']; // Contoh statis
                    @endphp
                    <select name="brand" onchange="document.getElementById('filter-form').submit()" class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $brand)
                         <option value="{{ Str::slug($brand) }}" {{ request('brand') == Str::slug($brand) ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>


                <!-- Dropdown Rentang Harga (Contoh) -->
                <div class="relative w-full">
                    <select name="price_range" onchange="document.getElementById('filter-form').submit()" class="appearance-none bg-white border border-gray-300 text-gray-700 p-2 pl-4 pr-10 rounded-full w-full text-center cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Harga</option>
                        <option value="0-1000000" {{ request('price_range') == '0-1000000' ? 'selected' : '' }}>Rp 0 - 1 jt</option>
                        <option value="1000001-3000000" {{ request('price_range') == '1000001-3000000' ? 'selected' : '' }}>Rp 1 jt - 3 jt</option>
                        <option value="3000001-7000000" {{ request('price_range') == '3000001-7000000' ? 'selected' : '' }}>Rp 3 jt - 7 jt</option>
                        <option value="7000001-" {{ request('price_range') == '7000001-' ? 'selected' : '' }}> > Rp 7 jt</option>
                    </select>
                     <i class="fas fa-chevron-down text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
             </form>
        </div>

    </div>

    <!-- Product Section -->
    <div class="container mx-auto px-4 pt-4 pb-8">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold">
                     @if(request('category') == 'handphone')
                        Handphone
                     @elseif(request('category') == 'accessory')
                        Aksesoris
                     @else
                        Semua Produk
                     @endif
                 </h2>
                 <p class="text-sm text-gray-600">Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari {{ $products->total() }} produk</p>
            </div>
             {{-- Tombol Reset Filter --}}
             @if(request()->hasAny(['category', 'brand', 'price_range', 'search']))
                <a href="{{ route('allproduct') }}" class="text-sm text-blue-600 hover:underline">Reset Filter</a>
             @endif
        </div>

        <!-- Products Grid (DINAMIS) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <!-- Product Card -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                    {{-- Link ke halaman detail produk --}}
                    <a href="{{ route('product.show', $product) }}" class="block product-image-container bg-gray-100 w-full h-56 flex items-center justify-center flex-shrink-0 p-4 relative group">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image max-h-full object-contain transition duration-500 ease-in-out transform group-hover:scale-105">
                        @else
                            {{-- Placeholder jika tidak ada gambar --}}
                            <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                <i class="fa fa-image text-5xl"></i>
                            </div>
                        @endif
                         {{-- Discount Badge (Example) --}}
                         @if ($product->original_price && $product->original_price > $product->price)
                             @php
                                $discountPercentage = round((($product->original_price - $product->price) / $product->original_price) * 100);
                             @endphp
                             <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                 {{ $discountPercentage }}% OFF
                             </span>
                         @endif
                    </a>
                    <div class="p-4 text-gray-800 flex flex-col flex-grow">
                        {{-- Nama Produk (link ke detail) --}}
                        <h3 class="font-semibold text-base flex-grow mb-2">
                            <a href="{{ route('product.show', $product) }}" class="hover:text-blue-600 line-clamp-2" title="{{ $product->name }}">{{ $product->name }}</a>
                        </h3>

                        {{-- Harga --}}
                        <div class="mt-auto"> {{-- Push price and buttons to bottom --}}
                            <p class="text-xl font-bold text-blue-600 mt-1">{{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                            {{-- Harga Asli (jika ada diskon) --}}
                            @if ($product->original_price && $product->original_price > $product->price)
                                <p class="text-gray-500 line-through text-sm">{{ $product->formatted_original_price ?? 'Rp ' . number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif

                            {{-- Tombol Aksi --}}
                            <div class="flex mt-4 space-x-2">
                                 {{-- Cek stok --}}
                                 @if($product->stock > 0)
                                    @auth('web') {{-- Pastikan cek guard web --}}
                                        {{-- Tombol Tambah ke Keranjang (jika login) --}}
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" data-cart-action="add" data-product-id="{{ $product->id }}"
                                                class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200">
                                                <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                            </button>
                                        </form>
                                        {{-- Tombol Beli (link ke detail) --}}
                                        <a href="{{ route('product.show', $product) }}" title="Lihat Detail"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    @else
                                        {{-- Tombol jika belum login (mengarahkan ke login) --}}
                                        <a href="{{ route('login', ['redirect' => route('allproduct', request()->query())]) }}" title="Login untuk tambah ke keranjang"
                                            class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-200 transition duration-200">
                                             <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                        </a>
                                        <a href="{{ route('product.show', $product) }}" title="Lihat Detail"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    @endauth
                                 @else
                                    <span class="text-center text-sm text-red-600 bg-red-100 border border-red-300 rounded-lg py-2 px-4 w-full">Stok Habis</span>
                                 @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Pesan jika tidak ada produk --}}
                <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-16 bg-gray-50 rounded-lg">
                     <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 text-xl font-semibold">Oops! Produk tidak ditemukan.</p>
                    @if(request()->hasAny(['category', 'brand', 'price_range', 'search']))
                        <p class="text-gray-500 mt-2">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('allproduct') }}" class="mt-4 inline-block text-blue-600 hover:underline font-medium">
                           <i class="fas fa-sync-alt mr-1"></i> Reset Filter
                        </a>
                    @else
                         <p class="text-gray-500 mt-2">Saat ini belum ada produk yang tersedia.</p>
                    @endif
                </div>
            @endforelse
        </div>
        <!-- AKHIR Products Grid -->

        <!-- Pagination Links -->
        <div class="mt-12">
            {{-- Render pagination links, mempertahankan query string --}}
            {{ $products->appends(request()->query())->onEachSide(1)->links() }}
        </div>

    </div>

@endsection

@section('styles')
{{-- Tambahkan style khusus jika perlu --}}
<style>
    .product-image-container {
        height: 224px; /* Sesuaikan tinggi gambar */
    }
    .product-image {
        max-width: 90%;
        max-height: 100%;
        object-fit: contain;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        height: 2.5em; /* Sesuaikan based on line-height */
        line-height: 1.25em;
    }
    /* Style untuk pagination (Tailwind default) */
    .pagination { } /* Container */
    .pagination > nav { display: flex; justify-content: space-between; align-items: center; }
    .pagination span[aria-current="page"] span { background-color: #3b82f6; color: white; border-color: #3b82f6;}
    .pagination a:hover { background-color: #ebf8ff; } /* light blue */
    .pagination span[aria-disabled="true"] span { color: #a0aec0; cursor: not-allowed;}
    .pagination a, .pagination span { /* Styling for links and spans */ }
</style>
@endsection

@section('scripts')
{{-- Tambahkan script JS jika perlu, misal untuk AJAX add to cart --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Contoh: SweetAlert --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: AJAX Add to Cart
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('form');
            if (form) {
                e.preventDefault();
                const formData = new FormData(form);
                const originalButtonText = this.innerHTML; // Simpan teks tombol asli
                this.disabled = true; // Disable tombol
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menambah...'; // Loading state

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                     if (response.status === 401) { // Unauthorized
                         window.location.href = "{{ route('login', ['redirect' => url()->full()]) }}";
                         throw new Error('Unauthorized');
                     }
                     if (!response.ok && response.status !== 400 && response.status !== 401) { // Handle non-validation errors
                         throw new Error('Network response was not ok: ' + response.statusText);
                     }
                    return response.json().catch(() => {
                        // Handle cases where response might not be JSON (e.g., server error pages)
                        throw new Error('Invalid JSON response from server.');
                    });
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success', title: 'Berhasil!', text: data.message || 'Produk ditambahkan.',
                            toast: true, position: 'top-end', showConfirmButton: false, timer: 2000
                        });
                        // Update cart count (sesuaikan selector)
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement && data.cartCount !== undefined) {
                            cartCountElement.textContent = data.cartCount;
                            // Jika count 0, sembunyikan? Jika > 0, tampilkan.
                            cartCountElement.classList.toggle('hidden', data.cartCount <= 0);
                        }
                    } else {
                         Swal.fire({
                            icon: 'error', title: 'Gagal', text: data.message || 'Tidak dapat menambahkan produk.',
                            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
                        });
                    }
                })
                .catch(error => {
                    if (error.message !== 'Unauthorized') {
                        console.error('Add to Cart Error:', error);
                         Swal.fire({
                            icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan. Silakan coba lagi.',
                            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
                        });
                    }
                })
                .finally(() => {
                    // Kembalikan state tombol setelah selesai
                    this.disabled = false;
                    this.innerHTML = originalButtonText;
                });
            }
        });
    });
});
</script>
@endsection