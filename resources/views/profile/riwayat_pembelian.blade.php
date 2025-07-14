@extends('layouts.app')

@section('title', 'Riwayat Pembelian - PhoneKu')

@section('content')
<div class="relative">
    <div class="bg-blue-500 min-h-[400px] sm:min-h-[400px] md:min-h-[500px] lg:min-h-[400px] xl:min-h-[350px] relative">
    </div>

    <div class="absolute bottom-[-24px] left-0 w-full overflow-hidden wave-container" style="line-height: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#f9fafb" fill-opacity="1"
                d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <div
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4/5 max-w-3xl z-0 pointer-events-none">
        <div class="relative w-full h-full" style="overflow: hidden;">
            <img src="{{ asset('img/banner4.png') }}" alt="Smartphones"
                class="object-contain w-full h-auto max-h-[300px] md:max-h-[350px] lg:max-h-[400px]">
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8 relative -mt-48 z-10">
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-4">
            <div class="bg-white rounded-xl p-4 shadow-md mb-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-gray-200 shadow-sm">
                        <img src="{{ $user->profile && $user->profile->profile_picture ? asset('storage/' . $user->profile->profile_picture) : asset('img/profile.png') }}"
                            alt="User Profile" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold mb-1 text-gray-800">{{ $user->name }}</h2>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                <a href="{{ route('profile') }}"
                    class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-user w-5 mr-3 text-center"></i>
                    <span>Tentang Saya</span>
                </a>
                <a href="{{ route('riwayatbeli') }}"
                    class="flex items-center py-3 px-4 bg-blue-500 text-gray-100 rounded-xl shadow-sm">
                    <i class="fas fa-history w-5 mr-3 text-center"></i>
                    <span>Riwayat Pembelian</span>
                </a>
                <a href="{{ route('profilekeamanan') }}"
                    class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-shield-alt w-5 mr-3 text-center"></i>
                    <span>Keamanan & Privasi</span>
                </a>
                <a href="{{ route('profile.logout') }}"
                    class="flex items-center py-3 px-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </div>

        <section class="w-full md:w-3/4">
            <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">Riwayat Pembelian</h3>
                <p class="text-gray-500 mb-6">Lihat dan Telusuri Jejak dan Transaksi Pembelian Anda</p>

                @forelse($orders as $order)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300 mb-4">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center pb-4 border-b border-gray-200">
                            <div class="mb-2 md:mb-0">
                                <p class="text-sm text-gray-500">
                                    Tanggal Pesanan: <span class="font-semibold">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }} WIB</span>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Kode Pesanan: <span class="font-semibold">{{ $order->order_code }}</span>
                                </p>
                            </div>
                            <div class="flex flex-col md:flex-row gap-2">
                                <span class="text-sm px-3 py-1 rounded-full whitespace-nowrap
                                            @if($order->payment_status == 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($order->payment_status == 'completed') bg-green-100 text-green-700
                                            @elseif($order->payment_status == 'failed') bg-red-100 text-red-700
                                            @elseif($order->payment_status == 'refunded') bg-gray-100 text-gray-700
                                            @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <span class="text-sm px-3 py-1 rounded-full whitespace-nowrap
                                            @if($order->order_status == 'dibuat') bg-yellow-100 text-yellow-700
                                            @elseif($order->order_status == 'diproses') bg-blue-100 text-blue-700
                                            @elseif($order->order_status == 'dikirimkan') bg-blue-100 text-blue-700
                                            @elseif($order->order_status == 'dalam pengiriman') bg-blue-100 text-blue-700
                                            @elseif($order->order_status == 'telah sampai') bg-green-100 text-green-700
                                            @elseif($order->order_status == 'selesai') bg-green-100 text-green-700
                                            @elseif($order->order_status == 'dibatalkan') bg-red-100 text-red-700
                                            @endif">
                                    {{ $order->order_status == 'telah sampai' ? 'Telah Sampai' : ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>

                        @foreach($order->orderItems as $item)
                        <div class="flex flex-col md:flex-row md:items-center gap-4 w-full border-t border-gray-100 pt-4">
                            <div class="flex flex-row gap-4 w-full md:w-2/3">
                                <div class="w-24 md:w-32 flex-shrink-0">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('img/default_product.png') }}"
                                        alt="{{ $item->product->name }}" class="w-full h-auto rounded-md object-cover">
                                </div>

                                <div class="flex flex-col justify-between w-full text-base text-gray-700 space-y-1">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h4>
                                    <p>Warna: 
                                        @if($item->color)
                                            @if(preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $item->color))
                                                <span class="inline-block w-4 h-4 rounded-full border border-gray-300 align-middle mr-1" style="background: {{ $item->color }};"></span>
                                            @endif
                                            {{ $item->color }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    <p>SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                    <p>Jumlah: {{ $item->quantity }}</p>
                                    <p>Harga Per Unit: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 w-full md:w-1/3 md:items-end">
                                <div class="text-sm text-right">
                                    <p class="text-gray-600">Total Harga Item:</p>
                                    <p class="font-semibold text-gray-800">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex flex-col gap-2 w-full md:w-auto text-right">
                                    @if($item->product)
                                    <a href="{{ route('product.show', $item->product->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-5 py-2 rounded-full flex items-center justify-center">
                                        Beli Lagi
                                    </a>
                                    @endif
                                    @if($item->product)
                                    @php
                                    $alreadyReviewed = \App\Models\Testimonial::where('user_id', auth()->id())
                                    ->where('order_item_id', $item->id) // Ganti product_id dengan order_item_id
                                    ->exists();
                                    @endphp
                                    @if($order->payment_status === 'completed' && $order->order_status === 'selesai')
                                    @if(!$alreadyReviewed)
                                    <a href="{{ route('ulasan.form', ['orderItem' => $item->id]) }}"
                                        class="bg-blue-700 hover:bg-blue-600 text-white text-sm px-5 py-2 rounded-full">
                                        Beri Ulasan
                                    </a>
                                    @else
                                    <button class="bg-green-400 text-white text-sm px-5 py-2 rounded-full" disabled>
                                        Sudah Diberi Ulasan
                                    </button>
                                    @endif
                                    @else
                                    <button class="bg-gray-400 text-white text-sm px-5 py-2 rounded-full" disabled>
                                        Dalam Proses
                                    </button>
                                    @endif
                                    @endif


                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="w-full text-right mt-4 pt-4 border-t border-gray-200 space-y-1">
                            <p class="text-sm text-gray-600">Subtotal: <span class="font-semibold">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span></p>
                            <p class="text-sm text-gray-600">Biaya Pengiriman: <span class="font-semibold">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }} ({{ $order->courier_service ?? 'N/A' }})</span></p>
                            <p class="text-sm text-gray-600">Biaya Layanan: <span class="font-semibold">Rp{{ number_format($order->service_fee, 0, ',', '.') }}</span></p>
                            <p class="text-lg text-gray-700 font-bold mt-2">Total Pembayaran: <span class="text-blue-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm text-center text-gray-500">
                    <p class="mb-4">Anda belum memiliki riwayat pembelian.</p>
                    <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline inline-block">Mulai Belanja Sekarang!</a>
                </div>
                @endforelse
                @if ($orders->hasPages())
                    <div class="flex justify-center mt-10">
                        <nav role="navigation" aria-label="Pagination Navigation"
                            class="inline-flex rounded-md shadow-sm overflow-hidden border border-gray-200">

                            {{-- Previous Page Link --}}
                            @if ($orders->onFirstPage())
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">←</span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}"
                                    class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">←</a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($orders->links()->elements[0] as $page => $url)
                                @if ($page == $orders->currentPage())
                                    <span class="px-4 py-2 text-sm bg-blue-500 text-white">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}"
                                    class="px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-100 transition">→</a>
                            @else
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed">→</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>
        </section>
    </div>
</div>
@endsection
