@extends('layouts.app')

@section('title', 'Setelah Keluar - PhoneKu')

@section('content')
<div class="relative">
    <div class="bg-blue-500 min-h-[400px] sm:min-h-[400px] md:min-h-[500px] lg:min-h-[400px] xl:min-h-[350px] relative">
        <!-- Kosongkan konten header jika tidak ada teks -->
    </div>

    <!-- Wave SVG -->
    <div class="absolute bottom-[-24px] left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#f9fafb" fill-opacity="1"
                d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Banner Image -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4/5 max-w-3xl z-0 pointer-events-none">
        <div class="relative w-full h-full" style="overflow: hidden;">
            <img src="{{ asset('img/banner4.png') }}" alt="Smartphones"
                class="object-contain w-full h-auto max-h-[300px] md:max-h-[350px] lg:max-h-[400px]">
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8 -mt-48 relative z-10">
    <div class="flex flex-wrap lg:flex-nowrap">
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 lg:w-1/4 mb-6 md:mb-0 md:pr-4">
            <div class="bg-white rounded-xl p-4 shadow-md mb-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-gray-200 shadow-sm">
                        <img src="{{ asset('img/profile.png') }}" alt="User Profile" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold mb-1 text-gray-800">Belum Masuk</h2>
                </div>
            </div>

            <!-- Navigation -->
            <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                @php $navItems = [
                    ['icon' => 'user', 'text' => 'Tentang Saya'],
                    ['icon' => 'history', 'text' => 'Riwayat Pembelian'],
                    ['icon' => 'shield-alt', 'text' => 'Keamanan & Privasi'],
                    ['icon' => 'sign-out-alt', 'text' => 'Keluar Akun']
                ]; @endphp

                @foreach($navItems as $item)
                    <a href="{{ route('profileout') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-{{ $item['icon'] }} w-5 mr-3 text-center"></i>
                        <span class="text-sm sm:text-base">{{ $item['text'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Main Panel -->
        <div class="w-full lg:w-3/4">
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 text-center">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-2">Anda Belum Masuk</h3>
                <p class="text-gray-500 mb-6 text-sm sm:text-base">Silahkan Masuk ke Akun Terlebih Dahulu atau Daftar!</p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full transition duration-300 text-sm sm:text-base text-center">
                        Masuk
                    </a>
                    <a href="/registrasi"
                       class="w-full sm:w-auto px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full transition duration-300 text-sm sm:text-base text-center">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
