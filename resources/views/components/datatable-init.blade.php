@props([
    'id',
    'columnDefs' => []
])

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof $ === 'undefined' || !$.fn.DataTable) {
            console.error('DataTables / jQuery not loaded');
            return;
        }

        $('#{{ $id }}').DataTable({
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

    });
</script>
@endpush
