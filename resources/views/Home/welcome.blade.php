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
            <path fill="#ffffff" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,149.3C1120,160,1280,128,1360,112L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
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
                <div class="flex items-center bg-blue-500 rounded-full overflow-hidden">
                    <input type="text" class="w-full bg-blue-500 text-white placeholder-white/80 py-3 px-6 outline-none" placeholder="Cari barang yang anda inginkan....">
                    <button class="bg-blue-500 text-white p-3">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
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
        
        <!-- View All Button -->
        <div class="flex justify-center mt-8">
            <button class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-12 rounded-md">
                Lihat Semua Produk
            </button>
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
        
        <!-- View All Button -->
        <div class="flex justify-center mt-8">
            <button class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-12 rounded-md">
                Lihat Semua Produk
            </button>
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