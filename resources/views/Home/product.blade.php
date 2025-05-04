@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', $product->name . ' - PhoneKu') {{-- Judul halaman dinamis --}}

@section('content')

    <!-- Product Detail Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
            <!-- Product Image Section -->
            <div class="flex flex-col">
                <!-- Main Image Container -->
                <div class="bg-gray-100 rounded-xl p-4 md:p-8 flex items-center justify-center mb-4 relative shadow-sm aspect-square overflow-hidden">
                    @php
                        // Filter gambar yang valid (tidak null atau string kosong)
                        $images = collect([$product->image, $product->image2, $product->image3])->filter()->values();
                        $hasMultipleImages = $images->count() > 1;
                    @endphp

                    @forelse($images as $index => $imagePath)
                        <img src="{{ asset('storage/' . $imagePath) }}"
                             alt="{{ $product->name }} - Foto {{ $index + 1 }}"
                             data-index="{{ $index }}"
                             class="product-image {{ $index == 0 ? 'active' : '' }} absolute inset-0 w-full h-full object-contain transition-opacity duration-300 ease-in-out p-2"
                             style="opacity: {{ $index == 0 ? 1 : 0 }};"> {{-- Use opacity for smoother transition --}}
                    @empty
                         {{-- Placeholder jika tidak ada gambar sama sekali --}}
                         <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                             <i class="fa fa-camera text-6xl"></i>
                         </div>
                    @endforelse

                    <!-- Navigation Arrows -->
                    @if($hasMultipleImages)
                    <button class="slider-arrow left absolute top-1/2 left-2 md:left-4 transform -translate-y-1/2 z-10">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-arrow right absolute top-1/2 right-2 md:right-4 transform -translate-y-1/2 z-10">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    @endif
                </div>

                <!-- Image Navigation Dots -->
                @if($hasMultipleImages)
                <div class="flex justify-center space-x-2 mt-2">
                     @foreach($images as $index => $imagePath)
                        <button class="dot {{ $index == 0 ? 'active bg-blue-500 w-6' : 'bg-gray-300 w-2' }} h-2 rounded-full transition-all duration-300 ease-in-out" data-index="{{ $index }}"></button>
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
                        <p class="text-3xl font-bold text-blue-600">{{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <p class="text-gray-400 line-through text-xl">{{ $product->formatted_original_price ?? 'Rp ' . number_format($product->original_price, 0, ',', '.') }}</p>
                             @php $discountPercentage = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                             <span class="text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded">
                                 DISKON {{ $discountPercentage }}%
                             </span>
                        @endif
                    </div>
                </div>

                 <!-- Quantity & Stock -->
                 <div class="mb-6">
                     {{-- Form untuk Add to Cart & Beli Langsung --}}
                     <form id="product-action-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-between">
                            <div class="flex-shrink-0">
                                <h3 class="text-xs text-gray-500 font-semibold mb-1 uppercase">KUANTITAS</h3>
                                <div class="flex items-center border rounded-full quantity-counter bg-white">
                                    <button type="button" class="px-4 py-2 text-gray-600 quantity-btn minus-btn rounded-l-full hover:bg-gray-100 transition duration-150" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                           class="w-12 text-center border-y-0 border-x quantity-input appearance-none focus:outline-none focus:ring-0 font-medium"
                                           {{ $product->stock <= 0 ? 'readonly' : '' }}>
                                    <button type="button" class="px-4 py-2 text-gray-600 quantity-btn plus-btn rounded-r-full hover:bg-gray-100 transition duration-150" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                 <h3 class="text-xs text-gray-500 font-semibold mb-1 uppercase">STOK</h3>
                                 <p class="text-sm {{ $product->stock > 5 ? 'text-green-600' : ($product->stock > 0 ? 'text-orange-600' : 'text-red-600') }} font-bold">
                                    {{ $product->stock > 0 ? $product->stock . ' Tersedia' : 'Habis' }}
                                </p>
                            </div>
                        </div>
                     </form>
                 </div>


                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        {{-- Total Harga (Update by JS) --}}
                        <div>
                            <p class="text-sm text-gray-600 font-medium">TOTAL HARGA</p>
                            <p class="text-2xl font-bold text-blue-600" id="total-price-display">
                                {{ $product->stock > 0 ? ($product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.')) : 'Rp 0' }}
                            </p>
                        </div>

                        {{-- Tombol Beli & Keranjang --}}
                        <div class="flex space-x-3">
                             @if($product->stock > 0)
                                @auth('web')
                                    {{-- Tombol Add to Cart --}}
                                    <button type="submit" form="product-action-form" formaction="{{ route('cart.add', $product->id) }}"
                                        class="add-to-cart-btn border border-blue-500 bg-white text-blue-500 py-3 px-5 rounded-lg flex items-center justify-center font-semibold hover:bg-blue-50 transition duration-200" title="Tambah ke Keranjang">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>

                                    {{-- Tombol Beli Sekarang --}}
                                    <button type="submit" form="product-action-form" formaction="{{ route('cart.add', $product->id) }}" data-redirect-checkout="true"
                                        class="buy-now-btn bg-blue-500 text-white py-3 px-8 rounded-lg font-semibold flex-grow hover:bg-blue-600 transition duration-200">
                                        Beli Sekarang
                                    </button>
                                @else
                                    {{-- Tombol jika belum login --}}
                                    <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}" title="Login untuk tambah ke keranjang"
                                        class="border border-blue-500 bg-white text-blue-500 py-3 px-5 rounded-lg flex items-center justify-center font-semibold hover:bg-blue-50 transition duration-200">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                    <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}" title="Login untuk Beli"
                                        class="bg-blue-500 text-white py-3 px-8 rounded-lg font-semibold flex-grow hover:bg-blue-600 transition duration-200">
                                        Beli Sekarang
                                    </a>
                                @endauth
                             @else
                                <span class="text-red-600 font-semibold py-3 px-6 border border-red-300 rounded-lg bg-red-50 w-full text-center">Stok Habis</span>
                             @endif
                        </div>
                    </div>
                </div>

                <!-- Details/Description -->
                <div class="mt-10">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 border-b pb-2">Deskripsi Produk</h3>
                    <div class="text-gray-700 prose prose-sm max-w-none leading-relaxed"> {{-- `prose` dari tailwind typography --}}
                        {!! nl2br(e($product->description ?? 'Tidak ada deskripsi untuk produk ini.')) !!}
                    </div>
                </div>

            </div> <!-- End Product Info Section -->
        </div> <!-- End Grid -->

        {{-- Bagian Testimoni (Contoh Statis - Anda bisa buat dinamis nanti) --}}
        {{-- <div class="container mx-auto px-4 py-12 mt-10"> ... kode testimoni ... </div> --}}
        {{-- Akhir Bagian Testimoni --}}


        {{-- Related Products Section --}}
        @if($relatedProducts && $relatedProducts->isNotEmpty())
        <div class="container mx-auto px-4 py-12 mt-16 border-t border-gray-200">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Produk Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col shadow-sm transition duration-300 ease-in-out hover:shadow-lg">
                    <a href="{{ route('product.show', $related) }}" class="block product-image-container bg-gray-100 w-full h-56 flex items-center justify-center flex-shrink-0 p-4 relative group">
                        @if ($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="product-image max-h-full object-contain transition duration-500 ease-in-out transform group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400"><i class="fa fa-image text-5xl"></i></div>
                        @endif
                         {{-- Discount Badge --}}
                         @if ($related->original_price && $related->original_price > $related->price)
                             @php $discountPercentage = round((($related->original_price - $related->price) / $related->original_price) * 100); @endphp
                             <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">{{ $discountPercentage }}% OFF</span>
                         @endif
                    </a>
                    <div class="p-4 text-gray-800 flex flex-col flex-grow">
                        <h3 class="font-semibold text-base flex-grow mb-2">
                            <a href="{{ route('product.show', $related) }}" class="hover:text-blue-600 line-clamp-2" title="{{ $related->name }}">{{ $related->name }}</a>
                        </h3>
                        <div class="mt-auto">
                            <p class="text-xl font-bold text-blue-600 mt-1">{{ $related->formatted_price ?? 'Rp ' . number_format($related->price, 0, ',', '.') }}</p>
                            @if ($related->original_price && $related->original_price > $related->price)
                                <p class="text-gray-500 line-through text-sm">{{ $related->formatted_original_price ?? 'Rp ' . number_format($related->original_price, 0, ',', '.') }}</p>
                            @endif
                            <div class="flex mt-4 space-x-2">
                                @if($related->stock > 0)
                                    @auth('web')
                                        <form action="{{ route('cart.add', $related->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" data-cart-action="add" data-product-id="{{ $related->id }}"
                                                class="add-to-cart-btn bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm w-full text-center hover:bg-blue-200 transition duration-200"><i class="fas fa-cart-plus mr-1"></i> Keranjang</button>
                                        </form>
                                        <a href="{{ route('product.show', $related) }}" title="Lihat Detail"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i class="fas fa-eye mr-1"></i> Detail</a>
                                    @else
                                        <a href="{{ route('login', ['redirect' => route('product.show', $related)]) }}" title="Login untuk tambah"
                                            class="bg-blue-100 text-blue-600 border border-blue-300 rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-200 transition duration-200"><i class="fas fa-cart-plus mr-1"></i> Keranjang</a>
                                        <a href="{{ route('product.show', $related) }}" title="Lihat Detail"
                                            class="bg-blue-500 text-white rounded-lg py-2 px-3 text-sm flex-1 text-center no-underline hover:bg-blue-600 transition duration-200"><i class="fas fa-eye mr-1"></i> Detail</a>
                                    @endauth
                                @else
                                    <span class="text-center text-sm text-red-600 bg-red-100 border border-red-300 rounded-lg py-2 px-4 w-full">Stok Habis</span>
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
    <style>
        /* Image Slider */
        .product-image { position: absolute; top:0; left:0; opacity: 0; pointer-events: none; } /* Absolute positioning */
        .product-image.active { position: relative; opacity: 1; pointer-events: auto; } /* Make active visible */
        .slider-arrow { background-color: rgba(0, 0, 0, 0.3); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.2s ease; }
        .slider-arrow:hover { background-color: rgba(0, 0, 0, 0.5); }
        .dot { cursor: pointer; }

        /* Quantity Counter */
        .quantity-input { text-align: center; border-left: none; border-right: none; }
        .quantity-input[readonly] { background-color: #f9fafb; cursor: not-allowed; }
        .quantity-btn:disabled { color: #9ca3af; cursor: not-allowed; background-color: #f9fafb; }
        .quantity-counter { display: inline-flex; }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
         input[type=number] { -moz-appearance: textfield; /* Firefox */ }

        /* Rating */
        .star-rating .star { color: #facc15; } /* Tailwind yellow-400 */
        .star-rating .star.empty { color: #d1d5db; } /* Tailwind gray-300 */

        /* Detail Tab */
        .tab-button { position: relative; }
        .tab-button::after { content: ""; position: absolute; bottom: -9px; left: 0; width: 100%; height: 2px; background-color: #3b82f6; } /* Tailwind blue-500 */

        /* Testimonial */
        .testimonial-card { transition: all 0.2s ease; }
        .testimonial-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .testimonial-card .star-rating .star { font-size: 14px; }
        .proof-img-container img { border: 1px solid #e5e7eb; }
        .hidden { display: none; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

        /* Tailwind Prose (Ensure @tailwindcss/typography is installed) */
         .prose { color: #374151; /* gray-700 */ }
         .prose p { margin-top: 0.75em; margin-bottom: 0.75em; line-height: 1.65; }
         .prose ul { list-style-type: disc; margin-top: 1em; margin-bottom: 1em; padding-left: 1.5em; }
         .prose li { margin-top: 0.5em; margin-bottom: 0.5em; }

        /* Lightbox style */
        #image-lightbox { background-color: rgba(0, 0, 0, 0.9); }
    </style>
@endsection

@section('scripts')
    {{-- Script JS dari view asli Anda (Lightbox, Testimoni) + perbaikan & tambahan --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Contoh: SweetAlert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
             // --- Image Slider ---
             const images = document.querySelectorAll('.product-image');
             const dots = document.querySelectorAll('.dot');
             const leftArrow = document.querySelector('.slider-arrow.left');
             const rightArrow = document.querySelector('.slider-arrow.right');
             let currentImageIndex = 0;
             const totalImages = images.length;

             function showImage(index) {
                 if (totalImages === 0) return;
                 index = (index + totalImages) % totalImages; // Wrap around index

                 images.forEach((img, i) => {
                     img.classList.toggle('active', i === index);
                     img.style.opacity = (i === index) ? 1 : 0; // Use opacity for transition
                 });
                 dots.forEach((dot, i) => {
                     dot.classList.toggle('active', i === index);
                     dot.classList.toggle('bg-blue-500', i === index);
                     dot.classList.toggle('w-6', i === index); // Wider active dot
                     dot.classList.toggle('bg-gray-300', i !== index);
                     dot.classList.toggle('w-2', i !== index); // Smaller inactive dot
                 });
                 currentImageIndex = index;
             }

             if(leftArrow && rightArrow && totalImages > 1) { // Only add listeners if multiple images
                leftArrow.addEventListener('click', () => showImage(currentImageIndex - 1));
                rightArrow.addEventListener('click', () => showImage(currentImageIndex + 1));
             }

             dots.forEach(dot => {
                 dot.addEventListener('click', () => showImage(parseInt(dot.dataset.index)));
             });

             if(totalImages > 0) showImage(0); // Initialize

             // --- Quantity Counter & Total Price Update ---
            const quantityInputDetail = document.querySelector('.quantity-input');
            const minusBtnDetail = document.querySelector('.minus-btn');
            const plusBtnDetail = document.querySelector('.plus-btn');
            const totalPriceDisplay = document.getElementById('total-price-display');
             // Parse product price safely, default to 0
            const productPrice = parseFloat("{{ is_numeric($product->price) ? $product->price : 0 }}");
            const stock = parseInt("{{ $product->stock }}") || 0;

            function formatRupiah(number) {
                if (isNaN(number)) return 'Rp 0';
                // Use Intl.NumberFormat for better localization
                 return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
            }

            function updateDetailTotalPrice() {
                if (!quantityInputDetail || stock <= 0) {
                    if(totalPriceDisplay) totalPriceDisplay.textContent = formatRupiah(0);
                    return;
                }
                let quantity = parseInt(quantityInputDetail.value);

                if (isNaN(quantity) || quantity < 1) quantity = 1;
                if (quantity > stock) quantity = stock;
                quantityInputDetail.value = quantity; // Correct input value

                const total = productPrice * quantity;
                if(totalPriceDisplay) totalPriceDisplay.textContent = formatRupiah(total);

                // Update button states
                if (minusBtnDetail) minusBtnDetail.disabled = (quantity <= 1);
                if (plusBtnDetail) plusBtnDetail.disabled = (quantity >= stock);
            }

            if (minusBtnDetail) minusBtnDetail.addEventListener('click', () => { if (parseInt(quantityInputDetail.value) > 1) { quantityInputDetail.value--; updateDetailTotalPrice(); } });
            if (plusBtnDetail) plusBtnDetail.addEventListener('click', () => { if (parseInt(quantityInputDetail.value) < stock) { quantityInputDetail.value++; updateDetailTotalPrice(); } });
            if (quantityInputDetail) {
                quantityInputDetail.addEventListener('input', updateDetailTotalPrice);
                quantityInputDetail.addEventListener('change', updateDetailTotalPrice); // Ensure update on blur/manual change
            }
            updateDetailTotalPrice(); // Initial update

             // --- Testimonial "See More" ---
             // (Kode JS Testimoni dari file asli Anda bisa ditaruh di sini)
             const seeMoreBtn = document.getElementById('see-more-btn');
             const testimonialMore = document.querySelector('.testimonial-more');
             if (seeMoreBtn && testimonialMore) {
                 seeMoreBtn.addEventListener('click', () => {
                     testimonialMore.classList.remove('hidden');
                     seeMoreBtn.classList.add('hidden');
                     // Re-init lightbox for new images if needed
                     initLightbox(testimonialMore.querySelectorAll('.proof-image'));
                 });
             }

             // --- Image Lightbox ---
             // (Kode JS Lightbox dari file asli Anda bisa ditaruh di sini)
            const lightbox = document.createElement('div'); // ... (rest of lightbox code) ...
            // Initialize lightbox
            function initLightbox(imageElements) {
                 imageElements.forEach(img => {
                    img.style.cursor = 'pointer'; // Add pointer cursor
                    img.removeEventListener('click', openLightboxHandler); // Remove old listeners
                    img.addEventListener('click', openLightboxHandler);
                 });
            }
             function openLightboxHandler() { openLightbox(this.src); } // Define handler
             initLightbox(document.querySelectorAll('.proof-image')); // Init for all proof images

            // --- AJAX Add to Cart & Buy Now Logic ---
            const productActionForm = document.getElementById('product-action-form');

             function submitProductAction(button, redirectCheckout = false) {
                 if (!productActionForm) return;

                 const formData = new FormData(productActionForm);
                 const actionUrl = button.getAttribute('formaction') || productActionForm.action; // Get action from button or form
                 const originalButtonContent = button.innerHTML;
                 button.disabled = true;
                 button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Loading...';

                 fetch(actionUrl, {
                     method: 'POST',
                     body: formData,
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                         'X-Requested-With': 'XMLHttpRequest',
                         'Accept': 'application/json',
                     }
                 })
                 .then(response => {
                     if (response.status === 401) {
                         window.location.href = "{{ route('login', ['redirect' => url()->current()]) }}";
                         throw new Error('Unauthorized');
                     }
                      if (!response.ok && response.status !== 400) {
                          throw new Error('Network error: ' + response.statusText);
                      }
                     return response.json().catch(() => { throw new Error('Invalid JSON response'); });
                 })
                 .then(data => {
                     if (data.success) {
                          // Update cart count
                          const cartCountElement = document.getElementById('cart-count'); // Adjust selector
                          if (cartCountElement && data.cartCount !== undefined) {
                              cartCountElement.textContent = data.cartCount;
                              cartCountElement.classList.toggle('hidden', data.cartCount <= 0);
                          }

                          if (redirectCheckout) {
                              window.location.href = "{{ route('checkout') }}";
                          } else {
                              Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Ditambahkan ke keranjang.', timer: 1500, showConfirmButton: false });
                          }
                     } else {
                          Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Aksi gagal.' });
                     }
                 })
                 .catch(error => {
                     if (error.message !== 'Unauthorized') {
                         console.error('Action Error:', error);
                         Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan.' });
                     }
                 })
                 .finally(() => {
                     button.disabled = false;
                     button.innerHTML = originalButtonContent;
                 });
             }

             document.querySelectorAll('.add-to-cart-btn').forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); submitProductAction(btn, false); }));
             document.querySelectorAll('.buy-now-btn').forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); submitProductAction(btn, true); }));

        }); // End DOMContentLoaded
    </script>
@endsection