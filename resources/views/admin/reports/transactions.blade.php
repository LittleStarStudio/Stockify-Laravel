@extends('layouts.app')

@section('title','Stock Transaction Report')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Stock Transaction Report</h1>
            <p class="text-sm text-gray-600">Export stock in & out data</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border grid grid-cols-4 gap-4 shadow-md items-end">

        <div>
            <label class="text-sm text-gray-600">From Date</label>
            <input type="date" id="from"
                   class="border rounded px-2 py-1 w-full">
        </div>

        <div>
            <label class="text-sm text-gray-600">To Date</label>
            <input type="date" id="to"
                   class="border rounded px-2 py-1 w-full">
        </div>

        <div>
            <label class="text-sm text-gray-600">Type</label>
            <select id="type" class="border rounded px-2 py-1 w-full">
                <option value="">All</option>
                <option value="IN">IN</option>
                <option value="OUT">OUT</option>
            </select>
        </div>

        <div>
            <button id="btnExport"
                class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Export Excel
            </button>
        </div>
    </div>

    <!-- INFO -->
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
        <p class="text-sm font-bold underline">This report contains:</p>
        <p class="text-sm mt-1">
            Transaction Date, SKU, Product Name, Transaction Type (IN/OUT), Quantity, Status, Source, User, Approved By, System Stock, Physical Stock, and Notes. Default period is current month.
        </p>
        <p class="text-sm mt-1.5">Data will be exported in Excel format.</p>
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
    @vite('resources/js/admin/transactions-report.js')
@endpush
