@extends('layouts.app')

@section('title','User Report')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">User Report</h1>
            <p class="text-sm text-gray-600">Export system users data</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border grid grid-cols-4 gap-4 shadow-md items-end">

        <div>
            <label class="text-sm text-gray-600">Role</label>
            <select id="role" class="border rounded px-2 py-1 w-full">
                <option value="">All</option>
                <option value="admin">Admin</option>
                <option value="manajer_gudang">Manager</option>
                <option value="staff_gudang">Staff</option>
            </select>
        </div>

        <div class="col-span-2"></div>

        <div>
            <button id="btnExportUsers"
                class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Export Excel
            </button>
        </div>
    </div>

    <!-- INFO -->
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
        <p class="text-sm font-bold underline">This report contains:</p>
        <p class="text-sm">
            Name, Email, Role, Approval Status, and Registration Date.
        </p>
        <p class="text-sm mt-1.5">Data will be exported in Excel format.</p>
    </div>

</div>
@endsection

@if(session('error'))
<script>
Swal.fire('Oops','{{ session('error') }}','warning');
</script>
@endif

@push('scripts')
    @vite('resources/js/admin/users-report.js')
@endpush
