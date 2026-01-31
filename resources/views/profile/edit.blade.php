@extends('layouts.app')

@section('title','Profile Settings')

@section('content')

<form id="profileForm"
      action="{{ route('profile.update') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PATCH')

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Profile Settings
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Manage your profile
            </p>
        </div>

        <!-- MAIN GRID -->
         
        <div class="relative bg-white border border-gray-200 rounded-lg shadow-md p-5">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- LEFT : AVATAR PREVIEW -->
                <div class="flex flex-col items-center gap-4">

                    <img id="logoPreview"
                        src="{{ auth()->user()->avatar_url }}"
                        class="w-24 h-24 object-contain mt-1 transition">

                    <!-- AVATAR UPLOAD -->
                    <div>

                        <label class="flex items-center gap-3 px-3 py-2
                                    border rounded-lg cursor-pointer hover:bg-blue-100">

                            <span class="px-3 py-1 bg-gray-100 rounded text-sm">
                                Choose File
                            </span>

                            <span id="edit-avatar-filename"
                                class="text-sm text-gray-500">
                                No file chosen
                            </span>

                            <input id="edit-avatar"
                                type="file"
                                name="avatar"
                                class="hidden">
                        </label>

                        <p class="text-center text-xs text-gray-400 mt-1">
                            JPG / PNG max 2MB
                        </p>
                    </div>
                </div>

                <!-- RIGHT : FORM -->
                <div class="md:col-span-2 space-y-6">

                    

                    <!-- NAME -->
                    <div>
                        <label class="block text-sm mb-1">Name</label>
                        <input type="text"
                            name="name"
                            value="{{ auth()->user()->name }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm mb-1">Email</label>
                        <input type="email"
                            name="email"
                            value="{{ auth()->user()->email }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-sm mb-1">Password</label>

                        <div class="relative">
                            <input type="password"
                                id="passwordInput"
                                name="password"
                                class="w-full border rounded px-3 py-2"
                                placeholder="Leave blank to keep current">

                            <button type="button"
                                    id="togglePassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2">

                                <!-- OPEN -->
                                <svg id="eyeOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                </svg>

                                <!-- CLOSED -->
                                <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M3 3l18 18M1.5 12S5 5 12 5M22.5 12S19 19 12 19"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('dashboard') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 border rounded">
                    Cancel
                </a>

                <button id="btnSave"
                        type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Update Profile
                </button>
            </div>

        </div>

    </div>
</form>
@endsection

@push('scripts')
    @vite('resources/js/admin/profile.js')
@endpush
