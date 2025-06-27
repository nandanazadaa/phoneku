@extends('layouts.app')

@section('title', 'Checkout - PhoneKu')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Checkout</h3>

            @if($cartItems->isEmpty())
                <div class="text-center text-gray-500">Keranjang Anda kosong.</div>
            @else
                <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="products" id="productsInput">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cart Items Summary -->
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Daftar Belanja</h4>
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="font-semibold">{{ $item->product->name }}</p>
                                        <p>Jumlah: {{ $item->quantity }}</p>
                                        <p>Harga: Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                            <div class="mt-4 pt-4 border-t">
                                <p class="font-semibold">Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Shipping and Payment Details -->
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Detail Pengiriman & Pembayaran</h4>
                            <div class="bg-white p-4 md:p-6 rounded-lg shadow mb-4">
                                <h5 class="text-md font-semibold mb-2">Pilih Kurir</h5>
                                <select class="form-control mb-2 w-full border rounded p-2" name="courier" id="courier" required>
                                    @foreach($couriers as $courier)
                                        <option value="{{ $courier->courier }}">{{ ucfirst($courier->courier) }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control mb-2 w-full border rounded p-2" name="courier_service" id="courier_service" required>
                                    @foreach($couriers as $courier)
                                        <option value="{{ $courier->service_type }}" data-courier="{{ $courier->courier }}" data-cost="{{ $courier->shipping_cost }}">{{ ucfirst($courier->service_type) }} (Rp {{ number_format($courier->shipping_cost, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                                <p id="shipping-cost-display" class="text-sm">Biaya Pengiriman: Rp{{ number_format($shippingCost, 0, ',', '.') }}</p>
                                <p class="text-sm">Biaya Layanan: Rp{{ number_format($serviceFee, 0, ',', '.') }}</p>
                                <p class="text-lg font-bold mt-2">Total: Rp{{ number_format($total, 0, ',', '.') }}</p>
                            </div>

                            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Lanjutkan Pembayaran</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const form = $('#checkoutForm');
        const productsInput = $('#productsInput');
        const courierSelect = $('#courier');
        const serviceSelect = $('#courier_service');
        const shippingCostDisplay = $('#shipping-cost-display');

        // Prepare products data for submission
        const cartItems = @json($cartItems);
        const products = cartItems.map(item => ({
            product_id: item.product_id,
            quantity: item.quantity
        }));
        productsInput.val(JSON.stringify(products));

        // Filter service types based on selected courier
        courierSelect.on('change', function() {
            const selectedCourier = $(this).val();
            serviceSelect.find('option').each(function() {
                const option = $(this);
                if (option.data('courier') === selectedCourier || !option.data('courier')) {
                    option.show();
                } else {
                    option.hide();
                }
            });
            serviceSelect.val(serviceSelect.find('option:visible:first').val()).trigger('change');
        });

        // Update shipping cost display
        serviceSelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const cost = selectedOption.data('cost') || 0;
            shippingCostDisplay.text('Biaya Pengiriman: Rp' + cost.toLocaleString('id-ID'));
            // Optionally, update total via AJAX or recalculate if needed
        });

        // Trigger initial change to set correct options
        courierSelect.trigger('change');
    });
</script>
@endpush