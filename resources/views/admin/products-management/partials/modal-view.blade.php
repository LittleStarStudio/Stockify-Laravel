<div id="viewProductModal"
     class="fixed inset-0 z-50 flex items-start justify-center
            bg-black bg-opacity-0 opacity-0 pointer-events-none
            transition-opacity duration-300"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-4xl bg-white rounded-lg shadow-xl
                    transform -translate-y-6 opacity-0
                    transition-all duration-300 ease-out">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">
                    Product Detail
                </h2>

                <button
                    data-modal-close
                    class="absolute top-0 right-0
                           w-12 h-12
                           flex items-center justify-center
                           text-white
                           rounded-tr-lg
                           hover:bg-red-500 transition">
                    ✕
                </button>
            </div>

            <!-- CONTENT -->
            <div class="px-6 py-6">

                @php
                    $row = 'grid grid-cols-[80px_1px_1fr] items-center
                            px-4 py-3 border rounded-lg shadow-sm
                            hover:shadow-md transition bg-white';

                    $label = 'text-sm text-gray-500 pr-4 text-left';
                    $divider = 'h-6 bg-gray-300';
                    $value = 'text-sm font-medium text-gray-700
                              text-right pl-4 break-all';
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <!-- IMAGE PREVIEW -->
                        <div class="flex flex-col items-center justify-start space-y-3">

                            <div class="w-40 h-40 border rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                                <img id="view-image"
                                    src=""
                                    alt="Product Image"
                                    class="w-full h-full object-cover hidden">
                                <span id="view-image-placeholder"
                                    class="text-gray-400 text-sm">
                                    No Image
                                </span>
                            </div>
                            
                        </div>

                        <!-- ATTRIBUTES VIEW -->
                        <div class="w-full border rounded-lg p-3 bg-white shadow-sm mt-3">
                            <p class="text-sm text-gray-500 text-center mb-2">
                                Attributes
                            </p>
                            <ul id="view-attributes" class="text-sm text-gray-700 bg-gray-100 border rounded-md p-2 space-y-1"></ul>
                        </div>
                    </div>

                    <!-- DATA GRID -->
                    <div class="md:col-span-2 space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Name -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Name</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-name" class="{{ $value }}"></span>
                            </div>

                            <!-- Min Stock -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Min Stock</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-min-stock" class="{{ $value }}"></span>
                            </div>

                            <!-- SKU -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">SKU</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-sku" class="{{ $value }}"></span>
                            </div>

                            <!-- Status -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Status</span>
                                <span class="{{ $divider }}"></span>
                                <div class="flex justify-end">
                                    <span id="view-status"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full">
                                    </span>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Category</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-category" class="{{ $value }}"></span>
                            </div>

                            <!-- Supplier -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Supplier</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-supplier" class="{{ $value }}"></span>
                            </div>

                            <!-- Purchase -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Purchase</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-purchase" class="{{ $value }}"></span>
                            </div>

                            <!-- Selling -->
                            <div class="{{ $row }}">
                                <span class="{{ $label }}">Selling</span>
                                <span class="{{ $divider }}"></span>
                                <span id="view-selling" class="{{ $value }}"></span>
                            </div>

                        </div>

                        <!-- DESCRIPTION -->
                        <div class="border rounded-lg shadow-sm bg-white p-4 space-y-2 hover:shadow-md transition bg-white">
                    
                            <p class="text-sm text-gray-500 text-center">
                                Description
                            </p>
                            <hr class="border-gray-300">
                            <p id="view-description" class="text-sm text-gray-700 font-medium text-left break-words"></p>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
