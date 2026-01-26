<!-- ================= SIDEBAR ================= -->
    <aside id="top-bar-sidebar" class="fixed top-14 left-0 z-40 w-64 h-[calc(100vh-3.5rem)] transition-transform -translate-x-full sm:translate-x-0 bg-sky-100 border-e border-sky-200">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-1 text-sm font-medium text-sky-900">

                {{-- Dashboard MENU --}}
                <li>
                    <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-base {{ request()->is('dashboard') ? 'bg-sky-300 font-semibold' : 'hover:bg-sky-200' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>


                @if (auth()->user()->role === 'admin')
                    {{-- USERS MENU --}}
                    <li>

                        <button type="button"
                            class="flex items-center w-full gap-3 px-3 py-2 rounded-base
                            transition
                            {{ request()->is('admin/user-requests*', 'admin/users-management*')
                                ? 'bg-sky-300 font-semibold'
                                : 'hover:bg-sky-200' }}"
                            aria-controls="dropdown-users"
                            data-collapse-toggle="dropdown-users">

                            {{-- ICON --}}
                            <svg class="flex-shrink-0 w-5 h-5"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M7 17a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4M12 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                            </svg>

                            {{-- LABEL --}}
                            <span class="flex-1 text-left whitespace-nowrap">
                                Users
                            </span>

                            {{-- ARROW --}}
                            <svg class="w-4 h-4 transition-transform duration-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- SUB MENU --}}
                        <ul id="dropdown-users"
                            class="hidden py-1 space-y-1">

                            {{-- USERS REQUEST --}}
                            <li>
                                <a href="{{ route('admin.user-requests.index') }}"
                                    class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                    {{ request()->is('admin/user-requests*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Users Request
                                </a>
                            </li>

                            {{-- USERS MANAGEMENT --}}
                            <li>
                                <a href="{{ route('admin.users-management.index') }}"
                                    class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                    {{ request()->is('admin/users-management*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Users Management
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                <!-- SUPPLIERS MENU -->
                <li>
                    <a href="{{ route('admin.suppliers-management.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-base {{ request()->is('admin/suppliers-management*') ? 'bg-sky-300 font-semibold' : 'hover:bg-sky-200' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                        <span>Suppliers</span>
                    </a>
                </li>
                
                <!-- CATEGORIES MENU -->
                <li>
                    <a href="{{ route('admin.categories-management.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-base {{ request()->is('admin/categories-management*') ? 'bg-sky-300 font-semibold' : 'hover:bg-sky-200' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17 21-5-4-5 4V3.889a.92.92 0 0 1 .244-.629.808.808 0 0 1 .59-.26h8.333a.81.81 0 0 1 .589.26.92.92 0 0 1 .244.63V21Z"/>
                        </svg>
                        <span>Categories</span>
                    </a>
                </li>

                <!-- PRODUCTS MENU -->
                    <li>

                        <button type="button"
                                class="flex items-center w-full gap-3 px-3 py-2 rounded-base
                                transition
                                {{ request()->is('admin/products-management*', 'admin/product-attributes*')
                                    ? 'bg-sky-300 font-semibold'
                                    : 'hover:bg-sky-200' }}"
                                aria-controls="dropdown-products"
                                data-collapse-toggle="dropdown-products">

                            {{-- ICON --}}
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg>

                            {{-- LABEL --}}
                            <span class="flex-1 text-left whitespace-nowrap">
                                Products
                            </span>

                            {{-- ARROW --}}
                            <svg class="w-4 h-4 transition-transform duration-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- SUB MENU --}}
                        <ul id="dropdown-products"
                            class="hidden py-1 space-y-1">

                            {{-- PRODUCTS MANAGEMENT --}}
                            <li>
                                <a href="{{ route('admin.products-management.index') }}"
                                    class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                    {{ request()->is('admin/products-management*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Products Management
                                </a>
                            </li>

                            {{-- PRODUCT ATTRIBUTES --}}
                            <li>
                                <a href="{{ route('admin.product-attributes.index') }}"
                                    class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                    {{ request()->is('admin/product-attributes*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Product Attributes
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- STOCK MENU -->
                    <li>

                        <button type="button"
                                class="flex items-center w-full gap-3 px-3 py-2 rounded-base
                                transition
                                {{ request()->is('admin/stock-transactions*', 'admin/stock-transactions*')
                                    ? 'bg-sky-300 font-semibold'
                                    : 'hover:bg-sky-200' }}"
                                aria-controls="dropdown-stocks"
                                data-collapse-toggle="dropdown-stocks">

                            {{-- ICON --}}
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg>

                            {{-- LABEL --}}
                            <span class="flex-1 text-left whitespace-nowrap">
                                Stocks
                            </span>

                            {{-- ARROW --}}
                            <svg class="w-4 h-4 transition-transform duration-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- SUB MENU --}}
                        <ul id="dropdown-stocks"
                            class="hidden py-1 space-y-1">

                            
                            {{-- STOCK REQUEST --}}
                            <li>
                                <a href="{{ route('admin.stock-transactions.request') }}"
                                class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                {{ request()->is('admin/stock-transactions*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Stock Request
                                </a>
                            </li>

                            {{-- STOCK TRANSACTION --}}
                            <li>
                                <a href="{{ route('admin.stock-transactions.index') }}"
                                    class="flex items-center ps-11 pe-3 py-2 rounded-base text-sm
                                    {{ request()->is('admin/stock-transactions*')
                                        ? 'bg-sky-300 font-semibold'
                                        : 'hover:bg-sky-200' }}">
                                    Stock Management
                                </a>
                            </li>

                        </ul>
                    </li>

                    

                <li class="py-2">
                    <div class="border-t border-sky-300"></div>
                </li>
            </ul>
        </div>
    </aside>
