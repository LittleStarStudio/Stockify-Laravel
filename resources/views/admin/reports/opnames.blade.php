@extends('layouts.app')

@section('title','Stock Opname Report')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Stock Opname Report</h1>
            <p class="text-sm text-gray-600">Export stock audit data</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border grid grid-cols-4 gap-4 shadow-md items-end">

        <div>
            <label class="text-sm text-gray-600">Status</label>
            <select id="status" class="border rounded px-2 py-1 w-full">
                <option value="">All</option>
                <option value="APPROVED">Approved</option>
                <option value="REJECTED">Rejected</option>
                <option value="SUBMITTED">Submitted</option>
            </select>
        </div>

        <div class="col-span-2"></div>

        <div>
            <button id="btnExportOpnames"
                class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Export Excel
            </button>
        </div>
    </div>

    <!-- INFO -->
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
        <p class="text-sm font-bold underline">This report contains:</p>
        <p class="text-sm mt-1">
             Opname Date, SKU, Product, System Stock, Physical Stock, Difference, Staff, Manager, Status and Notes.
        </p>
        <P class="text-sm mt-1.5">File will be downloaded in Excel format.</P>
    </div>

</div>
@endsection

{{-- SweetAlert error from backend --}}
@if(session('error'))
<script>
Swal.fire('Oops','{{ session('error') }}','warning');
</script>
@endif

@push('scripts')
    @vite('resources/js/admin/opnames-report.js')
@endpush
