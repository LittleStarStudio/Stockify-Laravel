<div id="viewSupplierModal"
     class="fixed inset-0 z-50 flex items-center justify-center
            opacity-0 pointer-events-none transition"
     data-modal-overlay>

    <div class="modal-box bg-white rounded-lg shadow-lg w-full max-w-lg
                transform transition">

        <div class="p-6 space-y-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Supplier Detail
            </h2>

            <div class="space-y-2 text-sm">
                <p><strong>Name:</strong> <span id="view-name"></span></p>
                <p><strong>Email:</strong> <span id="view-email"></span></p>
                <p><strong>Phone:</strong> <span id="view-phone"></span></p>
                <p><strong>Address:</strong> <span id="view-address"></span></p>
                <p><strong>Created:</strong> <span id="view-created"></span></p>
                <p><strong>Updated:</strong> <span id="view-updated"></span></p>
            </div>

            <div class="flex justify-end">
                <button
                    type="button"
                    data-modal-close
                    class="px-4 py-2 text-sm bg-gray-600 text-white rounded hover:bg-gray-700">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
