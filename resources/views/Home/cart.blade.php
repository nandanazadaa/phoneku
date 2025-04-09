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
            <h2 class="text-3xl font-bold mb-8">Keranjang</h2>
          
            <div class="flex flex-col lg:flex-row gap-8">
              <!-- Daftar Produk -->
              <div class="flex-1 space-y-8">
                <!-- Item Produk -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b pb-4">
                  <div class="flex items-center gap-4">
                    <img src="https://cdnpro.eraspace.com/media/catalog/product/a/p/apple_iphone_11_white_new_1_1_1.jpg" alt="Product" class="w-40 h-40 rounded-lg object-cover" />
                    <div>
                      <h3 class="text-lg font-semibold">Iphone 11</h3>
                      <p class="text-sm text-gray-600">Red</p>
                      <p class="text-sm text-gray-600">SKU: 8100019113</p>
                      <p class="text-sm text-green-600 font-medium">Tersedia</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-4">
                    <p class="text-xl font-semibold">Rp5.999.999</p>
                    <button class="text-gray-600 hover:text-red-600">🗑️</button>
                  </div>
                  <div class="flex items-center border rounded-full px-3 py-1">
                    <button class="px-2 text-xl font-semibold">−</button>
                    <span class="px-4 text-lg">1</span>
                    <button class="px-2 text-xl font-semibold">+</button>
                  </div>
                </div>
          
                <!-- Produk Kedua -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b pb-4">
                  <div class="flex items-center gap-4">
                    <img src="https://cdnpro.eraspace.com/media/catalog/product/a/p/apple_iphone_11_white_new_1_1_1.jpg" alt="Product" class="w-40 h-40  rounded-lg object-cover" />
                    <div>
                      <h3 class="text-lg font-semibold">Iphone 12</h3>
                      <p class="text-sm text-gray-600">Blue</p>
                      <p class="text-sm text-gray-600">SKU: 8100019222</p>
                      <p class="text-sm text-green-600 font-medium">Tersedia</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-4">
                    <p class="text-xl font-semibold">Rp6.999.999</p>
                    <button class="text-gray-600 hover:text-red-600">🗑️</button>
                  </div>
                  <div class="flex items-center border rounded-full px-3 py-1">
                    <button class="px-2 text-xl font-semibold">−</button>
                    <span class="px-4 text-lg">1</span>
                    <button class="px-2 text-xl font-semibold">+</button>
                  </div>
                </div>
              </div>
          
              <!-- Ringkasan -->
              <div class="w-full lg:w-1/3">
                <div class="bg-white shadow rounded-xl p-6 border">
                  <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
                  <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp12.999.998</span>
                  </div>
                  <hr class="my-2">
                  <div class="flex justify-between font-bold text-lg mb-4">
                    <span>Total</span>
                    <span>Rp12.999.998</span>
                  </div>
                  <button class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition">Lanjutkan Pembayaran</button>
                </div>
              </div>
            </div>
          </section>
    </div>
    
   @endsection
</body>
</html>