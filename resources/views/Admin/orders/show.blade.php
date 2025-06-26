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
        <div class="mb-2"><b>Status Pengiriman:</b> <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">{{ $order->shipping_status ?? '-' }}</span></div>
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
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-2 py-1 border">{{ $item->product->name ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $item->quantity }}</td>
                    <td class="px-2 py-1 border">Rp{{ number_format($item->price,0,',','.') }}</td>
                    <td class="px-2 py-1 border">Rp{{ number_format($item->quantity * $item->price,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form method="post" action="{{ route('admin.orders.update', $order->id) }}" class="bg-white rounded shadow p-4">
        @csrf
        <div class="mb-2">
            <label class="block font-semibold mb-1">Status Pembayaran</label>
            <select name="payment_status" class="border rounded px-2 py-1">
                <option value="pending" @selected($order->payment_status=='pending')>Pending</option>
                <option value="completed" @selected($order->payment_status=='completed')>Completed</option>
                <option value="failed" @selected($order->payment_status=='failed')>Failed</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="block font-semibold mb-1">Status Pengiriman</label>
            <select name="shipping_status" class="border rounded px-2 py-1">
                <option value="processing" @selected($order->shipping_status=='processing')>Diproses</option>
                <option value="shipped" @selected($order->shipping_status=='shipped')>Dikirim</option>
                <option value="delivered" @selected($order->shipping_status=='delivered')>Selesai</option>
                <option value="cancelled" @selected($order->shipping_status=='cancelled')>Dibatalkan</option>
            </select>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Update Status</button>
    </form>
</div>
@endsection
