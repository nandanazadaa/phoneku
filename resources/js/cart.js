document.addEventListener('DOMContentLoaded', function() {
    // Get all needed elements
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const checkoutButton = document.getElementById('checkout-btn');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const deleteButtons = document.querySelectorAll('.delete-item-btn');
    const alertContainer = document.getElementById('alert-container');
    const orderSummary = document.getElementById('order-summary');
    
    // Set CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Format number to Indonesian Rupiah
    function formatRupiah(number) {
        if (isNaN(number)) return 'Rp0';
        return 'Rp' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Calculate total price based on checked items
    function updateTotalPrice() {
        let total = 0;
        let checkedCount = 0;
        const currentCheckboxes = document.querySelectorAll('.cart-checkbox');
        
        currentCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.getAttribute('data-price'));
                checkedCount++;
            }
        });

        // Update texts
        if (subtotalElement && totalElement) {
            subtotalElement.textContent = formatRupiah(total);
            totalElement.textContent = formatRupiah(total);

            // Update the subtotal label in the summary based on checked count
            const subtotalLabel = subtotalElement.previousElementSibling;
            if (subtotalLabel && subtotalLabel.tagName === 'SPAN') {
                subtotalLabel.textContent = `Subtotal (${checkedCount} Item Dipilih)`;
            }
        }

        // Enable/disable checkout button if no items are selected
        if (checkoutButton) {
            checkoutButton.disabled = (checkedCount === 0);
            if (checkedCount === 0) {
                checkoutButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                checkoutButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            } else {
                checkoutButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                checkoutButton.classList.add('bg-blue-500', 'hover:bg-blue-600');
            }
        }
    }

    // Show an alert message
    function showAlert(message, type = 'success') {
        // Create alert div
        const alertDiv = document.createElement('div');
        alertDiv.className = `bg-${type === 'success' ? 'green' : type === 'warning' ? 'orange' : 'red'}-100 
                              text-${type === 'success' ? 'green' : type === 'warning' ? 'orange' : 'red'}-700 
                              p-4 rounded mb-6 alert-slide-in`;
        alertDiv.textContent = message;
        
        // Add to container
        alertContainer.appendChild(alertDiv);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            alertDiv.classList.add('alert-fade-out');
            setTimeout(() => {
                alertContainer.removeChild(alertDiv);
            }, 500);
        }, 3000);
    }

    // Check if cart is empty and update UI accordingly
    function checkEmptyCart() {
        const items = document.querySelectorAll('.cart-item');
        
        if (items.length === 0) {
            // Create empty cart message if it doesn't exist
            if (!document.getElementById('empty-cart-message')) {
                const emptyMessage = document.createElement('div');
                emptyMessage.id = 'empty-cart-message';
                emptyMessage.className = 'text-center py-8 col-span-full';
                emptyMessage.innerHTML = `
                    <p class="text-gray-500 text-lg">Keranjang Anda kosong.</p>
                    <a href="{{ route('allproduct') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                        Mulai Belanja
                    </a>
                `;
                cartItemsContainer.appendChild(emptyMessage);
            }
            
            // Hide order summary
            if (orderSummary) {
                orderSummary.style.display = 'none';
            }
        }
    }

    // Handle item deletion with AJAX
    function setupDeleteHandlers() {
        document.querySelectorAll('.delete-item-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!confirm('Yakin ingin menghapus item ini?')) {
                    return;
                }
                
                const itemId = this.getAttribute('data-item-id');
                const cartItem = document.getElementById(`cart-item-${itemId}`);
                
                // Start fade out animation
                cartItem.classList.add('fade-out');
                
                // Send AJAX request to delete item
                fetch(`{{ url('cart') }}/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Wait for animation to complete then remove element
                    setTimeout(() => {
                        cartItem.remove();
                        
                        // Show success message
                        showAlert(data.message || 'Item berhasil dihapus dari keranjang');
                        
                        // Update the cart totals
                        updateTotalPrice();
                        
                        // Check if cart is empty
                        checkEmptyCart();
                    }, 500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    cartItem.classList.remove('fade-out'); // Remove animation if failed
                    showAlert('Gagal menghapus item dari keranjang', 'error');
                });
            });
        });
    }

    // Add event listener to each checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });
    
    // Setup delete handlers
    setupDeleteHandlers();

    // Initialize total price on page load
    updateTotalPrice();
});