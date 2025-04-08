<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - PhoneKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .hero {
            background: linear-gradient(to bottom, #009fff, #00c6ff);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .section {
            padding: 60px 0;
        }
        .section img {
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end">
                <div class="text-white flex space-x-4">
                    <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
                    <span class="text-white">|</span>
                    <a href="{{ route('registrasi') }}" class="hover:underline">Daftar</a>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-xl py-4 px-6 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-8">
                        <a href="#" class="text-blue-500 font-medium border-b-2 border-blue-500 pb-1">Beranda</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Tim</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Belanja</a>
                        <a href="#" class="text-gray-600 hover:text-blue-500">Kontak</a>
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

<!-- Hero Section -->
<div class="hero mt-5">
    <div class="container">
        <h1 class="fw-bold">Tentang Kami</h1>
        <p><i class="bi bi-people"></i></p>
    </div>
</div>

<!-- About Content -->
<div class="section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="text-uppercase text-muted">Pusat Belanja</h5>
                <h2 class="fw-bold">Handphone & Aksesoris</h2>
                <p>Selamat datang di [Nama Toko]! Kami adalah sebuah toko yang berfokus pada penjualan handphone (HP) dan berbagai aksesoris berkualitas tinggi.</p>
                <p>Berdiri sejak [tahun berdiri], kami telah melayani ribuan pelanggan yang mencari produk berkualitas dan pelayanan terbaik.</p>
                <h5 class="mt-4">Visi Kami</h5>
                <p>Menjadi penyedia gadget dan aksesoris terbaik yang dapat memenuhi kebutuhan digital Anda dengan memberikan produk berkualitas, harga kompetitif, dan layanan pelanggan yang memuaskan.</p>
                <h5 class="mt-4">Misi Kami</h5>
                <ul>
                    <li>Menyediakan berbagai pilihan HP terbaru dari berbagai merek terkenal dengan kualitas terjamin.</li>
                    <li>Menawarkan berbagai aksesoris pendukung yang akan meningkatkan pengalaman penggunaan handphone Anda.</li>
                    <li>Memberikan layanan purna jual yang responsif dan membantu pelanggan dalam setiap kebutuhan mereka.</li>
                    <li>Memberikan harga yang terjangkau dengan kualitas terbaik.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img src="/img/aboutus.png" alt="Team Working">
            </div>
        </div>
    </div>
</div>

<!-- Sejarah -->
<div class="section">
    <div class="container">
        <h4 class="fw-bold">Sejarah</h4>
        <p class="text-muted">2025 - Sekarang</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
