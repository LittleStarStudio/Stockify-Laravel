window.confirmAction = function ({
    title,
    text,
    icon = 'question',
    confirmText = 'Ya',
    confirmColor = '#2563eb',
    cancelText = 'Batal',
    cancelColor = '#6b7280',
    form
}) {
    Swal.fire({
        title,
        text,
        icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.submit();
        }
    });
}
