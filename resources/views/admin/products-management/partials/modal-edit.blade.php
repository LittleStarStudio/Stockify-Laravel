<div id="editProductModal"
     class="fixed inset-0 z-50 flex items-start justify-center
            bg-black bg-opacity-0 opacity-0 pointer-events-none
            transition-opacity duration-300"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-4xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0
                    transition-all duration-300 ease-out">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-yellow-500 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">Edit Product</h2>

                <button data-modal-close
                        class="absolute top-0 right-0 w-12 h-12
                               flex items-center justify-center
                               hover:bg-red-500 transition rounded-tr-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="px-6 py-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- IMAGE PREVIEW -->
                        <div class="flex flex-col items-center space-y-3">

                            <div class="w-40 h-40 border rounded-lg overflow-hidden bg-gray-100
                                        flex items-center justify-center">

                                <img id="edit-image-preview"
                                     src=""
                                     class="w-full h-full object-cover hidden">

                                <span id="edit-image-placeholder"
                                      class="text-gray-400 text-sm">
                                    No Image
                                </span>
                            </div>

                            <!-- FILE PICKER -->
                            <label class="flex items-center gap-3 px-3 py-2
                                          border border-gray-300 rounded-lg
                                          cursor-pointer hover:bg-gray-50">

                                <span class="px-3 py-1 bg-gray-100 rounded text-sm">
                                    Choose File
                                </span>

                                <span id="edit-image-filename"
                                      class="text-sm text-gray-500">
                                    No file chosen
                                </span>

                                <input id="edit-image"
                                       type="file"
                                       name="image"
                                       class="hidden">
                            </label>

                            <!-- ATTRIBUTES -->
                            <div>
                                <label class="text-sm text-gray-500">Attributes</label>

                                <div id="attr-wrapper-edit" class="space-y-2 mt-2"></div>

                                <button type="button"
                                        id="btnAddAttrEdit"
                                        class="mt-2 text-blue-600 text-sm hover:underline">
                                    + Add Attribute
                                </button>
                            </div>

                        </div>

                        <!-- FORM GRID -->
                        <div class="md:col-span-2 space-y-4">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="text-sm text-gray-500">Name</label>
                                    <input id="edit-name" name="name" class="input">
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Min Stock</label>
                                    <input id="edit-minimum_stock" type="number" name="minimum_stock" class="input">
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">SKU</label>
                                    <input id="edit-sku" name="sku" class="input">
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Status</label>
                                    <select id="edit-is_active" name="is_active" class="input">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Category</label>
                                    <select id="edit-category_id" name="category_id" class="input">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Supplier</label>
                                    <select id="edit-supplier_id" name="supplier_id" class="input">
                                        @foreach($suppliers as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Purchase</label>
                                    <input type="text" id="edit-harga-beli-display" class="input">
                                    <input type="hidden" name="purchase_price" id="edit-harga-beli">
                                </div>

                                <div>
                                    <label class="text-sm text-gray-500">Selling</label>
                                    <input type="text" id="edit-harga-jual-display" class="input">
                                    <input type="hidden" name="selling_price" id="edit-harga-jual">
                                </div>

                            </div>

                            <!-- DESCRIPTION -->
                            <div>
                                <label class="text-sm text-gray-500">Description</label>
                                <textarea id="edit-description" name="description" rows="3" class="input"></textarea>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t flex justify-end gap-2">

                    <button data-modal-close type="button"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button type="button"
                            id="btn-save-edit-product"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Save
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
