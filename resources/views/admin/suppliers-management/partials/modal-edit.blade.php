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
        <div class="flex items-center justify-between px-6 py-4 bg-yellow-500 text-white rounded-t-lg">
            <h2 class="text-lg font-semibold">
                Edit Supplier
            </h2>

            <button
                type="button"
                data-modal-close
                class="absolute top-0 right-0 w-12 h-12
                    flex items-center justify-center
                    hover:bg-red-500 transition rounded-tr-lg">
                ✕
            </button>
        </div>

        {{-- BODY --}}
        <form id="editSupplierForm" class="px-6 py-5 space-y-4" method="POST">

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
                    bg-gray-200 
                    rounded-md
                    hover:bg-gray-300
                    disabled:opacity-50 disabled:cursor-not-allowed
                    transition">
                Cancel
            </button>

            <button
                type="button"
                id="btn-save-edit-supplier"
                class="px-4 py-2 text-sm font-medium text-white
                    bg-yellow-500 rounded-md
                    hover:bg-yellow-600
                    disabled:opacity-50 disabled:cursor-not-allowed
                    transition">
                Save
            </button>

        </div>

    </div>
</div>
