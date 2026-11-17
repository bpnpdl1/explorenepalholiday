<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('admin-toast', ({ message, text, type = 'success', variant, ...options }) => {
            window.AdminToast?.show(message ?? text, variant ?? type, options);
        });
    });
</script>
