<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PhoneKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
    crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>

    <!-- Leaflet Geocoder untuk pencarian lokasi -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        /* Custom radio button styling */
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
            border: 1px solid #d1d5db;
            background-color: white;
        }
        
        .payment-radio:checked + .radio-custom {
            border: 2px solid #3b82f6;
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
            background-color: #3b82f6;
        }
        
        .payment-radio:checked ~ label {
            background-color: #f0f9ff;
            border-color: #3b82f6;
        }
        
        /* Quantity counter styling */
        .quantity-counter input::-webkit-outer-spin-button,
        .quantity-counter input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .quantity-counter input[type=number] {
            -moz-appearance: textfield;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            margin: 10vh auto;
            width: 100%;
            max-width: 600px;
            border-radius: 0.5rem;
            position: relative;
            max-height: 80vh;
            overflow-y: auto;
        }

        .active-tab {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
        }

        /* Animation for modal */
        .modal-fade {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Map styling */
        .map-container {
            position: relative;
            height: 300px;
            background-color: #f3f4f6;
            overflow: hidden;
            border-radius: 0.5rem;
        }

        #map {
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .pinpoint-marker {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -100%);
            color: #3b82f6;
            font-size: 2rem;
            z-index: 10;
            pointer-events: none;
            text-shadow: 0px 0px 2px rgba(255, 255, 255, 0.8);
        }
        
        .map-search-box {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            z-index: 10;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .map-controls {
            position: absolute;
            bottom: 10px;
            left: 10px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .map-control-button {
            width: 32px;
            height: 32px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header/Logo -->
    <header class="container mx-auto py-4 px-4 mt-5">
        <div class="flex items-center">
            <a href="#" class="flex items-center">
                <img src="img/logo2.png" alt="PhoneKu Logo">
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pb-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-5">Checkout</h1>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Address & Product -->
            <div class="w-full lg:w-2/3 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg text-gray-400 font-medium uppercase">ALAMAT PENGIRIMAN</h2>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <div class="text-blue-500 mr-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="font-medium">Rumah | Nama Penerima</span>
                        </div>
                        <p class="text-gray-700 ml-9">
                            Warung Mbak Sri Zada, Jalan Jogja Ring Road Selatan, Menayu Lor, Tirtonirmolo,<br>
                            Kabupaten Bantul, Daerah Istimewa Yogyakarta
                        </p>
                        <div class="mt-4 ml-9">
                            <button id="changeAddressBtn" class="px-4 py-1 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition">Ganti</button>
                        </div>
                    </div>
                </div>

                <!-- Product -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <div class="flex flex-col md:flex-row items-start">
                            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                <img src="img/iphone11.png" alt="iPhone 11 Red" class="w-28 h-auto object-contain">
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-xl font-medium mb-2">Iphone 11</h3>
                                <div class="mb-2">Red</div>
                                <div class="mb-2">SKU: 8100019113</div>
                                <div class="mb-4">Tersedia</div>
                                
                                <div class="border rounded-lg p-3 mb-4">
                                    <div class="font-medium">Reguler</div>
                                    <div>JNE (20.000)</div>
                                    <div class="text-gray-600">Estimasi Tiba 10 - 15 April</div>
                                </div>
                                
                                <div class="flex border-t border-gray-200 pt-4">
                                    <button class="flex items-center text-blue-500">
                                        <i class="far fa-sticky-note mr-2"></i>
                                        <span>Beri Catatan</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col items-end mt-4 md:mt-0">
                                <div class="text-right font-medium mb-4">Rp5.999.999</div>
                                <div class="flex items-center border rounded-md quantity-counter">
                                    <button class="px-3 py-1 text-gray-600 quantity-btn" data-action="decrease">−</button>
                                    <input type="number" min="1" value="1" class="w-10 text-center border-x quantity-input">
                                    <button class="px-3 py-1 text-gray-600 quantity-btn" data-action="increase">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment & Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium mb-4">Metode Pembayaran</h2>
                        
                        <!-- GoPay Option -->
                        <div class="mb-4">
                            <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-gopay">
                                <div class="flex items-center">
                                    <div class="radio-circle mr-3">
                                        <input type="radio" name="payment" id="payment-gopay" class="sr-only payment-radio">
                                        <span class="radio-custom"></span>
                                    </div>
                                    <img src="img/gopay.png" alt="GoPay" class="h-6 mr-3">
                                    <div>
                                        <div>Gopay</div>
                                        <div class="text-xs text-gray-500">Mudah, cepat dan aman</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Alfamart Option -->
                        <div class="mb-4">
                            <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer payment-option" for="payment-alfamart">
                                <div class="flex items-center">
                                    <div class="radio-circle mr-3">
                                        <input type="radio" name="payment" id="payment-alfamart" class="sr-only payment-radio" checked>
                                        <span class="radio-custom"></span>
                                    </div>
                                    <img src="img/Alfamart.png" alt="Alfamart" class="h-6 mr-3">
                                    <div>
                                        <div>Alfamart / Alfamidi / Lawson / Dan+Dan</div>
                                        <div class="text-xs text-gray-500">Langsung setor di cabang mana saja</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Indomaret Option -->
                        <div class="mb-4">
                            <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50" for="payment-indomaret">
                                <div class="flex items-center">
                                    <div class="radio-circle mr-3">
                                        <input type="radio" name="payment" id="payment-indomaret" class="sr-only payment-radio">
                                        <span class="radio-custom"></span>
                                    </div>
                                    <img src="img/indomaret.png" alt="Indomaret" class="h-6 mr-3">
                                    <div>
                                        <div>Indomaret</div>
                                        <div class="text-xs text-gray-500">Langsung setor di cabang mana saja</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="text-center">
                            <a href="#" class="text-blue-500 text-sm">Lihat Semua</a>
                        </div>
                    </div>
                    
                    <!-- Voucher Section -->
                    <div class="p-4 border-b border-gray-200">
                        <button class="flex items-center justify-between w-full bg-gray-100 p-3 rounded-lg">
                            <span class="font-medium">Pilih Voucher Anda</span>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>

                    <!-- Order Summary -->
                    <div class="p-4">
                        <h2 class="text-lg font-medium mb-4">Ringkasan Transaksi</h2>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Harga (1 Barang)</span>
                                <span id="product-price">Rp 5.999.999</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Ongkos Kirim</span>
                                <span>Rp 20.000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biasa Jasa Aplikasi</span>
                                <span>Rp 1.000</span>
                            </div>
                        </div>
                        <div class="flex justify-between font-medium text-lg pt-4 border-t border-gray-200">
                            <span>Total Tagihan</span>
                            <span id="total-amount">Rp 6.020.999</span>
                        </div>
                        
                        <!-- Pay Button -->
                        <button class="w-full bg-blue-500 text-white rounded-lg py-3 mt-6 font-medium hover:bg-blue-600 transition">
                            Bayar Sekarang
                        </button>
                        <p class="text-gray-500 text-xs text-center mt-3">
                            Dengan melanjutkan pembayaran, kamu menyetujui S&K yang berlaku
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Address Modal -->
    <div id="addressModal" class="modal">
        <div class="modal-content modal-fade">
            <!-- Main Address Modal -->
            <div id="mainAddressModal">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-medium">Daftar Alamat</h2>
                    <button id="closeAddressModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="flex border-b">
                        <button id="allAddressTab" class="flex-1 py-3 text-center active-tab">Semua Alamat</button>
                        <button id="friendAddressTab" class="flex-1 py-3 text-center text-gray-500"></button>
                    </div>
                    
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" placeholder="Tulis Nama Alamat / Kota / Kecamatan tujuan pengiriman" class="w-full pl-10 pr-4 py-3 border rounded-lg">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="my-4">
                        <button id="addNewAddressBtn" class="w-full py-3 border-2 border-blue-500 text-blue-500 rounded-lg font-medium hover:bg-blue-50 transition">
                            Tambah Alamat Baru
                        </button>
                    </div>
                    
                    <!-- Address List -->
                    <div class="border rounded-lg my-4 relative">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="font-medium mr-2">Rumah</div>
                                <div class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded">Utama</div>
                            </div>
                            <div class="font-medium mt-1">Zaada</div>
                            <div class="text-gray-500 mt-1">6289537913264</div>
                            <div class="text-gray-600 mt-1">Warung Mbak sri zada Menayu Kulon Tirtonirmolo kasihan,Bantul</div>
                            
                            <div class="mt-3 flex justify-between">
                                <button class="text-gray-600 text-sm">Share</button>
                                <button class="text-gray-600 text-sm">Ubah Alamat</button>
                            </div>
                        </div>
                        
                        <!-- Selected checkmark -->
                        <div class="absolute top-4 right-4 text-blue-500">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Add New Address Modal -->
            <div id="addAddressModal" style="display: none;">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-medium">Tambah Alamat</h2>
                    <button id="closeAddNewModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-4">
                    <!-- Progress steps -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">1</div>
                            <div class="text-xs text-blue-500">Cari lokasi pengirimanmu</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-white text-blue-500 border-2 border-blue-500 flex items-center justify-center mb-1">2</div>
                            <div class="text-xs text-gray-500">Tentukan pinpoint lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-1">3</div>
                            <div class="text-xs text-gray-500">Lengkapi detail alamat</div>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-medium mb-4">Di mana lokasi tujuan pengirimanmu?</h3>
                    
                    <div class="relative mb-4">
                        <input type="text" placeholder="Tulis nama jalan / gedung / perumahan" class="w-full pl-10 pr-4 py-3 border rounded-lg">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    
                    <button id="useCurrentLocationBtn" class="w-full py-3 border text-gray-700 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-crosshairs mr-2"></i>
                        <span>Gunakan Lokasi Saat Ini</span>
                    </button>
                    
                    <div class="text-gray-500 mb-4">
                        Tidak ketemu? <a href="#" class="text-blue-500">Isi alamat secara manual</a>
                    </div>
                    
                    <div class="text-gray-500">
                        Mau cara lain? <a href="#" class="text-blue-500">Isi alamat secara manual</a>
                    </div>
                </div>
            </div>
            
            <!-- Pinpoint Location Modal -->
            <div id="pinpointModal" style="display: none;">
                <div class="flex items-center p-4 border-b">
                    <button id="backToAddAddress" class="mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h2 class="text-xl font-medium">Tambah Alamat</h2>
                    <button id="closePinpointModal" class="ml-auto text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-4">
                    <!-- Progress steps -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500">Cari lokasi pengirimanmu</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">2</div>
                            <div class="text-xs text-blue-500">Tentukan pinpoint lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-200 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-1">3</div>
                            <div class="text-xs text-gray-500">Lengkapi detail alamat</div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-medium mb-4">Tentukan titik pinpoint lokasi kamu</h3>
                    
                    <!-- Map container with search box -->
                    <div class="map-container mb-4 relative">
                        <input id="map-search" class="map-search-box w-full" type="text" placeholder="Cari lokasi...">
                        
                        <!-- This div will contain the Leaflet Map -->
                        <div id="map"></div>
                        
                        <!-- Pinpoint marker fixed in center -->
                        <div class="pinpoint-marker">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        
                        <!-- Map controls -->
                        <div class="map-controls">
                            <button id="recenter-button" class="map-control-button">
                                <i class="fas fa-crosshairs"></i>
                            </button>
                            <button id="zoom-in-button" class="map-control-button">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button id="zoom-out-button" class="map-control-button">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="selected-location" class="bg-gray-100 rounded-lg p-4 mb-4" data-address="" data-lat="" data-lng="">
                        <div id="location-area" class="font-medium">Mencari lokasi...</div>
                        <div id="location-detail" class="text-gray-600">Mohon tunggu...</div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="text-gray-700 font-medium">Nama lokasi tidak sesuai alamatmu?</div>
                        <div class="text-gray-600">Tenang, kamu akan isi alamat nanti. Pastikan pinpoint sudah sesuai dulu.</div>
                    </div>
                    
                    <div class="mb-4">
                        <button id="manualAddressLink" class="text-blue-500">
                            Mau cara lain? Isi alamat secara manual
                        </button>
                    </div>
                    
                    <button id="continueToDetailsBtn" class="w-full py-3 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition">
                        Pilih Lokasi & Lanjut Isi Alamat
                    </button>
                </div>
            </div>
            
            <!-- Complete Address Details Modal -->
            <div id="addressDetailsModal" style="display: none;">
                <div class="flex items-center p-4 border-b">
                    <button id="backToPinpoint" class="mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h2 class="text-xl font-medium">Tambah Alamat</h2>
                    <button id="closeDetailsModal" class="ml-auto text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-4">
                    <!-- Progress steps -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500">Cari lokasi pengirimanmu</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text-xs text-blue-500">Tentukan pinpoint lokasi</div>
                        </div>
                        <div class="flex-1 h-0.5 bg-blue-500 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">3</div>
                            <div class="text-xs text-blue-500">Lengkapi detail alamat</div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-medium mb-4">Lengkapi detail alamat</h3>
                    
                    <div class="mb-4">
                        <div class="mb-2 font-medium">Long-Lat</div>
                        <div class="flex items-center border rounded-lg p-3 bg-gray-50">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            <span class="text-gray-700"></span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-medium" for="addressLabel">Label Alamat</label>
                        <input type="text" id="addressLabel" placeholder="Rumah" class="w-full p-3 border rounded-lg">
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="addressLabelCount">0</span>/30</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-medium" for="fullAddress">Alamat Lengkap</label>
                        <textarea id="fullAddress" rows="4" class="w-full p-3 border rounded-lg resize-none"></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="fullAddressCount">0</span>/200</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-medium" for="courierNotes">Catatan Untuk Kurir (Opsional)</label>
                        <textarea id="courierNotes" rows="3" placeholder="Warna rumah, patokan, pesan khusus, dll." class="w-full p-3 border rounded-lg resize-none"></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="courierNotesCount">0</span>/45</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-medium" for="recipientName">Nama Penerima</label>
                        <input type="text" id="recipientName" placeholder="Ez" class="w-full p-3 border rounded-lg">
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="recipientNameCount">0</span>/50</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-medium" for="phoneNumber">Nomor HP</label>
                        <div class="relative">
                            <input type="tel" id="phoneNumber" class="w-full p-3 border rounded-lg">
                            <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-address-book text-gray-400"></i>
                            </button>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1"><span id="phoneNumberCount">0</span>/15</div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="primaryAddress" class="mr-2 h-4 w-4 text-blue-500">
                            <span>Jadikan alamat utama</span>
                        </label>
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="termsAgreement" class="mr-2 h-4 w-4 text-blue-500">
                            <span>Saya menyetujui <a href="#" class="text-blue-500">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-500">Kebijakan Privasi</a> pengaturan alamat di PhoneKu.</span>
                        </label>
                    </div>
                    
                    <button id="saveAddressBtn" class="w-full py-3 bg-gray-200 text-gray-400 rounded-lg font-medium">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentOptions = document.querySelectorAll('.payment-radio');
        const paymentLabels = document.querySelectorAll('.payment-option');
        
        paymentOptions.forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-radio').forEach(r => {
                    r.closest('label').classList.remove('bg-blue-50', 'border-blue-500');
                    r.closest('label').classList.add('hover:bg-gray-50');
                });
                
                // Add active class to selected label
                if (this.checked) {
                    this.closest('label').classList.add('bg-blue-50', 'border-blue-500');
                    this.closest('label').classList.remove('hover:bg-gray-50');
                }
            });
        });

        document.querySelectorAll('.payment-radio:checked').forEach(radio => {
            radio.closest('label').classList.add('bg-blue-50', 'border-blue-500');
            radio.closest('label').classList.remove('hover:bg-gray-50');
        });
        
        // Quantity counter
        const quantityInput = document.querySelector('.quantity-input');
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.dataset.action;
                let currentValue = parseInt(quantityInput.value);
                
                if (action === 'increase') {
                    quantityInput.value = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
                
                // Trigger event to update price calculation
                updatePrice();
            });
        });
        
        quantityInput.addEventListener('change', function() {
            if (this.value < 1) {
                this.value = 1;
            }
            updatePrice();
        });
        
        function updatePrice() {
            const quantity = parseInt(quantityInput.value);
            const unitPrice = 5999999;
            const shippingCost = 20000;
            const serviceFee = 1000;
            
            const totalProductPrice = unitPrice * quantity;
            const totalAmount = totalProductPrice + shippingCost + serviceFee;
            
            document.getElementById('product-price').textContent = 'Rp ' + formatPrice(totalProductPrice);
            document.getElementById('total-amount').textContent = 'Rp ' + formatPrice(totalAmount);
        }
        
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Address Modal Functionality
        const addressModal = document.getElementById('addressModal');
        const mainAddressModal = document.getElementById('mainAddressModal');
        const addAddressModal = document.getElementById('addAddressModal');
        const pinpointModal = document.getElementById('pinpointModal');
        const addressDetailsModal = document.getElementById('addressDetailsModal');
        
        // Open main address modal
        document.getElementById('changeAddressBtn').addEventListener('click', function() {
            addressModal.style.display = 'block';
            mainAddressModal.style.display = 'block';
            addAddressModal.style.display = 'none';
            pinpointModal.style.display = 'none';
            addressDetailsModal.style.display = 'none';
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        });
        
        // Close modals
        document.getElementById('closeAddressModal').addEventListener('click', function() {
            addressModal.style.display = 'none';
            document.body.style.overflow = '';
        });
        
        document.getElementById('closeAddNewModal').addEventListener('click', function() {
            addressModal.style.display = 'none';
            document.body.style.overflow = '';
        });
        
        document.getElementById('closePinpointModal').addEventListener('click', function() {
            addressModal.style.display = 'none';
            document.body.style.overflow = '';
        });
        
        document.getElementById('closeDetailsModal').addEventListener('click', function() {
            addressModal.style.display = 'none';
            document.body.style.overflow = '';
        });
        
        // Tab switching
        const allAddressTab = document.getElementById('allAddressTab');
        const friendAddressTab = document.getElementById('friendAddressTab');
        
        allAddressTab.addEventListener('click', function() {
            allAddressTab.classList.add('active-tab');
            allAddressTab.classList.remove('text-gray-500');
            friendAddressTab.classList.remove('active-tab');
            friendAddressTab.classList.add('text-gray-500');
        });
        
        friendAddressTab.addEventListener('click', function() {
            friendAddressTab.classList.add('active-tab');
            friendAddressTab.classList.remove('text-gray-500');
            allAddressTab.classList.remove('active-tab');
            allAddressTab.classList.add('text-gray-500');
        });
        
        // Show add new address modal
        document.getElementById('addNewAddressBtn').addEventListener('click', function() {
            mainAddressModal.style.display = 'none';
            addAddressModal.style.display = 'block';
        });
        
        // Navigate to pinpoint modal
        document.getElementById('useCurrentLocationBtn').addEventListener('click', function() {
            addAddressModal.style.display = 'none';
            pinpointModal.style.display = 'block';
        });
        
        // Navigate back to add address modal
        document.getElementById('backToAddAddress').addEventListener('click', function() {
            pinpointModal.style.display = 'none';
            addAddressModal.style.display = 'block';
        });
        
        // Navigate to complete details
        document.getElementById('continueToDetailsBtn').addEventListener('click', function() {
            pinpointModal.style.display = 'none';
            addressDetailsModal.style.display = 'block';
        });
        
        // Navigate back to pinpoint
        document.getElementById('backToPinpoint').addEventListener('click', function() {
            addressDetailsModal.style.display = 'none';
            pinpointModal.style.display = 'block';
        });
        
        // Form validation for address details
        const addressLabel = document.getElementById('addressLabel');
        const fullAddress = document.getElementById('fullAddress');
        const recipientName = document.getElementById('recipientName');
        const phoneNumber = document.getElementById('phoneNumber');
        const termsAgreement = document.getElementById('termsAgreement');
        const saveAddressBtn = document.getElementById('saveAddressBtn');
        
        function checkFormValidity() {
            if (
                addressLabel.value.trim() !== '' && 
                fullAddress.value.trim() !== '' && 
                recipientName.value.trim() !== '' && 
                phoneNumber.value.trim() !== '' &&
                termsAgreement.checked
            ) {
                saveAddressBtn.classList.remove('bg-gray-200', 'text-gray-400');
                saveAddressBtn.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                saveAddressBtn.disabled = false;
            } else {
                saveAddressBtn.classList.add('bg-gray-200', 'text-gray-400');
                saveAddressBtn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                saveAddressBtn.disabled = true;
            }
        }
        
        [addressLabel, fullAddress, recipientName, phoneNumber].forEach(input => {
            input.addEventListener('input', checkFormValidity);
        });
        
        termsAgreement.addEventListener('change', checkFormValidity);
        
        // Save address and close modal
        saveAddressBtn.addEventListener('click', function() {
            if (!this.disabled) {
                // In a real app, you would save the address data here
                
                // Update the address in the main checkout page
                const addressElement = document.querySelector('.p-4 .text-gray-700.ml-9');
                if (addressElement && fullAddress.value.trim() !== '') {
                    addressElement.textContent = fullAddress.value;
                }
                
                const nameElement = document.querySelector('.p-4 .font-medium');
                if (nameElement && addressLabel.value.trim() !== '' && recipientName.value.trim() !== '') {
                    nameElement.textContent = addressLabel.value + ' | ' + recipientName.value;
                }
                
                // Close modal
                addressModal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
        
        // Count characters for text inputs
        function updateCounter(input, counterSelector, maxLength) {
            const counter = input.parentElement.querySelector(counterSelector);
            if (counter) {
                const length = input.value.length;
                counter.textContent = length + '/' + maxLength;
            }
        }
        
        addressLabel.addEventListener('input', function() {
            updateCounter(this, '.text-right.text-xs', 30);
        });
        
        fullAddress.addEventListener('input', function() {
            updateCounter(this, '.text-right.text-xs', 200);
        });
        
        courierNotes.addEventListener('input', function() {
            updateCounter(this, '.text-right.text-xs', 45);
        });
        
        recipientName.addEventListener('input', function() {
            updateCounter(this, '.text-right.text-xs', 50);
        });
        
        phoneNumber.addEventListener('input', function() {
            updateCounter(this, '.text-right.text-xs', 15);
        });
    });
</script>

<script>
    // Leaflet Map Implementation
    let map;
    let geocoder;
    let searchControl;
    let defaultLocation = [-7.8013, 110.3505]; // Default to Yogyakarta [latitude, longitude]
    
    function initMap() {
        console.log("Initializing Leaflet map...");
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error("Map element not found!");
            return;
        }
    
        // Create map instance
        map = L.map('map', {
            center: defaultLocation,
            zoom: 15,
            zoomControl: false // Nonaktifkan kontrol zoom default
        });
    
        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Initialize geocoder
        geocoder = L.Control.Geocoder.nominatim();
        
        // Setup search box and controls
        setupSearch();
        setupMapControls();
        
        // Get user location
        getUserLocation();
        
        // Setup map events
        map.on('moveend', function() {
            updateLocationInfo();
        });
        
        console.log("Leaflet map initialized");
    }
    
    function setupSearch() {
        const searchInput = document.getElementById('map-search');
        
        // Handle search input
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value;
                    
                    if (query.trim() !== '') {
                        geocoder.geocode(query, function(results) {
                            if (results && results.length > 0) {
                                const result = results[0];
                                const latlng = result.center;
                                
                                map.setView(latlng, 17);
                                updateLocationInfo();
                            } else {
                                alert('Lokasi tidak ditemukan');
                            }
                        });
                    }
                }
            });
        }
    }
    
    function setupMapControls() {
        // Recenter button - get user location
        document.getElementById('recenter-button').addEventListener('click', function() {
            getUserLocation();
        });
        
        // Zoom in button
        document.getElementById('zoom-in-button').addEventListener('click', function() {
            map.setZoom(map.getZoom() + 1);
        });
        
        // Zoom out button
        document.getElementById('zoom-out-button').addEventListener('click', function() {
            map.setZoom(map.getZoom() - 1);
        });
    }
    
    function getUserLocation() {
        if (navigator.geolocation) {
            document.getElementById('location-area').textContent = "Mencari lokasi...";
            document.getElementById('location-detail').textContent = "Mohon tunggu...";
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 17);
                    updateLocationInfo();
                },
                function(error) {
                    console.error("Geolocation error:", error);
                    map.setView(defaultLocation, 15);
                    updateLocationInfo();
                }
            );
        } else {
            console.log("Browser doesn't support geolocation");
            map.setView(defaultLocation, 15);
            updateLocationInfo();
        }
    }
    
function updateLocationInfo() {
    const center = map.getCenter();
    const selectedLocation = document.getElementById('selected-location');
    
    // Simpan koordinat
    selectedLocation.dataset.lat = center.lat;
    selectedLocation.dataset.lng = center.lng;
    
    // Update tampilan dengan koordinat terlebih dahulu sebagai fallback
    const coords = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`;
    document.getElementById('location-area').textContent = "Lokasi";
    document.getElementById('location-detail').textContent = coords;
    
    // Tetapkan alamat dasar agar tidak kosong
    selectedLocation.dataset.address = `Lokasi (${coords})`;
    
    // Coba lakukan reverse geocoding
    try {
        geocoder.reverse(
            center,
            map.options.crs.scale(map.getZoom()),
            function(results) {
                if (results && results.length > 0) {
                    const result = results[0];
                    const address = result.name;
                    
                    console.log("Geocoder result:", result); // Debug
                    
                    // Simpan alamat lengkap
                    selectedLocation.dataset.address = address || selectedLocation.dataset.address;
                    
                    // Coba parsing alamat
                    if (address) {
                        const addressParts = address.split(',');
                        
                        // Area adalah bagian pertama atau "Lokasi" jika kosong
                        let area = addressParts[0] ? addressParts[0].trim() : 'Lokasi';
                        
                        // Detail adalah bagian lainnya atau koordinat jika kosong
                        let detail = '';
                        if (addressParts.length > 1) {
                            detail = addressParts.slice(1).join(',').trim();
                        }
                        
                        // Update UI dengan informasi lokasi
                        document.getElementById('location-area').textContent = area;
                        document.getElementById('location-detail').textContent = detail || coords;
                    }
                } else {
                    // Jika geocoding gagal, gunakan metode alternatif
                    useAlternativeGeocoding(center);
                }
            }
        );
    } catch (error) {
        console.error("Error in geocoding:", error);
        // Gunakan metode alternatif jika terjadi error
        useAlternativeGeocoding(center);
    }
}
    
    function saveSelectedLocation() {
        const selectedLocation = document.getElementById('selected-location');
        const address = selectedLocation.dataset.address;
        const lat = selectedLocation.dataset.lat;
        const lng = selectedLocation.dataset.lng;
        
        if (address && lat && lng) {
            // Save to localStorage for persistence
            localStorage.setItem('selectedAddress', address);
            localStorage.setItem('selectedLat', lat);
            localStorage.setItem('selectedLng', lng);
            
            
            return true;
        }
        
        return false;
    }
    
    // Main document ready function
    document.addEventListener('DOMContentLoaded', function() {
        // Setup existing functionality (payment, quantity, etc.) from original code...
        
        // Setup event for opening pinpoint modal
        document.getElementById('useCurrentLocationBtn').addEventListener('click', function() {
            // Initialize map after modal is displayed
            setTimeout(() => {
                initMap();
            }, 500);
        });
        
        // Save location when continuing to details
        document.getElementById('continueToDetailsBtn').addEventListener('click', function() {
            saveSelectedLocation();
        });
    });
    </script>

<script>
function autofillAddressForm() {
    const selectedLocation = document.getElementById('selected-location');
    const address = selectedLocation.dataset.address;
    const lat = selectedLocation.dataset.lat;
    const lng = selectedLocation.dataset.lng;
    
    if (!address) {
        console.warn("Tidak ada alamat yang dipilih untuk diisi otomatis");
        return false;
    }
    
    // Simpan data lokasi di localStorage untuk penggunaan di halaman lain jika perlu
    localStorage.setItem('selectedAddress', address);
    localStorage.setItem('selectedLat', lat);
    localStorage.setItem('selectedLng', lng);
    
    // Dapatkan informasi lokasi untuk digunakan dalam pengisian form
    const areaName = document.getElementById('location-area').textContent;
    const areaDetail = document.getElementById('location-detail').textContent;
    
    // Mengisi formulir setelah modal detail alamat ditampilkan
    setTimeout(() => {
        
        // Isi kolom label alamat dengan "Rumah" sebagai default jika belum diisi
        const addressLabelField = document.getElementById('addressLabel');
        if (addressLabelField && !addressLabelField.value) {
            addressLabelField.value = "Rumah";
            addressLabelField.dispatchEvent(new Event('input'));
        }
        
        // Update informasi pinpoint di form detail alamat
        const pinpointInfoText = document.querySelector('.flex.items-center.border.rounded-lg.p-3.bg-gray-50 .text-gray-700');
        if (pinpointInfoText) {
            pinpointInfoText.textContent = address;
        }
        
        // Fokus ke field berikutnya yang perlu diisi (misalnya nama penerima)
        const recipientNameField = document.getElementById('recipientName');
        if (recipientNameField) {
            // Berikan fokus setelah delay kecil agar UI selesai transisi
            setTimeout(() => recipientNameField.focus(), 300);
        }
        
        console.log("Form alamat berhasil diisi otomatis:", address);
    }, 300); // Delay untuk memastikan modal detail alamat sudah tampil
    
    return true;
}

// Perbarui event listener untuk tombol continueToDetailsBtn
document.addEventListener('DOMContentLoaded', function() {
    // Setup existing functionality...
    
    // Ganti event listener pada tombol "Pilih Lokasi & Lanjut Isi Alamat"
    const continueBtn = document.getElementById('continueToDetailsBtn');
    if (continueBtn) {
        continueBtn.addEventListener('click', function() {
            // Isi formulir secara otomatis
            const success = autofillAddressForm();
            
            if (success) {
                // Beralih ke modal detail alamat
                document.getElementById('pinpointModal').style.display = 'none';
                document.getElementById('addressDetailsModal').style.display = 'block';
            } else {
                // Tampilkan pesan jika tidak ada alamat yang dipilih
                alert('Mohon tunggu informasi lokasi dimuat atau coba posisi lain');
            }
        });
    }
    
    // Tambahkan fungsi untuk memvalidasi form
    const validateForm = function() {
        const addressLabel = document.getElementById('addressLabel');
        const fullAddress = document.getElementById('fullAddress');
        const recipientName = document.getElementById('recipientName');
        const phoneNumber = document.getElementById('phoneNumber');
        const termsAgreement = document.getElementById('termsAgreement');
        const saveAddressBtn = document.getElementById('saveAddressBtn');
        
        if (
            addressLabel.value.trim() !== '' && 
            fullAddress.value.trim() !== '' && 
            recipientName.value.trim() !== '' && 
            phoneNumber.value.trim() !== '' &&
            termsAgreement.checked
        ) {
            saveAddressBtn.classList.remove('bg-gray-200', 'text-gray-400');
            saveAddressBtn.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600');
            saveAddressBtn.disabled = false;
        } else {
            saveAddressBtn.classList.add('bg-gray-200', 'text-gray-400');
            saveAddressBtn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600');
            saveAddressBtn.disabled = true;
        }
    };
    
    // Tambahkan listener pada semua field form untuk validasi real-time
    const formFields = [
        document.getElementById('addressLabel'),
        document.getElementById('fullAddress'),
        document.getElementById('recipientName'),
        document.getElementById('phoneNumber'),
        document.getElementById('termsAgreement')
    ];
    
    formFields.forEach(field => {
        if (field) {
            field.addEventListener(field.type === 'checkbox' ? 'change' : 'input', validateForm);
        }
    });
    
    // Setup event untuk tombol simpan alamat
    const saveAddressBtn = document.getElementById('saveAddressBtn');
    if (saveAddressBtn) {
        saveAddressBtn.addEventListener('click', function() {
            if (!this.disabled) {
                // Simpan data alamat (misalnya melalui AJAX atau ke localStorage)
                const addressData = {
                    label: document.getElementById('addressLabel').value,
                    fullAddress: document.getElementById('fullAddress').value,
                    courierNotes: document.getElementById('courierNotes')?.value || '',
                    recipientName: document.getElementById('recipientName').value,
                    phoneNumber: document.getElementById('phoneNumber').value,
                    isPrimary: document.getElementById('primaryAddress')?.checked || false,
                    lat: localStorage.getItem('selectedLat'),
                    lng: localStorage.getItem('selectedLng')
                };
                
                // Simpan di localStorage sebagai contoh
                localStorage.setItem('savedAddress', JSON.stringify(addressData));
                
                // Update alamat di halaman checkout utama
                updateCheckoutAddress(addressData);
                
                // Tutup modal
                document.getElementById('addressModal').style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }
});

/**
 * Fungsi untuk memperbarui informasi alamat di halaman checkout utama
 */
function updateCheckoutAddress(addressData) {
    // Update nama dan label
    const nameElement = document.querySelector('.p-4 .font-medium');
    if (nameElement && addressData.label && addressData.recipientName) {
        nameElement.textContent = addressData.label + ' | ' + addressData.recipientName;
    }
    
    // Update alamat lengkap
    const addressElement = document.querySelector('.p-4 .text-gray-700.ml-9');
    if (addressElement && addressData.fullAddress) {
        addressElement.textContent = addressData.fullAddress;
    }
}
</script>
<script>
    // Fungsi untuk memperbarui penghitung karakter untuk semua field
function setupCharacterCounters() {
    // Daftar field dan batas karakter masing-masing
    const fields = [
        { id: 'addressLabel', limit: 30 },
        { id: 'fullAddress', limit: 200 },
        { id: 'courierNotes', limit: 45 },
        { id: 'recipientName', limit: 50 },
        { id: 'phoneNumber', limit: 15 }
    ];
    
    // Setup penghitung untuk setiap field
    fields.forEach(field => {
        const element = document.getElementById(field.id);
        const counterElement = document.getElementById(field.id + 'Count');
        
        if (element && counterElement) {
            // Update counter saat halaman dimuat pertama kali
            counterElement.textContent = element.value.length;
            
            // Setup event listener untuk memperbarui counter saat input berubah
            element.addEventListener('input', function() {
                const length = this.value.length;
                counterElement.textContent = length;
                
                // Opsional: tambahkan validasi panjang maksimum
                if (length > field.limit) {
                    counterElement.classList.add('text-red-500');
                } else {
                    counterElement.classList.remove('text-red-500');
                }
            });
        }
    });
}

// Panggil fungsi ini saat dokumen siap
document.addEventListener('DOMContentLoaded', function() {
    setupCharacterCounters();
});
</script>
</body>
</html>