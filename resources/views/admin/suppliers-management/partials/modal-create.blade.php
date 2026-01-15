<div id="createSupplierModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-0 opacity-0 pointer-events-none transition"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0 transition-all">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">Add Supplier</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12
                               flex items-center justify-center
                               hover:bg-red-500 transition rounded-tr-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form id="createSupplierForm">
                @csrf

                <div class="px-6 py-6 space-y-4">

                    <div>
                        <label class="text-sm text-gray-500">Name</label>
                        <input name="name" class="input w-full">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <input name="email" type="email" class="input w-full">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Phone</label>
                        <input name="phone" class="input w-full">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Address</label>
                        <textarea name="address" rows="3" class="input w-full"></textarea>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t flex justify-end gap-2">
                    <button data-modal-close
                            type="button"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button
                        type="button"
                        id="btn-save-create-supplier"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
