@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-semibold text-black">
                User Management
            </h1>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            @if (!$isTrash)

                <!-- Add User -->
                <button
                    type="button"
                    data-modal-target="createUserModal"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    Add User
                </button>

                <!-- Bin -->
                <button
                    type="button"
                    id="btn-open-bin"
                    class="px-4 py-2 bg-gray-600 text-white rounded">

                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg>

                    Bin
                </button>


            @else

                <!-- Back -->
                <a href="{{ route('admin.users-management.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700">

                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                              d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                    Back
                </a>

            @endif
        </div>
    </div>

    <!-- ================= USERS TABLE ================= -->
    <div class="relative bg-white border border-gray-300 rounded-lg shadow-md">

        <div class="overflow-x-auto">
            <table id="usersManagementTable"
                class="w-full text-sm text-left text-black border-collapse table-crud">

                <!-- Table Head -->
                <thead class="font-semibold bg-gray-100 border-b">
                    <tr>
                        <th class="px-5 py-4 text-center col-action">No</th>
                        <th class="px-5 py-4">User</th>
                        <th class="px-5 py-4">Email</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-center col-action">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-100">

                            <!-- No -->
                            <td class="px-5 py-4 text-center"></td>

                            <!-- Avatar & Name -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <img
                                        src="{{ $user->avatar_url }}"
                                        alt="Avatar"
                                        class="w-6 h-6 rounded-full object-cover border">

                                    <span class="font-medium">
                                        {{ $user->name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-5 py-4">
                                {{ $user->email }}
                            </td>

                            <!-- Role -->
                            <td class="px-5 py-4 capitalize">
                                {{ str_replace('_', ' ', $user->role) }}
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4">
                                @if ($user->isDeleted())
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                        Deleted
                                    </span>
                                @elseif ($user->isActive())
                                    <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                        Active
                                    </span>
                                @elseif ($user->isPending())
                                    <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                        Rejected
                                    </span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="px-2 py-3 text-center col-action">

                                @if($user->trashed())

                                    <!-- RESTORE ONLY -->
                                    <form method="POST"
                                        action="{{ route('admin.users-management.restore', $user->id) }}"
                                        class="inline">
                                        @csrf
                                        <button
                                            type="button"
                                            class="btn-confirm flex items-center gap-2 px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded"
                                            data-title="Restore user?"
                                            data-text="User will be restored"
                                            data-confirm="Yes, Restore"
                                            data-color="#2563eb">
                                            Restore
                                        </button>
                                    </form>

                                @else

                                    <!-- DROPDOWN -->
                                    <div class="relative inline-block text-left">

                                        <!-- TOGGLE -->
                                        <button
                                            type="button"
                                            class="action-toggle inline-flex items-center gap-1 px-3 py-1 text-sm font-medium text-gray-700 border rounded hover:bg-gray-100">
                                            Actions

                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="m6 9 6 6 6-6"/>
                                            </svg>
                                            
                                        </button>

                                        <!-- MENU -->
                                        <div
                                            class="action-menu hidden absolute right-0 top-full mt-2
                                                w-44 bg-white border rounded-lg shadow-lg z-50">


                                            <!-- Data Modal Payload -->
                                            @php
                                            
                                                $viewUserPayload = [
                                                    "id" => $user->id,
                                                    "name" => $user->name,
                                                    "email" => $user->email,
                                                    "role" => ucfirst(str_replace('_', ' ', $user->role)),
                                                    "approval_status" => ucfirst($user->approval_status),
                                                    "avatar_url" => $user->avatar_url,
                                                    "created_at" => $user->created_at->format('d M Y H:i'),
                                                    "updated_at" => $user->updated_at->format('d M Y H:i'),
                                                ];

                                                $editUserPayload = [
                                                    "id" => $user->id,
                                                    "name" => $user->name,
                                                    "email" => $user->email,
                                                    "role" => $user->role,
                                                    "approval_status" => $user->approval_status,
                                                    "avatar_url" => $user->avatar_url,
                                                ];
                                                
                                            @endphp


                                            <!-- VIEW -->
                                            <button
                                                type="button"
                                                data-action="view"
                                                data-user='@json($viewUserPayload)'
                                                data-modal-target="viewUserModal"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50">

                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6
                                                        c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M15 12a3 3 0 1 1-6 0"/>
                                                </svg>

                                                View
                                            </button>

                                            <!-- EDIT -->
                                            <button
                                                type="button"
                                                data-action="edit"
                                                data-user='@json($editUserPayload)'
                                                data-modal-target="editUserModal"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50">

                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="m14.304 4.844 2.852 2.852
                                                        M7 7H4v10h11v-4.5
                                                        m2.409-9.91a2.017 2.017 0 0 1 0 2.853"/>
                                                </svg>

                                                Edit
                                            </button>

                                            <!-- DELETE -->
                                            <form method="POST"
                                                action="{{ route('admin.users-management.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    class="btn-confirm flex w-full items-center gap-2 px-4 py-2
                                                        text-sm text-red-600 hover:bg-red-50"
                                                    data-title="Delete user?"
                                                    data-text="User will be moved to Bin"
                                                    data-confirm="Yes, Delete"
                                                    data-color="#dc2626">

                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8
                                                            M10 3h4a1 1 0 0 1 1 1v3H9V4
                                                            a1 1 0 0 1 1-1Z"/>
                                                    </svg>

                                                    Delete
                                                </button>
                                            </form>
                                        </div>

                                    </div>


                                @endif


                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6"
                                class="px-6 py-8 text-center text-gray-500 italic">
                                {{ $isTrash ? 'No deleted users found.' : 'No users found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- ================= OPEN EDIT MODAL IF VALIDATION ERROR ================= -->
@if (session('open_edit_modal'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("editUserModal");
            if (modal) {
                // buka modal pakai util JS yang sudah ada
                const box = modal.querySelector(".modal-box");

                modal.classList.remove(
                    "opacity-0",
                    "pointer-events-none",
                    "bg-opacity-0"
                );
                modal.classList.add(
                    "opacity-100",
                    "bg-opacity-50"
                );

                requestAnimationFrame(() => {
                    box.classList.remove("-translate-y-6", "opacity-0");
                    box.classList.add("translate-y-0", "opacity-100");
                });
            }
        });
    </script>
@endif


<!-- ================= DATATABLES ================= -->
<x-datatable-init
    id="usersManagementTable"
    :columnDefs="[
        ['orderable' => false, 'targets' => [0, 5]]
    ]"
/>

<!-- ================= MODALS ================= -->
@include('admin.users-management.partials.modal-create')
@include('admin.users-management.partials.modal-edit')
@include('admin.users-management.partials.modal-view')
@include('admin.users-management.partials.modal-bin')

@endsection