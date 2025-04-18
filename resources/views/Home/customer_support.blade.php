@extends('layouts.app')

@section('title', 'Customer Support - PhoneKu')

@section('content')
<div class="flex items-center justify-center my-8 mx-8 mb-12 bg-gray-100">
    <div class="w-full h-[700px] bg-white rounded-xl shadow-lg overflow-hidden"> <!-- Perubahan di sini -->
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-4 text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full" alt="Avatar">
                <div>
                    <h4 class="font-semibold">Jessica Cowles</h4>
                    <p class="text-sm">We typically reply in few minutes.</p>
                </div>
            </div>
            <i class="fas fa-ellipsis-v"></i>
        </div>

        <!-- Chat Body -->
        <div class="p-4 space-y-4 overflow-y-auto h-[500px]"> <!-- Tambahan scroll jika isi banyak -->
            <div class="bg-blue-100 text-blue-800 p-2 rounded-lg w-max">Hey, I want to know more about shipping rates 🤔</div>

            <div class="flex flex-col space-y-2">
                <button class="bg-white border border-blue-500 text-blue-500 px-3 py-1 rounded-full w-max hover:bg-blue-100">
                    Shipping rates to EU countries
                </button>
                <button class="bg-blue-500 text-white px-3 py-1 rounded-full w-max hover:bg-blue-600">
                    Shipping rates to USA
                </button>
            </div>

            <div class="bg-gray-100 p-3 rounded-lg">
                <p>Hey 👋 $5 standard shipping in the contiguous USA on orders under $50</p>
                <div class="flex items-center mt-2 space-x-2 text-gray-500 text-sm">
                    <span>Was this helpful?</span>
                    <i class="fas fa-thumbs-up cursor-pointer hover:text-blue-500"></i>
                    <i class="fas fa-thumbs-down cursor-pointer hover:text-red-500"></i>
                </div>
            </div>
        </div>

        <!-- Input Message -->
        <div class="border-t p-3 flex items-center space-x-2">
            <input type="text" placeholder="Enter your message..."
                   class="flex-1 p-2 border border-gray-300 rounded-full focus:outline-none focus:ring focus:border-blue-300">
            <button class="bg-blue-500 text-white p-3 rounded-full hover:bg-blue-600 flex items-center justify-center">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
@endsection
