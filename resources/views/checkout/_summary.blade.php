<div class="bg-white p-4 md:p-6 rounded-lg shadow sticky top-6">
    <h2 class="text-lg md:text-xl font-semibold mb-4">Ringkasan Transaksi</h2>

    <!-- Courier Selection -->
    <div class="mb-4">
        <h3 class="text-md font-semibold mb-2">Pilih Kurir</h3>
        <select class="form-control mb-2 w-full border rounded p-2" id="courier" name="courier" required>
            <option value="">Pilih Kurir</option>
            @foreach($uniqueCouriers as $courier)
                <option value="{{ $courier->courier }}">{{ ucfirst($courier->courier) }}</option>
            @endforeach
        </select>
        <div>
            <!-- Dropdown untuk memilih JENIS LAYANAN -->
            <select class="form-control w-full border rounded p-2 transition-colors duration-200" id="courier-service" name="courier_service" required>
                <option value="">Pilih Jenis Layanan</option>
                {{-- Opsi ini akan diisi secara dinamis oleh JavaScript, tapi tetap ada di sini sebagai sumber data --}}
                @foreach($couriers as $courier)
                    <option value="{{ $courier->service_type }}" data-courier="{{ $courier->courier }}" data-cost="{{ $courier->shipping_cost }}" style="display: none;">
                        {{ ucfirst($courier->service_type) }} (Rp{{ number_format($courier->shipping_cost, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Transaction Summary -->
    <div class="space-y-3 text-sm">
        <!-- Product Breakdown -->
        <div class="border-b border-gray-200 pb-3">
            <h4 class="font-semibold text-gray-700 mb-2">Detail Produk</h4>
            @foreach($cartItems as $item)
            <div class="flex justify-between items-center mb-1">
                <div class="flex-1">
                    <div class="text-gray-800">{{ $item->product->name }}</div>
                    <div class="text-xs text-gray-500">{{ $item->quantity }} × Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                </div>
                <div class="text-right">
                    <div class="font-medium text-gray-800">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Cost Breakdown -->
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-700">Subtotal ({{ $cartItems->count() }} Barang)</span>
                <span class="font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-700">Ongkos Kirim</span>
                <span id="shipping-cost-display" class="font-medium">Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-700">Biaya Aplikasi</span>
                <span id="service-fee-display" class="font-medium">Rp{{ number_format($serviceFee, 0, ',', '.') }}</span>
            </div>
        </div>

        <hr class="my-3 border-gray-300">
        <div class="flex justify-between font-bold text-lg text-gray-800">
            <span>Total Pembayaran</span>
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

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const courierSelect = document.getElementById('courier');
            const serviceSelect = document.getElementById('courier-service');
            const allServiceOptions = Array.from(serviceSelect.options);

            // Fungsi untuk mengatur status awal atau me-reset dropdown layanan
            function setInitialServiceState() {
                // Nonaktifkan dropdown layanan
                serviceSelect.disabled = true;
                // Tambahkan style visual untuk menunjukkan elemen tidak aktif
                serviceSelect.classList.add('bg-gray-200', 'cursor-not-allowed');
                serviceSelect.classList.remove('bg-white');

                // Kosongkan isinya dan hanya tampilkan opsi placeholder
                serviceSelect.innerHTML = '';
                serviceSelect.appendChild(allServiceOptions[0]);
            }

            // Fungsi yang dijalankan setiap kali kurir diganti
            function handleCourierChange() {
                const selectedCourier = courierSelect.value;

                // Reset dropdown layanan terlebih dahulu
                setInitialServiceState();

                // Jika pengguna memilih kurir yang valid (bukan opsi "Pilih Kurir Anda")
                if (selectedCourier) {
                    // Aktifkan kembali dropdown layanan
                    serviceSelect.disabled = false;
                    // Hapus style nonaktif dan kembalikan style normal
                    serviceSelect.classList.remove('bg-gray-200', 'cursor-not-allowed');
                    serviceSelect.classList.add('bg-white');

                    // Loop dan tampilkan hanya layanan yang relevan
                    allServiceOptions.forEach(option => {
                        if (option.dataset.courier === selectedCourier) {
                            serviceSelect.appendChild(option);
                            option.style.display = 'block';
                        }
                    });
                }
            }

            // Jalankan fungsi event listener saat pilihan kurir berubah
            courierSelect.addEventListener('change', handleCourierChange);

            // Atur kondisi awal saat halaman pertama kali dimuat
            setInitialServiceState();
        });
</script>

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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih kurir dan jenis layanan terlebih dahulu.',
                        confirmButtonColor: '#3B82F6'
                    });
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Keranjang Kosong',
                        text: 'Keranjang Anda kosong. Tambahkan produk terlebih dahulu.',
                        confirmButtonColor: '#3B82F6'
                    });
                    return;
                }

                const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
                const shippingCost = parseFloat(selectedService.getAttribute('data-cost') || 0);
                const total = subtotal + shippingCost + serviceFee;

                fetch(window.location.origin + '/checkout/store', {
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
                                console.log('Payment Success:', result);

                                // Update payment status via frontend callback
                                fetch('/update-payment-status', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'settlement',
                                        transaction_id: result.transaction_id
                                    })
                                })
                                .then(response => {
                                    console.log('Update status response:', response);
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Payment status updated:', data);
                                })
                                .catch(error => {
                                    console.error('Error updating payment status:', error);
                                });

                                // Payment success will be handled by Midtrans callback redirect
                                console.log('Payment completed successfully. Redirecting to success page...');
                            },
                            onPending: function (result) {
                                console.log('Payment Pending:', result);

                                // Update payment status via frontend callback
                                fetch('/update-payment-status', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'pending',
                                        transaction_id: result.transaction_id
                                    })
                                })
                                .then(response => {
                                    console.log('Update status response:', response);
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Payment status updated:', data);
                                })
                                .catch(error => {
                                    console.error('Error updating payment status:', error);
                                });

                                Swal.fire({
                                    icon: 'info',
                                    title: 'Pembayaran Tertunda',
                                    html: `
                                        <div class="text-center">
                                            <p class="mb-3">Pembayaran Anda sedang dalam proses.</p>
                                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                                <p class="text-sm text-gray-600">Order ID:</p>
                                                <p class="font-semibold text-gray-800">${result.order_id}</p>
                                            </div>
                                            <p class="text-sm text-gray-600">Silakan selesaikan pembayaran Anda. Anda akan diarahkan kembali ke halaman checkout.</p>
                                        </div>
                                    `,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3B82F6',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const redirectUrl = window.location.origin + '/checkout';
                                        console.log('Redirecting to:', redirectUrl);
                                        window.location.href = redirectUrl;
                                    }
                                });
                            },
                            onError: function (result) {
                                console.log('Payment Error:', result);

                                // Update payment status via frontend callback
                                fetch('/update-payment-status', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'deny',
                                        transaction_id: result.transaction_id
                                    })
                                })
                                .then(response => {
                                    console.log('Update status response:', response);
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Payment status updated:', data);
                                })
                                .catch(error => {
                                    console.error('Error updating payment status:', error);
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    html: `
                                        <div class="text-center">
                                            <p class="mb-3">Maaf, pembayaran Anda gagal diproses.</p>
                                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                                <p class="text-sm text-gray-600">Order ID:</p>
                                                <p class="font-semibold text-gray-800">${result.order_id || 'N/A'}</p>
                                            </div>
                                            <p class="text-sm text-gray-600">Silakan coba lagi atau hubungi customer service jika masalah berlanjut.</p>
                                        </div>
                                    `,
                                    confirmButtonText: 'Coba Lagi',
                                    confirmButtonColor: '#EF4444',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect to checkout page to try again
                                        const redirectUrl = window.location.origin + '/checkout';
                                        console.log('Redirecting to checkout to try again:', redirectUrl);
                                        window.location.href = redirectUrl;
                                    }
                                });
                            },
                            onClose: function () {
                                console.log('Payment popup closed');
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda telah menutup popup pembayaran. Silakan coba lagi jika ingin melanjutkan pembayaran.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3B82F6'
                                });
                            }
                        });
                    } else if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            confirmButtonColor: '#EF4444'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Token Pembayaran Gagal',
                            text: 'Gagal mendapatkan token pembayaran. Silakan coba lagi.',
                            confirmButtonText: 'Coba Lagi',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat membuat pesanan: ' + error.message,
                        confirmButtonColor: '#EF4444'
                    });
                });
            });
        }
    });
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
