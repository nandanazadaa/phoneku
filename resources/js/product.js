document.addEventListener('DOMContentLoaded', function () {
    // --- Color Selection ---
    const colorOptions = document.querySelectorAll('.color-option');
    const selectedColorInput = document.getElementById('selected-color');
    let selectedColor = null;

    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected state from all options
            colorOptions.forEach(opt => {
                opt.classList.remove('selected');
                opt.style.transform = 'scale(1)';
            });
            
            // Add selected state to clicked option
            this.classList.add('selected');
            this.style.transform = 'scale(1.1)';
            
            // Update selected color
            selectedColor = this.dataset.color;
            selectedColorInput.value = selectedColor;
            
            console.log('Selected color:', selectedColor);
        });
    });

    // --- Image Slider ---
    const images = document.querySelectorAll('.product-image');
    const dots = document.querySelectorAll('.dot');
    const leftArrow = document.querySelector('.slider-arrow.left');
    const rightArrow = document.querySelector('.slider-arrow.right');
    let currentImageIndex = 0;
    const totalImages = images.length;

    function showImage(index) {
        if (totalImages === 0) return;
        index = (index + totalImages) % totalImages; // Wrap around index

        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
            img.style.opacity = (i === index) ? 1 : 0; // Use opacity for transition
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
            dot.classList.toggle('bg-blue-500', i === index);
            dot.classList.toggle('w-6', i === index); // Wider active dot
            dot.classList.toggle('bg-gray-300', i !== index);
            dot.classList.toggle('w-2', i !== index); // Smaller inactive dot
        });
        currentImageIndex = index;
    }

    if (leftArrow && rightArrow && totalImages > 1) { // Only add listeners if multiple images
        leftArrow.addEventListener('click', () => showImage(currentImageIndex - 1));
        rightArrow.addEventListener('click', () => showImage(currentImageIndex + 1));
    }

    dots.forEach(dot => {
        dot.addEventListener('click', () => showImage(parseInt(dot.dataset.index)));
    });

    if (totalImages > 0) showImage(0); // Initialize

    // --- Quantity Counter & Total Price Update ---
    const quantityInputDetail = document.querySelector('.quantity-input');
    const minusBtnDetail = document.querySelector('.minus-btn');
    const plusBtnDetail = document.querySelector('.plus-btn');
    const totalPriceDisplay = document.getElementById('total-price-display');
    // Get product data from window object
    const productPrice = window.productData ? window.productData.price : 0;
    const stock = window.productData ? window.productData.stock : 0;

    function formatRupiah(number) {
        if (isNaN(number)) return 'Rp 0';
        // Use Intl.NumberFormat for better localization
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    function updateDetailTotalPrice() {
        if (!quantityInputDetail || stock <= 0) {
            if (totalPriceDisplay) totalPriceDisplay.textContent = formatRupiah(0);
            return;
        }
        let quantity = parseInt(quantityInputDetail.value);

        if (isNaN(quantity) || quantity < 1) quantity = 1;
        if (quantity > stock) quantity = stock;
        quantityInputDetail.value = quantity; // Correct input value

        const total = productPrice * quantity;
        if (totalPriceDisplay) totalPriceDisplay.textContent = formatRupiah(total);

        // Update button states
        if (minusBtnDetail) minusBtnDetail.disabled = (quantity <= 1);
        if (plusBtnDetail) plusBtnDetail.disabled = (quantity >= stock);
    }

    if (minusBtnDetail) minusBtnDetail.addEventListener('click', () => {
        if (parseInt(quantityInputDetail.value) > 1) {
            quantityInputDetail.value--;
            updateDetailTotalPrice();
        }
    });
    if (plusBtnDetail) plusBtnDetail.addEventListener('click', () => {
        if (parseInt(quantityInputDetail.value) < stock) {
            quantityInputDetail.value++;
            updateDetailTotalPrice();
        }
    });
    if (quantityInputDetail) {
        quantityInputDetail.addEventListener('input', updateDetailTotalPrice);
        quantityInputDetail.addEventListener('change', updateDetailTotalPrice);
    }
    updateDetailTotalPrice(); // Initial update

    // --- AJAX Add to Cart & Buy Now Logic ---
    const productActionForm = document.getElementById('product-action-form');

    function submitProductAction(button, redirectCheckout = false) {
        if (!productActionForm) return;

        const formData = new FormData(productActionForm);
        const actionUrl = button.getAttribute('formaction') || productActionForm.action;
        const originalButtonContent = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Loading...';

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => {
                if (response.status === 401) {
                    // Redirect to login if needed
                    window.location.href = `/login?redirect=${encodeURIComponent(window.location.href)}`;
                    throw new Error('Unauthorized');
                }
                if (!response.ok && response.status !== 400) {
                    throw new Error('Network error: ' + response.statusText);
                }
                return response.json().catch(() => {
                    throw new Error('Invalid JSON response');
                });
            })
            .then(data => {
                if (data.success) {
                    // Update cart count
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement && data.cartCount !== undefined) {
                        cartCountElement.textContent = data.cartCount;
                        cartCountElement.classList.toggle('hidden', data.cartCount <= 0);
                    }

                    if (redirectCheckout) {
                        window.location.href = "/checkout";
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Ditambahkan ke keranjang.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Aksi gagal.'
                    });
                }
            })
            .catch(error => {
                if (error.message !== 'Unauthorized') {
                    console.error('Action Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan.'
                    });
                }
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = originalButtonContent;
            });
    }

    document.querySelectorAll('.add-to-cart-btn').forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        submitProductAction(btn, false);
    }));
    document.querySelectorAll('.buy-now-btn').forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        submitProductAction(btn, true);
    }));

    // --- Testimonial "See More" ---
    // (Kode JS Testimoni dari file asli Anda bisa ditaruh di sini)
    const seeMoreBtn = document.getElementById('see-more-btn');
    const testimonialMore = document.querySelector('.testimonial-more');
    if (seeMoreBtn && testimonialMore) {
        seeMoreBtn.addEventListener('click', () => {
            testimonialMore.classList.remove('hidden');
            seeMoreBtn.classList.add('hidden');
            // Re-init lightbox for new images if needed
            initLightbox(testimonialMore.querySelectorAll('.proof-image'));
        });
    }

    // --- Image Lightbox ---
    // (Kode JS Lightbox dari file asli Anda bisa ditaruh di sini)
    const lightbox = document.createElement('div'); // ... (rest of lightbox code) ...
    // Initialize lightbox
    function initLightbox(imageElements) {
        imageElements.forEach(img => {
            img.style.cursor = 'pointer'; // Add pointer cursor
            img.removeEventListener('click', openLightboxHandler); // Remove old listeners
            img.addEventListener('click', openLightboxHandler);
        });
    }

    function openLightboxHandler() {
        openLightbox(this.src);
    } // Define handler
    initLightbox(document.querySelectorAll('.proof-image')); // Init for all proof images
});