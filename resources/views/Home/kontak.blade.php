@extends('layouts.app')

@section('title', 'Kontak - PhoneKu')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative">
        <!-- Blue Background with Wave -->
        <div class="bg-blue-500 pb-52"> <!-- Increased padding from pb-48 to pb-72 -->
            <!-- Top Navigation -->
                <div class="container mx-auto px-4 py-2 flex justify-end">
                    
                </div>
                <!-- kontak -->
                <div class="mt-40 flex justify-center"> 
                        <h1 class="text-[48px] text-white font-bold text-center">Kontak</h1>
                </div>
        </div>
    
    <!-- kontak Content -->
    <div class="bg-white">
        <div class="container mx-auto px-32 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">  
                <div class="flex flex-row">
                    <!-- isi kiri -->
                    <div>
                        <!-- sambutan -->
                        <div>
                            <h6 class="text-[20px]">Hubungi Kami</h6>
                            <h2 class="font-bold text-[48px] leading-tight">Kami selalu senang membantu Anda dan menjawab pertanyaan Anda</h2>
                            <p class="mt-8 ">Silakan hubungi kami melalui pusat panggilan, email, atau kunjungi lokasi kami untuk mendapatkan bantuan lebih lanjut.</p>          
                        </div>

                        <!-- detail kontak -->
                        <div class="flex flex-row gap-20 mt-16">
                            <div>
                                <h6 class="font-bold text-[18px] mb-3 ">Pusat Panggilan</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p >08-311-328-913-799</p>
                                </a>

                                <h6 class="font-bold text-[18px] mb-3 mt-16">Email</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p >phonku@mail.com</p>
                                </a>
                            </div>
                            <div>
                                <h6 class="font-bold text-[18px] mb-3">Lokasi Kami</h6>
                                <a href="https://maps.app.goo.gl/TDxKt3buY2CinubM7" class="text-gray-600 hover:text-blue-500">
                                    <p>Indonesia</p>
                                </a>


                                <h6 class="font-bold text-[18px] mb-3 mt-16">Media Sosial</h6>
                                <div class="flex flex-row space-x-4">
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="text-gray-600 hover:text-blue-500">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- isi kanan -->
                <div class=" bg-gradient-to-br from-blue-500 to-cyan-400 rounded-3xl px-24 py-16 flex flex-col text-white overflow-hidden shadow-lg">
                    <div>
                        <h4 class="font-bold text-[24px]">Hubungi Kami</h4>
                        <p class="mt-6"> Tim kami akan dengan senang hati merespons setiap pertanyaan atau kebutuhan Anda secepat mungkin.</p>
                    </div>
                    <div>
                        <input type="text" placeholder="Nama Lengkap" class="w-full mt-12 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="email" placeholder="Email" class="w-full mt-2 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="text" placeholder="Subjek" class="w-full mt-2 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>
                    <div>
                        <input type="text" placeholder="Pesan" class="w-full mt-2 pb-20 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none">
                    </div>

                    <div>
                        <button class="bg-white text-gray-800 font-medium mt-8 px-6 py-3 rounded-full hover:bg-gray-100">
                            > Kirim Pesan
                        </button>
                    </div>
                </div>
            </div>

            <!-- google map -->
            <div class="mt-16 w-full h-[500px] rounded-xl overflow-hidden shadow-lg">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2818402780804!2d110.4090461!3d-7.7599048999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1744115106486!5m2!1sid!2sid" 
                    class="w-full h-full border-0"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </div>
    </div>
@endsection