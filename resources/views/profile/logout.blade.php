@extends('layouts.app')

@section('title', 'Keluar Akun - PhoneKu')

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

    <!-- Main Content - User Profile -->
    <div class="container mx-auto px-4 py-8 relative -mt-48 z-10">
        <div class="flex flex-wrap">
            <!-- Left Sidebar -->
            <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-4">
                <!-- User Profile Card -->
                <div class="bg-white rounded-xl p-4 shadow-md mb-6">
                    <div class="flex flex-col items-center mb-4">
                    @if(Auth::check() && isset($user))
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-gray-200 shadow-sm">
                            <img src="{{ $user->profile && $user->profile->profile_picture ? asset('storage/' . $user->profile->profile_picture) : asset('img/profile.png') }}"
                                alt="User Profile" class="w-full h-full object-cover">
                        </div>
                        <h2 class="text-xl font-bold mb-1 text-gray-800">{{ $user->name }}</h2>
                    @else
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-gray-200 shadow-sm">
                            <img src="{{ asset('img/profile.png') }}" alt="User Profile" class="w-full h-full object-cover">
                        </div>
                        <h2 class="text-xl font-bold mb-1 text-gray-800">Belum Masuk</h2>
                    @endif
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                    <a href="{{ route('profile') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-user w-5 mr-3 text-center"></i>
                        <span>Tentang Saya</span>
                    </a>
                    <a href="{{ route('riwayatbeli') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-history w-5 mr-3 text-center"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                    <a href="{{ route('profilekeamanan') }}" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                        <span>Keamanan & Privasi</span>
                    </a>
                    <a href="{{ route('profile.logout') }}" class="flex items-center py-3 px-4 bg-blue-500 text-gray-100 rounded-xl shadow-sm">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                        <span>Keluar Akun</span>
                    </a>
                </div>
            </div>

            <!-- Right Content -->
            <section class="w-full md:w-3/4 ">
                <div class="bg-white rounded-xl p-12 text-center shadow-md border border-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Keluar Akun</h3>
                    <p class="text-gray-500 mb-6">Anda Yakin Ingin Keluar Dari Akun Anda?</p>
                    <div class="flex justify-center">
                        <form class="inline" action="{{ route('profile.logout') }}" method="POST">
                            @csrf
                            <button 
                                class="bg-red-500 hover:bg-red-600 text-white py-2 px-12 rounded-full text-sm font-medium transition-all duration-200">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

