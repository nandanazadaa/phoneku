@extends('layouts.app')

@section('title', 'Keamanan & Privasi - PhoneKu')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative">
        <!-- Increased pb significantly: e.g., pb-80 or more depending on image height -->
<<<<<<< HEAD
        <div class="bg-blue-500  h-[500px] md:h-[550px] lg:h-[400px]">
            <!-- Konten header dibiarkan kosong untuk banner -->
=======
        <div class="bg-blue-500 pb-80 md:pb-96 bg-gradient-to-r from-blue-500 to-blue-400">
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end">
                
            </div>

            <div class="container mx-auto px-4 relative z-10">
                
            </div>
            <!-- NOTE: Image div is now placed AFTER the navigation container within the blue div -->
>>>>>>> 87350c343f8558977ed661e59f93fe5c79d5c2c9
        </div>

        <!-- Wave SVG -->
        <!-- Added wave-container class -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#f9fafb" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <!-- Hero Image with Phones - Adjusted Positioning -->
<<<<<<< HEAD
        <!-- Positioned relative to the outer 'relative' div -->
        <!-- Adjusted top to push it below the nav bar. Adjusted max-height. Kept z-0 -->
        <!-- Fine-tune 'top' and 'max-h' values as needed -->
        <!-- Fine-tune 'top' and 'max-h' values as needed -->
        <!-- Fine-tune 'top' and 'max-h' values as needed -->
        <div class="absolute top-[15%] left-[calc(50%+1cm)] transform -translate-x-1/2 w-full max-w-3xl mx-auto z-0 pointer-events-none" style="max-height: 70%;">
    <div class="relative w-full h-full" style="overflow: hidden;">
        <img src="img/banner4.png" alt="Smartphones"
            class="object-contain w-full h-auto max-h-[300px] md:max-h-[350px] lg:max-h-[400px]">
=======
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 w-3/4 md:w-2/3 lg:w-1/2 z-0 pointer-events-none">
            <!-- Adjusted max-height and position to make it stick to bottom -->
            <img src="img/banner4.png" alt="Smartphones" class="object-contain w-full max-h-[450px] md:max-h-[500px] lg:max-h-[600px]">
        </div>
>>>>>>> 87350c343f8558977ed661e59f93fe5c79d5c2c9
    </div>
</div>

    <!-- Main Content - User Profile -->
    <!-- Adjusted negative margin-top to match increased header height -->
    <div class="container mx-auto px-4 py-8 -mt-48 md:-mt-56 relative z-10">
        <div class="flex flex-wrap">
            <!-- Left Sidebar -->
            <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-4">
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
                    <a href="{{ route('profile') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 shadow-sm">
                        <i class="fas fa-user w-5 mr-3 text-center"></i>
                        <span>Tentang Saya</span>
                    </a>
                    <a href="{{ route('riwayatpembelian') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-history w-5 mr-3 text-center"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                    <a href="{{ route('profilekeamanan') }}" class="flex items-center py-3 px-4 bg-blue-500 text-gray-100 rounded-xl transition-colors">
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
            <!-- Content Area -->
        <section class="w-full md:w-3/4">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">Keamanan & Privasi</h3>
                <p class="text-gray-500 mb-6">Kontrol penuh atas informasi pribadi dan perlindungan akses akun Anda.</p>

                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Ubah Password -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="pwubah" class="block text-sm font-medium text-gray-700 mb-3">Ubah Password</label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="password" id="pwlama" placeholder="Password Lama"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700">

                            <input type="password" id="pwbaru" placeholder="Password Baru"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700">

                            <input type="password" id="pwconfirm" placeholder="Konfirmasi Password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700">
                        </div>

                        <button type="submit"
                            class="mt-4 w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-300">
                            Perbarui Password
                        </button>
                    </div>

                    <!-- Hapus Akun -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="pwubah" class="block text-sm font-medium text-gray-700 mb-1">Hapus Akun</label>
                        <p class="block text-sm font-medium text-gray-400 mb-2">Akun Anda Akan Dihapus Secara Permanen</p>
                        <button type="Perbarui Password"
                            class="w-full px-4 py-2 mb-4 border bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg">
                            Ajukan Penghapusan Akun
                        </button>
                    </div>
                </form>
            </div>
        </section>
        </div>
    </div>
@endsection