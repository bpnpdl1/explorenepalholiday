<script>
    const showAdminFlashToast = (message, type) => {
        if (!message) return;

        const toastClasses = {
            success: 'bg-success',
            error: 'bg-danger',
            warning: 'bg-warning',
            info: 'bg-info',
        };

        if (window.Toastify) {
            window.Toastify({
                text: String(message),
                duration: 4000,
                gravity: 'top',
                position: 'right',
                close: true,
                stopOnFocus: true,
                className: toastClasses[type] || 'bg-primary',
            }).showToast();
            return;
        }

        window.AdminToast?.show(message, type);
    };

    const flashMessages = @js([
        'success' => session('success'),
        'error' => session('error'),
        'warning' => session('warning'),
        'info' => session('info'),
    ]);

    const showFlashMessages = () => {
        Object.entries(flashMessages).forEach(([type, message]) => {
            showAdminFlashToast(message, type);
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showFlashMessages, { once: true });
    } else {
        showFlashMessages();
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('admin-toast', ({ message, text, type = 'success', variant, ...options }) => {
            window.AdminToast?.show(message ?? text, variant ?? type, options);
        });
    });
</script>
