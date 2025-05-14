@extends('layouts.app')

@section('title', 'Checkout - PhoneKu')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <main class="container mx-auto px-4 pb-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-5">Checkout</h1>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Address & Product -->
            <div class="w-full lg:w-2/3 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg text-gray-500 font-medium uppercase">ALAMAT PENGIRIMAN</h2>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <div class="text-blue-500 mr-3 text-xl">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="font-semibold text-gray-800" id="checkout-address-label-name">
                                {{ $user->profile->label ?? 'Alamat Utama' }} | {{ $user->profile->recipient_name ?? $user->name }}
                            </span>
                        </div>
                        <p class="text-gray-700 ml-9" id="checkout-address-full">
                            {{ $user->profile->address ?? '-' }}
                        </p>
                        <p class="text-gray-700 ml-9 mt-1" id="checkout-address-phone">
                            Telp: {{ $user->profile->phone ?? '-' }}
                        </p>
                        <div class="mt-4 ml-9">
                            <button type="button" id="changeAddressBtn" class="px-4 py-1 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition font-medium" onclick="document.getElementById('addressModal').style.display='block'">Ganti</button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Produk yang di Checkout -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg text-gray-500 font-medium uppercase">PRODUK DI PESAN</h2>
                    </div>
                    <div class="p-4 space-y-6">
                        @forelse($cartItems as $item)
                        <div class="flex flex-col md:flex-row items-start">
                            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-24 h-auto object-contain rounded-lg">
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $item->product->name }}</h3>
                                <div class="text-sm text-gray-600 mb-2">Kuantitas: {{ $item->quantity }}</div>
                            </div>
                            <div class="flex-shrink-0 text-right mt-4 md:mt-0 md:ml-auto">
                                <div class="font-bold text-lg text-gray-800">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-gray-500">Tidak ada produk di keranjang.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pilihan Kurir -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm mb-6">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg text-gray-500 font-medium uppercase">PILIH KURIR</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="courier" value="jne" class="mr-3" checked>
                            <div>
                                <div class="font-medium">JNE Reguler</div>
                                <div class="text-xs text-gray-500">2-3 hari • Rp20.000</div>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="courier" value="jnt" class="mr-3">
                            <div>
                                <div class="font-medium">J&T Express</div>
                                <div class="text-xs text-gray-500">1-2 hari • Rp22.000</div>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="courier" value="sicepat" class="mr-3">
                            <div>
                                <div class="font-medium">SiCepat</div>
                                <div class="text-xs text-gray-500">1-3 hari • Rp18.000</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Pilihan Voucher/Diskon -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm mb-6">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg text-gray-500 font-medium uppercase">VOUCHER/DISKON</h2>
                    </div>
                    <div class="p-4 flex items-center gap-3">
                        <input type="text" name="voucher_code" id="voucher_code" class="border rounded p-2 flex-1" placeholder="Masukkan kode voucher">
                        <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded" onclick="applyVoucher()">Cek</button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment & Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold mb-4 text-gray-800">Ringkasan Transaksi</h2>
                        <div class="space-y-2 mb-4 text-gray-700">
                            <div class="flex justify-between">
                                <span>Total Harga</span>
                                <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkos Kirim</span>
                                <span id="shipping-cost">Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Jasa Aplikasi</span>
                                <span>Rp{{ number_format($serviceFee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-green-600" id="discount-row" style="display:none;">
                                <span>Diskon</span>
                                <span id="discount-amount">-Rp0</span>
                            </div>
                        </div>
                        <div class="flex justify-between font-bold text-xl pt-4 border-t border-gray-200 text-gray-800">
                            <span>Total Pembayaran</span>
                            <span id="total-amount">Rp{{ number_format($subtotal + $shippingCost + $serviceFee, 0, ',', '.') }}</span>
                        </div>
                        <button type="button" class="w-full bg-blue-500 text-white rounded-lg py-3 mt-6 font-bold hover:bg-blue-600 transition" onclick="openPaymentModal()">
                            Bayar Sekarang
                        </button>
                        <p class="text-gray-500 text-xs text-center mt-3">
                            Dengan melanjutkan pembayaran, kamu menyetujui S&K yang berlaku
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Alamat -->
        <div id="addressModal" class="modal" style="display:none;">
            <div class="modal-content" style="max-width: 400px; margin: 10vh auto; padding: 2rem;">
                <h2 class="text-xl font-bold mb-4">Edit Alamat</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="label" class="block text-gray-700 mb-2">Label Alamat (Rumah/Kantor/dll)</label>
                        <input type="text" name="label" id="label" class="w-full border rounded p-2" value="{{ $user->profile->label }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="recipient_name" class="block text-gray-700 mb-2">Nama Penerima</label>
                        <input type="text" name="recipient_name" id="recipient_name" class="w-full border rounded p-2" value="{{ $user->profile->recipient_name ?? $user->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" class="w-full border rounded p-2" value="{{ $user->profile->phone }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="address" id="address" class="w-full border rounded p-2" rows="3" required>{{ $user->profile->address }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="document.getElementById('addressModal').style.display='none'" class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Pembayaran Lengkap -->
        <div id="paymentModal" class="modal" style="display:none;">
            <div class="modal-content" style="max-width: 500px; margin: 5vh auto; padding: 0; overflow:hidden;">
                
                <!-- Step 1: Pilih Metode Pembayaran -->
                <div id="paymentMethodStep" class="payment-step">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Pilih Metode Pembayaran</h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih cara pembayaran yang paling mudah untuk Anda</p>
                    </div>
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <!-- Bank Transfer -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">TRANSFER BANK</h3>
                            <div class="space-y-2">
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="bank_bca" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-bc4b22a15d5714b9b4db52ab63bc0b43" alt="BCA" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Bank BCA</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="bank_mandiri" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-f3e7ad5e5dd17b7d56c9dcba46f8e61f" alt="Mandiri" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Bank Mandiri</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="bank_bni" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-f2a2f7f6c0e0fc8da3b15befe6c8b3ec" alt="BNI" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Bank BNI</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="bank_bri" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-a14aa4a9c1dc44f8859b95a02b8c69f5" alt="BRI" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Bank BRI</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- E-Wallet -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">E-WALLET</h3>
                            <div class="space-y-2">
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="gopay" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-d41a5beec1e08e49f2720e1d851f1b72" alt="GoPay" class="w-8 h-8 mr-3">
                                        <span class="font-medium">GoPay</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="shopeepay" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-0ef83b7db6ae3b76e2f8e51f25844a5f" alt="ShopeePay" class="w-8 h-8 mr-3">
                                        <span class="font-medium">ShopeePay</span>
                                        <span class="ml-auto text-red-500 text-sm">Rp2.500</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="ovo" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-e23425c60a3a1e8cd5eb92962a8b7463" alt="OVO" class="w-8 h-8 mr-3">
                                        <span class="font-medium">OVO</span>
                                        <span class="ml-auto text-red-500 text-sm">Rp2.000</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="dana" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-e23425c60a3a1e8cd5eb92962a8b7463" alt="DANA" class="w-8 h-8 mr-3">
                                        <span class="font-medium">DANA</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Kartu -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">KARTU KREDIT/DEBIT</h3>
                            <div class="space-y-2">
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="credit_card" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <div class="flex mr-3">
                                            <img src="https://cdn.shopee.co.id/file/id-50009109-3fbc8a8f9324d36033c90b4ac22de7ba" alt="Visa" class="w-6 h-6 mr-1">
                                            <img src="https://cdn.shopee.co.id/file/id-50009109-e0c9e2d36e2f63aa83b34ac5b5a88a70" alt="Mastercard" class="w-6 h-6">
                                        </div>
                                        <span class="font-medium">Kartu Kredit/Debit</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Minimarket -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">MINIMARKET</h3>
                            <div class="space-y-2">
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="alfamart" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-b9a55dd5b7c4f2b8e5a3e6b7dd2e1234" alt="Alfamart" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Alfamart</span>
                                        <span class="ml-auto text-red-500 text-sm">Rp2.500</span>
                                    </div>
                                </label>
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="indomaret" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <img src="https://cdn.shopee.co.id/file/id-50009109-c7a55dd5b7c4f2b8e5a3e6b7dd2e5678" alt="Indomaret" class="w-8 h-8 mr-3">
                                        <span class="font-medium">Indomaret</span>
                                        <span class="ml-auto text-red-500 text-sm">Rp2.500</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- COD -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">BAYAR DI TEMPAT</h3>
                            <div class="space-y-2">
                                <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                    <input type="radio" name="payment_method" value="cod" class="payment-radio mr-3" hidden>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded mr-3 flex items-center justify-center">
                                            <i class="fas fa-money-bill-wave text-blue-600"></i>
                                        </div>
                                        <span class="font-medium">Bayar di Tempat (COD)</span>
                                        <span class="ml-auto text-green-600 text-sm">Gratis</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between">
                            <button type="button" onclick="closePaymentModal()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Batal</button>
                            <button type="button" id="continuePaymentBtn" onclick="proceedToPayment()" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition" disabled>Lanjutkan</button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Konfirmasi Order -->
                <div id="orderConfirmStep" class="payment-step" style="display:none;">
                    <div class="p-6 border-b border-gray-200">
                        <button type="button" onclick="showPaymentMethod()" class="text-blue-500 hover:text-blue-600 mb-2">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </button>
                        <h2 class="text-xl font-bold text-gray-800">Konfirmasi Pesanan</h2>
                        <p class="text-sm text-gray-600 mt-1">Pastikan semua informasi sudah benar sebelum membayar</p>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                                <span class="font-medium">Metode Pembayaran</span>
                            </div>
                            <div id="selectedPaymentDisplay" class="text-gray-700"></div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-shopping-cart text-blue-500 mr-2"></i>
                                <span class="font-medium">Ringkasan Pesanan</span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Total Harga</span>
                                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Jasa Aplikasi</span>
                                    <span>Rp{{ number_format($serviceFee, 0, ',', '.') }}</span>
                                </div>
                                <div id="paymentFeeRow" class="flex justify-between" style="display:none;">
                                    <span>Biaya Admin</span>
                                    <span id="paymentFeeAmount">Rp0</span>
                                </div>
                                <hr class="my-2">
                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total Pembayaran</span>
                                    <span id="finalTotalAmount">Rp{{ number_format($subtotal + $shippingCost + $serviceFee, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 mb-4">
                            Dengan melanjutkan pembayaran, Anda menyetujui 
                            <a href="#" class="text-blue-500 hover:underline">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="text-blue-500 hover:underline">Kebijakan Privasi</a> 
                            PhoneKu
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        <button type="button" onclick="processPayment()" class="w-full py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition" id="processPaymentBtn">
                            <i class="fas fa-lock mr-2"></i>Bayar Sekarang
                        </button>
                    </div>
                </div>

                <!-- Step 3: Instruksi Pembayaran -->
                <div id="paymentInstructionStep" class="payment-step" style="display:none;">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Instruksi Pembayaran</h2>
                        <p class="text-sm text-gray-600 mt-1">Selesaikan pembayaran sebelum batas waktu</p>
                    </div>
                    <div class="p-6">
                        <!-- Timer -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-center">
                            <div class="text-red-600 font-semibold mb-2">Selesaikan pembayaran dalam</div>
                            <div id="paymentTimer" class="text-2xl font-bold text-red-600"></div>
                        </div>

                        <!-- Order Details -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">No. Pesanan</span>
                                    <div id="orderNumber" class="font-bold text-gray-800"></div>
                                </div>
                                <div>
                                    <span class="text-gray-600">Total Pembayaran</span>
                                    <div id="totalPaymentAmount" class="font-bold text-blue-600"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Instructions Content (Will be populated by JS) -->
                        <div id="paymentInstructionContent"></div>
                    </div>
                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        <div class="flex gap-3">
                            <button type="button" onclick="copyPaymentInfo()" class="flex-1 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 transition">
                                <i class="fas fa-copy mr-2"></i>Salin Info
                            </button>
                            <button type="button" onclick="checkPaymentStatus()" class="flex-1 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                Cek Status Pembayaran
                            </button>
                        </div>
                        <button type="button" onclick="goToOrderHistory()" class="w-full mt-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Lihat Pesanan Saya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('styles')
<style>
/* Modal styling */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 50;
    overflow-y: auto;
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: white;
    margin: 5vh auto;
    width: 95vw;
    max-width: 500px;
    border-radius: 0.75rem;
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

@media (max-width: 600px) {
    .modal-content {
        max-width: 100vw;
        border-radius: 0;
        margin: 0;
    }
}

/* Payment option styling */
.payment-option {
    transition: all 0.2s ease;
}

.payment-option:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.payment-option.selected {
    background-color: #dbeafe;
    border-color: #3b82f6;
}

/* Payment step styling */
.payment-step {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Timer styling */
#paymentTimer {
    font-family: 'Courier New', monospace;
}

/* Scrollbar styling */
.modal-content::-webkit-scrollbar {
    width: 6px;
}

.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.modal-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Global variables
let paymentTimer;
let selectedPaymentMethod = null;
let orderData = null;

// Kurir & Voucher logic
let selectedCourier = 'jne';
let courierCost = 20000;
let discount = 0;

// Update ongkir & total saat kurir berubah
const courierRadios = document.querySelectorAll('input[name="courier"]');
courierRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        selectedCourier = this.value;
        if (selectedCourier === 'jne') courierCost = 20000;
        else if (selectedCourier === 'jnt') courierCost = 22000;
        else if (selectedCourier === 'sicepat') courierCost = 18000;
        document.getElementById('shipping-cost').textContent = 'Rp' + courierCost.toLocaleString('id-ID');
        updateTotal();
    });
});

function applyVoucher() {
    const code = document.getElementById('voucher_code').value.trim().toLowerCase();
    if (code === 'diskon10') {
        discount = 10000;
        document.getElementById('discount-row').style.display = 'flex';
        document.getElementById('discount-amount').textContent = '-Rp10.000';
    } else {
        discount = 0;
        document.getElementById('discount-row').style.display = 'none';
    }
    updateTotal();
}

function updateTotal() {
    const subtotal = {{ $subtotal ?? 0 }};
    const serviceFee = {{ $serviceFee ?? 0 }};
    let total = subtotal + courierCost + serviceFee - discount;
    document.getElementById('total-amount').textContent = 'Rp' + total.toLocaleString('id-ID');
    // Update juga di modal konfirmasi
    const finalTotalElement = document.getElementById('finalTotalAmount');
    if (finalTotalElement) finalTotalElement.textContent = 'Rp' + total.toLocaleString('id-ID');
}

// Modal functions
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    showPaymentMethod();
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    document.body.style.overflow = '';
    clearPaymentTimer();
}

function showPaymentMethod() {
    document.getElementById('paymentMethodStep').style.display = 'block';
    document.getElementById('orderConfirmStep').style.display = 'none';
    document.getElementById('paymentInstructionStep').style.display = 'none';
}

function showOrderConfirm() {
    document.getElementById('paymentMethodStep').style.display = 'none';
    document.getElementById('orderConfirmStep').style.display = 'block';
    document.getElementById('paymentInstructionStep').style.display = 'none';
}

function showPaymentInstruction() {
    document.getElementById('paymentMethodStep').style.display = 'none';
    document.getElementById('orderConfirmStep').style.display = 'none';
    document.getElementById('paymentInstructionStep').style.display = 'block';
}

// Payment method selection
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    document.querySelectorAll('.payment-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            if (this.checked) {
                this.closest('.payment-option').classList.add('selected');
                selectedPaymentMethod = this.value;
                document.getElementById('continuePaymentBtn').disabled = false;
                updateSelectedPaymentDisplay();
            }
        });
    });
});

function updateSelectedPaymentDisplay() {
    const paymentMethods = {
        'bank_bca': 'Transfer Bank BCA',
        'bank_mandiri': 'Transfer Bank Mandiri',
        'bank_bni': 'Transfer Bank BNI',
        'bank_bri': 'Transfer Bank BRI',
        'gopay': 'GoPay',
        'shopeepay': 'ShopeePay',
        'ovo': 'OVO',
        'dana': 'DANA',
        'credit_card': 'Kartu Kredit/Debit',
        'alfamart': 'Alfamart',
        'indomaret': 'Indomaret',
        'cod': 'Bayar di Tempat (COD)'
    };
    
    const displayElement = document.getElementById('selectedPaymentDisplay');
    if (displayElement && selectedPaymentMethod) {
        displayElement.innerHTML = `<div class="font-medium">${paymentMethods[selectedPaymentMethod]}</div>`;
    }
}

function proceedToPayment() {
    if (!selectedPaymentMethod) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Metode Pembayaran',
            text: 'Silakan pilih metode pembayaran terlebih dahulu'
        });
        return;
    }
    
    // Calculate payment fee
    calculatePaymentFee();
    showOrderConfirm();
}

function calculatePaymentFee() {
    const feeStructure = {
        'shopeepay': 2500,
        'ovo': 2000,
        'alfamart': 2500,
        'indomaret': 2500
    };
    
    const fee = feeStructure[selectedPaymentMethod] || 0;
    const subtotal = {{ $subtotal ?? 0 }};
    const shippingCost = {{ $shippingCost ?? 0 }};
    const serviceFee = {{ $serviceFee ?? 0 }};
    const finalTotal = subtotal + shippingCost + serviceFee + fee;
    
    // Update UI
    const feeRow = document.getElementById('paymentFeeRow');
    const feeAmount = document.getElementById('paymentFeeAmount');
    const finalTotalElement = document.getElementById('finalTotalAmount');
    
    if (fee > 0) {
        feeRow.style.display = 'flex';
        feeAmount.textContent = `Rp${fee.toLocaleString('id-ID')}`;
    } else {
        feeRow.style.display = 'none';
    }
    
    finalTotalElement.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
}

function processPayment() {
    const processBtn = document.getElementById('processPaymentBtn');
    processBtn.disabled = true;
    processBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    
    // Simulate order creation
    setTimeout(() => {
        createOrder();
    }, 2000);
}

function createOrder() {
    // Generate order number
    const orderNumber = 'PH' + Date.now();
    
    // Calculate final amount
    const subtotal = {{ $subtotal ?? 0 }};
    const shippingCost = {{ $shippingCost ?? 0 }};
    const serviceFee = {{ $serviceFee ?? 0 }};
    const paymentFee = getPaymentFee();
    const finalTotal = subtotal + shippingCost + serviceFee + paymentFee;
    
    orderData = {
        orderNumber: orderNumber,
        paymentMethod: selectedPaymentMethod,
        totalAmount: finalTotal,
        items: @json($cartItems ?? []),
        address: {
            name: "{{ $user->profile->recipient_name ?? $user->name }}",
            phone: "{{ $user->profile->phone ?? '' }}",
            address: "{{ $user->profile->address ?? '' }}"
        }
    };
    
    // Update UI with order details
    document.getElementById('orderNumber').textContent = orderNumber;
    document.getElementById('totalPaymentAmount').textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
    
    // Show payment instructions
    showPaymentInstructions();
    showPaymentInstruction();
    
    // Start payment timer (24 hours)
    startPaymentTimer(24 * 60 * 60);
}

function getPaymentFee() {
    const feeStructure = {
        'shopeepay': 2500,
        'ovo': 2000,
        'alfamart': 2500,
        'indomaret': 2500
    };
    return feeStructure[selectedPaymentMethod] || 0;
}

function showPaymentInstructions() {
    const instructionContent = document.getElementById('paymentInstructionContent');
    let content = '';
    
    switch (selectedPaymentMethod) {
        case 'bank_bca':
        case 'bank_mandiri':
        case 'bank_bni':
        case 'bank_bri':
            content = getBankTransferInstructions();
            break;
        case 'gopay':
        case 'shopeepay':
        case 'ovo':
        case 'dana':
            content = getEwalletInstructions();
            break;
        case 'credit_card':
            content = getCreditCardInstructions();
            break;
        case 'alfamart':
        case 'indomaret':
            content = getMinimarketInstructions();
            break;
        case 'cod':
            content = getCODInstructions();
            break;
    }
    
    instructionContent.innerHTML = content;
}

function getBankTransferInstructions() {
    const bankNames = {
        'bank_bca': 'BCA',
        'bank_mandiri': 'Mandiri',
        'bank_bni': 'BNI',
        'bank_bri': 'BRI'
    };
    
    const accountNumbers = {
        'bank_bca': '1234567890',
        'bank_mandiri': '1300012345678',
        'bank_bni': '1234567890',
        'bank_bri': '123456789012345'
    };
    
    const bankName = bankNames[selectedPaymentMethod];
    const accountNumber = accountNumbers[selectedPaymentMethod];
    
    return `
        <div class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-3">Transfer ke Rekening ${bankName}</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">No. Rekening</span>
                        <div class="flex items-center">
                            <span class="font-mono font-bold">${accountNumber}</span>
                            <button onclick="copyToClipboard('${accountNumber}')" class="ml-2 text-blue-500 hover:text-blue-700">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Atas Nama</span>
                        <span class="font-bold">PT PhoneKu Indonesia</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Transfer</span>
                        <div class="flex items-center">
                            <span class="font-bold text-green-600" id="transferAmount">Rp${orderData.totalAmount.toLocaleString('id-ID')}</span>
                            <button onclick="copyToClipboard('${orderData.totalAmount}')" class="ml-2 text-blue-500 hover:text-blue-700">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">Cara Transfer:</h4>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                    <li>Login ke ${bankName} mobile banking atau internet banking</li>
                    <li>Pilih menu Transfer ke Rekening ${bankName}</li>
                    <li>Masukkan nomor rekening: <span class="font-mono font-semibold">${accountNumber}</span></li>
                    <li>Masukkan jumlah transfer: <span class="font-semibold">Rp${orderData.totalAmount.toLocaleString('id-ID')}</span></li>
                    <li>Ikuti instruksi hingga transfer berhasil</li>
                    <li>Simpan bukti transfer untuk konfirmasi</li>
                </ol>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold">Penting:</p>
                        <p>Transfer sesuai dengan jumlah yang tertera. Jika berbeda, pembayaran mungkin tidak dapat diproses otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getEwalletInstructions() {
    const ewalletNames = {
        'gopay': 'GoPay',
        'shopeepay': 'ShopeePay',
        'ovo': 'OVO',
        'dana': 'DANA'
    };
    
    const ewalletName = ewalletNames[selectedPaymentMethod];
    
    return `
        <div class="space-y-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-3">Pembayaran via ${ewalletName}</h3>
                <div class="text-center">
                    <div class="bg-white p-4 rounded-lg border-2 border-dashed border-green-300 mb-4">
                        <div id="qr-code" class="w-48 h-48 mx-auto bg-gray-100 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500">QR Code akan muncul di sini</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Scan QR Code dengan aplikasi ${ewalletName}</p>
                    <p class="font-bold text-lg">Rp${orderData.totalAmount.toLocaleString('id-ID')}</p>
                </div>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                    <li>Buka aplikasi ${ewalletName} di smartphone Anda</li>
                    <li>Pilih menu "Scan QR" atau "Bayar"</li>
                    <li>Scan QR code yang ditampilkan di atas</li>
                    <li>Periksa detail pembayaran dan konfirmasi</li>
                    <li>Masukkan PIN ${ewalletName} Anda</li>
                    <li>Pembayaran selesai</li>
                </ol>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                    <div class="text-sm text-blue-800">
                        <p>QR Code berlaku selama 15 menit. Jika expired, silakan refresh halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getCreditCardInstructions() {
    return `
        <div class="space-y-4">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h3 class="font-semibold text-purple-800 mb-3">Pembayaran dengan Kartu</h3>
                <p class="text-sm text-gray-600 mb-3">Anda akan diarahkan ke halaman pembayaran kartu yang aman</p>
                <button onclick="redirectToCardPayment()" class="w-full py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                    <i class="fas fa-credit-card mr-2"></i>Lanjut ke Pembayaran Kartu
                </button>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">Kartu yang Diterima:</h4>
                <div class="flex space-x-3">
                    <img src="https://cdn.shopee.co.id/file/id-50009109-3fbc8a8f9324d36033c90b4ac22de7ba" alt="Visa" class="h-8">
                    <img src="https://cdn.shopee.co.id/file/id-50009109-e0c9e2d36e2f63aa83b34ac5b5a88a70" alt="Mastercard" class="h-8">
                    <img src="https://cdn.shopee.co.id/file/id-50009109-jcb-card-logo" alt="JCB" class="h-8">
                </div>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-green-600 mt-1 mr-2"></i>
                    <div class="text-sm text-green-800">
                        <p class="font-semibold">Transaksi Aman</p>
                        <p>Pembayaran diproses dengan teknologi enkripsi 256-bit SSL</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getMinimarketInstructions() {
    const minimarketName = selectedPaymentMethod === 'alfamart' ? 'Alfamart' : 'Indomaret';
    const paymentCode = 'PAY' + orderData.orderNumber.slice(-6);
    
    return `
        <div class="space-y-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-semibold text-red-800 mb-3">Pembayaran di ${minimarketName}</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kode Pembayaran</span>
                        <div class="flex items-center">
                            <span class="font-mono font-bold text-lg">${paymentCode}</span>
                            <button onclick="copyToClipboard('${paymentCode}')" class="ml-2 text-blue-500 hover:text-blue-700">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Bayar</span>
                        <span class="font-bold text-green-600">Rp${orderData.totalAmount.toLocaleString('id-ID')}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                    <li>Kunjungi ${minimarketName} terdekat</li>
                    <li>Berikan kode pembayaran: <span class="font-mono font-semibold">${paymentCode}</span> kepada kasir</li>
                    <li>Kasir akan memproses transaksi</li>
                    <li>Bayar sesuai nominal yang tertera</li>
                    <li>Simpan struk pembayaran</li>
                    <li>Pembayaran akan diproses otomatis</li>
                </ol>
            </div>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i class="fas fa-clock text-orange-600 mt-1 mr-2"></i>
                    <div class="text-sm text-orange-800">
                        <p class="font-semibold">Batas Waktu Pembayaran:</p>
                        <p>24 jam setelah pemesanan. Lewat dari itu, pesanan akan dibatalkan otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getCODInstructions() {
    return `
        <div class="space-y-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-3">Bayar di Tempat (COD)</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah yang dibayar ke kurir</span>
                        <span class="font-bold text-green-600">Rp${orderData.totalAmount.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Alamat pengiriman</span>
                        <span class="font-medium text-right text-sm">${orderData.address.address}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">Informasi Penting:</h4>
                <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                    <li>Pesanan akan dikirim ke alamat yang tertera</li>
                    <li>Pastikan ada yang menerima saat pengiriman</li>
                    <li>Pembayaran dilakukan tunai kepada kurir</li>
                    <li>Periksa kondisi barang sebelum pembayaran</li>
                    <li>Simpan struk pembayaran dari kurir</li>
                </ul>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i class="fas fa-truck text-blue-600 mt-1 mr-2"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Estimasi Pengiriman:</p>
                        <p>1-3 hari kerja tergantung lokasi. Anda akan mendapat notifikasi ketika kurir dalam perjalanan.</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function startPaymentTimer(seconds) {
    let timeLeft = seconds;
    
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const secs = timeLeft % 60;
        
        document.getElementById('paymentTimer').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            clearPaymentTimer();
            Swal.fire({
                icon: 'warning',
                title: 'Waktu Pembayaran Habis',
                text: 'Batas waktu pembayaran telah berakhir. Pesanan dibatalkan.',
                confirmButtonText: 'OK'
            }).then(() => {
                closePaymentModal();
            });
            return;
        }
        
        timeLeft--;
    }
    
    updateTimer();
    paymentTimer = setInterval(updateTimer, 1000);
}

function clearPaymentTimer() {
    if (paymentTimer) {
        clearInterval(paymentTimer);
        paymentTimer = null;
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Tersalin!',
            text: 'Informasi telah disalin ke clipboard',
            timer: 1500,
            showConfirmButton: false
        });
    });
}

function copyPaymentInfo() {
    let copyText = `Nomor Pesanan: ${orderData.orderNumber}\n`;
    copyText += `Total Pembayaran: Rp${orderData.totalAmount.toLocaleString('id-ID')}\n`;
    
    if (selectedPaymentMethod.includes('bank_')) {
        const accountNumbers = {
            'bank_bca': '1234567890',
            'bank_mandiri': '1300012345678',
            'bank_bni': '1234567890',
            'bank_bri': '123456789012345'
        };
        copyText += `Rekening: ${accountNumbers[selectedPaymentMethod]}\n`;
        copyText += `Atas Nama: PT PhoneKu Indonesia`;
    }
    
    copyToClipboard(copyText);
}

function checkPaymentStatus() {
    Swal.fire({
        icon: 'info',
        title: 'Mengecek Status...',
        text: 'Menunggu konfirmasi pembayaran',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        // Simulate payment check
        Swal.fire({
            icon: 'info',
            title: 'Pembayaran Belum Diterima',
            text: 'Pembayaran Anda belum kami terima. Mohon lakukan pembayaran sesuai instruksi.',
            confirmButtonText: 'OK'
        });
    });
}

function goToOrderHistory() {
    // Redirect to order history page
    window.location.href = '/orders';
}

function redirectToCardPayment() {
    // Simulate redirect to card payment gateway
    Swal.fire({
        icon: 'info',
        title: 'Mengalihkan...',
        text: 'Anda akan diarahkan ke halaman pembayaran kartu yang aman',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        // In real implementation, redirect to actual payment gateway
        // window.location.href = 'https://payment-gateway.com/...';
        console.log('Redirect to card payment gateway');
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('paymentModal');
    if (event.target === modal) {
        closePaymentModal();
    }
}

// Prevent closing modal when clicking inside
document.querySelector('.modal-content').onclick = function(event) {
    event.stopPropagation();
}
</script>
@endsection