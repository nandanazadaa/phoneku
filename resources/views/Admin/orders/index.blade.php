@extends('layouts.main')

@section('title', 'Manajemen Order')
@section('content')
<!-- Header biru gradient -->
<div class="bg-gradient-to-r from-blue-600 to-blue-400 rounded-b-2xl shadow-md px-8 py-8 mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-1">Manajemen Order</h1>
        <p class="text-white text-opacity-80">Manage Orders &amp; Transactions</p>
    </div>
</div>
<!-- Card utama -->
<div class="bg-white rounded-2xl shadow-lg p-0 md:p-8">
    <form method="get" class="mb-6 flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode/order/user/email..." class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 w-full md:w-64">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 w-full md:w-48">
            <option value="all">Semua Status</option>
            <option value="pending" @selected(request('status')=='pending')>Pending</option>
            <option value="completed" @selected(request('status')=='completed')>Completed</option>
            <option value="failed" @selected(request('status')=='failed')>Failed</option>
        </select>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <th class="px-4 py-3 font-semibold text-left">Kode</th>
                    <th class="px-4 py-3 font-semibold text-left">User</th>
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-left">Total</th>
                    <th class="px-4 py-3 font-semibold text-left">Status</th>
                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="@if($loop->even) bg-gray-50 @endif hover:bg-blue-50 transition">
                    <td class="px-4 py-3 font-mono text-gray-800">{{ $order->order_code }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-900">Rp{{ number_format($order->total,0,',','.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($order->payment_status=='completed') bg-green-100 text-green-700
                            @elseif($order->payment_status=='pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-lg text-xs font-semibold transition">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8 text-gray-400">Tidak ada order ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6 px-4 pb-4">{{ $orders->links() }}</div>
</div>
@endsection
