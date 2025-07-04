@extends('layouts.main')

@section('title', 'Detail Order')
@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:underline mb-4 inline-block">&larr; Kembali ke daftar order</a>
    <h1 class="text-2xl font-bold mb-4">Detail Order</h1>
    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="mb-2"><b>Kode Order:</b> {{ $order->order_code }}</div>
        <div class="mb-2"><b>User:</b> {{ $order->user->name ?? '-' }} ({{ $order->user->email ?? '-' }})</div>
        <div class="mb-2"><b>Tanggal:</b> {{ $order->created_at->format('d-m-Y H:i') }}</div>
        <div class="mb-2"><b>Alamat Pengiriman:</b> {{ $order->shipping_address }}</div>
        <div class="mb-2"><b>Kurir:</b> {{ $order->courier }} ({{ $order->courier_service }})</div>
        <div class="mb-2"><b>Status Pembayaran:</b> <span class="px-2 py-1 rounded text-xs @if($order->payment_status=='completed') bg-green-100 text-green-700 @elseif($order->payment_status=='pending') bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif">{{ ucfirst($order->payment_status) }}</span></div>
        <div class="mb-2"><b>Status Pesanan:</b> <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">{{ ucfirst(str_replace('telah sampai', 'Telah Sampai', $order->order_status)) }}</span></div>
        <div class="mb-2"><b>Subtotal:</b> Rp{{ number_format($order->subtotal,0,',','.') }}</div>
        <div class="mb-2"><b>Ongkir:</b> Rp{{ number_format($order->shipping_cost,0,',','.') }}</div>
        <div class="mb-2"><b>Biaya Layanan:</b> Rp{{ number_format($order->service_fee,0,',','.') }}</div>
        <div class="mb-2"><b>Total:</b> <b>Rp{{ number_format($order->total,0,',','.') }}</b></div>
    </div>
    <h2 class="text-lg font-semibold mb-2">Produk</h2>
    <div class="bg-white rounded shadow p-4 mb-4">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-2 py-1 border">Nama Produk</th>
                    <th class="px-2 py-1 border">Qty</th>
                    <th class="px-2 py-1 border">Harga Satuan</th>
                    <th class="px-2 py-1 border">Subtotal</th>
                    <th class="px-2 py-1 border">Stok Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-2 py-1 border">{{ $item->product->name ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $item->quantity }}</td>
                    <td class="px-2 py-1 border">Rp{{ number_format($item->price,0,',','.') }}</td>
                    <td class="px-2 py-1 border">Rp{{ number_format($item->quantity * $item->price,0,',','.') }}</td>
                    <td class="px-2 py-1 border">
                        @if($item->product)
                            <span class="px-2 py-1 rounded text-xs @if($item->product->stock > 10) bg-green-100 text-green-700 @elseif($item->product->stock > 0) bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif">
                                {{ $item->product->stock }} unit
                            </span>
                        @else
                            <span class="text-gray-500">Produk tidak ditemukan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form method="post" action="{{ route('admin.orders.update', $order->id) }}" class="bg-white rounded shadow p-4">
        @csrf
        @method('PATCH')
        <div class="mb-2">
            <label class="block font-semibold mb-1">Status Pesanan</label>
            <select name="order_status" class="border rounded px-2 py-1" required>
                <option value="dibuat" @selected($order->order_status=='dibuat')>Pesanan Dibuat</option>
                <option value="diproses" @selected($order->order_status=='diproses')>Sedang Diproses</option>
                <option value="dikirimkan" @selected($order->order_status=='dikirimkan')>Dikirimkan</option>
                <option value="dalam pengiriman" @selected($order->order_status=='dalam pengiriman')>Dalam Pengiriman</option>
                <option value="telah sampai" @selected($order->order_status=='telah sampai')>Telah Sampai</option>
                <option value="selesai" @selected($order->order_status=='selesai')>Selesai</option>
                <option value="dibatalkan" @selected($order->order_status=='dibatalkan')>Dibatalkan</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="block font-semibold mb-1">Status Pembayaran</label>
            <select name="payment_status" class="border rounded px-2 py-1">
                <option value="pending" @selected($order->payment_status=='pending')>Pending</option>
                <option value="completed" @selected($order->payment_status=='completed')>Completed</option>
                <option value="failed" @selected($order->payment_status=='failed')>Failed</option>
                <option value="refunded" @selected($order->payment_status=='refunded')>Refunded</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="block font-semibold mb-1">Catatan (Opsional)</label>
            <textarea name="notes" class="border rounded px-2 py-1 w-full" rows="3" placeholder="Tambahkan catatan untuk order ini...">{{ $order->notes ?? '' }}</textarea>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Update Status</button>
    </form>
</div>
@endsection
