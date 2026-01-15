@extends('layouts.app')

@section('title', 'Users Request')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">
                Users Request
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Manage your users request
            </p>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="relative overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">

        <table id="usersRequestTable" class="w-full text-sm text-left text-black border-collapse table-crud">

            {{-- Table Head --}}
            <thead class="bg-blue-600 text-white border-b border-blue-700">

                <tr class="uppercase tracking-wide text-xs font-semibold">
                    <th class="px-5 py-4 text-xs font-semibold text-white text-center col-action">No</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white">Name</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white">Email</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white">Role</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white text-center col-action">Action</th>
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-100 transition">

                        {{-- No --}}
                        <td class="px-6 py-4 font-medium text-gray-900 text-center"></td>

                        {{-- Name --}}
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $user->name }}
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>

                        {{-- Role --}}
                        <td class="px-6 py-4 capitalize">
                            {{ str_replace('_', ' ', $user->role) }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if ($user->approval_status === 'active')
                                <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                    Active
                                </span>
                            @elseif ($user->approval_status === 'pending')
                                <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                    Pending
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td class="px-5 py-4 space-x-2 text-center col-action">
                            @if ($user->approval_status === 'pending')

                                {{-- Approve --}}
                                <form action="{{ route('admin.user-requests.approve', $user->id) }}"
                                      method="POST"
                                      class="inline-block">
                                    @csrf
                                    <button
                                        type="button"
                                        class="btn-request-confirm inline-flex items-center px-2 py-1.5 text-xs font-semibold
                                               text-white bg-green-600 rounded hover:bg-green-700
                                               focus:outline-none focus:ring-2 focus:ring-green-300"
                                        data-title="Approve User ?"
                                        data-text="This user will be immediately active"
                                        data-icon="question"
                                        data-confirm="Yes, Approve It"
                                        data-color="#16a34a">
                                        Approve
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ route('admin.user-requests.reject', $user->id) }}"
                                      method="POST"
                                      class="inline-block">
                                    @csrf
                                    <button
                                        type="button"
                                        class="btn-request-confirm inline-flex items-center px-2 py-1.5 text-xs font-semibold
                                               text-white bg-red-600 rounded hover:bg-red-700
                                               focus:outline-none focus:ring-2 focus:ring-red-300"
                                        data-title="Reject User ?"
                                        data-text="This user will be rejected"
                                        data-icon="warning"
                                        data-confirm="Yes, Reject It"
                                        data-color="#dc2626">
                                        Reject
                                    </button>
                                </form>

                            @else
                                <span class="text-xs italic text-gray-400">No action</span>
                            @endif
                            
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>
    </div>
</div>

{{-- DataTables --}}
<x-datatable-init
    id="usersRequestTable"
    :columnDefs="[
        ['orderable' => false, 'targets' => [0, 5]]
    ]"
/>

@endsection
