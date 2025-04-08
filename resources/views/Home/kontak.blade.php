<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="font-sans bg-white">
    <!-- Header Section with Wave -->
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
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tim</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Belanja</a>
                        <a href="#" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Kontak</a>
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

            <!-- kontak -->
            <div class="mt-40 flex justify-center"> 
                    <h1 class="text-[48px] text-white font-bold text-center">Kontak</h1>
            </div>
    </div>
    
    <!-- kontak Content -->
    <div class="bg-white">
        <div class="container mx-auto px-32 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">  
                <div class="flex flex-row">
                    <!-- isi kanan -->
                    <div>
                        <!-- sambutan -->
                        <div>
                            <h6 class="text-[20px]">Hubungi Kami</h6>
                            <h2 class="font-bold text-[48px] leading-tight">Kami selalu senang membantu Anda dan menjawab pertanyaan Anda</h2>
                            <p class="mt-8 ">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>          
                        </div>

                        <!-- detail kontak -->
                        <div class="flex flex-row gap-20 mt-16">
                            <div>
                                <h6 class="font-bold text-[18px] mb-3 ">Pusat Panggilan</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p >08-311-328-913-799</p>
                                </a>

                                <h6 class="font-bold text-[18px] mb-3 mt-16">Email</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p >phonku@mail.com</p>
                                </a>
                            </div>
                            <div>
                                <h6 class="font-bold text-[18px] mb-3">Lokasi Kami</h6>
                                <a href="https://maps.app.goo.gl/TDxKt3buY2CinubM7" class="text-gray-600 hover:text-blue-500">
                                    <p>Indonesia</p>
                                </a>


                                <h6 class="font-bold text-[18px] mb-3 mt-16">Media Sosial</h6>
                                <div class="flex flex-row space-x-4">
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- isi kiri -->
                <div class=" bg-gradient-to-br from-blue-500 to-cyan-400 rounded-3xl px-24 py-16 flex flex-col text-white">
                    <div>
                        <h4 class="font-semibold text-[24px]">Hubungi Kami</h4>
                        <p class="mt-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do  sit amet, consectetur </p>
                    </div>
                    <div>
                        <input type="text" placeholder="Nama Lengkap" class="w-full mt-12 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="email" placeholder="Email" class="w-full mt-2 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="text" placeholder="Subjek" class="w-full mt-2 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="text" placeholder="Pesan" class="w-full mt-2 pb-20 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>

                    <div>
                        <button class="bg-white text-gray-800 font-medium mt-8 px-6 py-3 rounded-full hover:bg-gray-100">
                            > Kirim Pesan
                        </button>
                    </div>
                </div>
            </div>

            <!-- google map -->
            <div class="mt-16 w-full h-96 rounded-xl overflow-hidden shadow-lg">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2818402780804!2d110.4090461!3d-7.7599048999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1744115106486!5m2!1sid!2sid" 
                    class="w-full h-full border-0"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

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