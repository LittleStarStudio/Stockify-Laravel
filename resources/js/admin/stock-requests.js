document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-stock-confirm').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: this.dataset.title,
                text: this.dataset.text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: this.dataset.confirm,
                cancelButtonText: 'Cancel',
                confirmButtonColor: this.dataset.color
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
