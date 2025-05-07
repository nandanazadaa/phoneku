<!-- Top Navigation -->
<div class="bg-blue-500 relative">
    <div class="container mx-auto px-4 py-2 flex justify-end text-white space-x-4 text-sm">
        @guest
            <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
            <span>|</span>
            <a href="{{ route('registrasi') }}" class="hover:underline">Daftar</a>
        @endguest
    
        @auth
            <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline flex items-center">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        @endauth
    </div>
    
    <!-- Main Navigation -->
    <div class="container mx-auto px-4 pb-4">
        <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}"><img src="{{ asset('img/logo2.png') }}" alt="PhoneKu Logo" class="h-10"></a>
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('welcome') }}"
                class="{{ Route::currentRouteName() == 'welcome' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Beranda
                </a>
                <a href="{{ route('aboutus') }}"
                class="{{ Route::currentRouteName() == 'aboutus' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Tentang
                </a>
                <a href="{{ route('tim') }}"
                class="{{ Route::currentRouteName() == 'tim' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Tim
                </a>
                <a href="{{ route('allproduct') }}"
                class="{{ Route::currentRouteName() == 'allproduct' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Belanja
                </a>
                <a href="{{ route('kontak') }}"
                class="{{ Route::currentRouteName() == 'kontak' ? 'text-blue-500 font-medium border-b-2 border-blue-500 pb-1' : 'text-gray-600 hover:text-blue-500' }}">
                    Kontak
                </a>
            </div>
            
            <!-- Icons -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('cart') }}" 
                        class="{{ Route::currentRouteName() == 'cart' ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }} relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ \App\Models\Cart::where('user_id', Auth::user()->id ?? 0)->sum('quantity') > 0 ? '' : 'hidden' }}">
                            {{ \App\Models\Cart::where('user_id', Auth::user()->id ?? 0)->sum('quantity') }}
                        </span>
                    </a>
                    @php
                        $activeRoutes = ['profile', 'riwayatbeli', 'profilekeamanan', 'logout'];
                        $isProfileActive = in_array(Route::currentRouteName(), $activeRoutes);
                    @endphp
                    <a href="{{ route('profile') }}" 
                    class="{{ $isProfileActive ? 'text-blue-500 font-medium' : 'text-gray-600 hover:text-blue-500' }}">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                @else
                    <a href="{{ route('login', ['redirect' => route('cart')]) }}" 
                        class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </a>
                    <a href="{{ route('login') }}" 
                        class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>