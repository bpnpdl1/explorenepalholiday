document.addEventListener('submit', async (event) => {
    const form = event.target.closest('[data-booking-status-confirm]');

    if (!form) return;

    event.preventDefault();

    const statusSelect = form.querySelector('[name="status"]');
    const nextStatus = form.dataset.nextStatus
        || statusSelect?.selectedOptions[0]?.textContent.trim()
        || 'the selected status';
    const reference = form.dataset.bookingReference;
    const isDangerous = form.dataset.dangerous === 'true' || statusSelect?.value === 'canceled';
    const confirmationText = `Move booking ${reference} to ${nextStatus}?`;

    if (!window.Swal) {
        if (window.confirm(confirmationText)) {
            HTMLFormElement.prototype.submit.call(form);
        }

        return;
    }

    const result = await window.Swal.fire({
        title: isDangerous ? 'Cancel this booking?' : 'Update booking status?',
        text: confirmationText,
        icon: isDangerous ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonText: isDangerous ? 'Yes, cancel booking' : `Yes, set to ${nextStatus}`,
        cancelButtonText: 'Go back',
        buttonsStyling: false,
        customClass: {
            confirmButton: `btn btn-${isDangerous ? 'danger' : 'primary'} me-2`,
            cancelButton: 'btn btn-light',
        },
    });

    if (result.isConfirmed) {
        HTMLFormElement.prototype.submit.call(form);
    }
});
