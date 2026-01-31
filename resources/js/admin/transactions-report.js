document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnExport');
    const from = document.getElementById('from');
    const to = document.getElementById('to');
    const type = document.getElementById('type');

    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

    from.value = firstDay.toISOString().slice(0,10);
    to.value   = today.toISOString().slice(0,10);

    btn.addEventListener('click', function () {

        let f = from.value;
        let t = to.value;
        let ty = type.value;

        if (!f || !t) {
            Swal.fire('Warning','Please select date range','warning');
            return;
        }

        Swal.fire({
            title: 'Generating Report...',
            text: 'Your Excel file will be downloaded.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            let url = `/admin/reports/transactions/export?from=${f}&to=${t}&type=${ty}`;
            window.location.href = url;
        }, 500);
    });

});
