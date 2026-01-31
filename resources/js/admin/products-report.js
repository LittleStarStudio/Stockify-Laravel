document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnExportProducts');

    btn.addEventListener('click', function () {

        Swal.fire({
            title: 'Generating Product Report...',
            text: 'Your Excel file will be downloaded.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            window.location.href = '/admin/reports/products/export';
        }, 500);
    });

});
