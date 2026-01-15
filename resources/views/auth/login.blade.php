<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stockify</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 to-sky-100">

    <!-- ================= LOGIN CARD ================= -->
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-400 to-sky-500 px-8 py-6 text-center">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                  d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white">Stockify</h1>
                <p class="text-sky-100 text-sm mt-1">Sistem Manajemen Stok</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="p-8 space-y-5">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error dari middleware approval -->
                @if (session('error'))
                    <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Title -->
                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 mt-1">Silakan login ke akun Anda</p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="w-4 h-4 text-sky-600 bg-gray-50 border-gray-300 rounded focus:ring-2 focus:ring-sky-500 cursor-pointer">
                        <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full px-5 py-3 text-sm font-semibold text-white bg-sky-500 rounded-lg hover:bg-sky-600 focus:ring-4 focus:ring-sky-300 transition-colors shadow-sm">
                    Masuk ke Akun
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 text-gray-500 bg-white">atau</span>
                    </div>
                </div>

                <!-- Register -->
                <p class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:text-sky-700 hover:underline transition-colors">
                        Daftar Sekarang
                    </a>
                </p>

            </form>

            <!-- Footer -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} Stockify. All rights reserved.
                </p>
            </div>

        </div>
    </div>

</body>
</html>
