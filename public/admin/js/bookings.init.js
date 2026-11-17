document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#bookings-table');

    if (!table) {
        return;
    }

    const rows = Array.from(table.querySelectorAll('[data-booking-row]'));
    const search = document.querySelector('#booking-search');
    const stageFilter = document.querySelector('#booking-stage-filter');
    const emptyState = document.querySelector('#booking-empty-state');
    const stageActions = window.adminBookingStageActions ?? {};
    const statusClasses = window.adminBookingStatusClasses ?? {};

    const updateCounts = (previousStatus, nextStatus) => {
        const updateCount = (selector, matchesStatus) => {
            const element = document.querySelector(selector);
            let count = Number(element.textContent);

            if (matchesStatus(previousStatus)) count--;
            if (matchesStatus(nextStatus)) count++;

            element.textContent = count;
        };

        updateCount('#booking-stat-confirmed', (status) => status === 'Confirmed');
        updateCount('#booking-stat-attention', (status) => ['Pending review', 'Awaiting payment'].includes(status));
        updateCount('#booking-stat-inquiries', (status) => status === 'New inquiry');
    };

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

    const addTransitionActions = (row) => {
        const menu = row.querySelector('.dropdown-menu');
        const detailsItem = menu.querySelector('[data-booking-details]').closest('li');

        menu.querySelectorAll('[data-booking-transition]').forEach((button) => button.closest('li').remove());
        menu.querySelector('[data-booking-action-divider]')?.remove();

        const actions = stageActions[row.dataset.status] ?? [];

        if (actions.length > 0) {
            const dividerItem = document.createElement('li');
            const divider = document.createElement('hr');

            dividerItem.dataset.bookingActionDivider = '';
            divider.className = 'dropdown-divider';
            dividerItem.append(divider);
            detailsItem.after(dividerItem);
        }

        actions.forEach((action) => {
            const item = document.createElement('li');
            const button = document.createElement('button');
            const icon = document.createElement('i');

            button.type = 'button';
            button.className = `dropdown-item${action.danger ? ' text-danger' : ''}`;
            button.dataset.bookingTransition = '';
            button.dataset.nextStatus = action.next_status;
            button.dataset.confirm = action.confirm;

            icon.className = `${action.danger ? 'ri-close-circle-line' : 'ri-arrow-right-line'} me-2 align-bottom`;
            button.append(icon, document.createTextNode(action.label));
            item.append(button);
            menu.append(item);
        });

    };

    const transitionBooking = async (button) => {
        const row = button.closest('[data-booking-row]');
        const nextStatus = button.dataset.nextStatus;
        const isCancellation = nextStatus === 'Cancelled';
        const result = await window.Swal.fire({
            title: button.dataset.confirm,
            text: `Booking #${row.cells[0].textContent.trim().replace('#', '')} will move from ${row.dataset.status} to ${nextStatus}.`,
            icon: isCancellation ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: 'Continue',
            cancelButtonText: 'Go back',
            buttonsStyling: false,
            customClass: {
                confirmButton: `btn btn-${isCancellation ? 'danger' : 'primary'} me-2`,
                cancelButton: 'btn btn-light',
            },
        });

        if (!result.isConfirmed) {
            return;
        }

        const statusBadge = row.querySelector('[data-booking-status]');
        const previousStatus = row.dataset.status;
        const oldTone = statusClasses[row.dataset.status];
        const newTone = statusClasses[nextStatus];

        statusBadge.classList.remove(`bg-${oldTone}-subtle`, `text-${oldTone}`);
        statusBadge.classList.add(`bg-${newTone}-subtle`, `text-${newTone}`);
        statusBadge.textContent = nextStatus;
        row.dataset.status = nextStatus;

        addTransitionActions(row);
        updateCounts(previousStatus, nextStatus);
        applyFilters();

        window.AdminToast?.show(`Booking moved to ${nextStatus}.`, isCancellation ? 'warning' : 'success');
    };

    table.addEventListener('click', (event) => {
        const detailsButton = event.target.closest('[data-booking-details]');
        const transitionButton = event.target.closest('[data-booking-transition]');

        if (detailsButton) {
            const row = detailsButton.closest('[data-booking-row]');
            const cells = row.cells;

            window.Swal.fire({
                title: `Booking ${cells[0].textContent.trim()}`,
                text: [
                    cells[2].textContent.trim(),
                    cells[1].textContent.trim().replace(/\s+/g, ' · '),
                    `Travel date: ${cells[3].textContent.trim()}`,
                    `Guests: ${cells[4].textContent.trim()} · Total: ${cells[5].textContent.trim()}`,
                    `Stage: ${row.dataset.status}`,
                ].join('\n'),
                icon: 'info',
                confirmButtonText: 'Close',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn btn-primary' },
            });
        }

        if (transitionButton) {
            transitionBooking(transitionButton);
        }
    });

    search.addEventListener('input', applyFilters);
    stageFilter.addEventListener('change', applyFilters);

    rows.forEach(addTransitionActions);
    applyFilters();
});
