<div id="viewUserModal"
     class="fixed inset-0 z-50 flex items-start justify-center bg-black bg-opacity-0 opacity-0 pointer-events-none transition-opacity duration-300"
     data-modal-overlay>

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-box w-full max-w-2xl bg-white rounded-lg shadow-xl transform -translate-y-6 opacity-0 transition-all duration-300 ease-out">

            <!-- HEADER -->
            <div class="relative px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold">User View</h2>

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
            <div class="px-6 py-6 space-y-5">

                <!-- AVATAR -->
                <div class="flex justify-center">
                    <img id="view-avatar"
                         class="w-24 h-24 rounded-full object-cover border shadow"
                         alt="Avatar">
                </div>

                @php
                    $row = 'grid grid-cols-[70px_1px_1fr] items-center px-4 py-3 border rounded-lg shadow-sm hover:shadow-md transition bg-white';
                    $label = 'text-sm text-gray-500 pr-4 text-left';
                    $divider = 'h-6 bg-gray-400';
                    $value = 'text-sm font-medium text-gray-700 text-right pl-4 break-all max-w-full overflow-hidden';
                @endphp

                <!-- INFO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Name --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Name</span>
                        <span class="{{ $divider }}"></span>
                        <span id="view-name" class="{{ $value }}"></span>
                    </div>

                    {{-- Email --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Email</span>
                        <span class="{{ $divider }}"></span>
                        <span id="view-email" class="{{ $value }}"></span>
                    </div>

                    {{-- Role --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Role</span>
                        <span class="{{ $divider }}"></span>
                        <span id="view-role" class="{{ $value }}"></span>
                    </div>

                    {{-- Status --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Status</span>
                        <span class="{{ $divider }}"></span>
                        <div class="flex justify-end">
                            <span id="view-status"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full">
                            </span>
                        </div>
                    </div>

                    {{-- Created --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Created</span>
                        <span class="{{ $divider }}"></span>
                        <span id="view-created" class="{{ $value }}"></span>
                    </div>

                    {{-- Updated --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Updated</span>
                        <span class="{{ $divider }}"></span>
                        <span id="view-updated" class="{{ $value }}"></span>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
