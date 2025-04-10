@extends('layouts.app')

@section('title', 'Tentang Saya - PhoneKu')

@section('content')
    <!-- Header Section with Enhanced Wave and Banner -->
    <div class="relative">
        <div class="bg-blue-500 pb-80 md:pb-96 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400">
            <div class="container mx-auto px-4 py-2 flex justify-end">
                <!-- Top Navigation -->
            </div>

            <div class="container mx-auto px-4 relative z-10">
                <!-- Main Navigation -->
            </div>
        </div>

        <!-- Enhanced Wave SVG with Smoother Curves -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#f9fafb" fill-opacity="1" d="M0,192L60,176C120,160,240,128,360,144C480,160,600,224,720,245.3C840,267,960,245,1080,213.3C1200,181,1320,139,1380,117.3L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,1200,320,60,320L0,320Z"></path>
            </svg>
        </div>

        <!-- Improved Banner Image with Animation -->
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 w-3/4 md:w-2/3 lg:w-1/2 z-0 pointer-events-none">
            <img src="img/banner4.png" alt="Smartphones" class="object-contain w-full max-h-[450px] md:max-h-[500px] lg:max-h-[600px] animate-float">
        </div>
    </div>

    <!-- Main Content - User Profile -->
<div class="container mx-auto px-4 py-8 relative z-10">
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
                <a href="#" class="flex items-center py-3 px-4 bg-blue-500 text-white rounded-xl shadow-sm">
                    <i class="fas fa-user w-5 mr-3 text-center"></i>
                    <span>Tentang Saya</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-credit-card w-5 mr-3 text-center"></i>
                    <span>Pengaturan Pembayaran</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-history w-5 mr-3 text-center"></i>
                    <span>Riwayat Pembelian</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                    <span>Keamanan & Privasi</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-bell w-5 mr-3 text-center"></i>
                    <span>Notifikasi</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
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
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                                <input type="text" id="username" value="example" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                                <input type="text" id="nama" value="example" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Ubah</a>
                                </div>
                                <input type="email" id="email" value="example@gmail.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label for="telepon" class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Tambah</a>
                                </div>
                                <input type="tel" id="telepon" placeholder="Belum ditambahkan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">Gender</label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="gender" value="male" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="gender" value="female" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Enhanced Date of Birth Section -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Lahir</label>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="relative">
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 appearance-none bg-white">
                                            <option value="">Tanggal</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div class="relative">
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 appearance-none bg-white">
                                            <option value="">Bulan</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div class="relative">
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 appearance-none bg-white">
                                            <option value="">Tahun</option>
                                            @for ($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right pt-4">
                                <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                                    Simpan
                                </button>
                            </div>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="flex flex-col items-center border-l border-gray-200 pl-8 md:border-l-0 md:pl-0 md:border-t md:border-gray-200 md:pt-8 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-8">
                            <label for="profile-upload" class="cursor-pointer">
                                <div class="w-36 h-36 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg ring-2 ring-gray-200">
                                    <img src="img/profile.png" alt="Profile Picture" class="w-full h-full object-cover">
                                </div>
                            </label>
                            <input type="file" id="profile-upload" class="hidden">
                            <button type="button" onclick="document.getElementById('profile-upload').click()" class="bg-white border border-blue-500 text-blue-500 px-6 py-2 rounded-full mt-2 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-sm text-sm font-medium">
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