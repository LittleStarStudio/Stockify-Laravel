<!-- ================= NAVBAR ================= -->
<nav class="fixed top-0 z-50 w-full border-b shadow-sm h-14 bg-sky-400 border-sky-500">
    <div class="flex items-center justify-between h-full max-w-screen-xl px-4 mx-auto">

        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3">
            <img src="#" class="h-7" alt="Logo">
            <span class="text-xl font-semibold text-white">Stockify</span>
        </a>

        <!-- Search -->
        <form class="flex-1 hidden max-w-xl mx-6 md:block">
            <div class="relative">

                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-sky-500" viewBox="0 0 24 24" fill="none">
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>

                <input
                    type="search"
                    placeholder="Search"
                    class="block w-full h-10 text-sm bg-white border rounded-base ps-9 pe-24 border-sky-300 focus:ring-sky-500 focus:border-sky-500"
                >

                <button
                    type="submit"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2
                           h-7 px-3 text-xs font-medium text-white
                           bg-sky-500 rounded hover:bg-sky-600"
                >
                    Search
                </button>

            </div>
        </form>

        <!-- Right Menu -->
        <div class="flex items-center gap-3">

            <!-- Inbox -->
            <a
                href="/inbox"
                class="relative flex items-center justify-center w-10 h-10 rounded-base hover:bg-sky-300/40 focus:ring-4 focus:ring-sky-300"
            >
                <svg class="text-white w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 13h3.439a.991.991 0 0 1 .908.6
                           3.978 3.978 0 0 0 7.306 0
                           .99.99 0 0 1 .908-.6H20
                           M4 13v6a1 1 0 0 0 1 1h14
                           a1 1 0 0 0 1-1v-6
                           M4 13l2-9h12l2 9"
                    />
                </svg>

                <span
                    class="absolute top-1 right-1 inline-flex items-center justify-center
                           w-4 h-4 text-[10px] font-bold
                           text-white bg-red-500 rounded-full"
                >
                    3
                </span>
            </a>

            <!-- User Dropdown -->
            <div class="relative">
                <button
                    data-dropdown-toggle="user-dropdown"
                    class="flex text-sm rounded-full focus:ring-4 focus:ring-sky-300"
                >
                    <img
                        src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                        alt="user"
                        class="w-8 h-8 rounded-full"
                    >
                </button>

                <div
                    id="user-dropdown"
                    class="z-50 hidden my-4 text-base list-none divide-y rounded-lg shadow bg-sky-50 divide-sky-200"
                >
                    <ul class="py-2">

                        <li>
                            <a href="/profile" class="flex items-center gap-3 px-4 py-2 hover:bg-sky-200">
                                Profile
                            </a>
                        </li>

                        <li>
                            <a href="/settings" class="flex items-center gap-3 px-4 py-2 hover:bg-sky-200">
                                Settings
                            </a>
                        </li>

                        <li class="py-2">
                            <div class="border-t border-sky-300"></div>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button
                data-drawer-toggle="top-bar-sidebar"
                class="flex items-center justify-center w-10 h-10 rounded-base sm:hidden"
            >
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M5 7h14M5 12h14M5 17h14"/>
                </svg>
            </button>

        </div>
    </div>
</nav>
