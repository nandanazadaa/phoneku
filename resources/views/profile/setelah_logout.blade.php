@extends('layouts.app')

@section('title', 'Keluar Akun - PhoneKu')

@section('content')
<!-- Header Section with Wave -->
<div class="relative">
    <!-- Blue Background -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 pb-80 md:pb-96">
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

<!-- Main Content - User Profile -->
<div class="container mx-auto px-4 py-16 relative z-10">
    <div class="flex flex-wrap">
        <!-- Left Sidebar -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-4">
            <!-- User Profile Card -->
            <div class="bg-white rounded-xl p-4 shadow-md mb-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="w-32 h-32 rounded-full bg-blue-200 flex items-center justify-center mb-4 border-2 border-gray-200 shadow-sm">
                        <i class="fas fa-user text-5xl text-blue-500"></i>
                    </div>
                    <h2 class="text-xl font-bold mb-1 text-gray-800">Belum Masuk</h2>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-user w-5 mr-3 text-center"></i>
                    <span>Tentang Saya</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-credit-card w-5 mr-3 text-center"></i>
                    <span>Pengaturan Pembayaran</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-history w-5 mr-3 text-center"></i>
                    <span>Riwayat Pembelian</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                    <span>Keamanan & Privasi</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </div>

        <!-- Right Content -->
        <div class="w-full md:w-3/4 md:pl-4">
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Anda Belum Masuk</h2>
                <p class="text-gray-500 mb-6">Silahkan Masuk ke Akun Terlebih Dahulu atau Daftar!</p>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 hover:shadow-md text-white py-2 px-8 rounded-full text-sm font-medium transition-all duration-200">Masuk</a>
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 hover:shadow-md text-white py-2 px-8 rounded-full text-sm font-medium transition-all duration-200">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('styles')
<style>
    /* Fade-in Animation for Banner */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 1s ease-in-out;
    }

    /* Smooth Scroll Behavior */
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection