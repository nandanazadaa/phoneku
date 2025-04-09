@extends('layouts.app')

@section('title', 'Product - PhoneKu')

@section('content')    

    <!-- Product Detail Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Product Image Section -->
            <div class="flex flex-col">
                <!-- Main Image Container with Arrows -->
                <div class="bg-gray-50 rounded-xl p-8 flex items-center justify-center mb-4 relative">
                    <!-- Red iPhone (default) -->
                    <img src="img/iphone-merah.png" alt="iPhone 11 Red" data-color="red" class="product-image active w-full max-w-md h-auto object-contain" style="min-height: 350px;">
                    
                    <!-- Pink iPhone -->
                    <img src="img/iphone-hitam.png" alt="iPhone 11 Pink" data-color="pink" class="product-image w-full max-w-md h-auto object-contain" style="min-height: 350px;">
                    
                    <!-- White iPhone -->
                    <img src="img/iphone-ungu.png" alt="iPhone 11 White" data-color="white" class="product-image w-full max-w-md h-auto object-contain" style="min-height: 350px;">
                    
                    <!-- Left Arrow -->
                    <div class="slider-arrow left">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    
                    <!-- Right Arrow -->
                    <div class="slider-arrow right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                
                <!-- Image Navigation Dots -->
                <div class="flex justify-center space-x-2">
                    <button class="w-8 h-3 rounded-full bg-blue-500 dot active" data-index="0"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300 dot" data-index="1"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300 dot" data-index="2"></button>
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
                        <div class="color-circle selected" style="background-color: #FF3B30;" data-color="red"></div>
                        <div class="color-circle" style="background-color: #000000;" data-color="pink"></div>
                        <div class="color-circle" style="background-color: #efa1ff; border: 1px solid #E5E7EB;" data-color="white"></div>
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

@endsection
 
    
@section('styles')
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

    /* New styles for image slider arrows */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.7);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #0ea5e9;
        font-size: 18px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .slider-arrow:hover {
        background-color: rgba(255, 255, 255, 0.9);
        color: #0369a1;
    }

    .slider-arrow.left {
        left: 10px;
    }

    .slider-arrow.right {
        right: 10px;
    }

    .product-image {
        display: none;
    }

    .product-image.active {
        display: block;
    }
</style>
@endsection

@section('scripts')
    <script>
        // Color selection
        const colorCircles = document.querySelectorAll('.color-circle');
        const productImages = document.querySelectorAll('.product-image');
        const dots = document.querySelectorAll('.dot');
        let currentImageIndex = 0;
        
        // Function to update image slider based on index
        function updateImageSlider(index) {
            // Hide all images
            productImages.forEach(img => {
                img.classList.remove('active');
            });
            
            // Show selected image
            productImages[index].classList.add('active');
            
            // Update dots
            dots.forEach(dot => {
                dot.classList.remove('active', 'bg-blue-500', 'w-8');
                dot.classList.add('bg-gray-300', 'w-3');
            });
            
            dots[index].classList.add('active', 'bg-blue-500', 'w-8');
            dots[index].classList.remove('bg-gray-300', 'w-3');
            
            // Update current index
            currentImageIndex = index;
        }
        
        // Color circle click event
        colorCircles.forEach(circle => {
            circle.addEventListener('click', () => {
                // Remove selected class from all circles
                colorCircles.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked circle
                circle.classList.add('selected');
                
                // Get color
                const selectedColor = circle.getAttribute('data-color');
                
                // Find image with matching color
                productImages.forEach((img, index) => {
                    if (img.getAttribute('data-color') === selectedColor) {
                        updateImageSlider(index);
                    }
                });
            });
        });
        
        // Dot click event
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                updateImageSlider(index);
            });
        });
        
        // Arrow click events
        const leftArrow = document.querySelector('.slider-arrow.left');
        const rightArrow = document.querySelector('.slider-arrow.right');
        
        leftArrow.addEventListener('click', () => {
            let newIndex = currentImageIndex - 1;
            if (newIndex < 0) {
                newIndex = productImages.length - 1;
            }
            updateImageSlider(newIndex);
        });
        
        rightArrow.addEventListener('click', () => {
            let newIndex = currentImageIndex + 1;
            if (newIndex >= productImages.length) {
                newIndex = 0;
            }
            updateImageSlider(newIndex);
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
@endsection
