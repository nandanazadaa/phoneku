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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center mb-4">
                    <img src="img/logo2.png" alt="PhoneKu Logo" class="h-15">
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

<!-- JavaScript for slider -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Banner slider functionality
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dot');
        
        if (slides.length > 0 && dots.length > 0) {
            let currentSlide = 0;
            let slideInterval;
    
            // Initialize slider
            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => {
                    slide.style.display = 'none';
                    slide.classList.remove('active');
                });
                
                // Remove active class from all dots
                dots.forEach(dot => {
                    dot.classList.remove('active');
                    dot.classList.remove('bg-blue-500');
                    dot.classList.add('bg-gray-300');
                });
                
                // Show the current slide
                slides[index].style.display = 'block';
                slides[index].classList.add('active');
                
                // Add active class to current dot
                dots[index].classList.add('active');
                dots[index].classList.remove('bg-gray-300');
                dots[index].classList.add('bg-blue-500');
                
                // Update current slide index
                currentSlide = index;
            }
    
            // Auto slide function
            function startSlideShow() {
                slideInterval = setInterval(function() {
                    let nextSlide = (currentSlide + 1) % slides.length;
                    showSlide(nextSlide);
                }, 5000); // Change slide every 5 seconds
            }
    
            // Add click event to dots
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    let slideIndex = parseInt(this.getAttribute('data-slide'));
                    showSlide(slideIndex);
                    
                    // Reset the interval when manually changing slides
                    clearInterval(slideInterval);
                    startSlideShow();
                });
            });
    
            // Initialize the first slide
            showSlide(0);
            
            // Start the slideshow
            startSlideShow();
        }
    });
</script>