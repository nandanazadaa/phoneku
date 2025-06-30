<div class="bg-white p-4 md:p-6 rounded-lg shadow">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg text-gray-500 font-medium uppercase">Produk Dipesan</h2>
    </div>
    <div class="p-4 space-y-6">
        @forelse($cartItems as $item)
        <div class="flex items-center gap-4 border-b last:border-b-0 pb-4 last:pb-0">
            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-contain rounded-lg border">
            <div class="flex-1">
                <div class="font-semibold text-gray-800">{{ $item->product->name }}</div>
                <div class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</div>
                <div class="text-sm text-gray-500">Harga Satuan: Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                <div class="text-sm text-green-600 font-medium">Tersedia</div>
            </div>
            <div class="text-right">
                <div class="font-bold text-lg text-gray-800">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                <div class="text-xs text-gray-500">Total</div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500">Tidak ada produk di keranjang.</div>
        @endforelse
    </div>
    <div class="p-4 border-t border-gray-200">
        <p class="text-sm text-gray-500">Estimasi Tiba: 10 - 15 April</p>
    </div>
</div>