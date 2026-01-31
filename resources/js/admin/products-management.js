const rupiahState = {};

function formatRupiahView(num) {
    if (!num || isNaN(num)) return "";
    return "Rp " + Number(num).toLocaleString("id-ID");
}


function bindRupiah(displayId, hiddenId) {
    const display = document.getElementById(displayId);
    const hidden = document.getElementById(hiddenId);
    if (!display || !hidden) return;

    rupiahState[displayId] = "";

    function getDigitIndexFromCursor(cursorPos, formatted) {
        let digitCount = 0;
        for (let i = 0; i < cursorPos; i++) {
            if (/\d/.test(formatted[i])) digitCount++;
        }
        return digitCount;
    }

    function rebuild(formatted, digits, digitIndex, insert = null) {
        let arr = digits.split("");

        if (insert !== null) {
            arr.splice(digitIndex, 0, insert);
        } else {
            if (digitIndex > 0) arr.splice(digitIndex - 1, 1);
        }

        return arr.join("");
    }

    display.addEventListener("keydown", (e) => {
        const formatted = display.value;
        const cursor = display.selectionStart;
        let digits = rupiahState[displayId];

        const digitIndex = getDigitIndexFromCursor(cursor, formatted);

        // BACKSPACE
        if (e.key === "Backspace") {
            if (!digits) return;

            digits = rebuild(formatted, digits, digitIndex);
        }

        // ANGKA
        else if (/^\d$/.test(e.key)) {
            digits = rebuild(formatted, digits, digitIndex, e.key);
        }

        // NAVIGATION
        else if (["Tab", "ArrowLeft", "ArrowRight"].includes(e.key)) {
            return;
        }

        else {
            e.preventDefault();
            return;
        }

        e.preventDefault();

        rupiahState[displayId] = digits;
        hidden.value = digits;
        display.value = formatRupiahView(digits);

        // RESET POSISI KURSOR
        let newCursor = 0;
        let count = 0;
        while (count < digitIndex + (e.key !== "Backspace" ? 1 : 0) && newCursor < display.value.length) {
            if (/\d/.test(display.value[newCursor])) count++;
            newCursor++;
        }
        display.setSelectionRange(newCursor, newCursor);
    });
}


function resetRupiahState(...ids) {
    ids.forEach(id => {
        if (rupiahState[id] !== undefined) {
            rupiahState[id] = "";
        }

        const display = document.getElementById(id);
        if (display) display.value = "";
    });
}


let attrIndex = 1;

function addAttributeRow(id = "", value = "", target = "create") {

    const wrap = document.getElementById(target === "edit" ? "attr-wrapper-edit" : "attr-wrapper-create");

    if (!wrap) return;

    const row = document.createElement("div");
    row.className = "flex gap-2 mt-2";

    row.innerHTML = `
        <select name="attributes[${attrIndex}][id]" class="input w-1/2">
            ${window.attributesOptions}
        </select>

        <input type="text"
               name="attributes[${attrIndex}][value]"
               value="${value}"
               placeholder="Value"
               class="input w-1/2">
    `;

    if (id) row.querySelector("select").value = id;

    wrap.appendChild(row);
    attrIndex++;
}



document.addEventListener("DOMContentLoaded", () => {

    // DEPENDENCY CHECK
    if (typeof window.$ === "undefined" || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable not loaded");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const userRole = document.body.dataset.role;
    const isCrud = ["admin", "manajer_gudang"].includes(userRole);

    let binProductsTable = null;

    /* ================= IMAGE PREVIEW ================= */

    function imagePreview(input, img, filename, placeholder) {
        if (!input) return;

        input.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                img.src = URL.createObjectURL(this.files[0]);
                img.classList.remove("hidden");
                if (placeholder) placeholder.classList.add("hidden");
                if (filename) filename.textContent = this.files[0].name;
            } else {
                img.src = "";
                img.classList.add("hidden");
                if (placeholder) placeholder.classList.remove("hidden");
                if (filename) filename.textContent = "No file chosen";
            }
        });
    }

    imagePreview(
        document.getElementById("create-image"),
        document.getElementById("create-image-preview"),
        document.getElementById("create-image-filename"),
        document.getElementById("create-image-placeholder")
    );

    imagePreview(
        document.getElementById("edit-image"),
        document.getElementById("edit-image-preview"),
        document.getElementById("edit-image-filename"),
        document.getElementById("edit-image-placeholder")
    );

    // MONEY DISPAY FORMATED
    bindRupiah("create-harga-beli-display", "create-harga-beli");
    bindRupiah("create-harga-jual-display", "create-harga-jual");

    bindRupiah("edit-harga-beli-display", "edit-harga-beli");
    bindRupiah("edit-harga-jual-display", "edit-harga-jual");

    // PRODUCT ATTRIBUTES
    document.getElementById("btnAddAttr")?.addEventListener("click", () => {
        addAttributeRow("", "", "create");
    });

    document.getElementById("btnAddAttrEdit")?.addEventListener("click", () => {
        addAttributeRow("", "", "edit");
    });

    document.addEventListener("change", (e) => {
        if (e.target.name?.includes("[id]")) {
            const selects = [...document.querySelectorAll("select[name^='attributes']")];
            const values = selects.map(s => s.value).filter(v => v);

            if (values.filter(v => v === e.target.value).length > 1) {
                Swal.fire("Duplicate Attribute", "Attribute already used", "warning");
                e.target.value = "";
            }
        }
    });


    /* ================= UTILITIES ================= */

    function closeAllActionMenus() {
        document.querySelectorAll(".action-menu")
            .forEach(menu => menu.classList.add("hidden"));
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

        resetRupiahState(
            "create-harga-beli-display",
            "create-harga-jual-display",
            "edit-harga-beli-display",
            "edit-harga-jual-display"
        );

        const wrapCreate = document.getElementById("attr-wrapper-create");
        const wrapEdit   = document.getElementById("attr-wrapper-edit");

        if (wrapCreate) wrapCreate.innerHTML = "";
        if (wrapEdit) wrapEdit.innerHTML = "";

        attrIndex = 1;
        addAttributeRow("", "", "create");

        const form = modal.querySelector("form");
        if (form) form.reset();

        modal.querySelectorAll("#create-image-preview, #edit-image-preview").forEach(img => img.src = "");

        modal.querySelectorAll(".text-red-600").forEach(el => el.remove());
        modal.querySelectorAll(".border-red-500").forEach(el => el.classList.remove("border-red-500"));
        modal.querySelector(".is-validation-error")?.remove();
        modal.querySelectorAll("[id$='-filename']").forEach(el => {
            el.textContent = "No file chosen";
        });

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

        // GUARD CLICK HANDLER
        if (!isCrud && (
            e.target.closest("#btnAddProduct") ||
            e.target.closest("#btn-save-create-product") ||
            e.target.closest("#btn-save-edit-product")
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

        /* ================= OPEN MODALS ================= */

        // CREATECPRODUCT
        if (e.target.closest("#btnAddProduct")) {

            closeAllActionMenus();

            const img = document.getElementById("create-image-preview");
            const placeholder = document.getElementById("create-image-placeholder");
            img.classList.add("hidden");
            placeholder.classList.remove("hidden");

            openModal(document.getElementById("createProductModal"));
            return;
        }

        // BIN PRODUCT
        if (e.target.closest("#btn-open-bin-product")) {

            closeAllActionMenus();

            const res = await fetch("/admin/products-management/bin");
            const products = await res.json();

            if (!res.ok) {
                Swal.fire("Error", "Failed to load bin data", "error");
                return;                
            }

            openModal(document.getElementById("binProductModal"));

            requestAnimationFrame(() => {

                if ($.fn.DataTable.isDataTable("#binProductsTable")) {
                    binProductsTable.clear().destroy();
                }

                binProductsTable = $("#binProductsTable").DataTable({
                    data: products,
                    columns: [
                        { data: null, className: "text-center" },
                        { data: "sku" },
                        { data: "name" },
                        { data: "deleted_at", render: d => formatDate(d) },
                        {
                            data: "id",
                            orderable: false,
                            className: "text-center",
                            render: id => `
                                <form action="/admin/products-management/${id}/restore" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="button"
                                        class="btn-confirm px-3 py-1.5 rounded bg-slate-800 text-white"
                                        data-title="Restore product?"
                                        data-text="Product will be restored"
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
                binProductsTable.off("draw.dt").on("draw.dt", () => {
                    binProductsTable.column(0).nodes()
                        .each((cell, i) => cell.innerHTML = i + 1);
                });
                binProductsTable.draw();

            });

            return;
        }

        /* ================= VIEW PRODUCT ================= */

        const viewBtn = e.target.closest("[data-action='view']");
        if (viewBtn) {

            closeAllActionMenus();

            const p = JSON.parse(viewBtn.dataset.product);

            const attrBox = document.getElementById("view-attributes");
            attrBox.innerHTML = "";

            if (p.attribute_values?.length) {
                p.attribute_values.forEach(a => {
                    const li = document.createElement("li");
                    li.innerHTML = `<b>${a.name}</b>: ${a.value}`;
                    attrBox.appendChild(li);
                });
            } else {
                attrBox.innerHTML = "<li class='text-gray-400'>No attributes</li>";
            }

            document.getElementById("view-name").textContent = p.name;
            document.getElementById("view-sku").textContent = p.sku;
            document.getElementById("view-min-stock").textContent = p.minimum_stock;
            document.getElementById("view-category").textContent = p.category?.name ?? "-";
            document.getElementById("view-supplier").textContent = p.supplier?.name ?? "-";

            document.getElementById("view-purchase").textContent = formatRupiahView(p.purchase_price);
            document.getElementById("view-selling").textContent = formatRupiahView(p.selling_price);

            document.getElementById("view-description").textContent = p.description ?? "-";

            const statusEl = document.getElementById("view-status");
            statusEl.textContent = p.is_active ? "Active" : "Inactive";
            statusEl.className = `inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ${
                p.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
            }`;

            const img = document.getElementById("view-image");
            const placeholder = document.getElementById("view-image-placeholder");

            if (p.image) {
                img.src = `/storage/${p.image}`;
                img.classList.remove("hidden");
                placeholder.classList.add("hidden");
            } else {
                img.classList.add("hidden");
                placeholder.classList.remove("hidden");
            }

            openModal(document.getElementById("viewProductModal"));
            return;
        }

        // ================= EDIT PRODUCT =================
        const editBtn = e.target.closest("[data-action='edit']");
        if (editBtn) {

            closeAllActionMenus();

            const p = JSON.parse(editBtn.dataset.product);

            const form = document.getElementById("editProductForm");

            // SET ACTION
            form.action = `/admin/products-management/${p.id}`;

            // SET VALUE
            form.querySelector("[name='name']").value = p.name;
            form.querySelector("[name='sku']").value = p.sku;

            rupiahState["edit-harga-beli-display"] = String(p.purchase_price);
            rupiahState["edit-harga-jual-display"] = String(p.selling_price);

            document.getElementById("edit-harga-beli").value = p.purchase_price;
            document.getElementById("edit-harga-beli-display").value = formatRupiahView(p.purchase_price);
            document.getElementById("edit-harga-jual").value = p.selling_price;
            document.getElementById("edit-harga-jual-display").value = formatRupiahView(p.selling_price);

            form.querySelector("[name='minimum_stock']").value = p.minimum_stock;
            form.querySelector("[name='is_active']").value = p.is_active ? 1 : 0;
            form.querySelector("[name='category_id']").value = p.category_id;
            form.querySelector("[name='supplier_id']").value = p.supplier_id;
            form.querySelector("[name='description']").value = p.description ?? "";

            // IMAGE PREVIEW
            const img = document.getElementById("edit-image-preview");
            const placeholder = document.getElementById("edit-image-placeholder");

            if (p.image) {
                img.src = `/storage/${p.image}`;
                img.classList.remove("hidden");
                placeholder.classList.add("hidden");
            } else {
                img.classList.add("hidden");
                placeholder.classList.remove("hidden");
            }

            document.getElementById("edit-image-filename").textContent = "No file chosen";

            const wrap = document.getElementById("attr-wrapper-edit");
            wrap.innerHTML = "";
            attrIndex = 1;

            if (p.attribute_values) {
                p.attribute_values.forEach(row => {
                    addAttributeRow(row.id, row.value, "edit");
                });
            }

            openModal(document.getElementById("editProductModal"));
            return;
        }

        /* ================= SAVE CREATE PRODUCT ================= */
        const createBtn = e.target.closest("#btn-save-create-product");

        if (createBtn) {
            createBtn.disabled = true;

            const form = document.getElementById("createProductForm");

            const res = await fetch("/admin/products-management", {
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

            return;
        }


        // ================= SAVE EDIT PRODUCT =================
        const saveEditBtn = e.target.closest("#btn-save-edit-product");

        if (saveEditBtn) {
            saveEditBtn.disabled = true;

            const form = document.getElementById("editProductForm");

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

            Swal.fire({
                icon: "success",
                title: "Updated",
                text: data.message,
                confirmButtonColor: "#16a34a"
            }).then(() => location.reload());

            return;
        }

        // ================= DELETE & RESTORE =================
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

            Swal.fire({
                icon: "success",
                title: "Success",
                text: data.message,
                confirmButtonColor: "#16a34a"
            }).then(() => location.reload());

            return;
        }

    });

});
