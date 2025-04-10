@extends('layouts.app')

@section('title', 'Keluar Akun - PhoneKu')

@section('content')
<!-- Header Section with Wave -->
<div class="relative">
    <!-- Blue Background -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 pb-80 md:pb-96">
        <!-- Top Navigation -->
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="img/logo.png" alt="PhoneKu Logo" class="h-8">
                <span class="ml-2 text-white font-bold text-lg">PhoneKu</span>
            </div>
            <!-- Navigation Links -->
            <div class="flex space-x-6 text-white font-medium">
                <a href="#" class="hover:text-blue-200 transition-colors">Beranda</a>
                <a href="#" class="hover:text-blue-200 transition-colors">Tentang</a>
                <a href="#" class="hover:text-blue-200 transition-colors">Tim</a>
                <a href="#" class="hover:text-blue-200 transition-colors">Belanja</a>
                <a href="#" class="hover:text-blue-200 transition-colors">Kontak</a>
            </div>
            <!-- Icons -->
            <div class="flex space-x-4">
                <a href="#" class="text-white"><i class="fas fa-shopping-cart"></i></a>
                <a href="#" class="text-white"><i class="fas fa-user-circle"></i></a>
            </div>
        </div>
    </div>

    <!-- Wave SVG -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#f9fafb" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- Hero Image with Phones -->
    <div class="absolute top-16 left-1/2 transform -translate-x-1/2 w-full md:w-3/4 lg:w-1/2 z-0 pointer-events-none">
        <img src="img/banner4.png" alt="Smartphones" class="object-contain w-full max-h-[400px] md:max-h-[450px] lg:max-h-[500px] animate-fadeIn">
    </div>
</div>

<!-- Main Content - Logout Confirmation -->
<div class="container mx-auto px-4 py-12 relative z-10">
    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col md:flex-row items-center justify-between">
        <!-- Left Side: Profile Icon and "Belum Masuk" -->
        <div class="flex flex-col items-center md:items-start mb-6 md:mb-0">
            <div class="w-24 h-24 rounded-full bg-blue-200 flex items-center justify-center mb-4">
                <i class="fas fa-user text-4xl text-blue-500"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700">Belum Masuk</h3>
        </div>

        <!-- Right Side: Text and Buttons -->
        <div class="text-center md:text-left">
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Anda Belum Masuk</h2>
            <p class="text-gray-500 mb-6">Silahkan Masuk ke Akun Terlebih Dahulu atau Daftar!</p>
            <div class="flex justify-center md:justify-start space-x-4">
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-full text-sm font-medium transition-all duration-200">Masuk</a>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-full text-sm font-medium transition-all duration-200">Daftar</a>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="container mx-auto px-4 py-12">
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 rounded-xl p-8 text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0">
                <h3 class="text-2xl font-bold mb-2">TETAP UPDATE DENGAN PENAWARAN KAMI</h3>
            </div>
            <div class="w-full md:w-1/2">
                <div class="flex flex-col space-y-3">
                    <input type="email" placeholder="Masukkan Email Anda" class="px-4 py-3 rounded-full text-gray-700 w-full focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200">
                    <button class="bg-white text-blue-500 hover:bg-gray-100 font-medium py-3 rounded-full transition-all duration-200">Mulai Berlangganan Buletin</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection