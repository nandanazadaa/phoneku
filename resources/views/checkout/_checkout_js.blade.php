<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        const courier = document.getElementById('courier').value;
        const courierService = document.getElementById('courier-service').value;
        const shippingAddress = document.getElementById('address-section').innerText.trim();

        $.ajax({
            url: '{{ route('checkout.store') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                courier: courier,
                courier_service: courierService,
                shipping_address: shippingAddress,
                shipping_cost: {{ $shippingCost }},
                service_fee: {{ $serviceFee }}
            },
            success: function(response) {
                snap.pay(response.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '/checkout/success?order_id=' + result.order_id;
                    },
                    onPending: function(result) {
                        window.location.href = '/checkout/pending?order_id=' + result.order_id;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal!');
                    }
                });
            },
            error: function(xhr) {
                alert('Terjadi kesalah saat membuat pesanan.');
            }
        });
    };

document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            if (target) {
                target.style.display = 'flex';
            }
        });
    });

    // Close modal functionality (if not already handled)
    document.querySelectorAll('.modal .close, .modal .bg-opacity-50').forEach(element => {
        element.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>