<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Pembayaran Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-green-600 mb-4">Terima Kasih!</h1>
        <p class="text-gray-700 mb-4">Pembayaran Anda telah berhasil.</p>
        @if(isset($orderId))
            <p class="text-gray-700 mb-4">Order ID: <span class="font-semibold">{{ $orderId }}</span></p>
        @endif
        <p class="text-gray-600 mb-6">Kami akan segera memproses pesanan Anda. Cek status pesanan di halaman profil Anda.</p>
        <a href="{{ route('cart') }}" class="btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Kembali ke Keranjang</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show SweetAlert2 when page loads
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                html: `
                    <div class="text-center">
                        <p class="mb-3">Terima kasih telah berbelanja di PhoneKu</p>
                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                            <p class="text-sm text-gray-600">Order ID:</p>
                            <p class="font-semibold text-gray-800">{{ $orderId ?? 'N/A' }}</p>
                        </div>
                        <p class="text-sm text-gray-600">Pesanan Anda akan segera diproses. Anda dapat melacak status pesanan di halaman profil.</p>
                    </div>
                `,
                confirmButtonText: 'Lanjutkan',
                confirmButtonColor: '#3B82F6',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const redirectUrl = "{{ route('cart') }}";
                    console.log('Redirecting to:', redirectUrl);
                    window.location.href = redirectUrl;
                }
            });
        });
    </script>
</body>
</html>