<div id="editUserModal"
     class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg">

            <div class="flex justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Edit User</h2>
                <button data-modal-close>✕</button>
            </div>

            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')

                <div class="px-6 py-4 space-y-4">
                    <input id="edit-name" name="name" class="input" required>
                    <input id="edit-email" name="email" type="email" class="input" required>

                    <select id="edit-role" name="role" class="input">
                        <option value="manajer_gudang">Manajer Gudang</option>
                        <option value="staff_gudang">Staff Gudang</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 px-6 py-4 border-t">
                    <button data-modal-close type="button">Cancel</button>

                    <button
                        type="button"
                        class="btn-confirm bg-blue-600 text-white px-4 py-2 rounded"
                        data-title="Simpan perubahan?"
                        data-confirm="Ya, Simpan">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
