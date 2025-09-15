const Toast = {
    show(message, type = 'success', duration = 3000) {
        const container = document.getElementById('toast-container');
        if (!container) {
            console.warn('Toast container not found');
            return;
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type === 'success' ? 'toast-success' : 'toast-error'} animate-fade-in`;
        
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="h-5 w-5"></i>
                <span class="flex-1">${message}</span>
                <button class="toast-close p-1 hover:bg-black/10 rounded" onclick="this.parentElement.parentElement.remove()">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
        `;

        container.appendChild(toast);
        
        // Initialize Lucide icons for the new toast
        lucide.createIcons();

        // Auto remove after duration
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }
        }, duration);
    }
};