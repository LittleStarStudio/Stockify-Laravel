document.addEventListener("DOMContentLoaded", () => {

    // VALIDASI DEPENDENSI
    if (typeof window.$ === "undefined" || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable not loaded");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    let suppliersManagementDataTable = null;
    let binSuppliersDataTable = null;

    // AMBIL DATATABLE
    if ($.fn.DataTable.isDataTable("#suppliersManagementTable")) {
        suppliersManagementDataTable = $("#suppliersManagementTable").DataTable();
    }

    // AUTO NUMBERING 
    if (suppliersManagementDataTable) {
        suppliersManagementDataTable
            .on("order.dt search.dt draw.dt", function () {
                suppliersManagementDataTable
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each((cell, i) => {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
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

    // RENDER ROW
    function renderSupplierRow(supplier) {
        return [
            "",
            supplier.name,
            supplier.address ?? "-",
            supplier.phone ?? "-",
            supplier.email ?? "-",
            `
            <div class="relative inline-block text-left" data-supplier-id="${supplier.id}">
                <button type="button"
                    class="action-toggle inline-flex items-center gap-1 px-3 py-1.5 text-xs bg-gray-100 rounded">
                    Actions
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div class="action-menu hidden absolute right-0 mt-2 w-36 bg-white border rounded shadow z-50">
                    <button type="button"
                        data-action="view"
                        class="block w-full px-3 py-2 text-sm"
                        data-supplier='${JSON.stringify(supplier)}'>
                        View
                    </button>

                    <button type="button"
                        data-action="edit"
                        class="block w-full px-3 py-2 text-sm"
                        data-supplier='${JSON.stringify(supplier)}'>
                        Edit
                    </button>

                    <form action="/admin/suppliers-management/${supplier.id}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button"
                            class="btn-confirm block w-full px-3 py-2 text-sm text-red-600"
                            data-title="Delete supplier?"
                            data-text="Supplier will be moved to Bin"
                            data-confirm="Yes, Delete"
                            data-color="#dc2626">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            `
        ];
    }

    //GLOBAL CLICK HANDLER
    document.addEventListener("click", async (e) => {

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

        // ADD SUPPLIER
        if (e.target.closest("#btnAddSupplier")) {
            openModal(document.getElementById("createSupplierModal"));
            return;
        }

        // VIEW SUPPLIER
        const viewBtn = e.target.closest("[data-action='view']");
        if (viewBtn) {
            const s = JSON.parse(viewBtn.dataset.supplier);

            document.getElementById("view-name").textContent = s.name;
            document.getElementById("view-email").textContent = s.email ?? "-";
            document.getElementById("view-phone").textContent = s.phone ?? "-";
            document.getElementById("view-address").textContent = s.address ?? "-";
            document.getElementById("view-created").textContent = s.created_at ?? "-";
            document.getElementById("view-updated").textContent = s.updated_at ?? "-";

            openModal(document.getElementById("viewSupplierModal"));
            return;
        }

        // EDIT SUPPLIER
        const editBtn = e.target.closest("[data-action='edit']");
        if (editBtn) {
            const s = JSON.parse(editBtn.dataset.supplier);
            const form = document.getElementById("editSupplierForm");

            form.action = `/admin/suppliers-management/${s.id}`;
            form.querySelector("#edit-name").value = s.name;
            form.querySelector("#edit-email").value = s.email ?? "";
            form.querySelector("#edit-phone").value = s.phone ?? "";
            form.querySelector("#edit-address").value = s.address ?? "";

            openModal(document.getElementById("editSupplierModal"));
            return;
        }

        // SAVE CREATE + RELOAD
        const createBtn = e.target.closest("#btn-save-create-supplier");
        if (createBtn) {
            createBtn.disabled = true;

            const form = document.getElementById("createSupplierForm");
            if (!form) return;

            const res = await fetch("/admin/suppliers-management", {
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
        const editSaveBtn = e.target.closest("#btn-save-edit-supplier");
        if (editSaveBtn) {
            editSaveBtn.disabled = true;

            const form = document.getElementById("editSupplierForm");
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
        if (e.target.closest("#btn-open-bin-supplier")) {

            const res = await fetch("/admin/suppliers-management/bin");
            const suppliers = await res.json();

            if (!res.ok) {
                Swal.fire("Error", "Failed to load bin data", "error");
                return;
            }

            openModal(document.getElementById("binSupplierModal"));

            requestAnimationFrame(() => {

                if ($.fn.DataTable.isDataTable("#binSuppliersTable")) {
                    binSuppliersDataTable.clear().destroy();
                }

                binSuppliersDataTable = $("#binSuppliersTable").DataTable({
                    data: suppliers,
                    columns: [
                        { data: null, className: "text-center" },
                        { data: "name" },
                        { data: "email" },
                        { data: "phone" },
                        {
                            data: "deleted_at",
                            render: d => formatDate(d)
                        },
                        {
                            data: "id",
                            orderable: false,
                            className: "text-center",
                            render: id => `
                                <form action="/admin/suppliers-management/${id}/restore" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="button"
                                        class="btn-confirm px-3 py-1.5 rounded bg-slate-800 text-white"
                                        data-title="Restore supplier?"
                                        data-text="Supplier will be restored"
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
                    columnDefs: [{ orderable: false, targets: [0, 5] }]
                });

                binSuppliersDataTable.on("draw.dt", () => {
                    binSuppliersDataTable.column(0).nodes()
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
