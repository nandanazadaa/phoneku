@extends('layouts.app')

@section('title', 'Cart - PhoneKu')

@section('content')
    <!-- Header Section with Wave -->
    <div class="relative">
        <!-- Blue Background with Wave -->
        <div class="bg-blue-500 pb-16">
            <!-- Top Navigation -->
            <div class="container mx-auto px-4 py-2 flex justify-end"></div>
        
            <!-- Main Navigation -->
            <div class="container mx-auto px-4"></div>
        </div>
        <section class="container mx-auto px-4 py-10">
          <!-- Judul -->
          <h2 class="text-3xl font-bold mb-8 text-center md:text-left md:ml-12">Keranjang</h2>
        
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 ml-8">
            <!-- Daftar Produk -->
            <div class="lg:col-span-2 space-y-8">
              <!-- Item Produk -->
              <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 border-b pb-6">
                <!-- Gambar dan Detail -->
                <div class="flex sm:flex-row">
                  <img src="https://cdnpro.eraspace.com/media/catalog/product/a/p/apple_iphone_11_white_new_1_1_1.jpg" alt="Iphone 11" class="w-44 h-44 rounded-lg object-cover">
                  <div>
                    <h3 class="text-xl font-semibold">Iphone 11</h3>
                    <p class="text-base text-gray-600">SKU: 8100019113</p>
                    <p class="text-base text-gray-600">Red</p>
                    <p class="text-base text-green-600 font-medium">Tersedia</p>
                  </div>
                </div>
        
                <!-- Harga & Aksi -->
                <div class="flex flex-col items-start gap-3 w-full md:w-auto">
                  <div class="flex justify-between items-center w-full">
                    <p class="text-xl font-semibold mr-2">Rp5.999.999</p>
                    <button class="text-gray-600 hover:text-red-600 text-xl" fdprocessedid="37yblt">🗑️</button>
                  </div>
                  <div class="flex items-center border rounded-full px-3 py-1 md:mt-12">
                    <button class="px-2 text-xl font-semibold" fdprocessedid="d3j5x">−</button>
                    <span class="px-4 text-lg">1</span>
                    <button class="px-2 text-xl font-semibold" fdprocessedid="cdpyhb">+</button>
                  </div>
                </div>
              </div>
        
              <!-- Produk Kedua -->
              <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 border-b pb-6">
                <div class="flex sm:flex-row">
                  <img src="https://cdnpro.eraspace.com/media/catalog/product/a/p/apple_iphone_11_white_new_1_1_1.jpg" alt="Iphone 12" class="w-44 h-44 rounded-lg object-cover" />
                  <div>
                    <h3 class="text-xl font-semibold">Iphone 12</h3>
                    <p class="text-base text-gray-600">Blue</p>
                    <p class="text-base text-gray-600">SKU: 8100019222</p>
                    <p class="text-base text-green-600 font-medium">Tersedia</p>
                  </div>
                </div>
        
                <div class="flex flex-col items-start gap-3 w-full md:w-auto">
                  <div class="flex justify-between items-center w-full">
                    <p class="text-xl font-semibold mr-2">Rp6.999.999</p>
                    <button class="text-gray-600 hover:text-red-600 text-xl">🗑️</button>
                  </div>
                  <div class="flex items-center border rounded-full px-3 py-1 md:mt-12">
                    <button class="px-2 text-xl font-semibold">−</button>
                    <span class="px-4 text-lg">1</span>
                    <button class="px-2 text-xl font-semibold">+</button>
                  </div>
                </div>
              </div>
            </div>
        
            <!-- Ringkasan -->
            <div class="w-full">
              <div class="bg-white shadow rounded-xl p-6 border">
                <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
                <div class="flex justify-between mb-2 text-gray-700">
                  <span>Subtotal</span>
                  <span>Rp12.999.998</span>
                </div>
                <hr class="my-2" />
                <div class="flex justify-between font-bold text-lg mb-6">
                  <span>Total</span>
                  <span>Rp12.999.998</span>
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                  Lanjutkan Pembayaran
                </button>
              </div>
            </div>
          </div>
        </section>
        
        
    </div>
    
   @endsection
</body>
</html>