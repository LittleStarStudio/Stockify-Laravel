
document.addEventListener("DOMContentLoaded", () => {

    
    // VALIDASI JQUERY + DATATABLE
    if (!window.$ || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable not loaded");
        return;
    }

    
    // GLOBAL VARIABLES
    let suppliersManagementDataTable = null;
    let binSuppliersDataTable = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // UTIL MODAL
    function openModal(modal) {
        if (!modal) return;
        const box = modal.querySelector(".modal-box");

        modal.classList.remove("opacity-0", "pointer-events-none");
        modal.classList.add("opacity-100", "bg-opacity-50");

        requestAnimationFrame(() => {
            box?.classList.remove("-translate-y-6", "opacity-0");
            box?.classList.add("translate-y-0", "opacity-100");
        });
    }

    function closeModal(modal) {
        if (!modal) return;
        const box = modal.querySelector(".modal-box");

        box?.classList.remove("translate-y-0", "opacity-100");
        box?.classList.add("-translate-y-6", "opacity-0");

        modal.classList.remove("opacity-100", "bg-opacity-50");
        modal.classList.add("opacity-0");

        setTimeout(() => modal.classList.add("pointer-events-none"), 300);
    }

    function refreshNumbering() {
        if (!suppliersManagementDataTable) return;

        suppliersManagementDataTable
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each((cell, i) => cell.innerHTML = i + 1);
    }

    function closeAllActionMenus() {
        document.querySelectorAll(".action-menu")
            .forEach(menu => menu.classList.add("hidden"));
    }

    // AUTO NUMBERING SUPPLIERS MANAGEMENT TABLE
    if ($('#suppliersManagementTable').length) {
        suppliersManagementDataTable = $('#suppliersManagementTable').DataTable();

        suppliersManagementDataTable
            .on('order.dt search.dt draw.dt', function () {
                suppliersManagementDataTable
                    .column(0, { search: 'applied', order: 'applied' })
                    .nodes()
                    .each((cell, i) => {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    // FORMAT WAKTU
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
                    class="action-toggle inline-flex items-center gap-1
                        px-3 py-1.5 text-xs font-medium
                        bg-gray-100 text-gray-700
                        rounded-md hover:bg-gray-200 transition">
                    Actions
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div class="action-menu hidden absolute right-0 z-20 mt-1 w-36
                            bg-white border border-gray-200 rounded-md shadow-lg">

                    <button type="button"
                        class="btn-view block w-full text-left px-3 py-2 text-xs"
                        data-supplier='${JSON.stringify(supplier)}'>
                        View
                    </button>

                    <button type="button"
                        class="btn-edit block w-full text-left px-3 py-2 text-xs"
                        data-supplier='${JSON.stringify(supplier)}'>
                        Edit
                    </button>

                    <form action="/admin/suppliers-management/${supplier.id}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button"
                            class="btn-confirm block w-full text-left px-3 py-2 text-xs text-red-600"
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
    
    // CHECK DUPLICATE SUPPLIER
    function supplierExistsInTable(id) {

        if (!suppliersManagementDataTable) return false;

        let exists = false;

        suppliersManagementDataTable.rows().every(function () {

            const row = this.node(); 
            const wrapper = row.querySelector('[data-supplier-id]');

            if (!wrapper) return;

            if (String(wrapper.dataset.supplierId) === String(id)) {
                exists = true;
                return false;
            }
        });

        return exists;
    }

    
    // OPEN CREATE MODAL
    document.getElementById("btnAddSupplier")
        ?.addEventListener("click", () => {
            openModal(document.getElementById("createSupplierModal"));
        });

    
    // CREATE SUPPLIER
    const btnCreate = document.getElementById("btn-save-create-supplier");

    btnCreate?.addEventListener("click", async () => {

        if (btnCreate.disabled) return;

        btnCreate.disabled = true;
        btnCreate.textContent = "Saving...";

        const form = document.getElementById("createSupplierForm");

        try {
            const res = await fetch("/admin/suppliers-management", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            const data = await res.json();
            if (!res.ok) throw data;

            Swal.fire("Success", data.message, "success");

            if (!supplierExistsInTable(data.supplier.id)) {
                suppliersManagementDataTable
                    .row.add(renderSupplierRow(data.supplier))
                    .draw(false);
            }

            refreshNumbering();
            closeModal(document.getElementById("createSupplierModal"));
            form.reset();

        } catch (err) {
            Swal.fire(
                "Validation Error",
                err.errors
                    ? Object.values(err.errors).map(e => e[0]).join("<br>")
                    : (err.message || "Unknown error"),
                "error"
            );
        } finally {
            btnCreate.disabled = false;
            btnCreate.textContent = "Save";
        }
    });

    
    // SAVE EDIT SUPPLIER 
    const btnSaveEdit = document.getElementById("btn-save-edit-supplier");

    btnSaveEdit?.addEventListener("click", async () => {

        if (btnSaveEdit.disabled) return;

        btnSaveEdit.disabled = true;
        btnSaveEdit.textContent = "Saving...";

        const form = document.getElementById("editSupplierForm");

        try {
            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            const data = await res.json();
            if (!res.ok) throw data;

            Swal.fire("Success", data.message, "success");

            suppliersManagementDataTable
                .row($('.btn-edit[data-supplier*="\"id\":' + data.supplier.id + '"]').closest('tr'))
                .data(renderSupplierRow(data.supplier))
                .draw(false);

            suppliersManagementDataTable.draw(false);
            refreshNumbering();
            closeModal(document.getElementById("editSupplierModal"));

        } catch (err) {
            Swal.fire(
                "Validation Error",
                err.errors
                    ? Object.values(err.errors).map(e => e[0]).join("<br>")
                    : (err.message || "Unknown error"),
                "error"
            );
        } finally {
            btnSaveEdit.disabled = false;
            btnSaveEdit.textContent = "Save Changes";
        }
    });

    
    // OPEN BIN SUPPLIER MODAL
    document.getElementById("btn-open-bin-supplier")
        ?.addEventListener("click", async () => {

            const modal = document.getElementById("binSupplierModal");
            openModal(modal);

            try {
                const res = await fetch("/admin/suppliers-management/bin", {
                    headers: { "Accept": "application/json" }
                });

                const suppliers = await res.json();

                // destroy datatable jika sudah ada
                if ($.fn.DataTable.isDataTable("#binSuppliersTable")) {
                    binSuppliersDataTable.clear().destroy();
                }

                binSuppliersDataTable = $("#binSuppliersTable").DataTable({
                data: suppliers,
                autoWidth: false,
                pageLength: 10,
                lengthChange: false, 
                responsive: true,
                order: [],

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
                                    class="btn-confirm px-3 py-1.5 rounded-md
                                        text-white bg-slate-800 hover:bg-slate-900 transition"
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

                columnDefs: [
                    { orderable: false, targets: [0, 5] } 
                ],

                language: {
                    search: "Search:",
                    info: "Showing _START_ - _END_ of _TOTAL_ data",
                    emptyTable: "No deleted suppliers found",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });

                // numbering
                binSuppliersDataTable
                    .on("order.dt search.dt draw.dt", function () {
                        binSuppliersDataTable
                            .column(0)
                            .nodes()
                            .each((cell, i) => cell.innerHTML = i + 1);
                    })
                    .draw();

            } catch (err) {
                Swal.fire("Error", "Failed to load bin suppliers", "error");
            }
        });


    // GLOBAL CLICK HANDLER
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

        if (!e.target.closest(".action-menu") && !e.target.closest(".action-toggle")) {
            closeAllActionMenus();
        }

        // VIEW
        const viewBtn = e.target.closest("[data-action='view']");

        if (viewBtn) {
            closeAllActionMenus();

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

        // EDIT
        const editBtn = e.target.closest("[data-action='edit']");

        if (editBtn) {
            closeAllActionMenus();

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

        // DELETE & RESTORE
        const confirmBtn = e.target.closest(".btn-confirm");
        if (!confirmBtn) return;

        e.preventDefault();

        if (confirmBtn.dataset.loading === "true") return;
        confirmBtn.dataset.loading = "true";

        const form = confirmBtn.closest("form");
        const row = confirmBtn.closest("tr");

        const result = await Swal.fire({
            title: confirmBtn.dataset.title || "Are you sure?",
            text: confirmBtn.dataset.text || "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: confirmBtn.dataset.confirm || "Yes",
            confirmButtonColor: confirmBtn.dataset.color || "#dc2626"
        });

        if (!result.isConfirmed) {
            confirmBtn.dataset.loading = "false";
            return;
        }

        try {
            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            const data = await res.json();
            if (!res.ok) throw data;

            Swal.fire("Success", data.message, "success");

            // DELETE
            if (suppliersManagementDataTable.table().node().contains(row)) {
                suppliersManagementDataTable.row(row).remove().draw(false);
                refreshNumbering();
            }

            // RESTORE
            if (data.supplier && !supplierExistsInTable(data.supplier.id)) {
                suppliersManagementDataTable
                    .row.add(renderSupplierRow(data.supplier))
                    .draw(false);
                refreshNumbering();
            }

        } catch (err) {
            Swal.fire("Error", err.message || "Process failed", "error");
        } finally {
            confirmBtn.dataset.loading = "false";
        }
    });

});
