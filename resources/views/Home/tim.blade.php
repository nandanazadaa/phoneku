@extends('layouts.app')

@section('title', 'Tim - PhoneKu')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative">
        <div class="bg-blue-500 pb-200">
            <div class="container mx-auto px-4 py-2 flex justify-end"></div>
            <div class="container mx-auto px-4"></div>


            <section class="py-12">
                <div class="container mx-auto px-4 ">
                    <div class="mt-8">
                        <h1 class="text-5xl font-bold text-center text-white">Tim Kami</h1>
                    </div>
                  <div class="flex flex-wrap justify-center gap-12 mt-8">
                    <div class="relative bg-white rounded-[212px] w-48 pt-10 text-center py-12 px-3 shadow-lg lg:mt-40 flex flex-col justify-between min-h-[460px]">
                        <h2 class="text-xl font-bold">Muhammad Yusuf Nurwahid</h2>
                        <p class="text-sm text-gray-500 mb-4">Frontend Developer</p>
                        <div class="w-full h-48 rounded-[212px] overflow-hidden mb-4">
                          <img src="img/yusuf.jpg" alt="Muhammad Yusuf Nurwahid" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-gray-600"><i class="fa-solid fa-quote-left"></i>
                        Kode bukan sekadar instruksi untuk mesin,tapi juga catatan diam dari pikiran manusia yang ingin menciptakan solusi.Setiap kurung yang dibuka harus ditutup.Setiap bug yang muncul adalah tantangan untuk ditaklukkan, bukan musuh yang harus ditakuti. <i class="fa-solid fa-quote-right"></i>                        </p>
                        </p>
                        <div class="flex justify-center gap-4 mt-4 text-gray-600 text-xl">
                          <a href="https://github.com/yusufwahid"><i class="fab fa-github"></i></a>
                          <a href="https://www.instagram.com/wahidd_y?igsh=MWhjcWR1eHY3OXo5ag=="><i class="fab fa-instagram"></i></a>
                        </div>
                      </div>
                    <!-- Kartu Profil 1 (Naik) -->
                    <div class="relative bg-white rounded-[212px] w-48 pt-10 text-center py-12 px-3 shadow-lg lg:mt-0 lg:mb-40 flex flex-col justify-between min-h-[460px]">
                    <h2 class="text-xl font-bold">Nandana Zada Abiproya</h2>
                        <p class="text-sm text-gray-500 mb-4">Frontend Developer</p>
                        <div class="w-full h-48 rounded-[212px] overflow-hidden mb-4">
                          <img src="img/zada.jpg" alt="Nandana Zada Abiproya" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-gray-600"><i class="fa-solid fa-quote-left"></i>
                            Petir bukan sembarang petir.Ada yang mau rumahhnya disambar petir? <i class="fa-solid fa-quote-right"></i>                        </p>
                        </p>
                        <div class="flex justify-center gap-4 mt-4 text-gray-600 text-xl">
                        <a href="https://github.com/nandanazadaa"><i class="fab fa-github"></i></a>
                        <a href="https://www.instagram.com/zada.abiproya/?hl=en"><i class="fab fa-instagram"></i></a>
                        </div>
                      </div>

                    <!-- Kartu Profil 2 (Turun) -->
                    <div class="relative bg-white rounded-[212px] w-48 pt-10 text-center py-12 px-3 shadow-lg lg:mt-40 flex flex-col justify-between min-h-[460px]">
                        <h2 class="text-xl font-bold">Muhammad Zayga Ernesto</h2>
                        <p class="text-sm text-gray-500 mb-4">Frontend Developer</p>
                        <div class="w-full h-48 rounded-[212px] overflow-hidden mb-4">
                          <img src="img/zayga.jpg" alt="Muhammad Zayga Ernesto" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-gray-600"><i class="fa-solid fa-quote-left"></i>
                        Belajarku bukan dari buku besar, tapi dari error kecil yang muncul tiap malam. Aku anak hasil eksperimen: antara niat, koneksi Wi-Fi, dan tutorial berdurasi 2x speed. <i class="fa-solid fa-quote-right"></i>                  </p>
                        </p>
                        <div class="flex justify-center gap-4 mt-4 text-gray-600 text-xl">
                        <a href="https://github.com/ZaygaErnesto"><i class="fab fa-github"></i></a>
                        <a href="https://www.instagram.com/zaygaernesto/?hl=en"><i class="fab fa-instagram"></i></a>
                        </div>
                      </div>

                    <!-- Kartu Profil 3 (Naik) -->

                    <div class="relative bg-white rounded-[212px] w-48 pt-10 text-center py-12 px-3 shadow-lg lg:mt-0 lg:mb-40 flex flex-col justify-between min-h-[460px]">
                    <h2 class="text-xl font-bold">Ikhsanudin</h2>
                        <p class="text-sm text-gray-500 mb-4">Frontend Developer</p>
                        <div class="w-full h-48 rounded-[212px] overflow-hidden mb-4">
                          <img src="img/ikhsan.jpg" alt="Ikhsanudin" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-gray-600"><i class="fa-solid fa-quote-left"></i>
                        Jadilah Orang Pengembang sistem,Kalau tidak mau tergerus Oleh Sistem. <i class="fa-solid fa-quote-right"></i>                  </p>
                        </p>
                        <div class="flex justify-center gap-4 mt-4 text-gray-600 text-xl">
                        <a href="https://github.com/ikhsanudin017"><i class="fab fa-github"></i></a>
                        <a href="https://www.instagram.com/i_can017/?hl=en"><i class="fab fa-instagram"></i></a>
                        </div>
                      </div>

                      <div class="relative bg-white rounded-[212px] w-48 pt-10 text-center py-12 px-3 shadow-lg lg:mt-40 flex flex-col justify-between min-h-[460px]">
                      <h2 class="text-xl font-bold">Akbar Rizqy Effendi</h2>
                        <p class="text-sm text-gray-500 mb-4">Frontend Developer</p>
                        <div class="w-full h-48 rounded-[212px] overflow-hidden mb-4">
                          <img src="img/akbar.jpg" alt="Akbar Rizqy Effendi" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-gray-600"><i class="fa-solid fa-quote-left"></i>
                        Menjadi programmer bukan sekadar menulis baris kode. Ini tentang memecahkan masalah, gagal berkali-kali, lalu bangkit lagi dengan solusi yang lebih baik. <i class="fa-solid fa-quote-right"></i></p>
                        <div class="flex justify-center gap-4 mt-4 text-gray-600 text-xl">
                        <a href="https://github.com/RizqyAkbar"><i class="fab fa-github"></i></a>
                        <a href="https://www.instagram.com/rizqyme/?hl=en"><i class="fab fa-instagram"></i></a>
                        </div>
                      </div>

                  </div>
                </div>
              </section>
              <div class="bg-blue-500 wave-section">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave-svg" preserveAspectRatio="none">
              <path fill="#ffffff" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,149.3C1120,160,1280,128,1360,112L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
          </svg>
      </div>
        </div>
    </div>
@endsection
