document.addEventListener('DOMContentLoaded', () => {

    const table = $('#stocksTable').DataTable();

    const filterHTML = `
        <div id="customFilter"
            class="flex gap-2 items-center">
            <select id="filterType" class="border rounded px-2 py-1 text-sm">
                <option value="">All Type</option>
                <option value="IN">IN</option>
                <option value="OUT">OUT</option>
            </select>

            <select id="filterStatus" class="border rounded px-2 py-1 text-sm">
                <option value="">All Status</option>
                <option value="PENDING">PENDING</option>
                <option value="RECEIVED">RECEIVED</option>
                <option value="ISSUED">ISSUED</option>
                <option value="REJECTED">REJECTED</option>
            </select>

            <input type="date"
                id="filterDate"
                class="border rounded px-2 py-1 text-sm">

            <button id="resetFilter"
                class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                Reset
            </button>
        </div>
    `;

    
    const searchBox = $('#stocksTable_filter');

    searchBox.wrap(`
        <div class="flex justify-between items-center mb-4"></div>
    `);

    searchBox.parent().prepend(filterHTML);

    const typeFilter = document.getElementById('filterType');
    const statusFilter = document.getElementById('filterStatus');
    const dateFilter = document.getElementById('filterDate');
    const resetBtn = document.getElementById('resetFilter');

    function applyFilters() {
        table.draw();
    }

    $.fn.dataTable.ext.search.push(function (_, data) {
        const type = data[2];
        const status = data[4];
        const date = data[6];

        if (typeFilter.value && !type.includes(typeFilter.value)) return false;
        if (statusFilter.value && !status.includes(statusFilter.value)) return false;

        if (dateFilter.value) {
            const rowDate = new Date(date);
            const filterDate = new Date(dateFilter.value);
            if (rowDate.toDateString() !== filterDate.toDateString()) return false;
        }

        return true;
    });

    typeFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    dateFilter.addEventListener('change', applyFilters);

    resetBtn.addEventListener('click', () => {
        typeFilter.value = '';
        statusFilter.value = '';
        dateFilter.value = '';
        table.search('').draw();
    });

});
