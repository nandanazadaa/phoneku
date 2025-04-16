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
                    <img src="img/iphone-merah.png" alt="iPhone 11 Red" data-color="red"
                        class="product-image active w-full max-w-md h-auto object-contain" style="min-height: 350px;">

                    <!-- Pink iPhone -->
                    <img src="img/iphone-hitam.png" alt="iPhone 11 Pink" data-color="pink"
                        class="product-image w-full max-w-md h-auto object-contain" style="min-height: 350px;">

                    <!-- White iPhone -->
                    <img src="img/iphone-ungu.png" alt="iPhone 11 White" data-color="white"
                        class="product-image w-full max-w-md h-auto object-contain" style="min-height: 350px;">

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
                        <div class="color-circle" style="background-color: #efa1ff; border: 1px solid #E5E7EB;"
                            data-color="white"></div>
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
                        <div class="flex flex-col">
                            <div class="flex items-center space-x-2 mb-2">
                                <button class="quantity-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="text" value="1" class="quantity-input" readonly>
                                <button class="quantity-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <p class="text-sm text-blue-600 font-bold">Stok: 25</p>
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
                            <button
                                class="border border-blue-500 bg-white text-blue-500 py-2 px-3 rounded-md flex items-center">
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

        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Testimoni Pelanggan</h2>
            
            <!-- Initial Testimonials (3 shown by default) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 testimonial-initial">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user1.jpg" alt="User 1" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Andi Pratama</p>
                            <p class="text-sm text-gray-500">Jakarta</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Produk sangat berkualitas! Pengiriman cepat dan packing aman."</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof1.jpg" alt="Proof of Purchase 1" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
        
                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user2.png" alt="User 2" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Siti Nurhaliza</p>
                            <p class="text-sm text-gray-500">Bandung</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star empty"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"iPhone sesuai deskripsi, performa luar biasa."</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof2.jpg" alt="Proof of Purchase 2" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
        
                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user3.jpg" alt="User 3" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Rudi Hartono</p>
                            <p class="text-sm text-gray-500">Surabaya</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Harga kompetitif dan produk original."</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof3.jpg" alt="Proof of Purchase 3" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
            </div>
        
            <!-- Additional Testimonials (hidden by default) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 testimonial-more hidden">
                <!-- Testimonial 4 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user4.jpg" alt="User 4" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Budi Santoso</p>
                            <p class="text-sm text-gray-500">Yogyakarta</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star empty"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Pelayanan ramah, barang sampai tepat waktu."</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof4.jpg" alt="Proof of Purchase 4" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
        
                <!-- Testimonial 5 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user5.jpg" alt="User 5" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Dewi Lestari</p>
                            <p class="text-sm text-gray-500">Bali</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Sangat puas, barang sesuai ekspektasi."</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof5.jpg" alt="Proof of Purchase 5" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
        
                <!-- Testimonial 6 -->
                <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="img/user6.jpg" alt="User 6" class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-gray-800 font-semibold">Eko Widodo</p>
                            <p class="text-sm text-gray-500">Medan</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="star-rating flex">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Belanja di sini selalu menyenangkan!"</p>
                    <div class="proof-img-container h-32 overflow-hidden rounded-md">
                        <img src="img/proof6.jpg" alt="Proof of Purchase 6" class="w-full h-full object-cover proof-image">
                    </div>
                </div>
            </div>
        
            <!-- See More Button -->
            <div class="text-center mt-8">
                <button id="see-more-btn" class="bg-blue-500 text-white py-2 px-8 rounded-md font-medium hover:bg-blue-600 transition">
                    Lihat lebih banyak
                </button>
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

        /* Testimonial Card Styles */
        .testimonial-card {
            transition: all 0.2s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Star Rating in Testimonials */
        .testimonial-card .star-rating .star {
            color: #0ea5e9;
            font-size: 14px;
        }

        .testimonial-card .star-rating .star.empty {
            color: #94a3b8;
        }

        /* Proof Image */
        .testimonial-card img[src*="proof"] {
            border: 1px solid #e5e7eb;
        }

        /* Hidden Class */
        .hidden {
            display: none;
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

@section('scripts')
    <script>
        const seeMoreBtn = document.getElementById('see-more-btn');
        const testimonialMore = document.querySelector('.testimonial-more');

        seeMoreBtn.addEventListener('click', () => {
            testimonialMore.classList.remove('hidden');
            seeMoreBtn.classList.add('hidden');
        });

// Lightbox functionality
document.addEventListener('DOMContentLoaded', function() {
  // Create lightbox elements
  const lightbox = document.createElement('div');
  lightbox.id = 'image-lightbox';
  lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden';
  
  const lightboxContent = document.createElement('div');
  lightboxContent.className = 'relative max-w-4xl mx-auto';
  
  const lightboxImage = document.createElement('img');
  lightboxImage.className = 'max-h-screen max-w-full';
  lightboxImage.alt = 'Enlarged image';
  
  const closeButton = document.createElement('button');
  closeButton.className = 'absolute top-4 right-4 text-white text-4xl hover:text-gray-300';
  closeButton.innerHTML = '&times;';
  closeButton.onclick = closeLightbox;
  
  // Append elements
  lightboxContent.appendChild(lightboxImage);
  lightboxContent.appendChild(closeButton);
  lightbox.appendChild(lightboxContent);
  document.body.appendChild(lightbox);
  
  // Add click event to all testimonial images
  const testimonialImages = document.querySelectorAll('.testimonial-card img[src*="proof"]');
  testimonialImages.forEach(img => {
    img.classList.add('cursor-pointer', 'hover:opacity-90', 'transition');
    img.addEventListener('click', function() {
      openLightbox(this.src);
    });
  });
  
  // Lightbox functions
  function openLightbox(imgSrc) {
    lightboxImage.src = imgSrc;
    lightbox.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Add keyboard event listener
    document.addEventListener('keydown', handleKeyDown);
  }
  
  function closeLightbox() {
    lightbox.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    
    // Remove keyboard event listener
    document.removeEventListener('keydown', handleKeyDown);
  }
  
  function handleKeyDown(e) {
    if (e.key === 'Escape') {
      closeLightbox();
    }
  }
  
  // Close lightbox when clicking outside the image
  lightbox.addEventListener('click', function(e) {
    if (e.target === this) {
      closeLightbox();
    }
  });
  
  // Testimonial "See More" functionality
  const seeMoreBtn = document.getElementById('see-more-btn');
  const testimonialMore = document.querySelector('.testimonial-more');
  
  if (seeMoreBtn && testimonialMore) {
    seeMoreBtn.addEventListener('click', function() {
      testimonialMore.classList.remove('hidden');
      seeMoreBtn.classList.add('hidden');
      
      // Apply lightbox functionality to newly visible images
      const newImages = testimonialMore.querySelectorAll('img[src*="proof"]');
      newImages.forEach(img => {
        img.classList.add('cursor-pointer', 'hover:opacity-90', 'transition');
        img.addEventListener('click', function() {
          openLightbox(this.src);
        });
      });
    });
  }
});
    </script>
@endsection
