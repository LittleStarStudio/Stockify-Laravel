<div id="editUserModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-0 opacity-0
            pointer-events-none transition-opacity duration-300"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-2xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0
                    transition-all duration-300 ease-out">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-yellow-500 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">Edit User</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12
                               flex items-center justify-center
                               hover:bg-red-500 transition rounded-tr-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="px-6 py-6 space-y-6">

                    <!-- AVATAR PREVIEW -->
                    <div class="flex justify-center">
                        <img id="edit-avatar-preview"
                             class="w-24 h-24 rounded-full object-cover border shadow"
                             src="{{ asset('images/avatar-default.png') }}">
                    </div>

                    <!-- GRID -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-gray-500">Name</label>
                            <input id="edit-name" name="name" class="input">
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <input id="edit-email" type="email" name="email" class="input">
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">Role</label>
                            <select id="edit-role" name="role" class="input">
                                <option value="admin">Admin</option>
                                <option value="manajer_gudang">Manager Gudang</option>
                                <option value="staff_gudang">Staff Gudang</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">Status</label>
                            <select id="edit-status" name="approval_status" class="input">
                                <option value="active">Active</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <!-- AVATAR UPLOAD -->
                        <div class="md:col-span-2">
                            <label class="block text-sm text-gray-500 mb-1">Avatar</label>

                            <label class="flex items-center gap-3 px-3 py-2
                                          border rounded-lg cursor-pointer">
                                <span class="px-3 py-1 bg-gray-100 rounded text-sm">
                                    Choose File
                                </span>

                                <span id="edit-avatar-filename"
                                      class="text-sm text-gray-500">
                                    No file chosen
                                </span>

                                <input id="edit-avatar" type="file" name="avatar" class="hidden">
                            </label>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t flex justify-end gap-2">

                    <!-- CANCEL -->
                    <button
                        data-modal-close
                        type="button"
                        class="px-4 py-2 rounded-md
                            bg-gray-200 text-gray-700
                            hover:bg-gray-300
                            active:bg-gray-400
                            focus:outline-none focus:ring-2 focus:ring-gray-300
                            transition-all duration-200">
                        Cancel
                    </button>

                    <!-- SAVE -->
                    <button
                        type="button"
                        id="btn-save-edit-user"
                        class="px-4 py-2 rounded-md
                            bg-yellow-500 text-white
                            hover:bg-yellow-600
                            active:bg-yellow-700
                            focus:outline-none focus:ring-2 focus:ring-yellow-400
                            transition-all duration-200">
                        Save
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
