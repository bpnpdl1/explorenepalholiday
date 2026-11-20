const toastTypes = {
    success: 'success',
    error: 'danger',
    danger: 'danger',
    warning: 'warning',
    info: 'info',
    primary: 'primary',
};
window.AdminToast = {
    show(message, type = 'success', options = {}) {
        if (!message || !window.Toastify) {
            return;
        }

        const className = toastTypes[type] ?? 'primary';

        window.Toastify({
            text: String(message),
            duration: options.duration ?? 4000,
            gravity: options.gravity ?? 'top',
            position: options.position ?? 'right',
            close: options.close ?? true,
            stopOnFocus: true,
            className: `bg-${className}`,
            offset: { x: 0, y: 12 },
        }).showToast();
    },
};
