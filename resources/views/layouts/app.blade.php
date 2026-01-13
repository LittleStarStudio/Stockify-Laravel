<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-neutral-primary-soft min-h-screen">

    {{-- Navbar & Sidebar  Start--}}
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')
    {{-- Navbar & Sidebar  End--}}

    <!-- Wrapper Content + Footer -->
    <div class="flex min-h-screen">

        <!-- Offset Area (kanan sidebar) -->
        <div class="flex flex-col flex-1 ml-0 sm:ml-64">

            {{-- Main Content Start --}}
            <main class="flex-1 mt-14 px-6 py-6">
                @yield('content')
            </main>
            {{-- Main Content End --}}

            
            {{-- Footer Start--}}
                @include('layouts.partials.footer')
            {{-- Footer End--}}

        </div>

    </div>



    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    
    {{-- Flash Alert Global --}}
    <x-flash-alert />

    @stack('scripts')

</body>
</html>
