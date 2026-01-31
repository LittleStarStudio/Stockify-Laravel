<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Stockify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 to-sky-100 py-10">

<div class="w-full max-w-md mx-4">
    <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-sky-400 to-sky-500 px-8 py-6 text-center">
            <h1 class="text-2xl font-bold text-white">Create Your Stockify Account</h1>
            <p class="text-sky-100 text-sm mt-1">
                Your account will be verified by the admin
            </p>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-5">

            {{-- Session status --}}
            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-100 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="text-sm text-red-700 bg-red-100 p-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Create your password"
                        required
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500"
                    >
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Repeat your password"
                        required
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500"
                    >
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-3 text-sm font-semibold text-white bg-sky-500 rounded-lg hover:bg-sky-600 focus:ring-4 focus:ring-sky-300 transition">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:underline">
                    Log in
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
