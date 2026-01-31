@extends('layouts.app')

@section('title','Product Report')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Product Report</h1>
            <p class="text-sm text-gray-600">Export all products data</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border grid grid-cols-4 gap-4 shadow-md items-end">

        <div>
            <label class="text-sm text-gray-600">Status</label>
            <select id="status" class="border rounded px-2 py-1 w-full">
                <option value="">All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="col-span-2"></div>

        <div>
            <button id="btnExportProducts"
                class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Export Excel
            </button>
        </div>
    </div>

    <!-- INFO -->
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
        <p class="text-sm font-bold underline">This report contains:</p>
        <p class="text-sm mt-1">
            SKU, Name, Category, Supplier, Purchase Price, Selling Price, Current Stock,Minimum Stock, Status and Created Date.
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
    @vite('resources/js/admin/products-report.js')
@endpush
