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
                Kami memiliki ponsel yang sesuai dengan gaya Anda, dan Anda akan bangga memamerkannya. Dari desain yang ramping hingga performa yang tangguh.
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
                    <li><a href="{{ route('aboutus') }}" class="text-gray-600 hover:text-blue-500">Tentang</a></li>
                    <li><a href="{{ route('kontak') }}" class="text-gray-600 hover:text-blue-500">Kontak</a></li>
                    <li><a href="{{ route('tim') }}" class="text-gray-600 hover:text-blue-500">Tim Kami</a></li>
                </ul>
            </div>
            
            <!-- Product Links -->
            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Produk & Layanan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-blue-500">Customer Support</a></li>
                </ul>
            </div>
            
            <!-- Payment Methods -->
            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Pembayaran</h3>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow p-4 flex items-center justify-center">
                        <img src="/img/dana.png" alt="Dana" class="h-8 object-contain">
                    </div>

                    <div class="bg-white rounded-xl shadow p-4 flex items-center justify-center">
                        <img src="/img/shopeepay.png" alt="ShopeePay" class="h-8 object-contain">
                    </div>

                    <div class="bg-white rounded-xl shadow p-4 flex items-center justify-center">
                        <img src="/img/paypal.png" alt="Paypal" class="h-8 object-contain">
                    </div>

                    <div class="bg-white rounded-xl shadow p-4 flex items-center justify-center">
                        <img src="/img/bri.png" alt="BRI" class="h-8 object-contain">
                    </div>
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