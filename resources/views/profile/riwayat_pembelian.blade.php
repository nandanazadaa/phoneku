@extends('layouts.app')

@section('title', 'Riwayat Pembelian - PhoneKu')

@section('content')
<!-- Header Section with Wave -->
<div class="relative">
        <!-- Blue Background -->
        <!-- Increased pb significantly: e.g., pb-80 or more depending on image height -->
        <div class="bg-blue-500 pb-80 md:pb-96 bg-gradient-to-r from-blue-500 to-blue-400">
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end">
                
            </div>

            <!-- Main Navigation -->
            <!-- Added relative and z-10 to ensure it's above the image -->
            <div class="container mx-auto px-4 relative z-10">
                
            </div>
            <!-- NOTE: Image div is now placed AFTER the navigation container within the blue div -->
        </div>


    <!-- Wave SVG -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#f9fafb" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- Hero Image with Phones -->
    <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 w-3/4 md:w-2/3 lg:w-1/2 z-0 pointer-events-none">
        <img src="img/banner4.png" alt="Smartphones" class="object-contain w-full max-h-[450px] md:max-h-[500px] lg:max-h-[600px]">
    </div>
</div>

<!-- Main Content - User Profile -->
<div class="container mx-auto px-4 py-8 relative z-10">
    <div class="flex flex-wrap">
        <!-- Left Sidebar -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-4">
            <!-- User Profile Card -->
            <div class="bg-white rounded-xl p-4 shadow-md mb-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-gray-200 shadow-sm">
                        <img src="img/profile.png" alt="User Profile" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold mb-1 text-gray-800">Ahmed Rusdi</h2>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                <a href="{{ route('profile') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-user w-5 mr-3 text-center"></i>
                    <span>Tentang Saya</span>
                </a>
                <a href="{{ route('profilebayar') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-credit-card w-5 mr-3 text-center"></i>
                    <span>Pengaturan Pembayaran</span>
                </a>
                <a href="{{ route('riwayatpembelian') }}" class="flex items-center py-3 px-4 bg-blue-500 text-gray-100 rounded-xl shadow-sm">
                    <i class="fas fa-history w-5 mr-3 text-center"></i>
                    <span>Riwayat Pembelian</span>
                </a>
                <a href="{{ route('profilekeamanan') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                    <span>Keamanan & Privasi</span>
                </a>
                <a href="{{ route('logout') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </div>

        <!-- Right Content -->
        <section class="w-full md:w-3/4">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">Riwayat Pembelian</h3>
                <p class="text-gray-500 mb-6">Lihat dan Telusuri Jejak dan Transaksi Pembelian Anda</p>

                <!-- Purchase History Items -->
                <div class="space-y-6">
                    <!-- Purchase Item 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex flex-col md:flex-row justify-between items-start">
                            <div class="flex flex-col md:flex-row items-start mb-4 md:mb-0">
                                <div class="w-32 mb-4 md:mb-0 md:mr-6">
                                    <img src="img/iphone11.png" alt="iPhone 11" class="w-full rounded-md">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">iPhone 11</h4>
                                    <div class="space-y-1 text-gray-600">
                                        <p>Warna: Merah</p>
                                        <p>SKU: 8100019113</p>
                                        <p>Dibeli: 12 Maret 2025</p>
                                        <p>Harga: Rp5.999.999</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <div class="flex flex-col items-end">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-sm mb-4">Transaksi berhasil</span>
                                    <div class="text-right mb-3">
                                        <p class="text-gray-500 text-sm">Total 1 Produk:</p>
                                        <p class="font-semibold text-gray-700">Rp 5.999.9999</p>
                                    </div>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-full text-sm">Beli Lagi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Item 2 (repeat of item 1 for the example) -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex flex-col md:flex-row justify-between items-start">
                            <div class="flex flex-col md:flex-row items-start mb-4 md:mb-0">
                                <div class="w-32 mb-4 md:mb-0 md:mr-6">
                                    <img src="img/iphone11.png" alt="iPhone 11" class="w-full rounded-md">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">iPhone 11</h4>
                                    <div class="space-y-1 text-gray-600">
                                        <p>Warna: Merah</p>
                                        <p>SKU: 8100019113</p>
                                        <p>Dibeli: 12 Maret 2025</p>
                                        <p>Harga: Rp5.999.999</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <div class="flex flex-col items-end">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-sm mb-4">Transaksi berhasil</span>
                                    <div class="text-right mb-3">
                                        <p class="text-gray-500 text-sm">Total 1 Produk:</p>
                                        <p class="font-semibold text-gray-700">Rp 5.999.9999</p>
                                    </div>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-full text-sm">Beli Lagi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


@endsection