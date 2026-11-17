document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#inquiries-table');

    if (!table) {
        return;
    }

    const rows = Array.from(table.querySelectorAll('[data-inquiry-row]'));
    const search = document.querySelector('#inquiry-search');
    const stageFilter = document.querySelector('#inquiry-stage-filter');
    const emptyState = document.querySelector('#inquiry-empty-state');

    const applyFilters = () => {
        const query = search.value.trim().toLowerCase();
        const selectedStage = stageFilter.value;
        let visibleCount = 0;

        rows.forEach((row) => {
            const matchesQuery = row.textContent.toLowerCase().includes(query);
            const matchesStage = !selectedStage || row.dataset.status === selectedStage;
            const visible = matchesQuery && matchesStage;

            row.classList.toggle('d-none', !visible);
            visibleCount += Number(visible);
        });

        emptyState.classList.toggle('d-none', visibleCount > 0);
    };

    table.addEventListener('click', (event) => {
        const detailsButton = event.target.closest('[data-inquiry-details]');

        if (!detailsButton) {
            return;
        }

        const row = detailsButton.closest('[data-inquiry-row]');
        const cells = row.cells;

        window.Swal.fire({
            title: `Inquiry ${cells[0].textContent.trim()}`,
            text: [
                `${cells[1].textContent.trim().replace(/\s+/g, ' · ')}`,
                `Phone: ${cells[2].textContent.trim()}`,
                `Package: ${cells[3].textContent.trim()}`,
                `Requested travel: ${cells[4].textContent.trim()} · Travelers: ${cells[5].textContent.trim()}`,
                `Received: ${cells[6].textContent.trim()} · Stage: ${row.dataset.status}`,
                `Message: ${row.querySelector('[data-inquiry-message]').textContent.trim()}`,
            ].join('\n'),
            icon: 'info',
            confirmButtonText: 'Close',
            buttonsStyling: false,
            customClass: { confirmButton: 'btn btn-primary' },
        });
    });

    search.addEventListener('input', applyFilters);
    stageFilter.addEventListener('change', applyFilters);
    applyFilters();
});
