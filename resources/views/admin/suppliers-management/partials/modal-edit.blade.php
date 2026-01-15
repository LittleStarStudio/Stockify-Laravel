{{-- ================= EDIT SUPPLIER MODAL ================= --}}
<div
    id="editSupplierModal"
    data-modal-overlay
    class="fixed inset-0 z-50 flex items-center justify-center
           bg-black bg-opacity-0 opacity-0 pointer-events-none
           transition-all duration-300">

    <div
        class="modal-box w-full max-w-lg bg-white rounded-lg shadow-lg
               transform -translate-y-6 opacity-0 transition-all duration-300">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 bg-blue-600 rounded-t-lg">
            <h2 class="text-lg font-semibold text-white">
                Edit Supplier
            </h2>

            <button
                type="button"
                data-modal-close
                class="text-white hover:text-gray-200 transition">
                ✕
            </button>
        </div>

        {{-- BODY --}}
        <form id="editSupplierForm" class="px-6 py-5 space-y-4">

            {{-- NAME --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>
                <input
                    type="text"
                    id="edit-name"
                    name="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Supplier name">
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    id="edit-email"
                    name="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="supplier@email.com">
            </div>

            {{-- PHONE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Phone
                </label>
                <input
                    type="text"
                    id="edit-phone"
                    name="phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="08xxxxxxxxxx">
            </div>

            {{-- ADDRESS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Address
                </label>
                <textarea
                    id="edit-address"
                    name="address"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Supplier address"></textarea>
            </div>

        </form>

        {{-- FOOTER --}}
        <div class="flex justify-end gap-2 px-6 py-4 border-t">

            <button
                type="button"
                data-modal-close
                class="px-4 py-2 text-sm font-medium text-gray-700
                       bg-gray-100 rounded-md hover:bg-gray-200 transition">
                Cancel
            </button>

            <button
                type="button"
                id="btn-save-edit-supplier"
                class="px-4 py-2 text-sm font-medium text-white
                       bg-blue-600 rounded-md hover:bg-blue-700 transition">
                Save Changes
            </button>

        </div>

    </div>
</div>
