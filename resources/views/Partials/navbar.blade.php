<!-- Top Navigation -->
<div class="bg-blue-500 relative">
    <div class="container mx-auto px-4 py-2 flex justify-end">
        
    </div>
    
    <!-- Main Navigation -->
    <div class="container mx-auto px-4 pb-4">
        <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}"><img src="img/logo2.png" alt="PhoneKu Logo" class="h-10"></a>
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('welcome') }}" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Beranda</a>
                <a href="{{ route('aboutus') }}" class="text-gray-600 hover:text-blue-500">Tentang</a>
                <a href="{{ route('tim') }}" class="text-gray-600 hover:text-blue-500">Tim</a>
                <a href="{{ route('allproduct') }}" class="text-gray-600 hover:text-blue-500">Belanja</a>
                <a href="{{ route('kontak') }}" class="text-gray-600 hover:text-blue-500">Kontak</a>
            </div>
            
            <!-- Icons -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('checkuot') }}" class="text-blue-500">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </a>
                <a href="#" class="text-blue-500">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</div>