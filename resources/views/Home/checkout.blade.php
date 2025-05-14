@extends('layouts.app') {{-- Pastikan layout utama Anda --}}

@section('title', 'Checkout - PhoneKu') {{-- Judul Halaman --}}

@section('content') {{-- Sesuaikan dengan section content di layout Anda --}}

<div class="bg-gray-50 min-h-screen py-8"> {{-- Tambah min-h-screen dan padding --}}
    <!-- Main Content -->
    <main class="container mx-auto px-4 pb-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-5">Checkout</h1>

        {{-- Tampilkan pesan jika keranjang kosong atau tidak ada item valid untuk checkout --}}
             <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                 <p class="text-gray-500 text-xl mb-4">Tidak ada item di keranjang Anda yang bisa dicheckout.</p>
                 <a href="{{ route('allproduct') }}" class="mt-6 inline-block bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition font-medium">
                     Mulai Belanja
                 </a>
             </div>
            {{-- Tampilkan konten checkout jika ada item valid --}}
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left Column: Address & Product -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg text-gray-500 font-medium uppercase">ALAMAT PENGIRIMAN</h2>
                        </div>
                        <div class="p-4">
                            {{-- TODO: Tampilkan alamat user secara dinamis di sini --}}
                            {{-- Anda perlu mengambil alamat user (misalnya alamat default) dari Controller --}}
                            <div class="flex items-center mb-4">
                                <div class="text-blue-500 mr-3 text-xl"> {{-- Gunakan warna blue-500 --}}
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                {{-- Contoh data statis (GANTI INI DENGAN DATA DINAMIS DARI USER/ALAMAT) --}}
                                <span class="font-semibold text-gray-800" id="checkout-address-label-name">Rumah | Zaada</span>
                            </div>
                            <p class="text-gray-700 ml-9" id="checkout-address-full">
                                {{-- Contoh Alamat Lengkap Statis (GANTI INI DENGAN DATA DINAMIS) --}}
                                Warung Mbak Sri Zada, Jalan Jogja Ring Road Selatan, Menayu Lor, Tirtonirmolo, Kasihan,<br>
                                Kabupaten Bantul, Daerah Istimewa Yogyakarta, 55184
                            </p>
                             <p class="text-gray-700 ml-9 mt-1" id="checkout-address-phone">
                                 {{-- Contoh Nomer HP Statis (GANTI INI DENGAN DATA DINAMIS) --}}
                                 Telp: 089537913264
                             </p>
                            <div class="mt-4 ml-9">
                                <button type="button" id="changeAddressBtn" class="px-4 py-1 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition font-medium">Ganti</button>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Produk yang di Checkout -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                         <div class="p-4 border-b border-gray-200 bg-gray-50">
                             <h2 class="text-lg text-gray-500 font-medium uppercase">PRODUK DI PESAN</h2>
                         </div>
                         <div class="p-4 space-y-6">
                            {{-- *** LOOPING ITEM CART YANG VALID UNTUK CHECKOUT (DATA DINAMIS) *** --}}
                            
                                <!-- Item Produk -->
                                <div class="flex flex-col md:flex-row items-start {}">
                                    <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                         {{-- Gunakan asset('storage/') untuk gambar produk --}}
                                        <img src="{{ 'https://via.placeholder.com/100x100' }}"
                                             alt="{}" class="w-24 h-auto object-contain rounded-lg"> {{-- Ukuran gambar disesuaikan --}}
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Nama Produk</h3> 
                                        {{-- Detail produk lain (warna/varian) jika ada --}}
                                        {{-- <div class="text-sm text-gray-600 mb-2">Warna</div>
                                        {{-- Kuantitas item --}}
                                         <div class="text-sm text-gray-600 mb-2">Kuantitas</div>
                                        {{-- Ringkasan Fitur (opsional, sesuai kode lama Anda) --}}
                                         {{-- Jika deskripsi bisa diparse menjadi fitur --}}
                                         {{-- <div class="text-gray-700 text-xs">
                                         </div> --}}
                                    </div>
                                    <div class="flex-shrink-0 text-right mt-4 md:mt-0 md:ml-auto"> {{-- ML Auto untuk dorong ke kanan di md+ --}}
                                        {{-- Harga Subtotal per item (Harga Satuan * Kuantitas) --}}
                                        <div class="font-bold text-lg text-gray-800">Rp</div>
                                    </div>
                                </div>
                            
                            {{-- *** END LOOPING ITEM CART *** --}}
                         </div>
                    </div>
                </div>

                <!-- Right Column: Payment & Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                        {{-- Metode Pembayaran --}}
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold mb-4 text-gray-800">Metode Pembayaran</h2>

                            {{-- --- Daftar Metode Pembayaran (sesuai kode Anda) --- --}}
                            <div class="mb-4">
                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-gopay">
                                    <div class="flex items-center">
                                        <div class="radio-circle mr-3">
                                            <input type="radio" name="payment" id="payment-gopay" class="sr-only payment-radio" value="gopay">
                                            <span class="radio-custom"></span>
                                        </div>
                                        <img src="{{ asset('img/gopay.png') }}" alt="GoPay" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                        <div>
                                            <div class="font-medium text-gray-800">Gopay</div>
                                            <div class="text-xs text-gray-500">Mudah, cepat dan aman</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer payment-option" for="payment-alfamart">
                                    <div class="flex items-center">
                                        <div class="radio-circle mr-3">
                                            <input type="radio" name="payment" id="payment-alfamart" class="sr-only payment-radio" value="alfamart" checked>
                                            <span class="radio-custom"></span>
                                        </div>
                                        <img src="{{ asset('img/Alfamart.png') }}" alt="Alfamart" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                        <div>
                                            <div class="font-medium text-gray-800">Alfamart / Alfamidi / Lawson / Dan+Dan</div>
                                            <div class="text-xs text-gray-500">Langsung setor di cabang mana saja</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-indomaret">
                                    <div class="flex items-center">
                                        <div class="radio-circle mr-3">
                                            <input type="radio" name="payment" id="payment-indomaret" class="sr-only payment-radio" value="indomaret">
                                            <span class="radio-custom"></span>
                                        </div>
                                        <img src="{{ asset('img/indomaret.png') }}" alt="Indomaret" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                        <div>
                                            <div class="font-medium text-gray-800">Indomaret</div>
                                            <div class="text-xs text-gray-500">Langsung setor di cabang mana saja</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- Expanded Payment Methods (toggle with JS) --}}
                            <div class="payment-methods-expanded" id="expandedPaymentMethods">
                                <!-- BCA Option -->
                                <div class="mb-4">
                                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-bca">
                                        <div class="flex items-center">
                                            <div class="radio-circle mr-3">
                                                <input type="radio" name="payment" id="payment-bca" class="sr-only payment-radio" value="bca">
                                                <span class="radio-custom"></span>
                                            </div>
                                            <img src="{{ asset('img/bca.png') }}" alt="BCA" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                            <div>
                                                <div class="font-medium text-gray-800">Bank BCA</div>
                                                <div class="text-xs text-gray-500">Bayar melalui transfer BCA</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- BNI Option -->
                                <div class="mb-4">
                                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-bni">
                                        <div class="flex items-center">
                                            <div class="radio-circle mr-3">
                                                <input type="radio" name="payment" id="payment-bni" class="sr-only payment-radio" value="bni">
                                                <span class="radio-custom"></span>
                                            </div>
                                            <img src="{{ asset('img/bni.png') }}" alt="BNI" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                            <div>
                                                <div class="font-medium text-gray-800">Bank BNI</div>
                                                <div class="text-xs text-gray-500">Bayar melalui transfer BNI</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- OVO Option -->
                                <div class="mb-4">
                                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-ovo">
                                        <div class="flex items-center">
                                            <div class="radio-circle mr-3">
                                                <input type="radio" name="payment" id="payment-ovo" class="sr-only payment-radio" value="ovo">
                                                <span class="radio-custom"></span>
                                            </div>
                                            <img src="{{ asset('img/ovo.png') }}" alt="OVO" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                            <div>
                                                <div class="font-medium text-gray-800">OVO</div>
                                                <div class="text-xs text-gray-500">Bayar dengan saldo OVO</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Dana Option -->
                                <div class="mb-4">
                                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-dana">
                                        <div class="flex items-center">
                                            <div class="radio-circle mr-3">
                                                <input type="radio" name="payment" id="payment-dana" class="sr-only payment-radio" value="dana">
                                                <span class="radio-custom"></span>
                                            </div>
                                            <img src="{{ asset('img/dana.png') }}" alt="DANA" class="h-6 mr-3"> {{-- Gunakan asset() --}}
                                            <div>
                                                <div class="font-medium text-gray-800">DANA</div>
                                                <div class="text-xs text-gray-500">Bayar dengan saldo DANA</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="togglePaymentMethods" class="text-blue-500 text-sm flex items-center justify-center w-full hover:text-blue-700 transition"> {{-- Warna teks disesuaikan --}}
                                    <span id="togglePaymentText">Lihat Semua</span>
                                    <i class="fas fa-chevron-down ml-1" id="togglePaymentIcon"></i>
                                </button>
                            </div>
                        </div> {{-- Akhir Metode Pembayaran --}}


                        {{-- Voucher Section --}}
                        <div class="p-4 border-b border-gray-200">
                            <button type="button" id="openVoucherModal" class="flex items-center justify-between w-full bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                                <span class="font-medium text-gray-800" id="selectedVoucherText">Pilih Voucher Anda</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                        </div> {{-- Akhir Voucher Section --}}


                        <!-- Order Summary -->
                        <div class="p-4">
                            <h2 class="text-lg font-bold mb-4 text-gray-800">Ringkasan Transaksi</h2>
                            <div class="space-y-2 mb-4 text-gray-700">
                                <div class="flex justify-between">
                                    {{-- *** GUNAKAN VARIABEL DARI CONTROLLER *** --}}
                                    <span>Total Harga </span> 
                                    <span>Rp</span> {{-- Gunakan variabel subtotal dari controller --}}
                                </div>
                                <div class="flex justify-between">
                                    <span>Total Ongkos Kirim</span>
                                    {{-- *** GUNAKAN VARIABEL DARI CONTROLLER *** --}}
                                    <span>Rp</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Jasa Aplikasi</span>
                                     {{-- *** GUNAKAN VARIABEL DARI CONTROLLER *** --}}
                                    <span>Rp</span>
                                </div>
                            </div>

                            {{-- Bagian Diskon Voucher (akan diatur oleh JS) --}}
                            {{-- Default hidden, akan muncul jika voucher diaplikasikan --}}
                            <div class="flex justify-between text-green-600 font-semibold" id="voucher-discount-row" style="display: none;">
                                <span>Diskon Voucher</span>
                                <span id="voucher-discount-amount">- Rp 0</span> {{-- Nilai awal, diubah JS --}}
                            </div>

                            <div class="flex justify-between font-bold text-xl pt-4 border-t border-gray-200 text-gray-800">
                                <span>Total Tagihan</span>
                                {{-- *** GUNAKAN VARIABEL DARI CONTROLLER *** --}}
                                <span id="total-amount">Rp</span> 
                            </div>

                            {{-- Tombol Bayar Sekarang --}}
                             {{-- Anda perlu form POST di sini untuk mengirim data pesanan ke backend --}}
                             {{-- Untuk saat ini, biarkan type="button" sampai logic proses pembayaran dibuat --}}
                            <button type="button" class="w-full bg-blue-500 text-white rounded-lg py-3 mt-6 font-bold hover:bg-blue-600 transition">
                                Bayar Sekarang
                            </button>
                            <p class="text-gray-500 text-xs text-center mt-3">
                                Dengan melanjutkan pembayaran, kamu menyetujui S&K yang berlaku
                            </p>
                        </div> {{-- Akhir Ringkasan Pesanan --}}

                    </div> {{-- Akhir Ringkasan & Pembayaran Column --}}
                </div> {{-- Akhir Right Column --}}
            </div> {{-- Akhir Flex lg:flex-row --}}
    </main> {{-- Akhir Main Content --}}

    <!-- Voucher Modal -->
    {{-- Kode Modal Voucher Anda (tetap sama, tapi sesuaikan data attribute voucher) --}}
    <div id="voucherModal" class="modal">
        <div class="modal-content" style="max-width: 500px"> {{-- Hapus class modal-fade di sini, tambahkan via JS --}}
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-medium text-gray-800">Pilih Voucher</h2>
                <button type="button" id="closeVoucherModal" class="text-gray-500 hover:text-gray-700 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-4">
                <div class="mb-4">
                    <div class="relative">
                        {{-- Input Kode Voucher --}}
                        <input type="text" placeholder="Masukkan kode voucher" class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                            Pakai
                        </button>
                    </div>
                </div>

                <div class="my-4">
                    <h3 class="font-medium text-gray-800">Voucher PhoneKu</h3>

                    <!-- Voucher List -->
                    <div class="space-y-3 mt-3">
                        {{-- Data attribute data-value, data-min-spend, data-max-discount akan dibaca oleh JS --}}
                        <!-- Voucher 1 (Diskon Tetap) -->
                        <div>
                            <input type="radio" name="voucher" id="voucher-1" class="sr-only voucher-radio" value="voucher-1" data-type="fixed_discount" data-value="100000" data-min-spend="1000000">
                            <label for="voucher-1" class="block">
                                <div class="voucher-item rounded-lg p-3 cursor-pointer">
                                    <div class="flex items-start">
                                        <div class="text-blue-500 text-xl mr-3 mt-1 flex-shrink-0">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="font-medium text-gray-800">Diskon Rp 100.000</div>
                                            <div class="text-sm text-gray-600">Min. belanja Rp 1.000.000</div>
                                            <div class="mt-1 text-xs text-gray-500">Berlaku hingga 30 April 2025</div>
                                        </div>
                                        <div class="ml-3 flex-shrink-0">
                                            <div class="h-5 w-5 border-2 border-gray-300 rounded-full flex items-center justify-center voucher-radio-circle">
                                                <div class="h-3 w-3 bg-blue-500 rounded-full hidden voucher-radio-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Voucher 2 (Gratis Ongkir) -->
                        <div>
                            <input type="radio" name="voucher" id="voucher-2" class="sr-only voucher-radio" value="voucher-2" data-type="shipping_discount" data-value="{{ $shippingCost ?? 0 }}" data-min-spend="500000"> {{-- Gunakan variabel shippingCost dari Controller --}}
                            <label for="voucher-2" class="block">
                                <div class="voucher-item rounded-lg p-3 cursor-pointer">
                                    <div class="flex items-start">
                                        <div class="text-blue-500 text-xl mr-3 mt-1 flex-shrink-0">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="font-medium text-gray-800">Gratis Ongkir</div>
                                            <div class="text-sm text-gray-600">Min. belanja Rp 500.000</div>
                                            <div class="mt-1 text-xs text-gray-500">Berlaku hingga 20 April 2025</div>
                                        </div>
                                        <div class="ml-3 flex-shrink-0">
                                            <div class="h-5 w-5 border-2 border-gray-300 rounded-full flex items-center justify-center voucher-radio-circle">
                                                <div class="h-3 w-3 bg-blue-500 rounded-full hidden voucher-radio-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Voucher 3 (Diskon Persentase) -->
                        <div>
                            <input type="radio" name="voucher" id="voucher-3" class="sr-only voucher-radio" value="voucher-3" data-type="percentage_discount" data-value="0.10" data-max-discount="200000" data-min-spend="0"> {{-- data-value adalah persentase dalam desimal --}}
                            <label for="voucher-3" class="block">
                                <div class="voucher-item rounded-lg p-3 cursor-pointer">
                                    <div class="flex items-start">
                                        <div class="text-blue-500 text-xl mr-3 mt-1 flex-shrink-0">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="font-medium text-gray-800">Diskon 10%</div>
                                            <div class="text-sm text-gray-600">Maks. diskon Rp 200.000</div>
                                            <div class="mt-1 text-xs text-gray-500">Berlaku hingga 15 April 2025</div>
                                        </div>
                                        <div class="ml-3 flex-shrink-0">
                                            <div class="h-5 w-5 border-2 border-gray-300 rounded-full flex items-center justify-center voucher-radio-circle">
                                                <div class="h-3 w-3 bg-blue-500 rounded-full hidden voucher-radio-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                         {{-- Tambahkan voucher lain di sini --}}

                         <!-- Opsi Tidak Menggunakan Voucher -->
                         <div>
                            <input type="radio" name="voucher" id="voucher-none" class="sr-only voucher-radio" value="none" checked> {{-- Default terpilih --}}
                            <label for="voucher-none" class="block">
                                <div class="voucher-item rounded-lg p-3 cursor-pointer">
                                    <div class="flex items-start">
                                         <div class="h-5 w-5 flex-shrink-0 mr-3"></div> {{-- Placeholder untuk align --}}
                                        <div class="flex-grow">
                                            <div class="font-medium text-gray-800">Tidak Pakai Voucher</div>
                                            <div class="text-sm text-gray-600">Lanjutkan tanpa voucher</div>
                                        </div>
                                        <div class="ml-3 flex-shrink-0">
                                            <div class="h-5 w-5 border-2 border-gray-300 rounded-full flex items-center justify-center voucher-radio-circle">
                                                <div class="h-3 w-3 bg-blue-500 rounded-full hidden voucher-radio-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="button" id="applyVoucherBtn" class="w-full py-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600 transition mt-4">
                    Pakai Voucher
                </button>
            </div>
        </div>
    </div> {{-- Akhir Modal Voucher --}}


    <!-- Address Modal -->
    {{-- Kode Modal Alamat Anda (tetap sama, sedikit penyesuaian ID back button) --}}
    <div id="addressModal" class="modal">
        <div class="modal-content"> {{-- Hapus class modal-fade di sini --}}
            <!-- Main Address Modal (Daftar Alamat) -->
            <div id="mainAddressModal">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-medium text-gray-800">Daftar Alamat</h2>
                    <button type="button" id="closeAddressModal" class="text-gray-500 hover:text-gray-700 text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="flex border-b">
                        {{-- Tab Semua Alamat (jika ada fitur tab) --}}
                        <button type="button" id="allAddressTab" class="flex-1 py-3 text-center active-tab font-medium">Semua Alamat</button>
                        {{-- <button type="button" id="myAddressTab" class="flex-1 py-3 text-center text-gray-500 hover:text-gray-700 font-medium">Alamat Saya</button> --}}
                    </div>

                    <div class="my-4">
                        <div class="relative">
                            <input type="text" placeholder="Tulis Nama Alamat / Kota / Kecamatan tujuan pengiriman" class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <div class="my-4">
                        <button type="button" id="addNewAddressBtn" class="w-full py-3 border-2 border-blue-500 text-blue-500 rounded-lg font-bold hover:bg-blue-50 transition">
                            Tambah Alamat Baru
                        </button>
                    </div>

                    <!-- Address List -->
                    {{-- TODO: Ini perlu looping dari data alamat user --}}
                    {{-- Anda perlu mengambil daftar alamat user dari Controller dan melooping di sini --}}
                    <div class="border rounded-lg my-4 relative p-4 cursor-pointer hover:bg-gray-50 transition"> {{-- Tambahkan kelas interaksi --}}
                         {{-- Radio button untuk memilih alamat --}}
                        <input type="radio" name="selected_address" id="address-1" class="sr-only address-radio" checked>
                        <label for="address-1" class="block w-full h-full absolute inset-0 cursor-pointer"></label> {{-- Label overlay --}}

                        <div class="flex items-center">
                            <div class="font-semibold mr-2 text-gray-800">Rumah</div>
                            <div class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Utama</div> {{-- Primary tag --}}
                        </div>
                        <div class="font-medium mt-1 text-gray-800">Zaada</div> {{-- Nama Penerima --}}
                        <div class="text-gray-600 mt-1">089537913264</div> {{-- Nomor HP --}}
                        <div class="text-gray-700 mt-1">Warung Mbak sri zada Menayu Kulon Tirtonirmolo kasihan, Bantul, Daerah Istimewa Yogyakarta, 55184</div> {{-- Alamat Lengkap --}}

                        <div class="mt-3 flex justify-between text-sm">
                            <button type="button" class="text-gray-600 hover:text-gray-800">Share</button>
                            <button type="button" class="text-gray-600 hover:text-gray-800">Ubah Alamat</button>
                        </div>

                        {{-- Selected checkmark --}}
                        <div class="absolute top-4 right-4 text-blue-500 address-selected-icon"> {{-- Warna disesuaikan --}}
                            <i class="fas fa-check-circle text-xl"></i> {{-- Icon disesuaikan --}}
                        </div>
                    </div>

                    {{-- Contoh Alamat Lain --}}
                     <div class="border rounded-lg my-4 relative p-4 cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="selected_address" id="address-2" class="sr-only address-radio">
                        <label for="address-2" class="block w-full h-full absolute inset-0 cursor-pointer"></label>
                         <div class="font-semibold mr-2 text-gray-800">Kantor</div>
                         <div class="font-medium mt-1 text-gray-800">Budi Santoso</div>
                         <div class="text-gray-600 mt-1">081234567890</div>
                         <div class="text-gray-700 mt-1">Jl. Merdeka No. 12, Gedung A, Lantai 5, Jakarta Pusat, DKI Jakarta, 10110</div>
                         <div class="mt-3 flex justify-between text-sm">
                             <button type="button" class="text-gray-600 hover:text-gray-800">Share</button>
                             <button type="button" class="text-gray-600 hover:text-gray-800">Ubah Alamat</button>
                         </div>
                         <div class="absolute top-4 right-4 text-gray-300 address-selected-icon"> {{-- Icon tidak aktif --}}
                            <i class="fas fa-check-circle text-xl"></i>
                         </div>
                     </div>
                     {{-- End Address List --}}

                </div> {{-- Akhir p-4 Main Address Modal --}}
            </div> {{-- Akhir Main Address Modal --}}

            <!-- Add New Address Modal (Cari Lokasi) -->
            {{-- Kode Modal Tambah Alamat Anda (tetap sama) --}}
            <div id="addAddressModal" style="display: none;">
                <div class="flex items-center p-4 border-b">
                    <button type="button" id="backToAddAddress" class="mr-4 text-gray-600 hover:text-gray-800 text-xl">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h2 class="text-xl font-medium text-gray-800">Tambah Alamat Baru</h2>
                    <button type="button" id="closeAddNewModal" class="ml-auto text-gray-500 hover:text-gray-700 text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-4">
                    <!-- Progress steps -->
                    <div class="flex items-center justify-between mb-6 text-sm">
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">1</div>
                            <div class="text-xs text-blue-500 text-center">Cari lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-1"></div> {{-- Jarak antar step disesuaikan --}}
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-white text-blue-500 border-2 border-blue-500 flex items-center justify-center mb-1">2</div>
                            <div class="text-xs text-gray-500 text-center">Tentukan pinpoint</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-1"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-1">3</div>
                            <div class="text-xs text-gray-500 text-center">Lengkapi detail</div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Di mana lokasi tujuan pengirimanmu?</h3>

                    <div class="relative mb-4">
                        {{-- Input untuk mencari lokasi awal --}}
                        <input type="text" placeholder="Tulis nama jalan / gedung / perumahan" id="location-search-input" class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <button type="button" id="useCurrentLocationBtn" class="w-full py-3 border border-gray-300 text-gray-700 rounded-lg flex items-center justify-center mb-4 hover:bg-gray-100 transition font-medium">
                        <i class="fas fa-crosshairs mr-2"></i>
                        <span>Gunakan Lokasi Saat Ini</span>
                    </button>

                </div> {{-- Akhir p-4 Add New Address Modal --}}
            </div> {{-- Akhir Add New Address Modal --}}

            <!-- Pinpoint Location Modal (Tentukan Titik) -->
            {{-- Kode Modal Pinpoint Anda (tetap sama, sedikit penyesuaian ID back button) --}}
            <div id="pinpointModal" style="display: none;">
                <div class="flex items-center p-4 border-b">
                    <button type="button" id="backToPinpointStep" class="mr-4 text-gray-600 hover:text-gray-800 text-xl"> {{-- ID diubah --}}
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h2 class="text-xl font-medium text-gray-800">Tambah Alamat Baru</h2>
                    <button type="button" id="closePinpointModal" class="ml-auto text-gray-500 hover:text-gray-700 text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-4">
                    <!-- Progress steps -->
                     <div class="flex items-center justify-between mb-6 text-sm">
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500 text-center">Cari lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-1"></div> {{-- Warna progress bar disesuaikan --}}
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">2</div>
                            <div class="text-xs text-blue-500 text-center">Tentukan pinpoint</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-1"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-1">3</div>
                            <div class="text-xs text-gray-500 text-center">Lengkapi detail</div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Tentukan titik pinpoint lokasi kamu</h3>

                    <!-- Map container with search box -->
                    <div class="map-container mb-4 relative">

                        {{-- Input search overlay di atas peta --}}
                        <input type="text" placeholder="Cari lokasi di peta..." class="map-search-box focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400" id="map-search-input-overlay"> {{-- ID diubah --}}

                        <!-- This div will contain the Leaflet Map -->
                        <div id="map"></div>

                        <!-- Pinpoint marker fixed in center -->
                        <div class="pinpoint-marker">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <!-- Map controls -->
                        <div class="map-controls">
                            <button type="button" id="recenter-button" class="map-control-button hover:bg-gray-100 transition">
                                <i class="fas fa-crosshairs"></i>
                            </button>
                            <button type="button" id="zoom-in-button" class="map-control-button hover:bg-gray-100 transition">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" id="zoom-out-button" class="map-control-button hover:bg-gray-100 transition">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Informasi lokasi yang dipilih --}}
                    <div id="selected-location" class="bg-gray-100 rounded-lg p-4 mb-4 text-gray-800" data-address="" data-lat="" data-lng="">
                        <div id="location-area" class="font-semibold">Mencari lokasi...</div>
                        <div id="location-detail" class="text-sm text-gray-600">Mohon tunggu...</div>
                    </div>

                    <div class="bg-blue-100 rounded-lg p-4 mb-6 text-blue-800"> {{-- Warna disesuaikan --}}
                        <div class="font-semibold">Nama lokasi tidak sesuai alamatmu?</div>
                        <div class="text-sm text-blue-700">Tenang, kamu akan isi alamat nanti. Pastikan pinpoint sudah sesuai dulu.</div>
                    </div>

                    <button type="button" id="continueToDetailsBtn" class="w-full py-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600 transition">
                        Pilih Lokasi & Lanjut Isi Alamat
                    </button>
                </div> {{-- Akhir p-4 Pinpoint Modal --}}
            </div> {{-- Akhir Pinpoint Location Modal --}}

            <!-- Complete Address Details Modal (Lengkapi Detail) -->
            {{-- Kode Modal Detail Alamat Anda (tetap sama) --}}
            <div id="addressDetailsModal" style="display: none;">
                <div class="flex items-center p-4 border-b">
                    <button type="button" id="backToPinpoint" class="mr-4 text-gray-600 hover:text-gray-800 text-xl">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h2 class="text-xl font-medium text-gray-800">Tambah Alamat Baru</h2>
                    <button type="button" id="closeDetailsModal" class="ml-auto text-gray-500 hover:text-gray-700 text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-4">
                    <!-- Progress steps -->
                    <div class="flex items-center justify-between mb-6 text-sm">
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500 text-center">Cari lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-1"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500 text-center">Tentukan pinpoint</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-1"></div> {{-- Warna progress bar disesuaikan --}}
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">3</div> {{-- Step 3 aktif --}}
                            <div class="text-xs text-blue-500 text-center">Lengkapi detail</div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Lengkapi detail alamat</h3>

                    {{-- Info Lokasi dari Pinpoint --}}
                    <div class="mb-4">
                        <div class="mb-2 font-medium text-gray-800">Lokasi Pinpoint</div>
                        <div class="flex items-center border border-gray-300 rounded-lg p-3 bg-gray-50 text-gray-700">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-3 text-lg flex-shrink-0"></i>
                            <span id="details-pinpoint-location" class="flex-grow"></span> {{-- Akan diisi JS --}}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-800" for="addressLabel">Label Alamat</label>
                        <input type="text" id="addressLabel" placeholder="Contoh: Rumah, Kantor, Apartemen" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="addressLabelCount">0</span>/30</div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-800" for="fullAddress">Alamat Lengkap</label>
                        <textarea id="fullAddress" rows="4" placeholder="Nama Jalan, Nomor Bangunan/Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos" class="w-full p-3 border rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400"></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="fullAddressCount">0</span>/200</div>
                    </div>

                     {{-- Catatan untuk Kurir (Opsional) --}}
                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-800" for="courierNotes">Catatan Untuk Kurir <span class="font-normal text-gray-500">(Opsional)</span></label>
                        <textarea id="courierNotes" rows="3" placeholder="Contoh: Rumah cat hijau, dekat pos ronda, titip satpam" class="w-full p-3 border rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400"></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="courierNotesCount">0</span>/45</div>
                    </div>


                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-800" for="recipientName">Nama Penerima</label>
                        <input type="text" id="recipientName" placeholder="Contoh: Budi Santoso" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="recipientNameCount">0</span>/50</div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-800" for="phoneNumber">Nomor HP</label>
                        <div class="relative">
                            <input type="tel" id="phoneNumber" placeholder="Contoh: 0812xxxxxxxx" class="w-full p-3 border rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400"> {{-- Tambah padding-right --}}
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"> {{-- Tombol kontak --}}
                                <i class="fas fa-address-book"></i>
                            </button>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="phoneNumberCount">0</span>/15</div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center text-gray-700 text-sm"> {{-- Ukuran font disesuaikan --}}
                            <input type="checkbox" id="primaryAddress" class="mr-2 h-4 w-4 text-blue-500 focus:ring-blue-400 rounded"> {{-- Warna checkbox & ring --}}
                            <span>Jadikan alamat utama</span>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start text-gray-700 text-sm"> {{-- items-start untuk align di baris pertama --}}
                            <input type="checkbox" id="termsAgreement" class="mr-2 h-4 w-4 text-blue-500 focus:ring-blue-400 rounded mt-1"> {{-- Warna checkbox & ring --}}
                            <span>Saya menyetujui <a href="#" class="text-blue-500 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-500 hover:underline">Kebijakan Privasi</a> pengaturan alamat di PhoneKu.</span>
                        </label>
                    </div>

                    {{-- Tombol Simpan Alamat (default disabled) --}}
                    <button type="button" id="saveAddressBtn" class="w-full py-3 bg-gray-300 text-gray-500 rounded-lg font-bold cursor-not-allowed">
                        Simpan Alamat
                    </button>
                </div> {{-- Akhir p-4 Detail Alamat Modal --}}
            </div> {{-- Akhir Complete Address Details Modal --}}
        </div> {{-- Akhir Modal Content --}}
    </div> {{-- Akhir Address Modal --}}

</div> {{-- Akhir Wrapper div bg-gray-50 --}}

@endsection {{-- Akhir section content --}}


@section('styles')
    @parent {{-- Penting: Jaga agar styles dari layout utama tetap ada --}}
    {{-- Tambahkan atau timpa styles di sini --}}
    <style>
        /* Custom radio button styling (Metode Pembayaran) */
        .radio-circle {
            position: relative;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radio-custom {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #d1d5db; /* gray-300 */
            background-color: white;
            transition: all 0.2s ease;
        }

        .payment-radio:checked + .radio-custom {
            border: 2px solid #3b82f6; /* blue-500 */
        }

        .payment-radio:checked + .radio-custom::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #3b82f6; /* blue-500 */
        }

         /* Style untuk label radio metode pembayaran yang terpilih di-toggle via JS */
        /* .payment-radio:checked ~ label div { /* Target div di dalam label */
        /*
        } */


        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Lebih gelap agar modal lebih jelas */
            z-index: 50; /* Pastikan di atas konten lain */
            overflow-y: auto; /* Scrollable jika konten panjang */
            backdrop-filter: blur(5px); /* Efek blur */
             /* Add smooth transition for background */
            transition: background-color 0.3s ease-out;
        }

        .modal-content {
            background-color: white;
            margin: 8vh auto; /* Margin atas dan bawah */
            width: 95%; /* Lebar responsif */
            max-width: 600px; /* Lebar maksimal */
            border-radius: 0.75rem; /* Border lebih bulat */
            position: relative;
            max-height: 84vh; /* Tinggi maksimal */
            overflow-y: auto; /* Scrollable konten */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow */
            /* Initial state for animation */
            opacity: 0;
            transform: translateY(20px);
        }

        /* Animation state */
        .modal.show .modal-content {
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

         /* Make modal container visible for animation */
         .modal.show {
             display: block;
         }

        /* Map styling (untuk modal alamat) */
        .map-container {
            position: relative;
            height: 300px; /* Tinggi map */
            background-color: #f3f4f6; /* gray-100 */
            overflow: hidden;
            border-radius: 0.5rem;
        }

        #map {
            width: 100%;
            height: 100%;
            z-index: 1; /* Di bawah marker dan kontrol */
        }

        .pinpoint-marker {
            position: absolute;
            top: 50%;
            left: 50%;
            /* Transform disesuaikan agar ujung bawah icon tepat di tengah */
            transform: translate(-50%, -100%);
            color: #3b82f6; /* blue-500 */
            font-size: 2.5rem; /* Ukuran icon lebih besar */
            z-index: 10;
            pointer-events: none; /* Agar tidak menghalangi interaksi map */
            text-shadow: 0px 0px 3px rgba(255, 255, 255, 0.9); /* Outline putih agar jelas di peta gelap */
        }

        .map-search-box {
            position: absolute;
            top: 12px; /* Jarak dari atas */
            left: 12px; /* Jarak dari kiri */
            right: 12px; /* Jarak dari kanan */
            z-index: 10; /* Di atas peta */
            padding: 10px 14px; /* Padding lebih besar */
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); /* Shadow lebih jelas */
            background-color: white;
            font-size: 1rem; /* Ukuran font */
        }

        .map-controls {
            position: absolute;
            bottom: 12px; /* Jarak dari bawah */
            left: 12px; /* Jarak dari kiri */
            z-index: 5; /* Di atas peta, di bawah marker/search */
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .map-control-button {
            width: 36px; /* Ukuran tombol */
            height: 36px; /* Ukuran tombol */
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25); /* Shadow lebih jelas */
            cursor: pointer;
             font-size: 1rem; /* Ukuran icon */
        }

        .map-control-button:active {
            transform: scale(0.95); /* Efek tekan */
        }


        /* Voucher styling */
        .voucher-item {
            border: 1px dashed #d1d5db; /* gray-300 */
            transition: all 0.2s ease;
             position: relative; /* Untuk menempatkan radio circle di dalamnya */
             padding-right: 40px; /* Beri ruang untuk radio circle */
        }

        .voucher-item:hover {
            border-color: #3b82f6; /* blue-500 */
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        }

        /* Style item voucher yang terpilih */
        .voucher-radio:checked + label .voucher-item {
            border: 1px dashed #3b82f6; /* blue-500 */
            background-color: #eff6ff; /* blue-50 */
        }

        /* Style radio button di dalam voucher item */
        .voucher-radio-circle {
             position: absolute;
             top: 50%;
             right: 12px; /* Jarak dari kanan */
             transform: translateY(-50%);
             flex-shrink: 0; /* Jangan ciut */
             background-color: white; /* Background putih */
             height: 20px; /* Sama dengan radio-custom */
             width: 20px;  /* Sama dengan radio-custom */
             border-radius: 50%;
             border: 2px solid #d1d5db; /* gray-300 */
             display: flex;
             align-items: center;
             justify-content: center;
        }
         .voucher-radio:checked + label .voucher-radio-circle {
             border-color: #3b82f6; /* blue-500 */
         }
         .voucher-radio-dot {
             background-color: #3b82f6; /* blue-500 */
             height: 10px; /* Dot size */
             width: 10px; /* Dot size */
             border-radius: 50%;
         }
         .voucher-radio:checked + label .voucher-radio-dot {
             display: block; /* Tampilkan dot jika terpilih */
         }

        /* Checkout product details */
        .check-item {
            display: flex;
            align-items: flex-start; /* Align icon dan teks di awal baris */
            margin-bottom: 8px; /* Sedikit jarak antar item */
            line-height: 1.4; /* Jarak antar baris */
        }

        .check-icon {
            background-color: #22c55e; /* green-500 */
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            flex-shrink: 0; /* Jangan ciut */
            margin-top: 2px; /* Sesuaikan vertical alignment */
             font-size: 0.6rem; /* Ukuran icon centang */
        }

        /* Line clamp utility */
         .line-clamp-2 {
             overflow: hidden;
             display: -webkit-box;
             -webkit-line-clamp: 2;
             -webkit-box-orient: vertical;
         }

        /* Address radio styling in address modal */
         .address-radio:checked + label + div .address-selected-icon {
             color: #3b82f6; /* blue-500 */
         }
         .address-radio + label + div .address-selected-icon {
             color: #d1d5db; /* gray-300 */
         }

         /* Disable button styling */
        button:disabled {
            cursor: not-allowed !important; /* Gunakan !important jika diperlukan */
            opacity: 0.7; /* Tambahkan sedikit opacity */
        }
         /* Override hover for disabled button */
         button:disabled:hover {
             background-color: #d1d5db !important; /* gray-300 */
             color: #9ca3af !important; /* gray-400 */
         }
         /* Specific style for disabled save address button */
         #saveAddressBtn:disabled {
             background-color: #d1d5db !important;
             color: #9ca3af !important;
         }


    </style>
@endsection


@section('scripts')
    @parent {{-- Penting: Jaga agar scripts dari layout utama tetap ada --}}
    {{-- Pastikan SweetAlert2 terinstal atau gunakan CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    {{-- Leaflet Geocoder --}}
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Helper Function for Formatting Rupiah ---
        function formatRupiah(number) {
            if (isNaN(number) || number === null) return 'Rp 0';
            const formatted = parseFloat(number).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return 'Rp' + formatted;
        }

        function parseRupiah(rupiahString) {
             if (!rupiahString) return 0;
             // Remove "Rp ", dots, and commas, then parse as float
             const numberString = rupiahString.replace('Rp ', '').replace(/\./g, '').replace(/,/g, '');
             return parseFloat(numberString) || 0;
         }

        // --- Payment Method Selection ---
        const paymentRadios = document.querySelectorAll('.payment-radio');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active styling from all labels
                document.querySelectorAll('.payment-radio').forEach(r => {
                    r.closest('label').classList.remove('bg-blue-50', 'border-blue-500');
                    r.closest('label').classList.add('hover:bg-gray-50', 'border-gray-200'); // Restore default border
                });

                // Add active styling to the selected label
                if (this.checked) {
                    this.closest('label').classList.add('bg-blue-50', 'border-blue-500');
                    this.closest('label').classList.remove('hover:bg-gray-50', 'border-gray-200');
                }
            });
        });

         // Initialize active styling for the default checked radio on load
        document.querySelectorAll('.payment-radio:checked').forEach(radio => {
             radio.closest('label').classList.add('bg-blue-50', 'border-blue-500');
             radio.closest('label').classList.remove('hover:bg-gray-50', 'border-gray-200');
        });


        // --- Toggle Expanded Payment Methods ---
        const togglePaymentMethodsBtn = document.getElementById('togglePaymentMethods');
        const expandedPaymentMethodsDiv = document.getElementById('expandedPaymentMethods');
        const togglePaymentTextSpan = document.getElementById('togglePaymentText');
        const togglePaymentIconI = document.getElementById('togglePaymentIcon');

        if (togglePaymentMethodsBtn && expandedPaymentMethodsDiv && togglePaymentTextSpan && togglePaymentIconI) {
            togglePaymentMethodsBtn.addEventListener('click', function() {
                const isExpanded = expandedPaymentMethodsDiv.classList.toggle('show');

                if (isExpanded) {
                    togglePaymentTextSpan.textContent = 'Lihat Lebih Sedikit';
                    togglePaymentIconI.classList.remove('fa-chevron-down');
                    togglePaymentIconI.classList.add('fa-chevron-up');
                } else {
                    togglePaymentTextSpan.textContent = 'Lihat Semua';
                    togglePaymentIconI.classList.remove('fa-chevron-up');
                    togglePaymentIconI.classList.add('fa-chevron-down');
                }
            });
        }


        // --- Voucher Modal Functionality ---
        const voucherModal = document.getElementById('voucherModal');
        const openVoucherModalBtn = document.getElementById('openVoucherModal');
        const closeVoucherModalBtn = document.getElementById('closeVoucherModal');
        const applyVoucherBtn = document.getElementById('applyVoucherBtn');
        const voucherRadios = document.querySelectorAll('.voucher-radio');
        const selectedVoucherTextSpan = document.getElementById('selectedVoucherText');
        const voucherDiscountRowDiv = document.getElementById('voucher-discount-row');
        const voucherDiscountAmountSpan = document.getElementById('voucher-discount-amount');
        const totalAmountSpan = document.getElementById('total-amount');


        // Get initial summary values from Blade variables (server-side)
         const initialSubtotal = parseFloat("{{ $subtotal ?? 0 }}");
         const initialShippingCost = parseFloat("{{ $shippingCost ?? 0 }}");
         const initialServiceFee = parseFloat("{{ $serviceFee ?? 0 }}");
         // IMPORTANT: Base total amount should be calculated from backend values, excluding potential backend discounts if any
         const initialTotalAmount = initialSubtotal + initialShippingCost + initialServiceFee; // Recalculate based on base values


        // Function to calculate and update total amount based on applied voucher
        function updateTotalAmount() {
            let currentSubtotal = initialSubtotal; // Start with backend subtotal
            let currentShippingCost = initialShippingCost; // Start with backend shipping cost
            let currentServiceFee = initialServiceFee; // Start with backend service fee
            let discountAmount = 0; // Reset discount
            let voucherAppliedText = 'Tidak Pakai Voucher'; // Default text

             // Get the currently selected voucher radio button
            const selectedRadio = document.querySelector('.voucher-radio:checked');

            // Check if a voucher is selected and it's not the "none" option
            if (selectedRadio && selectedRadio.value !== 'none') {
                 const voucherLabel = selectedRadio.closest('label');
                 voucherAppliedText = voucherLabel.querySelector('.font-medium').textContent; // Get voucher title

                 // Get voucher data from data attributes
                 const voucherType = selectedRadio.dataset.type;
                 const voucherValue = parseFloat(selectedRadio.dataset.value || 0);
                 const minSpend = parseFloat(selectedRadio.dataset.minSpend || 0);
                 const maxDiscount = parseFloat(selectedRadio.dataset.maxDiscount || Infinity); // Use Infinity if no max limit

                 let calculatedDiscount = 0;
                 let minSpendMet = currentSubtotal >= minSpend;

                 if (minSpendMet) {
                     if (voucherType === 'fixed_discount') {
                         calculatedDiscount = voucherValue;
                     } else if (voucherType === 'shipping_discount') {
                          // Apply discount up to the initial shipping cost
                         calculatedDiscount = Math.min(voucherValue, initialShippingCost);
                     } else if (voucherType === 'percentage_discount') {
                         // Apply percentage discount on the subtotal
                         calculatedDiscount = currentSubtotal * voucherValue;
                         // Apply max discount limit
                         calculatedDiscount = Math.min(calculatedDiscount, maxDiscount);
                     }
                 } else {
                     // Minimum spending requirement not met
                      calculatedDiscount = 0;
                     voucherAppliedText += ` (Min. Belanja ${formatRupiah(minSpend)} tidak terpenuhi)`;
                 }

                 discountAmount = calculatedDiscount;

             } else {
                 // 'Tidak Pakai Voucher' is selected or no voucher selected
                 discountAmount = 0;
                 voucherAppliedText = 'Pilih Voucher Anda'; // Reset text if no voucher applied
                 // Ensure the "Tidak Pakai Voucher" radio is checked by default on load
                 // document.getElementById('voucher-none')?.checked = true; // This should be handled by initial blade 'checked' attribute
             }


            // Calculate the final total amount
            // Start with the initial total (Subtotal + Shipping + Service Fee)
            let finalTotal = initialTotalAmount;
            // Subtract the calculated discount
            finalTotal -= discountAmount;

            // Update UI elements
            if (selectedVoucherTextSpan) selectedVoucherTextSpan.textContent = voucherAppliedText;

            // Show or hide discount row and set its value
            if (voucherDiscountAmountSpan) {
                 voucherDiscountAmountSpan.textContent = '- ' + formatRupiah(discountAmount);
            }

            if (discountAmount > 0) {
                 if (voucherDiscountRowDiv) voucherDiscountRowDiv.style.display = 'flex';
                 if (voucherDiscountRowDiv) voucherDiscountRowDiv.classList.remove('text-red-600');
                 if (voucherDiscountRowDiv) voucherDiscountRowDiv.classList.add('text-green-600');
            } else {
                // Hide discount row if discount is 0, UNLESS a voucher with unmet minimum spend was selected
                 const selectedRadioValue = selectedRadio ? selectedRadio.value : 'none';
                 const selectedRadioMinSpend = selectedRadio ? parseFloat(selectedRadio.dataset.minSpend || 0) : 0;

                if (selectedRadioValue !== 'none' && initialSubtotal < selectedRadioMinSpend) {
                     // Voucher selected but min spend not met - show discount row with 0 and make it red
                    if (voucherDiscountRowDiv) {
                         voucherDiscountRowDiv.style.display = 'flex';
                         if (voucherDiscountAmountSpan) voucherDiscountAmountSpan.textContent = formatRupiah(0); // Show 0 discount
                         voucherDiscountRowDiv.classList.remove('text-green-600');
                         voucherDiscountRowDiv.classList.add('text-red-600');
                     }
                } else {
                    // No voucher, or min spend met but discount is 0 anyway, or "Tidak Pakai Voucher"
                    if (voucherDiscountRowDiv) voucherDiscountRowDiv.style.display = 'none';
                }
            }


            if (totalAmountSpan) totalAmountSpan.textContent = formatRupiah(finalTotal);
        }


        // Open voucher modal
        if (openVoucherModalBtn && voucherModal) {
            openVoucherModalBtn.addEventListener('click', function() {
                voucherModal.classList.add('show'); // Use class for animation
                // voucherModal.style.display = 'block'; // Initial display needs to be block before animation
                document.body.style.overflow = 'hidden'; // Prevent scrolling
                 // Re-calculate discount preview when opening modal in case subtotal changed (less common on checkout)
                 updateTotalAmount(); // This updates the selectedVoucherText too
            });
        }

        // Close voucher modal
         function closeVoucherModal() {
              if (voucherModal) {
                voucherModal.classList.remove('show'); // Use class for animation
                // voucherModal.style.display = 'none'; // Actual display none after animation (optional, can use transitionend)
                document.body.style.overflow = ''; // Restore scrolling
             }
         }

        if (closeVoucherModalBtn) {
             closeVoucherModalBtn.addEventListener('click', closeVoucherModal);
        }

        // Apply selected voucher button click handler
        if (applyVoucherBtn) {
            applyVoucherBtn.addEventListener('click', function() {
                updateTotalAmount(); // Calculate and update total based on selection
                closeVoucherModal(); // Close modal
            });
        }

        // Update voucher radio button styling
        if (voucherRadios.length > 0) {
            voucherRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Reset all indicator styles
                    voucherRadios.forEach(r => {
                        const circle = r.closest('label').querySelector('.voucher-radio-circle');
                        const dot = r.closest('label').querySelector('.voucher-radio-dot');
                         if (circle) {
                            circle.classList.remove('border-blue-500');
                             circle.classList.add('border-gray-300');
                         }
                         if (dot) dot.classList.add('hidden');
                    });

                    // Set the style for the selected radio
                    if (this.checked) {
                        const circle = this.closest('label').querySelector('.voucher-radio-circle');
                        const dot = this.closest('label').querySelector('.voucher-radio-dot');
                         if (circle) {
                             circle.classList.remove('border-gray-300');
                             circle.classList.add('border-blue-500');
                         }
                         if (dot) dot.classList.remove('hidden');
                    }
                    // Update the preview text and discount amount in the modal live
                    updateTotalAmount(); // Recalculate and update UI in modal
                });
            });

             // Initialize the selected voucher styling and total calculation on page load
            const initialSelectedVoucher = document.querySelector('.voucher-radio:checked');
            if (initialSelectedVoucher) {
                 const circle = initialSelectedVoucher.closest('label').querySelector('.voucher-radio-circle');
                 const dot = initialSelectedVoucher.closest('label').querySelector('.voucher-radio-dot');
                 if (circle) {
                     circle.classList.remove('border-gray-300');
                     circle.classList.add('border-blue-500');
                 }
                 if (dot) dot.classList.remove('hidden');
            }

            // Also call updateTotalAmount on load to set the initial summary price based on the default checked voucher (or none)
            updateTotalAmount();

        } // End if voucherRadios.length > 0



        // --- Address Modal Functionality ---
        const addressModal = document.getElementById('addressModal');
        const mainAddressModal = document.getElementById('mainAddressModal'); // Daftar Alamat
        const addAddressModal = document.getElementById('addAddressModal'); // Cari Lokasi
        const pinpointModal = document.getElementById('pinpointModal'); // Tentukan Pinpoint
        const addressDetailsModal = document.getElementById('addressDetailsModal'); // Lengkapi Detail

        const changeAddressBtn = document.getElementById('changeAddressBtn');
        const closeAddressModalBtn = document.getElementById('closeAddressModal');
        const addNewAddressBtn = document.getElementById('addNewAddressBtn');
        const closeAddNewModalBtn = document.getElementById('closeAddNewModal'); // Close button on 'Cari Lokasi' modal
        const useCurrentLocationBtn = document.getElementById('useCurrentLocationBtn');
        const backToAddAddressBtn = document.getElementById('backToAddAddress'); // Back button on 'Pinpoint' modal
        const closePinpointModalBtn = document.getElementById('closePinpointModal'); // Close button on 'Pinpoint' modal
        const continueToDetailsBtn = document.getElementById('continueToDetailsBtn'); // Continue button on 'Pinpoint' modal
        const backToPinpointBtn = document.getElementById('backToPinpoint'); // Back button on 'Lengkapi Detail' modal
        const closeDetailsModalBtn = document.getElementById('closeDetailsModal'); // Close button on 'Lengkapi Detail' modal
        const saveAddressBtn = document.getElementById('saveAddressBtn');


        // Function to show a specific modal pane
        function showAddressModalPane(paneId) {
            // Hide all panes
            mainAddressModal.style.display = 'none';
            addAddressModal.style.display = 'none';
            pinpointModal.style.display = 'none';
            addressDetailsModal.style.display = 'none';

            // Show the requested pane
            document.getElementById(paneId).style.display = 'block';

            // Add fade animation class to content
             addressModal.querySelector('.modal-content').classList.add('modal-fade');

             // Manage map lifecycle if showing pinpoint modal
             if (paneId === 'pinpointModal') {
                 // Use a small delay to ensure the map div is rendered before initializing
                 setTimeout(initMap, 100); // Delay 100ms
             } else {
                 // Destroy map instance if navigating away from pinpoint
                 if (map) {
                     map.remove();
                     map = null; // Set to null after removing
                     console.log("Map destroyed.");
                 }
             }
        }

        // Open main address modal
        if (changeAddressBtn && addressModal) {
            changeAddressBtn.addEventListener('click', function() {
                addressModal.classList.add('show'); // Use class for animation
                showAddressModalPane('mainAddressModal');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
        }

        // Close any address modal pane
         function closeAddressModals() {
              if (addressModal) {
                addressModal.classList.remove('show'); // Use class for animation
                // Optional: Hide the modal container after animation ends using transitionend
                // addressModal.addEventListener('transitionend', function handler() {
                //      addressModal.style.display = 'none';
                //      addressModal.removeEventListener('transitionend', handler);
                // }, { once: true }); // Use once: true for modern browsers

                document.body.style.overflow = ''; // Restore scrolling

                 // Always destroy map when closing modals
                 if (map) {
                     map.remove();
                     map = null;
                     console.log("Map destroyed on modal close.");
                 }
             }
         }

        // Attach close handlers
        if (closeAddressModalBtn) closeAddressModalBtn.addEventListener('click', closeAddressModals);
        if (closeAddNewModalBtn) closeAddNewModalBtn.addEventListener('click', closeAddressModals);
        if (closePinpointModalBtn) closePinpointModalBtn.addEventListener('click', closeAddressModals);
        if (closeDetailsModalBtn) closeDetailsModalBtn.addEventListener('click', closeAddressModals);


        // Navigate to add new address modal (from main address list)
        if (addNewAddressBtn) {
            addNewAddressBtn.addEventListener('click', function() {
                showAddressModalPane('addAddressModal');
            });
        }

        // Navigate to pinpoint modal (from add address - 'Cari Lokasi')
        if (useCurrentLocationBtn) {
            useCurrentLocationBtn.addEventListener('click', function() {
                showAddressModalPane('pinpointModal');
                // initMap is now called within showAddressModalPane
            });
        }

        // Navigate back from pinpoint to add address modal
        if (backToAddAddressBtn) {
            backToAddAddressBtn.addEventListener('click', function() {
                showAddressModalPane('addAddressModal');
                 // Map is destroyed within showAddressModalPane
            });
        }

        // Navigate from pinpoint to complete details modal
        if (continueToDetailsBtn) {
            continueToDetailsBtn.addEventListener('click', function() {
                // Attempt to autofill the details form with selected location info
                const success = autofillAddressForm(); // Call autofill function

                 // Only navigate if autofill was successful (location info is available)
                if (success) {
                    showAddressModalPane('addressDetailsModal');
                     // Map is destroyed within showAddressModalPane
                } else {
                     Swal.fire({ icon: 'warning', title: 'Lokasi Belum Dipilih', text: 'Mohon pastikan lokasi di peta sudah termuat sebelum melanjutkan.' });
                }
            });
        }

        // Navigate back from details to pinpoint modal
        if (backToPinpointBtn) {
            backToPinpointBtn.addEventListener('click', function() {
                showAddressModalPane('pinpointModal');
                // initMap is called within showAddressModalPane
            });
        }


        // --- Leaflet Map Implementation (inside Address Modal) ---
        let map;
        let geocoder;
        let defaultLocation = [-7.8013, 110.3505]; // Default to Yogyakarta (approx)

        function initMap() {
            console.log("Attempting to initialize Leaflet map...");
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                console.error("Map element (#map) not found. Cannot initialize map.");
                return;
            }

            // Check if map instance already exists, remove if it does
            if (map !== undefined && map !== null) {
                map.remove();
                map = null;
                console.log("Removed existing map instance.");
            }

            try {
                // Create map instance
                map = L.map('map', {
                    center: defaultLocation, // Start at default location
                    zoom: 15,
                    zoomControl: false // Disable default zoom control
                });
                console.log("Map instance created.");

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                 console.log("Tile layer added.");

                // Initialize Nominatim geocoder
                geocoder = L.Control.Geocoder.nominatim();
                 console.log("Geocoder initialized.");


                // Setup custom search box and controls
                setupMapSearch();
                setupMapControls();
                 console.log("Map search and controls setup.");

                // Try to get user's current location
                getUserLocation();
                 console.log("Attempting to get user location.");

                // Add event listener for map movement end
                map.on('moveend', function() {
                    console.log("Map 'moveend' detected.");
                    updateLocationInfo(); // Update info after map movement stops
                });
                 console.log("Map 'moveend' listener added.");

                // Manually update info initially after tiles load
                 map.whenReady(function() {
                      console.log("Map is ready.");
                     // updateLocationInfo(); // Initial update if getUserLocation doesn't trigger moveend
                     // getUserLocation already calls setView, which triggers moveend, so manual call might be redundant
                 });


                console.log("Leaflet map initialization complete.");

            } catch (error) {
                console.error("Error initializing Leaflet map:", error);
                 Swal.fire({ icon: 'error', title: 'Error Peta', text: 'Gagal memuat peta: ' + error.message });
                 // Hide map container or show fallback message if init fails
                 if(mapElement) mapElement.style.display = 'none';
                 const mapContainer = mapElement.closest('.map-container');
                 if(mapContainer) mapContainer.innerHTML = '<div class="p-4 text-center text-red-600">Gagal memuat peta.</div>';
            }
        }

        function setupMapSearch() {
             const searchInput = document.getElementById('map-search-input-overlay'); // Correct ID
             if (searchInput) {
                 searchInput.addEventListener('keydown', function(e) {
                     if (e.key === 'Enter') {
                         e.preventDefault(); // Prevent form submission if inside a form
                         const query = this.value;
                         if (query.trim() !== '' && geocoder) { // Ensure geocoder is initialized
                             geocoder.geocode(query, function(results) {
                                 console.log("Geocode results for '" + query + "':", results);
                                 if (results && results.length > 0) {
                                     const result = results[0];
                                     if (result.center) {
                                         // Set view to result center. Adjust zoom if current zoom is too low.
                                         map.setView(result.center, map.getZoom() < 15 ? 15 : map.getZoom());
                                         // 'moveend' event will trigger updateLocationInfo
                                     } else if (result.bbox) {
                                         map.fitBounds(result.bbox);
                                         // 'moveend' event will trigger updateLocationInfo
                                     } else {
                                          console.warn("Geocode result has no center or bbox:", result);
                                          Swal.fire({ icon: 'info', title: 'Lokasi Tidak Ditemukan', text: 'Detail lokasi tidak lengkap dari pencarian.' });
                                     }
                                 } else {
                                     Swal.fire({ icon: 'info', title: 'Tidak Ditemukan', text: 'Lokasi yang Anda cari tidak ditemukan.' });
                                 }
                             });
                         } else if (!geocoder) {
                              console.error("Geocoder not initialized.");
                         }
                     }
                 });
             }
        }

        function setupMapControls() {
            // Recenter button
            document.getElementById('recenter-button')?.addEventListener('click', function() {
                console.log("Recenter button clicked.");
                 if (map) getUserLocation(); // Attempt to get user's location and recenter only if map exists
            });

            // Zoom in button
            document.getElementById('zoom-in-button')?.addEventListener('click', function() {
                console.log("Zoom in button clicked.");
                 if (map) map.zoomIn();
            });

            // Zoom out button
            document.getElementById('zoom-out-button')?.addEventListener('click', function() {
                console.log("Zoom out button clicked.");
                 if (map) map.zoomOut();
            });
        }

        function getUserLocation() {
             const locationAreaSpan = document.getElementById('location-area');
             const locationDetailSpan = document.getElementById('location-detail');

            if (navigator.geolocation && map) { // Ensure geolocation and map are available
                 if (locationAreaSpan) locationAreaSpan.textContent = "Mencari lokasi Anda...";
                 if (locationDetailSpan) locationDetailSpan.textContent = "Mohon tunggu...";

                const geoOptions = { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }; // Increased timeout

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const latlng = [lat, lng];

                        console.log("Geolocation successful:", latlng);
                        // Set view to user location. This will trigger the 'moveend' event.
                        map.setView(latlng, 17);

                    },
                    function(error) {
                        console.error("Geolocation error:", error);
                        let errorMessage = "Gagal mendapatkan lokasi Anda.";
                         switch(error.code) {
                             case error.PERMISSION_DENIED:
                                 errorMessage += " (Akses lokasi ditolak). Mohon izinkan akses lokasi di browser Anda.";
                                 break;
                             case error.POSITION_UNAVAILABLE:
                                 errorMessage += " (Lokasi tidak tersedia). Informasi lokasi tidak tersedia.";
                                 break;
                             case error.TIMEOUT:
                                 errorMessage += " (Waktu habis). Waktu permintaan lokasi habis.";
                                 break;
                             case error.UNKNOWN_ERROR:
                                 errorMessage += " (Error tidak diketahui). Terjadi kesalahan tidak diketahui.";
                                 break;
                         }
                        Swal.fire({ icon: 'warning', title: 'Lokasi Tidak Ditemukan', text: errorMessage });

                        // Fallback to default location if geolocation fails
                         map.setView(defaultLocation, 15); // Set view to default
                         // Manually trigger updateLocationInfo as setView on same location might not trigger moveend
                         updateLocationInfo();
                    },
                   geoOptions
                );
            } else if (map) { // Map exists but geolocation is not supported
                 console.log("Browser does not support geolocation.");
                 Swal.fire({ icon: 'info', title: 'Browser Tidak Didukung', text: 'Browser Anda tidak mendukung Geolocation.' });
                // Fallback to default location
                 map.setView(defaultLocation, 15);
                 updateLocationInfo(); // Manually update info
            } else {
                 console.error("Map is not initialized when trying to get user location.");
                 if (locationAreaSpan) locationAreaSpan.textContent = "Error Memuat Lokasi";
                 if (locationDetailSpan) locationDetailSpan.textContent = "Peta tidak tersedia.";
            }
        }

        // Function to update location info based on map center using reverse geocoding
        function updateLocationInfo() {
            if (!map || !geocoder) { // Ensure map and geocoder are ready
                 console.error("Map or geocoder not ready for updateLocationInfo.");
                 return;
            }
            const center = map.getCenter();
            const selectedLocationDiv = document.getElementById('selected-location');
             const locationAreaSpan = document.getElementById('location-area');
             const locationDetailSpan = document.getElementById('location-detail');
             const detailsPinpointLocationSpan = document.getElementById('details-pinpoint-location'); // Span in details modal

            if (!selectedLocationDiv || !locationAreaSpan || !locationDetailSpan) {
                 console.error("Location info UI elements not found.");
                 return;
            }

            // Store coordinates as data attributes
            selectedLocationDiv.dataset.lat = center.lat;
            selectedLocationDiv.dataset.lng = center.lng;

            // Show coordinates while reverse geocoding is in progress
            const coords = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`;
            locationAreaSpan.textContent = "Memuat Alamat...";
            locationDetailSpan.textContent = coords;
            selectedLocationDiv.dataset.address = `Koordinat: ${coords}`; // Default address fallback

            // Perform reverse geocoding
             // Add a small delay before reverse geocoding to wait for map to settle
             setTimeout(() => {
                geocoder.reverse(
                    center,
                    map.options.crs.scale(map.getZoom()), // Use map's current scale
                    function(results) {
                        console.log("Reverse geocoding results:", results);
                        if (results && results.length > 0) {
                            const result = results[0];
                            // Prioritize result.name (often street/building) or result.html, fallback to formatted address
                            const address = result.name || result.html || (result.properties && result.properties.display_name) || 'Alamat Tidak Dikenali';
                            const addressObject = result.getAddressObject(); // Access address components

                            // Store full address string from result properties if available, otherwise use the simplified one
                             selectedLocationDiv.dataset.address = (result.properties && result.properties.display_name) || address;


                            // Attempt to parse address components for UI display
                            // This parsing logic might need adjustment based on geocoding service output format
                            let area = addressObject.city || addressObject.town || addressObject.village || addressObject.hamlet || addressObject.road || addressObject.neighbourhood || 'Area';
                            let detail = '';

                            // Try to build a more detailed line from components
                             const detailParts = [];
                             if(addressObject.house_number) detailParts.push(addressObject.house_number);
                             if(addressObject.road && addressObject.road !== area) detailParts.push(addressObject.road);
                             if(addressObject.suburb && addressObject.suburb !== area) detailParts.push(addressObject.suburb);
                             if(addressObject.village && addressObject.village !== area && addressObject.village !== detailParts[detailParts.length-1]) detailParts.push(addressObject.village);
                             if(addressObject.county && addressObject.county !== area && addressObject.county !== detailParts[detailParts.length-1]) detailParts.push(addressObject.county);
                             if(addressObject.state_district && addressObject.state_district !== area && addressObject.state_district !== detailParts[detailParts.length-1]) detailParts.push(addressObject.state_district);
                             if(addressObject.city && addressObject.city !== area && addressObject.city !== detailParts[detailParts.length-1]) detailParts.push(addressObject.city);
                             if(addressObject.postcode) detailParts.push(`(${addressObject.postcode})`);
                             if(addressObject.country && addressObject.country !== detailParts[detailParts.length-1]) detailParts.push(addressObject.country); // Add country if not last


                            detail = detailParts.join(', ');


                            // Update UI spans
                            locationAreaSpan.textContent = area || 'Area Tidak Diketahui';
                            locationDetailSpan.textContent = detail || address || coords; // Fallback to full address or coords

                             // Update the location text in the details modal if it's open
                             if (addressDetailsModal.style.display === 'block' && detailsPinpointLocationSpan) {
                                // Use the full display_name for the details modal if available
                                detailsPinpointLocationSpan.textContent = selectedLocationDiv.dataset.address;
                             }


                        } else {
                            console.warn("Reverse geocoding found no results.");
                            // Keep coordinates if no address found
                            locationAreaSpan.textContent = "Lokasi Tidak Dikenali";
                            locationDetailSpan.textContent = coords;
                            selectedLocationDiv.dataset.address = `Lokasi Tidak Dikenali (${coords})`;

                             if (detailsPinpointLocationSpan) {
                                detailsPinpointLocationSpan.textContent = `Lokasi Tidak Dikenali (${coords})`;
                             }
                        }
                    }
                );
             }, 200); // Small delay
        }

        // Function to autofill address details form based on pinpoint selection
         function autofillAddressForm() {
             const selectedLocationDiv = document.getElementById('selected-location');
             const address = selectedLocationDiv.dataset.address;
             const lat = selectedLocationDiv.dataset.lat;
             const lng = selectedLocationDiv.dataset.lng;

             const detailsPinpointLocationSpan = document.getElementById('details-pinpoint-location');
             const addressLabelInput = document.getElementById('addressLabel');
             const fullAddressTextarea = document.getElementById('fullAddress');
             const recipientNameInput = document.getElementById('recipientName');
             const phoneNumberInput = document.getElementById('phoneNumber');
             // ... other form fields

             // Check if location data is available and form elements exist
             if (!address || !lat || !lng || !detailsPinpointLocationSpan || !addressLabelInput || !fullAddressTextarea || !recipientNameInput || !phoneNumberInput) {
                 console.warn("Location data or form elements missing for autofill.");
                 // You might want to check which specific element is missing to give a better error message
                 return false; // Cannot autofill if data/elements are missing
             }

             // Fill the pinpoint location display in the details modal
             detailsPinpointLocationSpan.textContent = address;

             // Attempt to pre-fill address label and full address (optional, can be left for user)
             // You could try to extract parts from the 'address' string here if needed,
             // but often leaving these for the user to fill accurately is better.
             // addressLabelInput.value = 'Rumah'; // Default or guess based on address components
             // fullAddressTextarea.value = address; // Simple fill, user can refine


             // If you have user's previous addresses stored, you might fill recipient name/phone/label here
             // Example: const userDefaultAddress = {{-- $userDefaultAddress->toJson() ?? 'null' --}};
             // if (userDefaultAddress) {
             //     addressLabelInput.value = userDefaultAddress.label;
             //     recipientNameInput.value = userDefaultAddress.recipient_name;
             //     phoneNumberInput.value = userDefaultAddress.phone_number;
             //      // You might also try to parse and fill `fullAddressTextarea` based on existing address components vs pinpoint address components
             // }


             // Dispatch input event to trigger character counters and validation for pre-filled fields
             addressLabelInput.dispatchEvent(new Event('input'));
             fullAddressTextarea.dispatchEvent(new Event('input'));
             recipientNameInput.dispatchEvent(new Event('input'));
             phoneNumberInput.dispatchEvent(new Event('input'));

             // Focus on the first required field user needs to fill (e.g., recipient name)
             setTimeout(() => { recipientNameInput.focus(); }, 300); // Focus after a small delay

             console.log("Autofilling address form with pinpoint location:", address);
             return true; // Indicates successful data retrieval for autofill
         }


        // Function to validate address details form
        function validateAddressForm() {
            const addressLabel = document.getElementById('addressLabel');
            const fullAddress = document.getElementById('fullAddress');
            const recipientName = document.getElementById('recipientName');
            const phoneNumber = document.getElementById('phoneNumber');
            const termsAgreement = document.getElementById('termsAgreement');
            const saveAddressBtn = document.getElementById('saveAddressBtn');

            // Check if all required fields exist and are not empty (trimmed)
            const isFormValid = addressLabel && addressLabel.value.trim() !== '' &&
                              fullAddress && fullAddress.value.trim() !== '' &&
                              recipientName && recipientName.value.trim() !== '' &&
                              phoneNumber && phoneNumber.value.trim() !== '' &&
                              termsAgreement && termsAgreement.checked; // Terms must be checked

            if (saveAddressBtn) {
                 saveAddressBtn.disabled = !isFormValid;
                 if (isFormValid) {
                     saveAddressBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                     saveAddressBtn.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                 } else {
                     saveAddressBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                     saveAddressBtn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                 }
            }
        }

        // Setup validation listeners for address details form fields
        const formFieldsToValidate = [
            document.getElementById('addressLabel'),
            document.getElementById('fullAddress'),
            document.getElementById('recipientName'),
            document.getElementById('phoneNumber'),
            document.getElementById('termsAgreement')
        ];

        formFieldsToValidate.forEach(field => {
            if (field) {
                field.addEventListener(field.type === 'checkbox' ? 'change' : 'input', validateAddressForm);
            }
        });

        // Function to update character counters
         function setupCharacterCounters() {
             const fields = [
                 { id: 'addressLabel', limit: 30 },
                 { id: 'fullAddress', limit: 200 },
                 { id: 'courierNotes', limit: 45 },
                 { id: 'recipientName', limit: 50 },
                 { id: 'phoneNumber', limit: 15 }
             ];

             fields.forEach(field => {
                 const element = document.getElementById(field.id);
                 // Find the counter element (e.g., a span inside a div after the input)
                 // Assuming the structure is: <label>...</label> <input> <div class="text-right"> <span id="elementIdCount">...</span> </div>
                 const counterElement = element ? element.nextElementSibling?.querySelector('span#' + field.id + 'Count') : null;


                 if (element && counterElement) {
                     // Initial update
                     counterElement.textContent = element.value.length;

                     // Event listener
                     element.addEventListener('input', function() {
                         const length = this.value.length;
                         counterElement.textContent = length;

                         // Optional: highlight if exceeding limit
                         if (length > field.limit) {
                             counterElement.classList.add('text-red-500');
                         } else {
                             counterElement.classList.remove('text-red-500');
                         }
                         validateAddressForm(); // Re-validate form on input
                     });
                     // Also validate on change (e.g., pasting)
                     element.addEventListener('change', validateAddressForm);
                 }
             });
         }
         setupCharacterCounters(); // Call on DOMContentLoaded


        // --- Save Address Button ---
        if (saveAddressBtn) {
            saveAddressBtn.addEventListener('click', function() {
                // validation should prevent click if disabled, but double check
                if (this.disabled) {
                    console.warn("Save address button clicked while disabled.");
                    return;
                }

                // --- START: Simulation of saving address ---
                const addressData = {
                    label: document.getElementById('addressLabel')?.value.trim() || '',
                    fullAddress: document.getElementById('fullAddress')?.value.trim() || '',
                    courierNotes: document.getElementById('courierNotes')?.value.trim() || '',
                    recipientName: document.getElementById('recipientName')?.value.trim() || '',
                    phoneNumber: document.getElementById('phoneNumber')?.value.trim() || '',
                    isPrimary: document.getElementById('primaryAddress')?.checked || false,
                    lat: document.getElementById('selected-location')?.dataset.lat || null,
                    lng: document.getElementById('selected-location')?.dataset.lng || null,
                    pinpointAddress: document.getElementById('selected-location')?.dataset.address || 'Lokasi Tidak Dikenali'
                };

                console.log("Simulating saving address data:", addressData);

                // Simulate AJAX call success delay
                setTimeout(() => {
                     console.log("Simulated save success.");
                     Swal.fire({
                         icon: 'success',
                         title: 'Alamat Tersimpan!',
                         text: 'Alamat baru Anda berhasil disimpan (simulasi).',
                         timer: 2000,
                         showConfirmButton: false
                     }).then(() => {
                          // Update the address display on the main checkout page with saved data (simulasi)
                          updateCheckoutAddressDisplay(addressData);
                         closeAddressModals(); // Close all address modals
                     });
                }, 500); // Simulate 0.5 second network delay

                 // TODO: Replace the simulation above with a real AJAX request to your backend route
                 /*
                 fetch('/profile/address', { // Example endpoint where you handle saving addresses
                     method: 'POST',
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                     },
                     body: JSON.stringify(addressData)
                 })
                 .then(response => {
                     if (!response.ok) {
                          // Handle HTTP errors (4xx, 5xx)
                         return response.json().then(err => { throw new Error(err.message || 'Gagal menyimpan alamat.') });
                     }
                     return response.json(); // Assuming your backend returns JSON { success: true, ..., savedAddress: {...} }
                 })
                 .then(data => {
                     if (data.success) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Alamat Tersimpan!',
                              text: data.message || 'Alamat berhasil disimpan.',
                              timer: 2000,
                              showConfirmButton: false
                          }).then(() => {
                               // Update the address display on the main checkout page with the data returned from backend
                               updateCheckoutAddressDisplay(data.savedAddress);
                               closeAddressModals(); // Close all address modals
                          });
                     } else {
                          // Handle application-level errors returned in JSON
                          Swal.fire({ icon: 'error', title: 'Gagal Menyimpan Alamat', text: data.message || 'Terjadi kesalahan saat menyimpan alamat.' });
                     }
                 })
                 .catch(error => {
                      // Handle network errors or errors thrown in .then()
                      console.error('Error saving address:', error);
                      Swal.fire({ icon: 'error', title: 'Error', text: error.message || 'Terjadi kesalahan jaringan atau server.' });
                 });
                 */
                // --- END: Simulation of saving address ---
            });
        }

         // Function to update the main address display on the checkout page
         function updateCheckoutAddressDisplay(addressData) {
             const addressLabelRecipientSpan = document.getElementById('checkout-address-label-name'); // Use specific IDs
             const fullAddressP = document.getElementById('checkout-address-full');
             const phoneNumberP = document.getElementById('checkout-address-phone');


             if (addressLabelRecipientSpan && addressData.label && addressData.recipientName) {
                 addressLabelRecipientSpan.textContent = `${addressData.label} | ${addressData.recipientName}`;
             }
              if (fullAddressP && addressData.fullAddress) {
                  // Use innerHTML to respect line breaks manually added by user
                  fullAddressP.innerHTML = addressData.fullAddress.replace(/\n/g, '<br>');
              }
              if (phoneNumberP && addressData.phoneNumber) {
                   phoneNumberP.textContent = `Telp: ${addressData.phoneNumber}`;
              }
              // TODO: If you have a list of addresses, you would instead mark one as selected and update the main display based on that selection.
              // The current JS only handles updating the display after adding a *new* address.
              // For selecting an existing address, you'd need event listeners on the address list items in mainAddressModal.
         }

         // --- Address Radio Button Selection (in modal) ---
          const addressRadios = document.querySelectorAll('.address-radio');
          const addressSelectedIcons = document.querySelectorAll('.address-selected-icon'); // Assuming these are sibling divs

          addressRadios.forEach(radio => {
              radio.addEventListener('change', function() {
                  // Reset all icons to inactive state
                  addressSelectedIcons.forEach(icon => {
                      icon.classList.remove('text-blue-500');
                      icon.classList.add('text-gray-300');
                  });

                  // Set the icon for the selected radio to active state
                  if (this.checked) {
                       // The icon is likely a sibling element after the label
                      const iconContainer = this.closest('.border.rounded-lg').querySelector('.address-selected-icon');
                      if (iconContainer) {
                          iconContainer.classList.remove('text-gray-300');
                          iconContainer.classList.add('text-blue-500');
                      }
                       // TODO: Here you would typically update the main checkout page's address display
                       // with the details of the selected address.
                       // This requires having the address details available in the mainAddressModal view,
                       // maybe stored as data attributes on the list item div.
                  }
              });
          });

          // Initialize icon state on load for the default checked radio
          document.querySelectorAll('.address-radio:checked').forEach(radio => {
               const iconContainer = radio.closest('.border.rounded-lg').querySelector('.address-selected-icon');
               if (iconContainer) {
                   iconContainer.classList.remove('text-gray-300');
                   iconContainer.classList.add('text-blue-500');
               }
          });


        // --- Pay Now Button ---
        const payNowButton = document.querySelector('button.bg-blue-500.rounded-lg.py-3.mt-6'); // Select the Pay Now button

        if (payNowButton) {
             payNowButton.addEventListener('click', function() {
                 // TODO: Add logic to handle the payment process
                 // This would typically involve:
                 // 1. Getting the selected payment method
                 // 2. Getting the selected address ID (if multiple addresses exist)
                 // 3. Getting the selected voucher ID (if any)
                 // 4. Redirecting to a payment gateway or displaying payment instructions
                 // 5. Sending data to a backend route (e.g., /checkout/process) via AJAX or form submission
                 //    to create an Order record in the database and initiate payment.

                 console.log("Pay Now button clicked (simulasi).");

                 // Example: Show a confirmation or processing message
                 Swal.fire({
                     icon: 'info',
                     title: 'Memproses Pembayaran',
                     text: 'Fitur pembayaran sedang diimplementasikan...',
                     showConfirmButton: false,
                     timer: 3000 // Auto close after 3 seconds
                 });

                 // If you had a form for checkout process, you would submit it here:
                 // const checkoutProcessForm = document.getElementById('checkout-process-form'); // Assuming a form exists
                 // if (checkoutProcessForm) {
                 //      checkoutProcessForm.submit(); // Submit the form
                 // } else {
                 //     // Or make an AJAX call
                 //     // fetch('/checkout/process', { method: 'POST', body: ..., headers: ... })
                 //     // ...
                 // }
             });
        }


    }); // End DOMContentLoaded
    </script>

@endsection