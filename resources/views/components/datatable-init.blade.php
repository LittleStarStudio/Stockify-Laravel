@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof $ === 'undefined' || !$.fn.DataTable) {
            console.error('DataTables / jQuery not loaded');
            return;
        }

        // INIT DATATABLE
        const table = $('#{{ $id }}').DataTable({
            pageLength: 10,
            lengthChange: false,
            responsive: true,
            order: [],
            columnDefs: @json($columnDefs),
            language: {
                search: "Search:",
                info: "Showing _START_ - _END_ of _TOTAL_ data",
                paginate: {
                    previous: "‹",
                    next: "›"
                },
                emptyTable: "Data not found"
            }
        });

        // AUTO NUMBERING KOLOM "No"
        table.on('order.dt search.dt draw.dt', function () {
            table
                .column(0, { search: 'applied', order: 'applied' })
                .nodes()
                .each((cell, i) => {
                    cell.innerHTML = i + 1;
                });
        }).draw();

        // SIMPAN INSTANCE KE GLOBAL
        window['dt_' + '{{ $id }}'] = table;
        
    });
</script>
@endpush
