document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('seo-search');
    const statusFilter = document.getElementById('seo-status-filter');
    const robotsFilter = document.getElementById('seo-robots-filter');
    const rows = Array.from(document.querySelectorAll('[data-seo-row]'));
    const emptyState = document.getElementById('seo-empty-state');

    const filterRows = () => {
        const search = (searchInput?.value || '').trim().toLowerCase();
        const status = statusFilter?.value || '';
        const robots = robotsFilter?.value || '';
        let visibleRows = 0;

        rows.forEach((row) => {
            const matchesSearch = (row.dataset.search || '').toLowerCase().includes(search);
            const matchesStatus = !status || row.dataset.status === status;
            const matchesRobots = !robots || row.dataset.robots === robots;
            const isVisible = matchesSearch && matchesStatus && matchesRobots;

            row.classList.toggle('d-none', !isVisible);
            visibleRows += Number(isVisible);
        });

        emptyState?.classList.toggle('d-none', visibleRows !== 0);
    };

    [searchInput, statusFilter, robotsFilter].forEach((control) => {
        control?.addEventListener(control === searchInput ? 'input' : 'change', filterRows);
    });

    document.querySelectorAll('[data-seo-details]').forEach((button) => {
        button.addEventListener('click', () => {
            const details = [
                `URL: ${button.dataset.path}`,
                `Title: ${button.dataset.title}`,
                `Description: ${button.dataset.description}`,
                `Robots: ${button.dataset.robots}`,
            ].join('\n\n');

            if (window.Swal) {
                window.Swal.fire({
                    title: button.dataset.page,
                    text: details,
                    icon: 'info',
                    confirmButtonText: 'Close',
                });
            }
        });
    });
});
