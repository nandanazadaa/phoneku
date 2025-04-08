<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - tentang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .section {
            padding: 60px 0;
        }
        .section img {
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body class="font-sans bg-white">
    <!-- Header -->
    <div class="relative">
        <!-- Blue Background with Wave -->
        <div class="bg-blue-500 pb-52 bg-gradient-to-br from-blue-500 to-cyan-400"> <!-- Increased padding from pb-48 to pb-72 -->
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
                        <a href="#" class="text-gray-600 hover:text-blue-500">Beranda</a>
                        <a href="#" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Tentang</a>
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

            <!-- tentang kami -->
            <div class="mt-40 flex justify-center"> 
                <ul class="flex space-x-4 space-y-3 " >
                    <li><h1 class="text-[48px] text-white font-bold text-center">Tentang Kami</h1></li>
                    <li><img src="/img/aboutusicon.png" alt="icon tentang kami" ></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- About us Content -->
    <div class="bg-white">
        <div class="container mx-auto px-32  py-16 ">
            <div>
                <!-- about -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1/2">
                    <div class="px-24 text-justify">
                        <h6 class="text-[20px]">Pusat Belanja</h6>
                        <h2 class="font-bold text-[28px]">Handphone & Aksesoris</h2>
                        <p>Selamat datang di Phoneku! Kami adalah sebuah toko yang berfokus pada penjualan handphone (HP) dan berbagai aksesoris berkualitas tinggi.</p>
                        <p class="mt-4">Berdiri sejak 2025, kami telah melayani ribuan pelanggan yang mencari produk berkualitas dan pelayanan terbaik.</p>
                    </div>
                    <div>
                    <img src="/img/aboutus.png" alt="Team Working" class="w-[70%]">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1/2 mt-4" >
                    <!-- visi -->
                    <div class="px-24 text-justify">
                        <h5 class="mt-5 font-bold text-[20px]">Visi Kami</h5>
                        <p class="text-justify text-[16px]">Menjadi penyedia gadget dan aksesoris terbaik yang dapat memenuhi kebutuhan digital Anda dengan memberikan produk berkualitas, harga kompetitif, dan layanan pelanggan yang memuaskan.</p>
                    </div>
                    
                    <!-- misi -->
                    <div class="pr-48">
                        <h5 class="mt-5 font-bold text-[20px]">Misi Kami</h5>
                        <ul class="text-justify list-disc list-outside text-[16px] pl-5">
                                <li>Menyediakan berbagai pilihan HP terbaru dari berbagai merek terkenal dengan kualitas terjamin.</li>
                                <li>Menawarkan berbagai aksesoris pendukung yang akan meningkatkan pengalaman penggunaan handphone Anda.</li>
                                <li>Memberikan layanan purna jual yang responsif dan membantu pelanggan dalam setiap kebutuhan mereka.</li>
                                <li>Memberikan harga yang terjangkau dengan kualitas terbaik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sejarah -->
        <div class="bg-gray-100 pt-2 pb-9 w-full mt-10">
            <div class="px-64 pr-96">
                <h4 class="mt-4 font-bold text-[28px]">Sejarah</h4>
                <p class="text-[16px]">2025 - Sekarang</p>
                <p class="text-[20px] mt-5 leading-tight">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
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

</body>
</html>