@extends('layouts.app')

@section('title', 'Supplier Management')

@section('content')



<!-- Flag Role -->
@php

    $role = auth()->user()->role;
    $isAdmin = $role === 'admin';

@endphp


<div class="space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Suppliers Management
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Manage your suppliers and vendors
            </p>
        </div>

        @if ($isAdmin)

            <!-- Action Buttons -->
            <div class="flex gap-2">

                <!-- ADD SUPPLIER -->
                <button
                    type="button"
                    id="btnAddSupplier"
                    class="inline-flex items-center gap-2 px-4 py-2
                            text-sm font-medium text-white
                            bg-blue-600 rounded-md
                            hover:bg-blue-700
                            focus:outline-none focus:ring-2 focus:ring-blue-400
                            active:scale-[0.98]
                            transition">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                            d="M5 12h14m-7 7V5"/>
                    </svg>

                    Add Supplier
                </button>

                <!-- BIN SUPPLIER -->
                <button
                    type="button"
                    id="btn-open-bin-supplier"
                    class="inline-flex items-center gap-2 px-4 py-2
                        text-sm font-medium text-white
                        bg-gray-600 rounded-md
                        hover:bg-gray-700 transition">

                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg>

                    Bin
                </button>

            </div>
        
        @endif

    </div>

    <!-- ================= SUPPLIERS TABLE ================= -->
    <div class="relative bg-white border border-gray-200 rounded-lg shadow-sm">

        <div class="overflow-x-auto">
            <table id="suppliersManagementTable"
                   class="w-full text-sm text-left text-gray-700 border-collapse table-crud">

                <!-- Table Head -->
                <thead class="bg-blue-600 text-white border-b border-blue-700">
                    <tr class="uppercase tracking-wide text-xs font-semibold">
                        <th class="px-5 py-4 text-center text-xs font-semibold text-white text-center col-action">No</th>
                        <th class="px-5 py-4 text-xs font-semibold text-white">Name</th>
                        <th class="px-5 py-4 text-xs font-semibold text-white">Address</th>
                        <th class="px-5 py-4 text-xs font-semibold text-white">Phone</th>
                        <th class="px-5 py-4 text-xs font-semibold text-white">Email</th>
                        <th class="px-5 py-4 text-xs font-semibold text-white text-center col-action">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr class="border-b hover:bg-gray-100 transition">

                            <!-- No -->
                            <td class="px-5 py-4 font-medium text-gray-900 text-center"></td>

                            <!-- Name -->
                            <td class="px-5 py-4 font-medium text-gray-900">
                                {{ $supplier->name }}
                            </td>

                            <!-- Address -->
                            <td class="px-5 py-4">
                                {{ $supplier->address ?? '-' }}
                            </td>

                            <!-- Phone -->
                            <td class="px-5 py-4">
                                {{ $supplier->phone ?? '-' }}
                            </td>

                            <!-- Email -->
                            <td class="px-5 py-4">
                                {{ $supplier->email ?? '-' }}
                            </td>

                            <!-- Action -->
                                <td class="px-5 py-4 text-center">
                                    <div class="relative inline-block text-left">

                                        <!-- TOGGLE -->
                                        <button
                                            type="button"
                                            class="action-toggle inline-flex items-center gap-1
                                                px-3 py-1.5 text-xs
                                                bg-gray-100 text-gray-700
                                                rounded hover:bg-gray-200">
                                            Actions
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6"/>
                                            </svg>
                                        </button>

                                        <!-- MENU -->
                                        <div class="action-menu hidden absolute right-0 top-full mt-2
                                                    w-44 bg-white border rounded-lg shadow-lg z-50">


                                            <!-- DATA MODAL PAYLOAD -->
                                            @php
                                                $viewSupplierPayload = [
                                                    "id" => $supplier->id,
                                                    "name" => $supplier->name,
                                                    "email" => $supplier->email,
                                                    "phone" => $supplier->phone,
                                                    "address" => $supplier->address,
                                                    "created_at" => $supplier->created_at?->format('d M Y H:i'),
                                                    "updated_at" => $supplier->updated_at?->format('d M Y H:i'),
                                                ];
                                            @endphp

                                            @if (!$isAdmin)
                                            <!-- SELAIN ADMIN HANYA VIEW -->
                                            <button
                                                type="button"
                                                data-action="view"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50"
                                                data-supplier='@json($viewSupplierPayload)'>

                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6
                                                            c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="M15 12a3 3 0 1 1-6 0"/>
                                                </svg>

                                                View
                                            </button>
                                            
                                            @endif

                                            @if ($isAdmin)

                                            <!-- JIKA ADMIN SEMUA CRUD -->
                                            <button
                                                type="button"
                                                data-action="view"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50"
                                                data-supplier='@json($viewSupplierPayload)'>

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
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50"
                                                data-supplier='@json($supplier)'>

                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="m14.304 4.844 2.852 2.852
                                                            M7 7H4v10h11v-4.5
                                                            m2.409-9.91a2.017 2.017 0 0 1 0 2.853"/>
                                                </svg>

                                                Edit
                                            </button>

                                            <!-- DELETE -->
                                            <form action="{{ route('admin.suppliers-management.destroy', $supplier->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    class="btn-confirm flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                                    data-title="Delete supplier?"
                                                    data-text="Supplier will be moved to Bin"
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
                                            
                                            @endif

                                        </div>
                                    </div>
                                </td>
                            
                        </tr>
                    
                    @endforeach
                    
                </tbody>


            </table>
        </div>

    </div>

</div>

<!-- ================= DATATABLES ================= -->
<x-datatable-init
    id="suppliersManagementTable"
    :columnDefs="[
        ['orderable' => false, 'targets' => [0, 5]]
    ]"
/>

<!-- ================= MODALS ================= -->
@include('admin.suppliers-management.partials.modal-view')
@include('admin.suppliers-management.partials.modal-create')
@include('admin.suppliers-management.partials.modal-edit')
@include('admin.suppliers-management.partials.modal-bin')

@endsection

@push('scripts')
    @vite('resources/js/admin/suppliers-management.js')
@endpush
