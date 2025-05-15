<div class="sticky top-4 h-fit">
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
            </div>
            <div class="flex justify-between font-bold text-xl pt-4 border-t border-gray-200 text-gray-800">
                <span>Total Pembayaran</span>
                <span id="total-amount">Rp{{ number_format($subtotal + $shippingCost + $serviceFee, 0, ',', '.') }}</span>
            </div>
            <button type="button" class="w-full bg-blue-500 text-white rounded-lg py-3 mt-6 font-bold hover:bg-blue-600 transition text-lg sticky bottom-0" onclick="openPaymentModal()">
                Buat Pesanan
            </button>
            <p class="text-gray-500 text-xs text-center mt-3">
                Dengan melanjutkan pembayaran, kamu menyetujui S&K yang berlaku
            </p>
        </div>
    </div>
</div> 