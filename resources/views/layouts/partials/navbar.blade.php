<!-- ================= NAVBAR ================= -->
<nav class="fixed top-0 z-50 w-full border-b shadow-sm h-14 bg-sky-400 border-sky-500">
    <div class="flex items-center justify-between h-full max-w-screen-xl px-4 mx-auto">

        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3">
            
            @php
                $setting = \App\Models\AppSetting::find(1);
            @endphp

            <img src="{{ $setting->logo ? asset('storage/'.$setting->logo) : '/images/logo.png' }}"
                class="h-7">

            <span class="text-xl font-semibold text-white">
                {{ $setting->app_name }}
            </span>

        </a>

        <!-- Search -->
        <form action="{{ route('admin.global.search') }}" method="GET"
                class="flex-1 hidden max-w-xl mx-6 mt-3 md:block">


            <div class="relative">

                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-sky-500" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>

                <input
                    type="search"
                    name="q"
                    placeholder="Search..."
                    value="{{ request('q') }}"
                    class="block w-full h-10 text-sm bg-white border rounded-base ps-9 pe-24">

                <button type="submit"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2
                            h-7 px-3 text-xs font-medium text-white
                            bg-sky-500 rounded hover:bg-sky-600">
                    Search
                </button>

            </div>
        </form>

        <!-- Right Menu -->
        <div class="flex items-center gap-3">

            <!-- User Dropdown -->
            <div class="relative mr-8">
                <button
                    data-dropdown-toggle="user-dropdown"
                    class="flex text-sm rounded-full focus:ring-4 focus:ring-sky-300">
                    <img
                        src="{{ auth()->user()->avatar_url }}"
                        alt="user"
                        class="w-8 h-8 rounded-full object-cover border">
                </button>

                <div
                    id="user-dropdown"
                    class="z-50 hidden my-4 text-base list-none divide-y rounded-lg shadow bg-sky-50 divide-sky-200"
                >
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-sky-200">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-sky-200">
                                Settings
                            </a>
                        </li>

                        <li class="py-2">
                            <div class="border-t border-sky-300"></div>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-sky-200">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>
