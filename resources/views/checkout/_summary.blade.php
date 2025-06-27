<div class="bg-white p-4 md:p-6 rounded-lg shadow sticky top-6">
    <h2 class="text-lg md:text-xl font-semibold mb-4">Ringkasan Transaksi</h2>

    <!-- Courier Selection -->
    <div class="mb-4">
        <h3 class="text-md font-semibold mb-2">Pilih Kurir</h3>
        <select class="form-control mb-2 w-full border rounded p-2" id="courier" name="courier" required>
            <option value="">Pilih Kurir</option>
            @foreach($couriers as $courier)
                <option value="{{ $courier->courier }}">{{ ucfirst($courier->courier) }}</option>
            @endforeach
        </select>
        <select class="form-control mb-2 w-full border rounded p-2" id="courier-service" name="courier_service" required>
            <option value="">Pilih Jenis Layanan</option>
            @foreach($couriers as $courier)
                <option value="{{ $courier->service_type }}" data-courier="{{ $courier->courier }}" data-cost="{{ $courier->shipping_cost }}">{{ ucfirst($courier->service_type) }} (Rp{{ number_format($courier->shipping_cost, 0, ',', '.') }})</option>
            @endforeach
        </select>
    </div>

    <!-- Transaction Summary -->
    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span>Total Harga ({{ $cartItems->count() }} Barang)</span>
            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Ongkos Kirim</span>
            <span id="shipping-cost-display">Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Biaya Aplikasi</span>
            <span id="service-fee-display">Rp{{ number_format($serviceFee, 0, ',', '.') }}</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span id="total-display">Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <button id="pay-button" class="btn btn-primary w-full mt-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 {{ $cartItems->isEmpty() ? 'disabled' : '' }}">Bayar Sekarang</button>
    <form id="checkout-products-form" style="display:none;">
        @foreach($cartItems as $i => $item)
            <input type="hidden" name="products[{{ $i }}][product_id]" value="{{ $item->product_id }}">
            <input type="hidden" name="products[{{ $i }}][quantity]" value="{{ $item->quantity }}">
        @endforeach
        <input type="hidden" name="courier" id="selected-courier">
        <input type="hidden" name="courier_service" id="selected-courier-service">
    </form>
</div>

<!-- Tambahkan skrip Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        const courierSelect = document.getElementById('courier');
        const serviceSelect = document.getElementById('courier-service');
        const shippingCostDisplay = document.getElementById('shipping-cost-display');
        const serviceFeeDisplay = document.getElementById('service-fee-display');
        const totalDisplay = document.getElementById('total-display');
        const selectedCourierInput = document.getElementById('selected-courier');
        const selectedCourierServiceInput = document.getElementById('selected-courier-service');
        const subtotal = {{ $subtotal }};
        const serviceFee = {{ $serviceFee }};

        // Filter service types based on selected courier
        courierSelect.addEventListener('change', function() {
            const selectedCourier = this.value;
            const options = serviceSelect.options;
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (!selectedCourier || option.getAttribute('data-courier') === selectedCourier) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
            serviceSelect.value = ''; // Reset service selection
            updateDisplay();
        });

        // Update shipping cost and total display
        serviceSelect.addEventListener('change', function() {
            updateDisplay();
        });

        function updateDisplay() {
            const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
            const shippingCost = parseFloat(selectedService ? selectedService.getAttribute('data-cost') || 0 : 0);
            const total = subtotal + shippingCost + serviceFee;

            shippingCostDisplay.textContent = 'Rp' + shippingCost.toLocaleString('id-ID');
            totalDisplay.textContent = 'Rp' + total.toLocaleString('id-ID');
            selectedCourierInput.value = courierSelect.value || '';
            selectedCourierServiceInput.value = serviceSelect.value || '';
        }

        // Initial update
        updateDisplay();

        // Handle payment button click
        if (payButton) {
            payButton.addEventListener('click', function () {
                if (!courierSelect.value || !serviceSelect.value) {
                    alert('Silakan pilih kurir dan jenis layanan terlebih dahulu.');
                    return;
                }

                const form = document.getElementById('checkout-products-form');
                const formData = new FormData(form);
                const products = [];
                for (let pair of formData.entries()) {
                    const match = pair[0].match(/^products\[(\d+)\]\[(product_id|quantity)\]$/);
                    if (match) {
                        const idx = match[1];
                        const key = match[2];
                        if (!products[idx]) products[idx] = {};
                        products[idx][key] = pair[1];
                    }
                }
                if (!products.length) {
                    alert('Keranjang Anda kosong. Tambahkan produk terlebih dahulu.');
                    return;
                }

                const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
                const shippingCost = parseFloat(selectedService.getAttribute('data-cost') || 0);
                const total = subtotal + shippingCost + serviceFee;

                fetch('/checkout/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        products: products,
                        courier: courierSelect.value,
                        courier_service: serviceSelect.value,
                        shipping_cost: shippingCost,
                        service_fee: serviceFee,
                        total: total // Send the dynamically calculated total
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
                        snap.pay(data.snap_token, {
                            onSuccess: function (result) {
                                alert('Pembayaran berhasil! Order ID: ' + result.order_id);
                                window.location.href = '/thank-you?order_id=' + result.order_id;
                            },
                            onPending: function (result) {
                                alert('Pembayaran tertunda. Order ID: ' + result.order_id);
                                window.location.href = '/checkout';
                            },
                            onError: function (result) {
                                alert('Pembayaran gagal! Silakan coba lagi. Detail: ' + JSON.stringify(result));
                                console.error('Error:', result);
                            },
                            onClose: function () {
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

<meta name="csrf-token" content="{{ csrf_token() }}">