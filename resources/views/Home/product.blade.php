<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - iPhone 11 258GB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .color-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .color-circle.selected {
            border: 2px solid #0ea5e9;
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.3);
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            background-color: white;
            border-radius: 9999px;
            cursor: pointer;
        }
        
        .star-rating .star {
            color: #0ea5e9;
            font-size: 24px;
        }
        
        .star-rating .star.empty {
            color: #94a3b8;
        }
        
        .tab-button {
            position: relative;
        }
        
        .tab-button::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #0ea5e9;
        }
        
        .check-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .check-icon {
            background-color: #22c55e;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            flex-shrink: 0;
            margin-top: 3px;
        }
    </style>
</head>
<body class="font-sans bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-400">
        <div class="container mx-auto px-4 py-4">
            <div class="bg-white rounded-xl p-4 flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-blue-500">Beranda</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500">Tim</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500 border-b-2 border-blue-500 pb-1">Belanja</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500">Kontak</a>
                </div>
                
                <!-- Icons -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-blue-500">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </a>
                    <a href="#" class="text-blue-500">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Detail Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Product Image Section -->
            <div class="flex flex-col">
                <!-- Main Image -->
                <div class="bg-gray-50 rounded-xl p-8 flex items-center justify-center mb-4">
                    <img src="img/iphone11.png" alt="iPhone 11 Red" class="w-full max-w-md h-auto object-contain" style="min-height: 350px;">
                </div>
                
                <!-- Image Navigation Dots -->
                <div class="flex justify-center space-x-2">
                    <button class="w-8 h-3 rounded-full bg-blue-500"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                </div>
            </div>
            
            <!-- Product Info Section -->
            <div>
                <p class="text-gray-600 mb-1">Handphone</p>
                <h1 class="text-4xl font-bold mb-4">Iphone11 258GB</h1>
                
                <!-- Rating -->
                <div class="star-rating flex mb-6">
                    <span class="star"><i class="fas fa-star"></i></span>
                    <span class="star"><i class="fas fa-star"></i></span>
                    <span class="star"><i class="fas fa-star"></i></span>
                    <span class="star"><i class="fas fa-star"></i></span>
                    <span class="star empty"><i class="fas fa-star"></i></span>
                </div>
                
                <!-- Color Selection -->
                <div class="mb-8">
                    <h3 class="text-gray-800 font-semibold mb-3">WARNA</h3>
                    <div class="flex space-x-4">
                        <div class="color-circle selected" style="background-color: #FF3B30;"></div>
                        <div class="color-circle" style="background-color: #FFA698;"></div>
                        <div class="color-circle" style="background-color: #FFFFFF; border: 1px solid #E5E7EB;"></div>
                    </div>
                </div>
                
                <!-- Price -->
                <div class="flex justify-between mb-8">
                    <div>
                        <h3 class="text-gray-800 font-semibold mb-2">HARGA</h3>
                        <div class="flex flex-col">
                            <p class="text-3xl font-bold">Rp 7,500,000</p>
                            <p class="text-gray-500 line-through">Rp 9,500,000</p>
                        </div>
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <h3 class="text-gray-800 font-semibold mb-2">KUANTITAS</h3>
                        <div class="flex items-center space-x-2">
                            <button class="quantity-btn">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" value="1" class="quantity-input" readonly>
                            <button class="quantity-btn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Details Tab -->
                <div class="mb-6">
                    <div class="border-b border-gray-200 mb-4">
                        <button class="tab-button text-gray-800 font-semibold px-4 py-2">DETAIL</button>
                    </div>
                    
                    <div class="text-gray-700">
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span>Layar: 6.1 inci Liquid Retina HD Display</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span>Prosesor: A13 Bionic Chip – Cepat dan Efisien</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span>Kamera: Dual 12 MP (Wide & Ultra-Wide) + Night Mode</span>
                        </div>
                    </div>
                </div>
                
                <!-- Total Price and Buttons -->
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-600 font-medium">TOTAL HARGA</p>
                            <p class="text-2xl font-bold">Rp 7,500,000</p>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button class="border border-blue-500 bg-white text-blue-500 py-2 px-3 rounded-md flex items-center">
                                <span class="text-xl mr-1">+</span>
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button class="bg-blue-500 text-white py-2 px-12 rounded-md font-medium">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Newsletter Section -->
<div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-xl mx-4 my-12">
    <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-between">
        <div class="text-white mb-6 md:mb-0">
            <h2 class="text-2xl font-bold uppercase">Tetap Update</h2>
            <h2 class="text-2xl font-bold uppercase">Dengan Penawaran Kami</h2>
        </div>
        
        <div class="w-full md:w-auto">
            <div class="flex flex-col md:flex-row gap-4">
                <input type="email" placeholder="Masukkan Email Anda" class="px-4 py-3 rounded-full focus:outline-none">
                <button class="bg-white text-gray-800 font-medium px-6 py-3 rounded-full hover:bg-gray-100">
                    Mulai Berlangganan Buletin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white pt-10 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center mb-4">
                    <img src="img/logo2.png" alt="PhoneKu Logo" class="h-10">
                </div>
                <p class="text-gray-600 mb-4">
                    We have clothes that suits your style and which you're proud to wear. From women to men.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-500">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-500">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-500">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            
            <!-- Company Links -->
            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Perusahaan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Tentang</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Fitur</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Tim Kami</a></li>
                </ul>
            </div>
            
            <!-- Product Links -->
            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Produk & Layanan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Customer Support</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Delivery Details</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Terms & Conditions</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Privacy Policy</a></li>
                </ul>
            </div>
            
            <!-- Payment Methods -->
            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Pembayaran</h3>
                <div class="flex flex-wrap gap-2">
                    <img src="/api/placeholder/60/40" alt="Dana" class="h-8">
                    <img src="/api/placeholder/60/40" alt="OVO" class="h-8">
                    <img src="/api/placeholder/60/40" alt="GoPay" class="h-8">
                    <img src="/api/placeholder/60/40" alt="BRI" class="h-8">
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 mt-10 pt-6">
            <p class="text-gray-500 text-sm text-center">
                Phone.Ku © 2025-Present All Rights Reserved
            </p>
        </div>
    </div>
</footer>
 
    
    <script>
        // Color selection
        const colorCircles = document.querySelectorAll('.color-circle');
        colorCircles.forEach(circle => {
            circle.addEventListener('click', () => {
                // Remove selected class from all circles
                colorCircles.forEach(c => c.classList.remove('selected'));
                // Add selected class to clicked circle
                circle.classList.add('selected');
            });
        });
        
        // Quantity buttons
        const minusBtn = document.querySelector('.quantity-btn:first-child');
        const plusBtn = document.querySelector('.quantity-btn:last-child');
        const quantityInput = document.querySelector('.quantity-input');
        
        minusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });
    </script>
</body>
</html>