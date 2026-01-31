document.addEventListener("DOMContentLoaded", () => {

    // MEMASTIKAN JQUERY
    if (typeof window.$ === "undefined" || !$.fn || !$.fn.DataTable) {
        console.warn("jQuery / DataTable has not been loaded");
        return;
    }

    let binUsersDataTable = null;
    let usersManagementDataTable = null;

    // CSRF TOKEN
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // AVATAR PREVIEW (CREATE)
    const createAvatarInput    = document.getElementById("create-avatar");
    const createAvatarPreview  = document.getElementById("create-avatar-preview");
    const createAvatarFilename = document.getElementById("create-avatar-filename");

    if (createAvatarInput) {

        createAvatarInput.addEventListener("change", function () {

            if (this.files && this.files[0]) {
                createAvatarPreview.src = URL.createObjectURL(this.files[0]);
                createAvatarFilename.textContent = this.files[0].name;
            } else {
                createAvatarPreview.src = "/images/avatar-default.png";
                createAvatarFilename.textContent = "No file chosen";
            }

        });

    }


    // AVATAR PREVIEW (EDIT)
    const editAvatarInput    = document.getElementById("edit-avatar");
    const editAvatarPreview  = document.getElementById("edit-avatar-preview");
    const editAvatarFilename = document.getElementById("edit-avatar-filename");

    if (editAvatarInput) {

        editAvatarInput.addEventListener("change", function () {

            if (this.files && this.files[0]) {
                editAvatarPreview.src = URL.createObjectURL(this.files[0]);
                editAvatarFilename.textContent = this.files[0].name;
            } else {
                editAvatarPreview.src = "/images/avatar-default.png";
                editAvatarFilename.textContent = "No file chosen";
            }

        });
        
    }


    // TOGGLE PASSWORD VISIBILITY (CREATE)
    const toggleCreatePassword = document.getElementById("toggle-create-password");
    const createPasswordInput  = document.getElementById("create-password");
    const eyeOpen   = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (toggleCreatePassword) {
        toggleCreatePassword.addEventListener("click", () => {
            const isHidden = createPasswordInput.type === "password";

            createPasswordInput.type = isHidden ? "text" : "password";
            eyeOpen.classList.toggle("hidden", !isHidden);
            eyeClosed.classList.toggle("hidden", isHidden);
        });
    }


    // UTILITY FUNCTIONS
    function closeAllActionMenus() {
        document.querySelectorAll(".action-menu")
            .forEach(menu => menu.classList.add("hidden"));
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
            minute:  "2-digit"
        });
    }

    function openModal(modal) {
        if (!modal) return;

        const box = modal.querySelector(".modal-box");
        if (!box) return;

        // OPEN MODAL ANIMATION
        modal.classList.remove("opacity-0", "pointer-events-none", "bg-opacity-0");
        modal.classList.add("opacity-100", "bg-opacity-50");

        requestAnimationFrame(() => {
            box.classList.remove("-translate-y-6", "opacity-0");
            box.classList.add("translate-y-0", "opacity-100");
        });
    }

    function closeModal(modal) {
        if (!modal) return;

        const hasError = modal.querySelector(".is-validation-error");

        // RESET FORM DAN AVATAR
        if (!hasError) {
            const form = modal.querySelector("form");
            if (form) form.reset();

            // RESET AVATAR PREVIEW (CREATE MODAL)
            const createPreview  = modal.querySelector("#create-avatar-preview");
            const createFilename = modal.querySelector("#create-avatar-filename");

            if (createPreview)  createPreview.src = "/images/avatar-default.png";
            if (createFilename) createFilename.textContent = "No file chosen";

            // RESET AVATAR PREVIEW (EDIT MODAL)
            const editPreview = modal.querySelector("#edit-avatar-preview");
            const editFilename = modal.querySelector("#edit-avatar-filename");

            if (editPreview) editPreview.src = "/images/avatar-default.png";
            if (editFilename) editFilename.textContent = "No file chosen";

        }

        // RESET VIEW MODAL
        const viewAvatar  = modal.querySelector("#view-avatar");
        const viewName    = modal.querySelector("#view-name");
        const viewEmail   = modal.querySelector("#view-email");
        const viewRole    = modal.querySelector("#view-role");
        const viewCreated = modal.querySelector("#view-created");
        const viewUpdated = modal.querySelector("#view-updated");

        if (viewAvatar)  viewAvatar.src = "";
        if (viewName)    viewName.textContent = "";
        if (viewEmail)   viewEmail.textContent = "";
        if (viewRole)    viewRole.textContent = "";
        if (viewCreated) viewCreated.textContent = "";
        if (viewUpdated) viewUpdated.textContent = "";

        const statusEl = modal.querySelector("#view-status");
        if (statusEl) {
            statusEl.textContent = "";
            statusEl.className = "inline-flex items-center px-3 py-1 text-xs font-medium rounded-full";
        }

        // RESET VALIDATION
        modal.querySelectorAll(".text-red-600").forEach(el => el.remove());
        modal.querySelectorAll(".border-red-500").forEach(el => el.classList.remove("border-red-500"));
        modal.querySelectorAll(".focus\\:ring-red-500").forEach(el => el.classList.remove("focus:ring-red-500"));
        modal.querySelector(".is-validation-error")?.remove();

        // CLOSE MODAL ANIMATION
        const box = modal.querySelector(".modal-box");

        if (box) {
            box.classList.remove("translate-y-0", "opacity-100");
            box.classList.add("-translate-y-6", "opacity-0");
        }

        modal.classList.remove("opacity-100", "bg-opacity-50");
        modal.classList.add("opacity-0", "bg-opacity-0");

        setTimeout(() => modal.classList.add("pointer-events-none"), 300);
    }


    // CREATE NEW USER (AJAX)
    const btnCreateUser = document.getElementById("btn-save-create-user");

    if (btnCreateUser) {
        btnCreateUser.addEventListener("click", async (e) => {

            e.preventDefault();

            const form = document.getElementById("createUserForm");

            const response = await fetch("/admin/users-management", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            if (response.ok) {
                const data = await response.json();

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: data.message
                }).then(() => location.reload());

                return;
            }

            if (response.status === 422) {
                const data = await response.json();

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    html: Object.values(data.errors)
                        .map(err => `<div>${err[0]}</div>`)
                        .join(""),
                    
                    confirmButtonColor: "#dc2626"
                });

                return;
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to create user"
            });
        });
    }


    // LOAD BIN USERS
    const binBtn = document.getElementById("btn-open-bin");

    if (binBtn) {
        binBtn.addEventListener("click", async () => {

            const res = await fetch("/admin/users-management/bin");
            const users = await res.json();

            // OPEN MODAL BIN
            const binModal = document.getElementById("binUserModal");
            openModal(binModal);

            requestAnimationFrame(() => {

                if ($.fn.DataTable.isDataTable('#binUsersTable')) {
                    binUsersDataTable.clear().destroy();
                }

                binUsersDataTable = $('#binUsersTable').DataTable({
                    data: users, 
                    columns: [
                        { data: null,
                          className: 'text-center'
                         }, 
                        { data: 'name' },
                        { data: 'email' },
                        {
                            data: 'deleted_at',
                            render: data => formatDate(data)
                        },
                        {
                            data: 'id',
                            orderable: false,
                            className: 'text-center',
                            render: id => `
                                <form action="/admin/users-management/${id}/restore" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button
                                        type="button"
                                        class="btn-confirm px-3 py-1.5 rounded-md text-white bg-slate-800 hover:bg-slate-900 transition"
                                        data-title="Restore user?"
                                        data-text="User will be restored"
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
                    responsive: true,
                    order: [],
                    language: {
                        emptyTable: "No deleted users found",
                        search: "Search:",
                        info: "Showing _START_ - _END_ of _TOTAL_ data",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    },
                    columnDefs: [
                        { orderable: false, targets: [0, 4] }
                    ]
                });

                // AUTO NUMBERING BIN
                binUsersDataTable
                    .off('order.dt search.dt draw.dt')
                    .on('order.dt search.dt draw.dt', function () {
                        binUsersDataTable
                            .column(0, { search: 'applied', order: 'applied' })
                            .nodes()
                            .each((cell, i) => {
                                cell.innerHTML = i + 1;
                            });
                    })
                    .draw();

            });

        });
    }

    // GLOBAL CLICK HANDLER
    document.addEventListener("click", async (e) => {

        // DELETE + RESTORE CONFIRMATION BUTTON
        const confirmBtn = e.target.closest(".btn-confirm");

        if (confirmBtn) {

            e.preventDefault();

            const form = confirmBtn.closest("form");
            if (!form) return;

            const title   = confirmBtn.dataset.title   || "Are you sure?";
            const text    = confirmBtn.dataset.text    || "This action cannot be undone.";
            const confirm = confirmBtn.dataset.confirm || "Yes";
            const color   = confirmBtn.dataset.color   || "#dc2626";

            Swal.fire({

                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: confirm,
                cancelButtonText: "Cancel",
                confirmButtonColor: color,
                cancelButtonColor: "#6b7280"

            }).then((result) => {

                if (result.isConfirmed) {

                    fetch(form.action, {
                        method: form.method || "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        body: new FormData(form)
                    })
                    .then(async (res) => {

                        if (!res.ok) {
                            const err = await res.json();
                            throw err;
                        }

                        return res.json();
                    })
                    .then((data) => {

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: data.message,
                            confirmButtonColor: "#16a34a"
                        });
                        const row = confirmBtn.closest("tr");

                        // DELETE (TABLE UTAMA)
                        if (usersManagementDataTable && usersManagementDataTable.table().node().contains(row)) {
                            usersManagementDataTable
                                .row(row)
                                .remove()
                                .draw(false);
                        }

                        // RESTORE (DARI BIN)
                        if (binUsersDataTable && binUsersDataTable.table().node().contains(row)) {
                            binUsersDataTable
                                .row(row)
                                .remove()
                                .draw(false);
                        }

                        // TAMBAH DATA KE TABLE UTAMA USERS MANAGEMENT (CRUD)
                        if (data.user && usersManagementDataTable) {

                        const exists = usersManagementDataTable
                            .rows()
                            .data()
                            .toArray()
                            .some(row => row[2] === data.user.email);

                        if (!exists) {
                            usersManagementDataTable.row.add([
                                '',
                                `
                                <div class="flex items-center gap-2">
                                    <img src="${data.user.avatar_url}"
                                        class="w-6 h-6 rounded-full object-cover border">
                                    <span class="font-medium">${data.user.name}</span>
                                </div>
                                `,
                                data.user.email,
                                data.user.role,
                                data.user.status_html,
                                `
                                <div class="text-center text-gray-400 italic">
                                    Reload page to manage
                                </div>
                                `
                            ]).draw(false);
                        }
                    }

                    })
                    .catch((err) => {

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: err.message || "Failed to process request",
                            confirmButtonColor: "#dc2626"
                        });

                    });

                }
                
            });

            return;
        }

        // CLOSE MODAL (OVERLAY)
        const overlay = e.target.closest("[data-modal-overlay");

        if (overlay && !e.target.closest(".modal-box")) {
            
            closeModal(overlay);
            closeAllActionMenus();
            return;
            
        }

        // CLOSE MODAL DENGAN TOMBOL (X / CANCEL)
        if (e.target.closest("[data-modal-close]")) {

            closeModal(e.target.closest("[data-modal-overlay]"));
            closeAllActionMenus();
            return;

        }


        // DROPDOWN TOGGLE
        const toggle = e.target.closest(".action-toggle");

        if (toggle) {

            const menu = toggle.nextElementSibling;

            document.querySelectorAll(".action-menu")
                .forEach(m => m !== menu && m.classList.add("hidden"));

            menu.classList.toggle("hidden");
            return;
        }

        // KLIK DI LUAR DROPDOWN
        if (!e.target.closest(".action-menu")  && !e.target.closest(".action-toggle")) {
            
            closeAllActionMenus();
        }

        // VIEW USER
        const viewBtn = e.target.closest("[data-action='view']");
        
        if (viewBtn) {

            closeAllActionMenus();

            const user = JSON.parse(viewBtn.dataset.user);

            document.getElementById("view-name").textContent = user.name;
            document.getElementById("view-email").textContent = user.email;
            document.getElementById("view-role").textContent = user.role;
            document.getElementById("view-created").textContent = user.created_at;
            document.getElementById("view-updated").textContent = user.updated_at;

            const statusEl = document.getElementById("view-status");

            statusEl.textContent = user.approval_status;
            statusEl.className = "inline-flex items-center px-3 py-1 text-xs font-medium rounded-full";

            if (user.approval_status.toLowerCase() === "active") {
                statusEl.classList.add("bg-green-100", "text-green-700");
            } else if (user.approval_status.toLowerCase() === "pending") {
                statusEl.classList.add("bg-yellow-100", "text-yellow-700");
            } else {
                statusEl.classList.add("bg-red-100", "text-red-700");
            }

            document.getElementById("view-avatar").src = user.avatar_url;

            openModal(document.getElementById("viewUserModal"));
            return;
        }


        // OPEN MODAL (CREATE)
        if (e.target.closest("[data-modal-target='createUserModal']")) {

            closeAllActionMenus();

            openModal(document.getElementById("createUserModal"));
            return;
        }

        // OPEN MODAL (EDIT)
        const editBtn = e.target.closest("[data-action='edit']");
        if (editBtn) {

            closeAllActionMenus();

            const user = JSON.parse(editBtn.dataset.user);

            document.getElementById("edit-name").value = user.name;
            document.getElementById("edit-email").value = user.email;
            document.getElementById("edit-role").value = user.role;
            document.getElementById("edit-status").value = user.approval_status;

            document.getElementById("edit-avatar-preview").src = user.avatar_url;
            document.getElementById("edit-avatar-filename").textContent = "No file chosen";

            document.getElementById("editUserForm").action =
                `/admin/users-management/${user.id}`;

            openModal(document.getElementById("editUserModal"));
            return;
        }

        // BUTTON SAVE (EDIT)
        const saveEditBtn = e.target.closest("#btn-save-edit-user");
        
        if (saveEditBtn) {

            const form = document.getElementById("editUserForm");

            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            if (response.ok) {
                const data = await response.json();

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: data.message,
                    confirmButtonColor: "#16a34a"
                }).then(() => location.reload());

                return;
            }

            if (response.status === 422) {

                const data = await response.json();

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    html: Object.values(data.errors)
                        .map(err => `<div>${err[0]}</div>`)
                        .join(""),

                    confirmButtonColor: "#dc2626"
                });

                return;
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Something went wrong"
            });
        }

    });

});

