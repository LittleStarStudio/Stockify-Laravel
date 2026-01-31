document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnExportUsers');
    const role = document.getElementById('role');

    btn.addEventListener('click', function () {

        let r = role.value;

        Swal.fire({
            title: 'Generating User Report...',
            text: 'Your Excel file will be downloaded.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            window.location.href = `/admin/reports/users/export?role=${r}`;
        }, 500);
    });

});
