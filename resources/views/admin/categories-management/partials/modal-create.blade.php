<div id="createCategoryModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-0 opacity-0 pointer-events-none transition"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0 transition-all">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">Add Category</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12
                               flex items-center justify-center
                               hover:bg-red-500 transition rounded-tr-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form id="createCategoryForm">
                @csrf

                <div class="px-6 py-6 space-y-4">

                    <div>
                        <label class="text-sm text-gray-500">Name</label>
                        <input name="name" class="input w-full">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Description</label>
                        <textarea name="description" rows="3" class="input w-full"></textarea>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t flex justify-end gap-2">
                    <button data-modal-close
                            type="button"
                            class="px-4 py-2 text-sm font-medium 
                                bg-gray-200 rounded-md
                                hover:bg-gray-300
                                disabled:opacity-50 disabled:cursor-not-allowed
                                transition">
                        Cancel
                    </button>

                    <button
                        type="button"
                        id="btn-save-create-category"
                        class="px-4 py-2 text-sm font-medium text-white
                            bg-blue-600 rounded-md
                            hover:bg-blue-700
                            disabled:opacity-50 disabled:cursor-not-allowed
                            transition">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
