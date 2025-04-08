<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Marketplace Handphone & Aksesoris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .slide-container {
            overflow: hidden;
            width: 100%;
            border-radius: 0.75rem;
            max-height: 500px; 
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .slides {
            position: relative;
            width: 100%;
        }
        .slide {
            display: none;
            width: 100%;
        }
        .slide.active {
            display: block;
            animation: slideIn 0.8s ease-in-out;
        }
        @keyframes slideIn {
            from { 
                opacity: 0.7; 
                transform: translateX(30px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        .slider-dot {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .slider-dot:hover {
            transform: scale(1.1);
        }
        .wave-container {
            margin-top: 1rem; /* Reduced from 3rem to reduce gap */
            position: relative;
            z-index: 1;
        }
        
        .banner-image {
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: contain; /* Changed from cover to contain */
        }
        
        .banner-container {
            padding-bottom: 2rem; /* Added padding at bottom */
        }
        
        .wave-svg {
            display: block;
            width: 100%;
            height: auto;
            margin-top: -1px; /* Ensure no gaps between wave and content */
        }
    </style>
</head>
<body class="font-sans bg-white">
    <!-- Header Section with Wave -->
    <div class="relative">
        <!-- Blue Background with Wave -->
        <div class="bg-blue-500 pb-72"> <!-- Increased padding from pb-48 to pb-72 -->
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end">
                <div class="text-white flex space-x-4">
                    <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
                    <span class="text-white">|</span>
                    <a href="{{ route('registrasi') }}" class="hover:underline">Daftar</a>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-8">
                        <a href="#" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Beranda</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tim</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Belanja</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Kontak</a>
                    </div>
                    
                    <!-- Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-blue-500">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-500">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Hero Banner -->
            <div class="container mx-auto px-4 mt-8 banner-container">
                <div class="bg-white rounded-xl overflow-hidden relative z-10 pb-4" id="banner-slider">
                    <div class="slide-container relative">
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
                    <div class="flex justify-center space-x-2 py-4 relative z-10">
                        <button class="w-4 h-4 rounded-full bg-blue-500 slider-dot active" data-slide="0"></button>
                        <button class="w-4 h-4 rounded-full bg-gray-300 slider-dot" data-slide="1"></button>
                        <button class="w-4 h-4 rounded-full bg-gray-300 slider-dot" data-slide="2"></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 z-0 wave-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave-svg">
                <path fill="#ffffff" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,149.3C1120,160,1280,128,1360,112L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                <path fill="#f3f4f6" fill-opacity="0.5" d="M0,192L80,165.3C160,139,320,85,480,90.7C640,96,800,160,960,170.7C1120,181,1280,139,1360,117.3L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
    </div>
        
        <div class="absolute bottom-0 left-0 right-0 z-0 wave-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#ffffff" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,149.3C1120,160,1280,128,1360,112L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                <path fill="#f3f4f6" fill-opacity="0.5" d="M0,192L80,165.3C160,139,320,85,480,90.7C640,96,800,160,960,170.7C1120,181,1280,139,1360,117.3L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
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
    
    <!-- Newsletter Section -->
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-xl mx-4 my-12">
        <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-between">
            <div class="text-white mb-6 md:mb-0">
                <h2 class="text-2xl font-bold uppercase">Tetap Update</h2>
                <h2 class="text-2xl font-bold uppercase">Dengan Penawaran Kami</h2>
            </div>
            
            <div class="w-full md:w-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    <input type="email" placeholder="Masukkan Email Anda" class="px-4 py-3 rounded-full focus:outline-none">
                    <button class="bg-white text-gray-800 font-medium px-6 py-3 rounded-full hover:bg-gray-100">
                        Mulai Berlangganan Buletin
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white pt-10 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                    </div>
                    <p class="text-gray-600 mb-4">
                        We have clothes that suits your style and which you're proud to wear. From women to men.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-500">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Company Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 uppercase">Perusahaan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Fitur</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Tim Kami</a></li>
                    </ul>
                </div>
                
                <!-- Product Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 uppercase">Produk & Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Customer Support</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Delivery Details</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <!-- Payment Methods -->
                <div>
                    <h3 class="text-lg font-bold mb-4 uppercase">Pembayaran</h3>
                    <div class="flex flex-wrap gap-2">
                        <img src="/api/placeholder/60/40" alt="Dana" class="h-8">
                        <img src="/api/placeholder/60/40" alt="OVO" class="h-8">
                        <img src="/api/placeholder/60/40" alt="GoPay" class="h-8">
                        <img src="/api/placeholder/60/40" alt="BRI" class="h-8">
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-10 pt-6">
                <p class="text-gray-500 text-sm text-center">
                    Phone.Ku © 2025-Present All Rights Reserved
                </p>
            </div>
        </div>
    </footer>


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
</body>
</html>

