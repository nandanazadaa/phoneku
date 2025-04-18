@extends('layouts.app')

@section('title', 'Tim - PhoneKu')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative overflow-hidden">
        <!-- Background dengan height fixed daripada padding -->
        <div class="bg-blue-500  h-[500px] md:h-[550px] lg:h-[400px]">
            <!-- Konten header dibiarkan kosong untuk banner -->
        </div>

        <!-- Wave SVG di bagian bawah -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#fff" fill-opacity="1"
                    d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
        <!--banner hp-->
        <div class="absolute top-[15%] left-[calc(50%+1cm)] transform -translate-x-1/2 w-full max-w-3xl mx-auto z-0 pointer-events-none" style="max-height: 70%;">
    <div class="relative w-full h-full" style="overflow: hidden;">
        <img src="img/banner4.png" alt="Smartphones"
            class="object-contain w-full h-auto max-h-[300px] md:max-h-[350px] lg:max-h-[400px]">
    </div>
</div>


    <!-- Main Content - User Profile -->
    <!-- Menggunakan margin-top yang lebih kecil -->
    <div class="container mx-auto px-4 py-8 -mt-32 md:-mt-40 lg:-mt-48 relative z-10">
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
                    <a href="{{ route('profile') }}" class="flex items-center py-3 px-4 bg-blue-500 text-white rounded-xl shadow-sm">
                        <i class="fas fa-user w-5 mr-3 text-center"></i>
                        <span>Tentang Saya</span>
                    </a>
                    <a href="{{ route('riwayatpembelian') }}"
                        class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-history w-5 mr-3 text-center"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                    <a href="{{ route('profilekeamanan') }}"
                        class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                        <span>Keamanan & Privasi</span>
                    </a>
            
                    <a href="{{ route('logout') }}"
                        class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                        <span>Keluar Akun</span>
                    </a>
                </div>
            </div>

            <!-- Right Content -->
            <div class="w-full md:w-3/4 md:pl-4">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-4">Tentang Saya</h3>
                    <p class="text-gray-500 mb-8">Atur dan ubah informasi pribadi anda sesuai keinginan</p>

                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Form Fields -->
                            <div class="md:col-span-2 space-y-6">
                                <!-- Username -->
                                <div>
                                    <label for="username"
                                        class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                                    <input type="text" id="username" value="example"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Nama -->
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                                    <input type="text" id="nama" value="example"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Email -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                                        <a href="#"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">Ubah</a>
                                    </div>
                                    <input type="email" id="email" value="example@gmail.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-100 text-gray-500 cursor-not-allowed"
                                        readonly>
                                </div>

                                <!-- Nomor Telepon -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="telepon" class="block text-sm font-medium text-gray-600">Nomor
                                            Telepon</label>
                                        <a href="#"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">Tambah</a>
                                    </div>
                                    <input type="tel" id="telepon" placeholder="Belum ditambahkan"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Gender</label>
                                    <div class="flex space-x-6">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="gender" value="male"
                                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-2 text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="gender" value="female"
                                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-2 text-gray-700">Perempuan</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <select
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Tanggal</option>
                                            <option>1</option>
                                            <!-- Add all days -->
                                            <option>31</option>
                                        </select>
                                        <select
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Bulan</option>
                                            <option>Januari</option>
                                            <!-- Add all months -->
                                            <option>Desember</option>
                                        </select>
                                        <select
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Tahun</option>
                                            <option>1990</option>
                                            <!-- Add relevant years -->
                                            <option>2010</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right pt-4">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-8 py-3 rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                                        Simpan
                                    </button>
                                </div>
                            </div>

                            <!-- Profile Picture Upload -->
                            <div
                                class="flex flex-col items-center border-l border-gray-200 pl-8 md:border-l-0 md:pl-0 md:border-t md:border-gray-200 md:pt-8 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-8">
                                <label for="profile-upload" class="cursor-pointer">
                                    <div
                                        class="w-36 h-36 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg ring-2 ring-gray-200">
                                        <img src="img/profile.png" alt="Profile Picture"
                                            class="w-full h-full object-cover">
                                    </div>
                                </label>
                                <input type="file" id="profile-upload" class="hidden">
                                <button type="button" onclick="document.getElementById('profile-upload').click()"
                                    class="bg-white border border-blue-500 text-blue-500 px-6 py-2 rounded-full mt-2 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-sm text-sm font-medium">
                                    Pilih Gambar
                                </button>
                                <p class="text-gray-500 text-xs text-center mt-3">
                                    Ukuran File: Maksimum 1 MB<br>
                                    Ekstensi: PNG, JPG, JPEG
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Memastikan wave SVG tidak menyebabkan spasi tak terduga */
        .wave-container > svg {
            display: block;
        }
        
        /* Memastikan gambar tidak keluar dari container */
        .overflow-hidden {
            overflow: hidden;
        }

        /* Desain responsif untuk berbagai level zoom */
        @media screen and (max-width: 640px) {
            .h-[500px] {
                height: 400px;
            }
            
            .max-h-[300px] {
                max-height: 250px;
            }
        }

        /* Untuk browser dengan zoom yang berbeda */
        @media screen and (min-width: 1500px) {
            .lg\:h-[600px] {
                height: 700px;
            }
            
            .lg\:max-h-[400px] {
                max-height: 500px;
            }
        }
    </style>
@endsection