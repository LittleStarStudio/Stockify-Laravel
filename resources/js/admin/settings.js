document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('settingsForm');
    const input = document.getElementById('logoInput');
    const preview = document.getElementById('logoPreview');

    // PREVIEW LOGO
    if (input) {
        input.addEventListener('change', () => {
            if (input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
        });
    }

    // SUBMIT SWEETALERT
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const appName = form.querySelector('[name="app_name"]').value;

        // VALIDASI 
        if (!appName.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Application Name cannot be empty'
            });
            return;
        }

        // CONFIRM
        Swal.fire({
            title: 'Save settings?',
            text: 'Application settings will be updated',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (!result.isConfirmed) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(async res => {

                // SUCCESS
                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Settings updated successfully'
                    }).then(() => location.reload());
                    return;
                }

                // VALIDATION ERROR 
                if (res.status === 422) {
                    const data = await res.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: Object.values(data.errors)
                              .map(e => e[0])
                              .join('<br>')
                    });
                    return;
                }

                // ERROR
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong'
                });
            });
        });
    });
});
