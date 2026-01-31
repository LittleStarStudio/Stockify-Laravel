document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnExportOpnames');

    btn.addEventListener('click', function () {

        Swal.fire({
            title: 'Generating Opname Report...',
            text: 'Your Excel file will be downloaded.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            window.location.href = '/admin/reports/opnames/export';
        }, 500);
    });

});
