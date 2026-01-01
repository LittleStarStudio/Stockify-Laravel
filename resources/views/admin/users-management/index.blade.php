@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

    <div class="space-y-6">

        <!-- ================= HEADER ================= -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-black">
                    User Management
                </h1>
            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="p-4 text-sm text-green-800 bg-green-100 border border-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

                <div>

                    <!-- ADD USER BUTTON -->
                    <a href="{{ route('admin.users-management.store') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                            <svg class="w-5 h-5"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h14m-7 7V5"/>
                            </svg>

                            <span>Add User</span>
                    </a>

                    <!-- TRASH BIN -->
                    <a href="{{ route('admin.users-management.store') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">

                            <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>

                            <span>Bin</span>
                    </a>

                </div>
        </div>

        <!-- ================= USERS TABLE ================= -->
        <div class="relative overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">
            <table class="w-full text-sm text-left text-black border-collapse">

                <!-- TABLE HEAD -->
                <thead class="font-semibold bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-5 py-4 border-r border-gray-300">No.</th>
                        <th class="px-5 py-4 border-r border-gray-300">Name</th>
                        <th class="px-5 py-4 border-r border-gray-300">Email</th>
                        <th class="px-5 py-4 border-r border-gray-300">Role</th>
                        <th class="px-5 py-4 border-r border-gray-300">Status</th>
                        <th class="px-5 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <!-- TABLE BODY -->
                <tbody>
                    @foreach ($users as $user)

                    <tr class="bg-white border-b border-gray-300 hover:bg-gray-100">

                        {{-- No --}}
                        <td class="px-5 py-4 font-medium border-r border-gray-300">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Name --}}
                        <td class="px-5 py-4 font-medium border-r border-gray-300">
                            {{ $user->name }}
                        </td>

                        {{-- Email --}}
                        <td class="px-5 py-4 border-r border-gray-300">
                            {{ $user->email }}
                        </td>

                        {{-- Role --}}
                        <td class="px-5 py-4 border-r border-gray-300">
                            @if ($user->role === 'admin')
                                Admin
                            @elseif ($user->role === 'manajer_gudang')
                                Manager Gudang
                            @else
                                Staff Gudang
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 border-r border-gray-300">
                            @if($user->trashed())
                                <span class="px-3 py-1 text-xs font-medium text-gray-800 bg-gray-200 rounded-full">
                                    Deleted
                                </span>
                            @elseif($user->isActive())
                                <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                    Active
                                </span>
                            @elseif($user->isPending())
                                <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                    Pending
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-4 space-x-2 text-center">
                            @if($user->trashed())
                                <form action="{{ route('admin.users-management.restore', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1 text-xs text-white bg-gray-600 rounded">Restore</button>
                                </form>

                            @else
                                <a href="{{ route('admin.users-management.update', $user->id) }}" class="px-3 py-1 text-xs text-white bg-blue-600 rounded">Edit</a>

                                <form action="{{ route('admin.users-management.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 text-xs text-white bg-red-600 rounded">Delete</button>
                                </form>
                            @endif
                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

</div>

@endsection
