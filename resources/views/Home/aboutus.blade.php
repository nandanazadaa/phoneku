@extends('layouts.app')

@section('title', 'Tentang Kami - PhoneKu')

@section('content')
    <!-- Header Section with Banner -->
    <div class="bg-blue-500 pb-32 md:pb-52">
        <!-- Top Navigation -->
        <div class="container mx-auto px-4 py-2 flex justify-end"></div>
        
        <!-- Title -->
        <div class="mt-20 md:mt-40 flex justify-center"> 
            <h1 class="text-4xl md:text-[48px] text-white font-bold text-center">Tentang Kami</h1>
        </div>
    </div>

    <!-- About us Content -->
    <div class="bg-white">
        <div class="container mx-auto px-4 md:px-8 lg:px-16 xl:px-32 py-8 md:py-16">
            <div>
                <!-- about -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="px-4 md:px-8 lg:px-12 xl:px-24 text-justify">
                        <h6 class="text-lg md:text-xl">Pusat Belanja</h6>
                        <h2 class="font-bold text-2xl md:text-[28px]">Handphone</h2>
                        <p class="text-base md:text-lg">Selamat datang di Phoneku! Kami adalah sebuah toko yang berfokus pada penjualan handphone berkualitas tinggi.</p>
                        <p class="mt-4 text-base md:text-lg">Berdiri sejak 2025, kami telah melayani ribuan pelanggan yang mencari produk berkualitas dan pelayanan terbaik.</p>
                    </div>
                    <div class="flex justify-center md:justify-start">
                        <img src="/img/dokumentasi.png" alt="Team Working" class="w-full max-w-md rounded-lg shadow-md">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 md:mt-12">
                    <!-- visi -->
                    <div class="px-4 md:px-8 lg:px-12 xl:px-24 text-justify">
                        <h5 class="mt-5 font-bold text-xl">Visi Kami</h5>
                        <p class="text-justify text-base md:text-[16px]">Menjadi penyedia gadget terbaik yang dapat memenuhi kebutuhan digital Anda dengan memberikan produk berkualitas, harga kompetitif, dan layanan pelanggan yang memuaskan.</p>
                    </div>
                    
                    <!-- misi -->
                    <div class="px-4 md:px-8 lg:pr-12 xl:pr-24">
                        <h5 class="mt-5 font-bold text-xl">Misi Kami</h5>
                        <ul class="text-justify list-disc list-outside text-base md:text-[16px] pl-5 space-y-2">
                            <li>Menyediakan berbagai pilihan HP terbaru dari berbagai merek terkenal dengan kualitas terjamin.</li>
                            <li>Memberikan layanan purna jual yang responsif dan membantu pelanggan dalam setiap kebutuhan mereka.</li>
                            <li>Memberikan harga yang terjangkau dengan kualitas terbaik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sejarah -->
        <div class="bg-gray-100 pt-8 pb-12 w-full mt-8 md:mt-10">
            <div class="container mx-auto px-4 md:px-8 lg:px-16 xl:px-32 2xl:px-64">
                <h4 class="font-bold text-2xl md:text-[28px]">Sejarah</h4>
                <p class="text-base md:text-[16px]">2025 - Sekarang</p>
                <div class="space-y-4 mt-5">
                    <p class="text-lg md:text-xl leading-relaxed">Phoneku didirikan pada awal tahun 2025 oleh sekelompok profesional muda yang memiliki semangat tinggi dalam dunia teknologi dan komunikasi. Berawal dari sebuah toko kecil di pusat kota, Phoneku mulai dikenal karena komitmennya dalam menyediakan handphone berkualitas dengan harga yang bersaing.</p>
                    <p class="text-lg md:text-xl leading-relaxed">Hingga kini, Phoneku terus berkembang dan berinovasi dalam memberikan pelayanan terbaik, dengan fokus pada kepuasan pelanggan dan kepercayaan yang telah dibangun sejak awal berdiri.</p>
                </div>
            </div>
        </div> 
    </div>
@endsection