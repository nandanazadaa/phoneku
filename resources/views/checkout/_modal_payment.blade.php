<div id="paymentModal" class="modal fixed inset-0 flex items-center justify-center z-50" style="display:none;">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closePaymentModal()"></div>
    <div class="modal-content relative bg-white rounded-lg shadow-lg w-full max-w-lg mx-auto p-0 z-10 animate-fadeIn">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-blue-500 text-2xl font-bold focus:outline-none z-20" onclick="closePaymentModal()">&times;</button>
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
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/bca.png') }}" alt="BCA" class="w-10 h-8 object-contain">
                                <span class="font-medium">Bank BCA</span>
                                <span class="ml-auto text-green-600 text-sm">Gratis</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="bank_mandiri" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/mandiri.png') }}" alt="Mandiri" class="w-10 h-8 object-contain">
                                <span class="font-medium">Bank Mandiri</span>
                                <span class="ml-auto text-green-600 text-sm">Gratis</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="bank_bni" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/bni.png') }}" alt="BNI" class="w-10 h-8 object-contain">
                                <span class="font-medium">Bank BNI</span>
                                <span class="ml-auto text-green-600 text-sm">Gratis</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="bank_bri" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/bri.png') }}" alt="BRI" class="w-10 h-8 object-contain">
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
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/gopay.png') }}" alt="GoPay" class="w-10 h-8 object-contain">
                                <span class="font-medium">GoPay</span>
                                <span class="ml-auto text-green-600 text-sm">Gratis</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="shopeepay" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/shopeepay.png') }}" alt="ShopeePay" class="w-10 h-8 object-contain">
                                <span class="font-medium">ShopeePay</span>
                                <span class="ml-auto text-red-500 text-sm">Rp2.500</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="ovo" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/ovo.png') }}" alt="OVO" class="w-10 h-8 object-contain">
                                <span class="font-medium">OVO</span>
                                <span class="ml-auto text-red-500 text-sm">Rp2.000</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="dana" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/dana.png') }}" alt="DANA" class="w-10 h-8 object-contain">
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
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/visa.png') }}" alt="Visa" class="w-10 h-8 object-contain">
                                <img src="{{ asset('img/payment/mastercard.png') }}" alt="Mastercard" class="w-10 h-8 object-contain">
                                <span class="font-medium ml-2">Kartu Kredit/Debit</span>
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
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/alfamart.png') }}" alt="Alfamart" class="w-10 h-8 object-contain">
                                <span class="font-medium">Alfamart</span>
                                <span class="ml-auto text-red-500 text-sm">Rp2.500</span>
                            </div>
                        </label>
                        <label class="payment-option block p-3 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                            <input type="radio" name="payment_method" value="indomaret" class="payment-radio mr-3" hidden>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/payment/indomaret.png') }}" alt="Indomaret" class="w-10 h-8 object-contain">
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
<style>
@keyframes fadeIn { from { opacity: 0; transform: scale(0.98);} to { opacity: 1; transform: scale(1);} }
.animate-fadeIn { animation: fadeIn 0.2s; }
</style> 