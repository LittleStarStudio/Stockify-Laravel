@extends('layouts.app')

@section('title','Settings')

@section('content')

<form id="settingsForm"
      action="{{ route('admin.settings.update') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Application Settings
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Manage your application configuration
            </p>
        </div>

        <!-- MAIN GRID -->
        <div class="relative bg-white border border-gray-200 rounded-lg shadow-md p-5">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- LEFT : LOGO PREVIEW -->
                <div class="flex flex-col items-center gap-4">
                    <p class="text-center font-bold">App Logo</p>
                    <img id="logoPreview"
                        src="{{ $setting->logo ? asset('storage/'.$setting->logo) : '/images/logo.png' }}"
                        class="w-24 h-24 object-contain border rounded mt-1.5 mb-5 transition">

                    <!-- LOGO UPLOAD -->
                    @if (auth()->user()->role === 'admin')
                    
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

                                <input id="logoInput"
                                    type="file"
                                    name="logo"
                                    class="hidden">
                            </label>

                            <p class="text-center text-xs text-gray-400 mt-1">
                                JPG / PNG max 2MB
                            </p>
                        </div>

                    @endif
                </div>

                <!-- RIGHT : FORM -->
                <div class="md:col-span-2 space-y-6">

                    <!-- APP NAME -->
                    @if (auth()->user()->role !== 'admin')
                        
                        <div>
                            <label class="block text-sm mb-1">Application Name</label>
                            <input type="text"
                                name="app_name"
                                value="{{ $setting->app_name }}"
                                disabled
                                class="w-full border rounded px-3 py-2 bg-gray-100">
                        </div>

                    @else
                        
                        <div>
                            <label class="block text-sm mb-1">Application Name</label>
                            <input type="text"
                                name="app_name"
                                value="{{ $setting->app_name }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                    
                    @endif

                    <!-- LANGUAGE -->
                    <div>
                        <label class="block text-sm mb-1">Language</label>
                        <input type="text"
                            value="{{ $setting->language }}"
                            disabled
                            class="w-full border rounded px-3 py-2 bg-gray-100">
                    </div>

                    <!-- VERSION -->
                    <div>
                        <label class="block text-sm mb-1">Version</label>
                        <input type="text"
                            value="{{ $setting->version }}"
                            disabled
                            class="w-full border rounded px-3 py-2 bg-gray-100">
                    </div>

                </div>
            </div>

            <!-- ACTION -->
                <div class="flex justify-end gap-3 pt-4 mt-6">

                    <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 border rounded">
                        Back
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Save Settings
                        </button>
                    @endif
    
                </div>

        </div>

    </div>
</form>
@endsection

@push('scripts')
    @vite('resources/js/admin/settings.js')
@endpush
