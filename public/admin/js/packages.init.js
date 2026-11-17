document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#packages-table');

    if (!table) {
        return;
    }

    const rows = Array.from(table.querySelectorAll('[data-package-row]'));
    const search = document.querySelector('#package-search');
    const categoryFilter = document.querySelector('#package-category-filter');
    const statusFilter = document.querySelector('#package-status-filter');
    const emptyState = document.querySelector('#package-empty-state');

    const applyFilters = () => {
        const query = search.value.trim().toLowerCase();
        const selectedCategory = categoryFilter.value;
        const selectedStatus = statusFilter.value;
        let visibleCount = 0;

        rows.forEach((row) => {
            const matchesQuery = row.textContent.toLowerCase().includes(query);
            const matchesCategory = !selectedCategory || row.dataset.category === selectedCategory;
            const matchesStatus = !selectedStatus || row.dataset.status === selectedStatus;
            const visible = matchesQuery && matchesCategory && matchesStatus;

            row.classList.toggle('d-none', !visible);
            visibleCount += Number(visible);
        });

        emptyState.classList.toggle('d-none', visibleCount > 0);
    };

    search.addEventListener('input', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    applyFilters();
});
