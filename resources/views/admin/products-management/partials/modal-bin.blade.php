<div id="binProductModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-50
            opacity-0 pointer-events-none transition"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box bg-white w-full max-w-4xl
            rounded-xl overflow-hidden
            shadow-lg transform -translate-y-6 opacity-0 transition-all">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-gray-800 text-white">
                <h2 class="font-semibold">Product Bin</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12
                               flex items-center justify-center
                               text-white
                               rounded-tr-lg
                               hover:bg-red-500 transition">
                    ✕
                </button>
            </div>

            <!-- TABLE -->
            <div class="p-6 overflow-x-auto">
                <table id="binProductsTable"
                       class="w-full text-sm text-left text-black border-collapse table-crud">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 w-12 text-center col-action">No</th>
                            <th class="px-4 py-2">SKU</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Deleted At</th>
                            <th class="px-4 py-2 text-center col-action">Action</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>
            </div>

        </div>
    </div>
</div>
