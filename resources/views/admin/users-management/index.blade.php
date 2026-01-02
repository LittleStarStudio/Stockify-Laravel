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

        <div class="flex gap-2">

            <!-- ADD USER BUTTON -->
            <button
                type="button"
                data-modal-target="createUserModal"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">

                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M5 12h14m-7 7V5"/>
                </svg>
                Add User
            </button>

            <!-- TRASH BIN -->
            <a href="{{ route('admin.users-management.index', ['trash' => 1]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700">

                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg> 
                
                Bin
            </a>
        </div>
    </div>

    <!-- ================= USERS TABLE ================= -->
    <div class="relative overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">
        <table class="w-full text-sm text-left text-black">

            <thead class="font-semibold bg-gray-100 border-b">
                <tr>
                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4">Name</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Role</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-gray-100">

                        <td class="px-5 py-4">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-5 py-4">{{ $user->email }}</td>

                        <td class="px-5 py-4">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </td>

                        <td class="px-5 py-4">
                            @if($user->trashed())
                                <span class="badge-gray">Deleted</span>
                            @elseif($user->isActive())
                                <span class="badge-green">Active</span>
                            @elseif($user->isPending())
                                <span class="badge-yellow">Pending</span>
                            @else
                                <span class="badge-red">Rejected</span>
                            @endif
                        </td>

                        <td class="px-2 py-3 space-x-2 text-center">

                            @if($user->trashed())

                                <form method="POST"
                                    action="{{ route('admin.users-management.restore', $user->id) }}"
                                    class="inline">
                                    @csrf
                                    <button class="px-3 py-1 text-xs text-white bg-gray-600 rounded">
                                        Restore
                                    </button>
                                </form>

                            @else

                                <!-- EDIT (MODAL) -->
                                <button
                                    type="button"
                                    data-user='@json($user)'
                                    class="btn-edit px-3 py-1 text-xs text-white bg-blue-600 rounded">
                                    Edit
                                </button>


                                <!-- DELETE -->
                                <form method="POST"
                                    action="{{ route('admin.users-management.destroy', $user->id) }}"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        class="btn-confirm px-3 py-1 text-xs text-white bg-red-600 rounded"
                                        data-title="Delete user ?"
                                        data-text="User will be moved to Bin"
                                        data-icon="warning"
                                        data-confirm="Yes, Delete"
                                        data-color="#dc2626">
                                        Delete
                                    </button>
                                </form>
                                
                            @endif

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-6 text-center text-gray-500">
                            No users data
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>


<!-- ================= MODAL CREATE USER ================= -->
@include('admin.users-management.partials.modal-create')

<!-- ================= MODAL EDIT USER ================= -->
@include('admin.users-management.partials.modal-edit')


<!-- ================= JS SCRIPTS ================= -->
@push('scripts')
<script src="{{ asset('js/admin/users-management.js') }}"></script>
@endpush


@endsection
