@once
    
    <!-- Success -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Warning -->
    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: @json(session('warning')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Error/Failed -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endonce
