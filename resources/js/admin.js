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

document.addEventListener('DOMContentLoaded', () => {
    const chartElement = document.querySelector('#admin-bookings-chart');

    if (!chartElement || !window.ApexCharts) {
        return;
    }

    const styles = getComputedStyle(document.documentElement);
    const primary = styles.getPropertyValue('--vz-primary').trim() || '#405189';
    const success = styles.getPropertyValue('--vz-success').trim() || '#0ab39c';

    const chart = new window.ApexCharts(chartElement, {
        chart: {
            height: 320,
            type: 'area',
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [
            { name: 'Bookings', data: [18, 24, 20, 32, 28, 39, 35, 44, 38, 51, 47, 58] },
            { name: 'Inquiries', data: [12, 16, 19, 17, 24, 21, 29, 25, 31, 28, 36, 33] },
        ],
        colors: [primary, success],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: {
            type: 'gradient',
            gradient: { opacityFrom: 0.24, opacityTo: 0.02, stops: [0, 90, 100] },
        },
        grid: { borderColor: '#e9ebec', strokeDashArray: 4 },
        legend: { position: 'top', horizontalAlign: 'right' },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: { min: 0, tickAmount: 4 },
        tooltip: { shared: true, intersect: false },
    });

    chart.render();
});
