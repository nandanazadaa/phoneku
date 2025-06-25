<div class="bg-white p-4 md:p-6 rounded-lg shadow sticky top-6">
    <h2 class="text-lg md:text-xl font-semibold mb-4">Ringkasan Transaksi</h2>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span>Total Harga (1 Barang)</span>
            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Ongkos Kirim</span>
            <span>Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Biaya Aplikasi</span>
            <span>Rp{{ number_format($serviceFee, 0, ',', '.') }}</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
    <button id="pay-button" class="btn btn-primary w-full mt-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" @if($cartItems->isEmpty()) disabled @endif>Bayar Sekarang</button>
</div>

<!-- Tambahkan skrip Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function() {
                const cartItems = @json($cartItems);
                if (!cartItems || cartItems.length === 0) {
                    alert('Keranjang Anda kosong. Tambahkan produk terlebih dahulu.');
                    return;
                }

                // Ensure product_id and quantity are available
                const productId = cartItems[0]?.product_id || null;
                const quantity = cartItems[0]?.quantity || null;

                if (!productId || !quantity) {
                    alert('Data produk atau kuantitas tidak tersedia. Periksa keranjang Anda.');
                    return;
                }

                console.log('Sending data:', { product_id: productId, quantity: quantity, shipping_cost: {{ $shippingCost }}, service_fee: {{ $serviceFee }} });

                fetch('/checkout/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        shipping_cost: {{ $shippingCost }},
                        service_fee: {{ $serviceFee }}
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Network response was not ok ' + response.statusText);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.snap_token) {
                        console.log('Snap token received:', data.snap_token);
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil! Order ID: ' + result.order_id);
                                window.location.href = '/thank-you?order_id=' + result.order_id;
                            },
                            onPending: function(result) {
                                alert('Pembayaran tertunda. Order ID: ' + result.order_id);
                                window.location.href = '/checkout';
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal! Silakan coba lagi. Detail: ' + JSON.stringify(result));
                                console.error('Error:', result);
                            },
                            onClose: function() {
                                alert('Anda telah menutup popup pembayaran.');
                            }
                        });
                    } else if (data.error) {
                        alert('Error: ' + data.error);
                    } else {
                        alert('Gagal mendapatkan token pembayaran. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Terjadi kesalahan saat membuat pesanan: ' + error.message);
                });
            });
        }
    });
</script>

<!-- Tambahkan meta tag CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">