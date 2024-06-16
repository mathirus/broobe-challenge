import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    loadHistoryMetrics();
});

async function loadHistoryMetrics() {
    try {
        const response = await fetch('/metrics/history/data', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();
        renderHistoryMetrics(data);
        initializeDataTable();
    } catch (error) {
        console.error('Error loading metrics history:', error);
    }
}

function parseDate(dateString) {
    const [day, month, year, time] = dateString.split(/[- :]/);
    return new Date(`${year}-${month}-${day}T${time}`);
}

function renderHistoryMetrics(data) {
    const tbody = document.getElementById('metricsTableBody');
    tbody.innerHTML = '';
    data.forEach(metric => {
        const row = document.createElement('tr');
        row.className = 'border-b';
        row.innerHTML = `
            <td class="py-3 px-4 text-center">${metric.url}</td>
            <td class="py-3 px-4 text-center">${metric.strategy_name}</td>
            <td class="py-3 px-4 text-center">${metric.accessibility_metric ?? 'N/A'}</td>
            <td class="py-3 px-4 text-center">${metric.pwa_metric ?? 'N/A'}</td>
            <td class="py-3 px-4 text-center">${metric.performance_metric ?? 'N/A'}</td>
            <td class="py-3 px-4 text-center">${metric.seo_metric ?? 'N/A'}</td>
            <td class="py-3 px-4 text-center">${metric.best_practices_metric ?? 'N/A'}</td>
            <td class="py-2 px-4 text-center">${new Date(metric.created_at).toLocaleDateString()}</td>
        `;
        tbody.appendChild(row);
    });
}

function initializeDataTable() {
    $('#metricsTable').DataTable({
        dom: '<"top"fB>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'copy',
                text: 'Copy',
                className: 'dt-button'
            },
            {
                extend: 'csv',
                text: 'CSV',
                className: 'dt-button'
            },
            {
                extend: 'excel',
                text: 'Excel',
                className: 'dt-button'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                className: 'dt-button'
            },
            {
                extend: 'print',
                text: 'Print',
                className: 'dt-button'
            }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
}
