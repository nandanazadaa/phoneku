<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Marketplace Handphone & Aksesoris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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

</body>
</html>