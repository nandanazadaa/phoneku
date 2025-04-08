<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Tentang Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Optional: Add custom styles if needed */
        /* Ensure wave SVG doesn't cause unexpected space */
        .wave-container > svg { display: block; }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Header Section with Wave -->
    <div class="relative">
        <!-- Blue Background -->
        <!-- Increased pb significantly: e.g., pb-80 or more depending on image height -->
        <div class="bg-blue-500 pb-80 md:pb-96 bg-gradient-to-r from-blue-500 to-blue-400">
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end">
                <div class="text-white flex space-x-4">
                    <a href="#" class="hover:underline">Masuk</a> <!-- Dummy link -->
                    <span class="text-white">|</span>
                    <a href="#" class="hover:underline">Daftar</a> <!-- Dummy link -->
                </div>
            </div>

            <!-- Main Navigation -->
            <!-- Added relative and z-10 to ensure it's above the image -->
            <div class="container mx-auto px-4 relative z-10">
                <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between shadow-md">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-8">
                        <a href="#" class="text-gray-600 hover:text-blue-500">Beranda</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tim</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Belanja</a>
                        <a href="#" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Kontak</a>
                    </div>

                    <!-- Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-blue-500">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-500">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- NOTE: Image div is now placed AFTER the navigation container within the blue div -->
        </div>

        <!-- Wave SVG -->
        <!-- Added wave-container class -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#f9fafb" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <!-- Hero Image with Phones - Adjusted Positioning -->
        <!-- Positioned relative to the outer 'relative' div -->
        <!-- Adjusted top to push it below the nav bar. Adjusted max-height. Kept z-0 -->
      <!-- Fine-tune 'top' and 'max-h' values as needed -->
            <!-- Fine-tune 'top' and 'max-h' values as needed -->
<!-- Fine-tune 'top' and 'max-h' values as needed -->
<div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 w-3/4 md:w-2/3 lg:w-1/2 z-0 pointer-events-none">
    <!-- Adjusted max-height and position to make it stick to bottom -->
    <img src="img/banner4.png" alt="Smartphones" class="object-contain w-full max-h-[450px] md:max-h-[500px] lg:max-h-[600px]">
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
                                <!-- Username -->
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                                    <input type="text" id="username" value="example" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Nama -->
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                                    <input type="text" id="nama" value="example" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Email -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Ubah</a>
                                    </div>
                                    <input type="email" id="email" value="example@gmail.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
                                </div>

                                <!-- Nomor Telepon -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="telepon" class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Tambah</a>
                                    </div>
                                    <input type="tel" id="telepon" placeholder="Belum ditambahkan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                </div>

                                <!-- Gender -->
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

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Tanggal</option>
                                            <option>1</option>
                                            <!-- Add all days -->
                                            <option>31</option>
                                        </select>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Bulan</option>
                                            <option>Januari</option>
                                            <!-- Add all months -->
                                            <option>Desember</option>
                                        </select>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                            <option>Tahun</option>
                                            <option>1990</option>
                                             <!-- Add relevant years -->
                                            <option>2010</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
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

    <!-- Newsletter Section -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="md:w-1/2 text-center md:text-left">
                    <h3 class="text-white font-bold text-2xl md:text-3xl uppercase tracking-wide">Tetap Update</h3>
                    <h3 class="text-white font-bold text-2xl md:text-3xl uppercase tracking-wide">Dengan Penawaran Kami</h3>
                </div>
                <div class="md:w-1/2 w-full max-w-md">
                    <form class="flex flex-col space-y-3">
                         <div class="rounded-full bg-white flex items-center px-4 py-1 shadow-md focus-within:ring-2 focus-within:ring-blue-300">
                             <i class="far fa-envelope text-gray-400 mr-3"></i>
                             <input type="email" placeholder="Masukkan Email Anda" class="w-full bg-transparent border-none focus:outline-none py-2 text-gray-700" required>
                         </div>
                         <button type="submit" class="bg-white text-blue-500 font-semibold py-3 px-6 rounded-full hover:bg-gray-100 transition-colors shadow-md w-full">
                             Mulai Berlangganan Buletin
                         </button>
                     </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                    </div>
                    <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                        Kami menyediakan pilihan ponsel terbaik yang sesuai dengan gaya Anda. Dari merek ternama hingga terbaru.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="fab fa-tiktok text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Company Links -->
                <div>
                    <h3 class="text-base font-bold mb-5 uppercase text-gray-800 tracking-wider">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Fitur</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Tim Kami</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Karir</a></li>
                    </ul>
                </div>

                <!-- Product & Services Links -->
                <div>
                    <h3 class="text-base font-bold mb-5 uppercase text-gray-800 tracking-wider">Bantuan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Dukungan Pelanggan</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Detail Pengiriman</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors text-sm">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Payment Methods -->
                <div>
                     <h3 class="text-base font-bold mb-5 uppercase text-gray-800 tracking-wider">Pembayaran</h3>
                     <div class="flex flex-wrap gap-3 items-center">
                         <img src="img/dana.png" alt="Dana" class="h-7 object-contain" title="Dana">
                         <img src="img/ovo.png" alt="OVO" class="h-7 object-contain" title="OVO">
                         <img src="img/gopay.png" alt="GoPay" class="h-7 object-contain" title="GoPay">
                         <img src="img/bri.png" alt="BRI" class="h-7 object-contain" title="BRI">
                     </div>
                     
                </div>
            </div>

            <div class="border-t border-gray-200 mt-12 pt-6">
                <p class="text-gray-500 text-xs text-center">
                    Phone.Ku ™ © 2024 - Present. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>