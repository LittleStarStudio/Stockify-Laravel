document.addEventListener("DOMContentLoaded", () => {

    document.addEventListener("click", function (e) {


        /* ================= MODAL OPEN ================= */
        const openBtn = e.target.closest("[data-modal-target]");
        if (openBtn) {
            document
                .getElementById(openBtn.dataset.modalTarget)
                .classList.remove("hidden");
            return;
        }


        /* ================= MODAL CLOSE ================= */
        if (e.target.closest("[data-modal-close]")) {
            e.target.closest(".fixed").classList.add("hidden");
            return;
        }


        /* ================= EDIT AUTO FILL ================= */
        const editBtn = e.target.closest("[data-user]");
        if (editBtn) {
            const user = JSON.parse(editBtn.dataset.user);

            document.getElementById("edit-name").value = user.name;
            document.getElementById("edit-email").value = user.email;
            document.getElementById("edit-role").value = user.role;

            const form = document.getElementById("editUserForm");
            form.action = `/admin/users-management/${user.id}`;

            document.getElementById("editUserModal").classList.remove("hidden");
            return;
        }


        /* ================= SWEETALERT CONFIRM ================= */
        const button = e.target.closest(".btn-confirm");
        if (!button) return;

        e.preventDefault();

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
                button.closest("form").submit();
            }
        });



    });

});
