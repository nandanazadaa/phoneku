<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Global variables
let paymentTimer;
let selectedPaymentMethod = null;
let orderData = null;
let selectedCourier = 'jne';
let courierCost = 20000;

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

function updateTotal() {
    const subtotal = {{ $subtotal ?? 0 }};
    const serviceFee = {{ $serviceFee ?? 0 }};
    let total = subtotal + courierCost + serviceFee;
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
// (re-init on DOMContentLoaded)
document.addEventListener('DOMContentLoaded', function() {
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
    setTimeout(() => {
        createOrder();
    }, 2000);
}
function createOrder() {
    const orderNumber = 'PH' + Date.now();
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
    document.getElementById('orderNumber').textContent = orderNumber;
    document.getElementById('totalPaymentAmount').textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
    showPaymentInstructions();
    showPaymentInstruction();
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
    // ... (copy logic dari checkout.blade.php sebelumnya)
}
// ... (lanjutkan semua fungsi JS dari checkout.blade.php sebelumnya)
</script> 