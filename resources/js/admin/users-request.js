document.addEventListener("click", function (e) {

    const button = e.target.closest(".btn-request-confirm");
    if (!button) return;

    e.preventDefault();

    const form = button.closest("form");

    Swal.fire({
        title: button.dataset.title || "Are you sure?",
        text: button.dataset.text || "",
        icon: button.dataset.icon || "question",
        showCancelButton: true,
        confirmButtonText: button.dataset.confirm || "Yes",
        cancelButtonText: "Cancel",
        confirmButtonColor: button.dataset.color || "#2563eb",
        cancelButtonColor: "#9ca3af",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});


document.addEventListener("DOMContentLoaded", () => {

    const requestTable = $('#usersRequestTable').DataTable();

    requestTable.on('order.dt search.dt draw.dt', function () {
        requestTable
            .column(0, { search: 'applied', order: 'applied' })
            .nodes()
            .each((cell, i) => {
                cell.innerHTML = i + 1;
            });
    }).draw();

});
