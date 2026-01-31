document.addEventListener("DOMContentLoaded", () => {

    /* ================= DEPENDENCY CHECK ================= */
    if (typeof window.$ === "undefined" || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable not loaded");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const userRole = document.body.dataset.role;
    const isCrud = ["admin", "manajer_gudang"].includes(userRole);

    let binAttributesTable = null;

    /* ================= UTILITIES ================= */

    function closeAllActionMenus() {
        document.querySelectorAll(".action-menu")
            .forEach(menu => menu.classList.add("hidden"));
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const d = new Date(dateString);
        return d.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }

    function openModal(modal) {
        if (!modal) return;

        const box = modal.querySelector(".modal-box");
        modal.classList.remove("opacity-0", "pointer-events-none", "bg-opacity-0");
        modal.classList.add("opacity-100", "bg-opacity-50");

        requestAnimationFrame(() => {
            box.classList.remove("-translate-y-6", "opacity-0");
            box.classList.add("translate-y-0", "opacity-100");
        });
    }

    function closeModal(modal) {
        if (!modal) return;

        const form = modal.querySelector("form");
        if (form) form.reset();

        const box = modal.querySelector(".modal-box");
        if (box) {
            box.classList.remove("translate-y-0", "opacity-100");
            box.classList.add("-translate-y-6", "opacity-0");
        }

        modal.classList.remove("opacity-100", "bg-opacity-50");
        modal.classList.add("opacity-0", "bg-opacity-0");
        setTimeout(() => modal.classList.add("pointer-events-none"), 300);
    }

    /* ================= GLOBAL CLICK ================= */

    document.addEventListener("click", async (e) => {

        // GUARD
        if (!isCrud && (
            e.target.closest("#btnAddAttribute") ||
            e.target.closest("#btn-save-create-attribute") ||
            e.target.closest("#btn-save-edit-attribute")
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

        if (!e.target.closest(".action-menu")) closeAllActionMenus();

        /* ================= OPEN CREATE ================= */
        if (e.target.closest("#btnAddAttribute")) {
            openModal(document.getElementById("createAttributeModal"));
            return;
        }

        /* ================= OPEN BIN ================= */
        if (e.target.closest("#btn-open-bin-attribute")) {

            const res = await fetch("/admin/product-attributes/bin");
            const attributes = await res.json();

            if (!res.ok) {
                Swal.fire("Error", "Failed to load bin", "error");
                return;
            }

            openModal(document.getElementById("binAttributeModal"));

            requestAnimationFrame(() => {

                if ($.fn.DataTable.isDataTable("#binAttributesTable")) {
                    binAttributesTable.clear().destroy();
                }

                binAttributesTable = $("#binAttributesTable").DataTable({
                    data: attributes,
                    columns: [
                        { data: null, className: "text-center" },
                        { data: "name" },
                        { data: "slug" },
                        { data: "deleted_at", render: d => formatDate(d) },
                        {
                            data: "id",
                            orderable: false,
                            className: "text-center",
                            render: id => `
                                <form action="/admin/product-attributes/${id}/restore" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="button"
                                        class="btn-confirm px-3 py-1.5 rounded bg-slate-800 text-white"
                                        data-title="Restore attribute?"
                                        data-text="Attribute will be restored"
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

                binAttributesTable.off("draw.dt").on("draw.dt", () => {
                    binAttributesTable.column(0).nodes()
                        .each((cell, i) => cell.innerHTML = i + 1);
                });

                binAttributesTable.draw();
            });

            return;
        }

        /* ================= VIEW ================= */
        const viewBtn = e.target.closest("[data-action='view']");
        if (viewBtn) {
            const a = JSON.parse(viewBtn.dataset.attribute);

            document.getElementById("view-name").textContent = a.name;
            document.getElementById("view-slug").textContent = a.slug;
            document.getElementById("view-created").textContent = a.created_at;
            document.getElementById("view-updated").textContent = a.updated_at;

            openModal(document.getElementById("viewAttributeModal"));
            return;
        }

        /* ================= EDIT ================= */
        const editBtn = e.target.closest("[data-action='edit']");
        if (editBtn) {
            const a = JSON.parse(editBtn.dataset.attribute);
            const form = document.getElementById("editAttributeForm");

            form.action = `/admin/product-attributes/${a.id}`;
            document.getElementById("edit-attr-name").value = a.name;

            openModal(document.getElementById("editAttributeModal"));
            return;
        }

        /* ================= SAVE CREATE ================= */
        const createBtn = e.target.closest("#btn-save-create-attribute");
        if (createBtn) {
            createBtn.disabled = true;
            const form = document.getElementById("createAttributeForm");

            const res = await fetch("/admin/product-attributes", {
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

            Swal.fire("Success", data.message, "success")
                .then(() => location.reload());
        }

        /* ================= SAVE EDIT ================= */
        const saveEditBtn = e.target.closest("#btn-save-edit-attribute");
        if (saveEditBtn) {
            saveEditBtn.disabled = true;

            const form = document.getElementById("editAttributeForm");
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
                saveEditBtn.disabled = false;
                Swal.fire("Validation Error",
                    Object.values(data.errors).map(e => e[0]).join("<br>"),
                    "error");
                return;
            }

            Swal.fire("Updated", data.message, "success")
                .then(() => location.reload());
        }

        /* ================= DELETE & RESTORE ================= */
        const confirmBtn = e.target.closest(".btn-confirm");
        if (confirmBtn) {

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

            Swal.fire("Success", data.message, "success")
                .then(() => location.reload());
        }

    });

});
