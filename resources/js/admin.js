const AdminPanel = {
    init() {
        this.bindEvents();
        this.initializeComponents();
    },

    bindEvents() {
        // Confirm delete actions
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                e.preventDefault();
                const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
                this.confirmDelete(btn);
            }
        });

        // Image preview for product forms
        document.addEventListener('change', (e) => {
            if (e.target.type === 'file' && e.target.accept && e.target.accept.includes('image')) {
                this.previewImage(e.target);
            }
        });
    },

    initializeComponents() {
        // Initialize any complex components here
        this.initializeDataTables();
    },

    confirmDelete(button) {
        const itemName = button.dataset.name || 'this item';
        const form = button.closest('form');
        
        if (confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`)) {
            if (form) {
                form.submit();
            } else {
                // Handle AJAX delete if needed
                const url = button.dataset.url;
                if (url) {
                    this.performDelete(url);
                }
            }
        }
    },

    async performDelete(url) {
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                Toast.show('Item deleted successfully', 'success');
                // Reload the page or remove the element
                setTimeout(() => window.location.reload(), 1000);
            } else {
                Toast.show('Failed to delete item', 'error');
            }
        } catch (error) {
            Toast.show('An error occurred', 'error');
            console.error('Delete error:', error);
        }
    },

    previewImage(input) {
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            // Look for existing preview or create new one
            let preview = input.parentNode.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'image-preview w-32 h-32 object-cover rounded border mt-2';
                input.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    },

    initializeDataTables() {
        // Add sorting and filtering to tables if needed
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(table => {
            this.makeTableSortable(table);
        });
    },

    makeTableSortable(table) {
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                this.sortTable(table, header.dataset.sort);
            });
        });
    },

    sortTable(table, column) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isNumeric = table.querySelector(`th[data-sort="${column}"]`).dataset.type === 'number';
        
        const currentOrder = table.dataset.sortOrder || 'asc';
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        
        rows.sort((a, b) => {
            const aVal = a.querySelector(`[data-sort-value]`).dataset.sortValue || a.children[column].textContent;
            const bVal = b.querySelector(`[data-sort-value]`).dataset.sortValue || b.children[column].textContent;
            
            let comparison = 0;
            if (isNumeric) {
                comparison = parseFloat(aVal) - parseFloat(bVal);
            } else {
                comparison = aVal.localeCompare(bVal);
            }
            
            return newOrder === 'asc' ? comparison : -comparison;
        });
        
        rows.forEach(row => tbody.appendChild(row));
        table.dataset.sortOrder = newOrder;
        
        // Update sort indicators
        table.querySelectorAll('th[data-sort]').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        table.querySelector(`th[data-sort="${column}"]`).classList.add(`sort-${newOrder}`);
    },

    // Form validation helpers
    validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                this.showFieldError(field, 'This field is required');
                isValid = false;
            } else {
                this.clearFieldError(field);
            }
        });
        
        return isValid;
    },

    showFieldError(field, message) {
        field.classList.add('border-destructive');
        
        let errorDiv = field.parentNode.querySelector('.field-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'field-error text-sm text-destructive mt-1';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    },

    clearFieldError(field) {
        field.classList.remove('border-destructive');
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    },

    // Utility functions
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    },

    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
};

// Initialize admin panel when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    AdminPanel.init();
});