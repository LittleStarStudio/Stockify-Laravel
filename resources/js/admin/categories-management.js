document.addEventListener("DOMContentLoaded", () => {

    // VALIDASI DEPENDENSI
    if (typeof window.$ === "undefined" || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable not loaded");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const userRole = document.body.dataset.role || "guest";
    const isAdmin = userRole === "admin";

    let categoriesManagementDataTable = null;
    let binCategoriesDataTable = null;

    // AMBIL DATATABLE
    if ($.fn.DataTable.isDataTable("#categoriesManagementTable")) {
        categoriesManagementDataTable = $("#categoriesManagementTable").DataTable();
    }

    // UTILITIES
    function closeAllActionMenus() {
        document.querySelectorAll(".action-menu")
            .forEach(menu => menu.classList.add("hidden"));
    }

    function openModal(modal) {
        if (!modal) return;
        const box = modal.querySelector(".modal-box");
        if (!box) return;

        modal.classList.remove("opacity-0", "pointer-events-none", "bg-opacity-0");
        modal.classList.add("opacity-100", "bg-opacity-50");

        requestAnimationFrame(() => {
            box.classList.remove("-translate-y-6", "opacity-0");
            box.classList.add("translate-y-0", "opacity-100");
        });
    }

    function closeModal(modal) {
        if (!modal) return;

        modal.querySelectorAll(".text-red-600").forEach(el => el.remove());
        modal.querySelectorAll(".border-red-500").forEach(el => el.classList.remove("border-red-500"));
        modal.querySelectorAll(".focus\\:ring-red-500").forEach(el => el.classList.remove("focus:ring-red-500"));
        modal.querySelector(".is-validation-error")?.remove();

        const box = modal.querySelector(".modal-box");
        if (box) {
            box.classList.remove("translate-y-0", "opacity-100");
            box.classList.add("-translate-y-6", "opacity-0");
        }

        modal.classList.remove("opacity-100", "bg-opacity-50");
        modal.classList.add("opacity-0", "bg-opacity-0");

        setTimeout(() => modal.classList.add("pointer-events-none"), 300);
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const d = new Date(dateString);
        return d.toLocaleDateString("en-GB", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }

    //GLOBAL CLICK HANDLER
    document.addEventListener("click", async (e) => {

        // GUARD CLICK HANDLER
        if (!isAdmin && (
            e.target.closest("#btnAddCategory") ||
            e.target.closest("#btn-save-create-category") ||
            e.target.closest("#btn-save-edit-category")
        )) {
            Swal.fire("Access Denied", "Read-only access", "warning");
            return;
        }

        // CLOSE MODAL
        const overlay = e.target.closest("[data-modal-overlay]");
        if (overlay && !e.target.closest(".modal-box")) {
            closeModal(overlay);
            closeAllActionMenus();
            return;
        }

        if (e.target.closest("[data-modal-close]")) {
            closeModal(e.target.closest("[data-modal-overlay]"));
            closeAllActionMenus();
            return;
        }

        // DROPDOWN
        const toggle = e.target.closest(".action-toggle");
        if (toggle) {
            closeAllActionMenus();
            toggle.nextElementSibling.classList.toggle("hidden");
            return;
        }

        if (!e.target.closest(".action-menu")) {
            closeAllActionMenus();
        }

        // ADD CATEGORY
        if (e.target.closest("#btnAddCategory")) {
            openModal(document.getElementById("createCategoryModal"));
            return;
        }

        // VIEW CATEGORY
        const viewBtn = e.target.closest("[data-action='view']");
        if (viewBtn) {
            const c = JSON.parse(viewBtn.dataset.category);

            document.getElementById("view-name").textContent = c.name;
            document.getElementById("view-description").textContent = c.description ?? "-";
            document.getElementById("view-created").textContent = c.created_at ?? "-";
            document.getElementById("view-updated").textContent = c.updated_at ?? "-";

            const statusEl = document.getElementById("view-status");

            if (c.is_active) {
                statusEl.textContent = "Active";
                statusEl.className = "inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700";
            } else {
                statusEl.textContent = "Inactive";
                statusEl.className = "inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700";
            }

            openModal(document.getElementById("viewCategoryModal"));
            return;
        }

        // EDIT CATEGORY
        const editBtn = e.target.closest("[data-action='edit']");
        if (editBtn) {
            const c = JSON.parse(editBtn.dataset.category);
            const form = document.getElementById("editCategoryForm");

            form.action = `/admin/categories-management/${c.id}`;
            form.querySelector("#edit-name").value = c.name;
            form.querySelector("#edit-status").value = c.is_active ?? "";
            form.querySelector("#edit-description").value = c.description ?? "";

            openModal(document.getElementById("editCategoryModal"));
            return;
        }

        // SAVE CREATE + RELOAD
        const createBtn = e.target.closest("#btn-save-create-category");
        if (createBtn) {
            createBtn.disabled = true;

            const form = document.getElementById("createCategoryForm");
            if (!form) return;

            const res = await fetch("/admin/categories-management", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            const data = await res.json();

            if (!res.ok) {
                createBtn.disabled = false;
                Swal.fire("Validation Error",
                    Object.values(data.errors).map(e => e[0]).join("<br>"),
                    "error");
                return;
            }

            Swal.fire({
                icon: "success",
                title: "Success",
                text: data.message,
                confirmButtonColor: "#16a34a"
            }).then(() => location.reload());

            return;
        }

        // SAVE EDIT + RELOAD
        const editSaveBtn = e.target.closest("#btn-save-edit-category");
        if (editSaveBtn) {
            editSaveBtn.disabled = true;

            const form = document.getElementById("editCategoryForm");
            if (!form) return;

            const formData = new FormData(form);
            formData.append("_method", "PUT");

            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: formData
            });

            const data = await res.json();

            if (!res.ok) {
                editSaveBtn.disabled = false;
                Swal.fire("Validation Error",
                    Object.values(data.errors).map(e => e[0]).join("<br>"),
                    "error");
                return;
            }

            Swal.fire({
                icon: "success",
                title: "Success",
                text: data.message,
                confirmButtonColor: "#16a34a"
            }).then(() => location.reload());

            return;
        }

        // OPEN BIN
        if (e.target.closest("#btn-open-bin-category")) {

            const res = await fetch("/admin/categories-management/bin");
            const categories = await res.json();

            if (!res.ok) {
                Swal.fire("Error", "Failed to load bin data", "error");
                return;
            }

            openModal(document.getElementById("binCategoryModal"));

            requestAnimationFrame(() => {

                if ($.fn.DataTable.isDataTable("#binCategoriesTable")) {
                    binCategoriesDataTable.clear().destroy();
                }

                binCategoriesDataTable = $("#binCategoriesTable").DataTable({
                    data: categories,
                    columns: [
                        { data: null, className: "text-center" },
                        { data: "name" },
                        { data: "description" },
                        {
                            data: "deleted_at",
                            render: d => formatDate(d)
                        },
                        {
                            data: "id",
                            orderable: false,
                            className: "text-center",
                            render: id => `
                                <form action="/admin/categories-management/${id}/restore" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="button"
                                        class="btn-confirm px-3 py-1.5 rounded bg-slate-800 text-white"
                                        data-title="Restore category?"
                                        data-text="Category will be restored"
                                        data-confirm="Yes, Restore"
                                        data-color="#2563eb">
                                        Restore
                                    </button>
                                </form>
                            `
                        }
                    ],
                    pageLength: 10,
                    lengthChange: false,
                    order: [],
                    columnDefs: [{ orderable: false, targets: [0, 4] }]
                });

                // AUTO NUMBERING BIN
                binCategoriesDataTable.on("draw.dt", () => {
                    binCategoriesDataTable.column(0).nodes()
                        .each((cell, i) => cell.innerHTML = i + 1);
                }).draw();
            });

            return;
        }

        // DELETE & RESTORE + RELOAD
        const confirmBtn = e.target.closest(".btn-confirm");
        if (!confirmBtn) return;

        e.preventDefault();

        const form = confirmBtn.closest("form");

        const result = await Swal.fire({
            title: confirmBtn.dataset.title,
            text: confirmBtn.dataset.text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: confirmBtn.dataset.confirm,
            confirmButtonColor: confirmBtn.dataset.color,
            cancelButtonColor: "#6b7280"
        });

        if (!result.isConfirmed) return;

        const res = await fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (!res.ok) {
            Swal.fire("Error", data.message || "Process failed", "error");
            return;
        }

        Swal.fire({
            icon: "success",
            title: "Success",
            text: data.message,
            confirmButtonColor: "#16a34a"
        }).then(() => location.reload());
    });

});
