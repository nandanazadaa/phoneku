@extends('layouts.app')

@section('title', 'Belanja - PhoneKu Semua Produk')

@section('content')
    <div class="container mx-auto px-4 pt-12 pb-8">
        <div class="relative w-full">
            <div class="flex items-center bg-blue-500 rounded-full overflow-hidden">
                <input type="text" class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none" placeholder="Cari barang yang anda inginkan....">
                <button class="bg-blue-500 text-white p-3">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-2">
            <button class="relative bg-blue-500 text-white p-2 rounded-full w-full text-center">
                <span class="block text-center w-full">Brand</span>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2"></i>
            </button>
            <button class="relative bg-blue-500 text-white p-2 rounded-full w-full text-center">
                <span class="block text-center w-full">Rentang harga</span>
                <i class="fas fa-filter text-xl absolute right-4 top-1/2 -translate-y-1/2"></i>
            </button>
        </div>
    </div>

    <!-- Handphone Section -->
    <div class="container mx-auto px-4 pt-4 pb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-sm text-gray-600">Produk kami</p>
                <h2 class="text-2xl font-bold">All Product</h2>
            </div>
            

        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Product Card 1 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 2 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 3 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 4 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Second Row (hidden on small screens) -->
            <!-- Product Card 5 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 6 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 7 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Card 8 -->
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                <img src="img/iphone11.png" alt="iPhone 11" class="w-full h-64 object-contain">
                <div class="p-4 text-white">
                    <h3 class="font-medium">iPhone 11 256GB</h3>
                    <p class="text-2xl font-bold mt-1">Rp 7,500,000</p>
                    <p class="text-white/70 line-through">Rp 9,500,000</p>
                    <div class="flex mt-4 space-x-2">
                        <button class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center">+Keranjang</button>
                        <a href="{{ route('product') }}" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
        </div>
        
@endsection


@section('styles')
<style>
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
    width: 100vw; /* Gunakan viewport width agar merentang penuh */
    min-width: 100%; /* Pastikan minimal selebar container */
    height: 100%;
    transform: translateY(1px);
}
    
    .banner-image {
        width: 100%;
        object-fit: cover;
        max-height: 400px; /* Sesuaikan dengan tinggi banner yang diinginkan */
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

        // Initialize slider
        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => {
                slide.style.display = 'none';
                slide.classList.remove('active');
            });
            // Remove active class from all dots
            dots.forEach(dot => {
                dot.classList.remove('active');
                dot.classList.remove('bg-blue-500');
                dot.classList.add('bg-gray-300');
            });
            
            // Show the current slide
            slides[index].style.display = 'block';
            slides[index].classList.add('active');
            
            // Add active class to current dot
            dots[index].classList.add('active');
            dots[index].classList.remove('bg-gray-300');
            dots[index].classList.add('bg-blue-500');
            
            // Update current slide index
            currentSlide = index;
        }

        // Auto slide function
        function startSlideShow() {
            slideInterval = setInterval(function() {
                let nextSlide = (currentSlide + 1) % slides.length;
                showSlide(nextSlide);
            }, 5000); // Change slide every 5 seconds
        }

        // Add click event to dots
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                let slideIndex = parseInt(this.getAttribute('data-slide'));
                showSlide(slideIndex);
                
                // Reset the interval when manually changing slides
                clearInterval(slideInterval);
                startSlideShow();
            });
        });

        // Initialize the first slide
        showSlide(0);
        
        // Start the slideshow
        startSlideShow();
    });
</script>
@endsection

