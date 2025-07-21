@extends('layouts.app')

@section('title', 'Checkout - PhoneKu')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <main class="container mx-auto px-2 md:px-4 pb-12">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-6 mt-2 md:mt-5">Checkout</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kiri: Alamat, Produk, Kurir -->
            <div class="lg:col-span-2 space-y-6">
                @include('checkout._address')
                @include('checkout._products')
            </div>
            <!-- Kanan: Ringkasan & Bayar -->
            <div>
                @include('checkout._summary')
            </div>
        </div>
        <!-- Modal Edit Alamat -->
        @include('checkout._modal_address')
        <!-- Modal Pembayaran Lengkap -->
        @include('checkout._modal_payment')
    </main>
</div>
@endsection

@section('styles')
<style>
    @media (max-width: 600px) {
        .sticky.bottom-0 {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 40;
            border-radius: 0;
        }
    }
</style>
@endsection

@section('scripts')
@include('checkout._checkout_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CEGAH DUPLIKASI: hanya tambahkan jika belum ada event listener
        if (!window.__hamburgerMenuFixed) {
            window.__hamburgerMenuFixed = true;
            const hamburgerButton = document.getElementById('hamburger-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (hamburgerButton && mobileMenu) {
                hamburgerButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('active');
                    // Toggle icon
                    const isOpen = !mobileMenu.classList.contains('hidden');
                    const svg = hamburgerButton.querySelector('svg');
                    if (svg) {
                        if (isOpen) {
                            svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`;
                        } else {
                            svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                        }
                    }
                });
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!hamburgerButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        if (!mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                            mobileMenu.classList.remove('active');
                            const svg = hamburgerButton.querySelector('svg');
                            if (svg) {
                                svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                            }
                        }
                    }
                });
                // Close menu when clicking a link
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.classList.remove('active');
                        const svg = hamburgerButton.querySelector('svg');
                        if (svg) {
                            svg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                        }
                    });
                });
            }
        }
    });
</script>
@endsection
