<script>
    document.addEventListener('DOMContentLoaded', () => {
        const messages = @js([
            'success' => session('success'),
            'error' => session('error'),
            'warning' => session('warning'),
            'info' => session('info'),
        ]);

        Object.entries(messages).forEach(([type, message]) => {
            if (message) {
                window.AdminToast?.show(message, type);
            }
        });
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('admin-toast', ({ message, text, type = 'success', variant, ...options }) => {
            window.AdminToast?.show(message ?? text, variant ?? type, options);
        });
    });
</script>
