<div id="createUserModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-0 opacity-0 pointer-events-none transition"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-2xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0 transition-all">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">Create User</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12 flex items-center justify-center
                               hover:bg-red-500 transition rounded-tr-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form id="createUserForm" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="is-validation-error hidden"></div>
                @endif

                <div class="px-6 py-6 space-y-6">

                    <!-- AVATAR PREVIEW -->
                    <div class="flex justify-center">
                        <img id="create-avatar-preview"
                             class="w-24 h-24 rounded-full object-cover border shadow"
                             src="{{ asset('images/avatar-default.png') }}"
                             alt="Avatar">
                    </div>

                    <!-- GRID FORM -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- NAME -->
                        <div>
                            <label class="text-sm text-gray-500">Name</label>
                            <input name="name" class="input">
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <input name="email" type="email" class="input">
                        </div>

                        <!-- PASSWORD -->
                        <div class="relative md:col-span-2">
                            <label class="text-sm text-gray-500">Password</label>

                            <input
                                id="create-password"
                                type="password"
                                name="password"
                                class="input pr-10">

                            <button
                                type="button"
                                id="toggle-create-password"
                                class="absolute right-3 top-9 text-gray-500 hover:text-gray-700">

                                <!-- EYE OPEN -->
                                <svg id="eye-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M21 12c0 1.2-4 6-9 6s-9-4.8-9-6c0-1.2 4-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M15 12a3 3 0 1 1-6 0"/>
                                </svg>

                                <!-- EYE CLOSED -->
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M3 3l18 18"/>
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                                </svg>
                            </button>
                        </div>

                        <!-- ROLE -->
                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Role</label>
                            <select name="role" class="input">
                                <option value="admin">Admin</option>
                                <option value="manajer_gudang">Manager Gudang</option>
                                <option value="staff_gudang">Staff Gudang</option>
                            </select>
                        </div>

                        <!-- AVATAR UPLOAD -->
                        <div class="md:col-span-2">
                            <label class="block text-sm text-gray-500 mb-1">
                                Avatar
                            </label>

                            <label class="flex items-center gap-3 px-3 py-2
                                          border border-gray-300 rounded-lg
                                          cursor-pointer hover:bg-gray-50">

                                <span class="px-3 py-1 bg-gray-100 rounded text-sm">
                                    Choose File
                                </span>

                                <span id="create-avatar-filename"
                                      class="text-sm text-gray-500">
                                    No file chosen
                                </span>

                                <input id="create-avatar"
                                       type="file"
                                       name="avatar"
                                       class="hidden">
                            </label>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t flex justify-end gap-2">
                    <button
                        data-modal-close
                        type="button"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button
                        type="button"
                        id="btn-save-create-user"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
