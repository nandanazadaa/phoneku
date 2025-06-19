@extends('layouts.app')

@section('title', 'Kontak - PhoneKu')

@section('content')
    <div class="relative">
        <div class="bg-blue-500 pb-52">
            <div class="container mx-auto px-4 py-2 flex justify-end">
            </div>
            <div class="mt-32 sm:mt-40 flex justify-center">
                <h1 class="text-3xl sm:text-4xl md:text-[48px] text-white font-bold text-center">Kontak</h1>
            </div>
        </div>

        <div class="bg-white">
            <div class="container mx-auto px-4 sm:px-8 md:px-16 lg:px-32 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Kanan -->
                    <div class="flex flex-col">
                        <div>
                            <h6 class="text-lg sm:text-xl">Hubungi Kami</h6>
                            <h2 class="font-bold text-2xl sm:text-4xl md:text-[40px] leading-tight">
                                Kami selalu senang membantu Anda dan menjawab pertanyaan Anda
                            </h2>
                            <p class="mt-6 text-base sm:text-lg">
                                Silakan hubungi kami melalui pusat panggilan, email, atau kunjungi lokasi kami untuk
                                mendapatkan bantuan lebih lanjut.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-8 sm:gap-20 mt-12">
                            <div>
                                <h6 class="font-bold text-base sm:text-lg mb-2">Pusat Panggilan</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p>08-311-328-913-799</p>
                                </a>

                                <h6 class="font-bold text-base sm:text-lg mb-2 mt-6">Email</h6>
                                <a href="#" class="text-gray-600 hover:text-blue-500">
                                    <p>phonku@mail.com</p>
                                </a>
                            </div>
                            <div>
                                <h6 class="font-bold text-base sm:text-lg mb-2">Lokasi Kami</h6>
                                <a href="https://maps.app.goo.gl/TDxKt3buY2CinubM7"
                                    class="text-gray-600 hover:text-blue-500">
                                    <p>Indonesia</p>
                                </a>

                                <h6 class="font-bold text-base sm:text-lg mb-2 mt-6">Media Sosial</h6>
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

                    <!-- Kiri (Form) -->
                    <div
                        class="bg-gradient-to-br from-blue-500 to-cyan-400 rounded-3xl px-6 sm:px-12 md:px-24 py-12 flex flex-col text-white overflow-hidden shadow-lg">
                        <div>
                             @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- UNTUK MENAMPILKAN ERROR JIKA ADA INPUT YANG SALAH --}}
                            @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
                                    <ul class="list-disc list-inside mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h4 class="font-bold text-xl sm:text-2xl">Hubungi Kami</h4>
                            <p class="mt-4 sm:mt-6 text-sm sm:text-base">
                                Tim kami akan dengan senang hati merespons setiap pertanyaan atau kebutuhan Anda secepat
                                mungkin.
                            </p>
                        </div>
                       <form action="{{ route('kontak.kirim') }}" method="POST">
                        @csrf
                        <div class="mt-10 space-y-4">
                            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required
                                class="w-full px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none" value="{{ old('nama_lengkap') }}">
                            
                            <input type="email" name="email" placeholder="Email" required
                                class="w-full px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none" value="{{ old('email') }}">
                            
                            <input type="text" name="subjek" placeholder="Subjek" required
                                class="w-full px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none" value="{{ old('subjek') }}">
                            
                            <textarea name="pesan" placeholder="Pesan" required
                                class="w-full h-32 px-0 py-3 bg-transparent border-b border-white/50 placeholder-white focus:outline-none resize-none">{{ old('pesan') }}</textarea>
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-white text-gray-800 font-medium mt-8 px-6 py-3 rounded-full hover:bg-gray-100 w-full sm:w-auto">
                                Kirim Pesan
                            </button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="mt-16 w-full h-64 sm:h-96 md:h-[500px] rounded-xl overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2818402780804!2d110.4090461!3d-7.7599048999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1744115106486!5m2!1sid!2sid"
                        class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
