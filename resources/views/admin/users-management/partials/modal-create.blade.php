<div id="createUserModal"
     class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg">


            <!-- HEADER -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Add User</h2>
                <button data-modal-close class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>


            <!-- FORM -->
            <form method="POST" action="{{ route('admin.users-management.store') }}">
                @csrf

                <div class="px-6 py-4 space-y-4">

                    <div>
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name"
                               class="w-full px-3 py-2 mt-1 border rounded"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email"
                               class="w-full px-3 py-2 mt-1 border rounded"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password"
                               class="w-full px-3 py-2 mt-1 border rounded"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Role</label>
                        <select name="role"
                                class="w-full px-3 py-2 mt-1 border rounded">
                            <option value="manajer_gudang">Manajer Gudang</option>
                            <option value="staff_gudang">Staff Gudang</option>
                        </select>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-2 px-6 py-4 border-t">

                    <button type="button"
                            data-modal-close
                            class="px-4 py-2 text-sm bg-gray-200 rounded">
                        Cancel
                    </button>
                    
                    <button
                        type="button"
                        class="btn-confirm px-4 py-2 text-sm text-white bg-blue-600 rounded"
                        data-title="Tambah user?"
                        data-text="Data user akan disimpan"
                        data-confirm="Ya, Simpan">
                        Save
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
