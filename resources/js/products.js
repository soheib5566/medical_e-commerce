const ProductManager = {
    init() {
        this.bindEvents();
        this.initializeFilters();
    },

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.filterProducts();
                }, 300);
            });
        }

        // Category filter
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', () => this.filterProducts());
        }

        // Sort functionality
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', () => this.sortProducts());
        }
    },

    initializeFilters() {
        // Set initial state
        this.filterProducts();
    },

    filterProducts() {
        const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
        const selectedCategory = document.getElementById('category-filter')?.value || '';
        
        const productCards = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        productCards.forEach(card => {
            const name = card.dataset.name || '';
            const category = card.dataset.category || '';
            
            const matchesSearch = name.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
                card.classList.add('animate-scale-in');
                visibleCount++;
            } else {
                card.style.display = 'none';
                card.classList.remove('animate-scale-in');
            }
        });

        // Show/hide no products message
        const noProductsMsg = document.getElementById('no-products');
        if (noProductsMsg) {
            noProductsMsg.classList.toggle('hidden', visibleCount > 0);
        }

        // Re-sort visible products
        this.sortProducts();
    },

    sortProducts() {
        const sortValue = document.getElementById('sort-select')?.value || 'name';
        const grid = document.getElementById('products-grid');
        
        if (!grid) return;

        const cards = Array.from(grid.querySelectorAll('.product-card[style*="block"], .product-card:not([style*="none"])'))
            .filter(card => card.style.display !== 'none');

        cards.sort((a, b) => {
            switch (sortValue) {
                case 'price-low':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price-high':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'name':
                default:
                    return a.dataset.name.localeCompare(b.dataset.name);
            }
        });

        // Reorder DOM elements
        cards.forEach(card => {
            grid.appendChild(card);
        });

        // Add staggered animation
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.05}s`;
        });
    },

    // Price range filter (if needed later)
    filterByPriceRange(min, max) {
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            const price = parseFloat(card.dataset.price);
            const inRange = price >= min && price <= max;
            
            if (inRange) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
};