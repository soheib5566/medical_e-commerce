document.addEventListener('DOMContentLoaded', function () {
    // Initialize cart count in header
    updateCartCount();
});

// ----------------------
// Local helper functions
// ----------------------
function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartBadge = document.getElementById('cart-badge');
            if (cartBadge) {
                cartBadge.textContent = data.count;
                cartBadge.classList.toggle('hidden', data.count <= 0);
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    toast.textContent = message;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Auto remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Expose helpers globally
window.updateCartCount = updateCartCount;
window.showToast = showToast;

// ----------------------
// Cart actions
// ----------------------

// ✅ Add to Cart
window.addToCart = function (event, productId) {
    const button = event.currentTarget;
    const originalText = button.innerHTML;

    // Loading state
    button.innerHTML = 'Adding...';
    button.disabled = true;

    fetch(`/products/${productId}/cart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            showToast(data.message || 'Product added to cart!', 'success');
        } else {
            showToast(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showToast('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
};

// ✅ Update item quantity
window.updateQuantity = function(productId, action) {
    // Get current quantity from DOM
    const qtySpan = document.getElementById(`qty-${productId}`);
    let currentQty = parseInt(qtySpan ? qtySpan.textContent : 1);

    // Decide new quantity
    let newQuantity = currentQty;
    if (action === 'increase') newQuantity++;
    if (action === 'decrease') newQuantity--;

    if (newQuantity < 1) {
        removeFromCart(productId);
        return;
    }

    fetch(`/cart/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            showToast('Cart updated successfully');

            // ✅ Update the specific quantity span (main cart)
            if (qtySpan) qtySpan.textContent = newQuantity;

            // ✅ Update Order Summary
            const summaryQty = document.getElementById(`summary-qty-${productId}`);
            if (summaryQty) summaryQty.textContent = `Qty: ${newQuantity}`;

            const priceEl = document.querySelector(`#cart-item-${productId} p.text-blue-600`);
            if (priceEl) {
                const price = parseFloat(priceEl.textContent.replace('$', ''));
                const summaryPrice = document.getElementById(`summary-price-${productId}`);
                if (summaryPrice) summaryPrice.textContent = `$${(price * newQuantity).toFixed(2)}`;
            }

            recalcCartTotal();
        } else {
            showToast(data.message || 'Failed to update quantity', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
};


// ✅ Remove item from cart
window.removeFromCart = function(productId) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) return;

    fetch(`/cart/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            showToast('Item removed from cart');

            // Remove row from main cart
            const row = document.getElementById(`cart-item-${productId}`);
            if (row) row.remove();

            // ✅ Remove row from Order Summary
            const summaryRow = document.getElementById(`summary-item-${productId}`);
            if (summaryRow) summaryRow.remove();

            recalcCartTotal();
        } else {
            showToast(data.message || 'Failed to remove item', 'error');
        }
    })
    .catch(error => {
        console.error('Error removing item:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
};

// ✅ Recalculate cart total dynamically
function recalcCartTotal() {
    let total = 0;
    document.querySelectorAll('[id^="cart-item-"]').forEach(row => {
        const priceEl = row.querySelector('p.text-blue-600');
        const qtyEl = row.querySelector('span.text-lg');
        if (priceEl && qtyEl) {
            const price = parseFloat(priceEl.textContent.replace('$', ''));
            const qty = parseInt(qtyEl.textContent);
            total += price * qty;
        }
    });
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;
}