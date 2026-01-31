@extends('layouts.app')

@section('title','Stock Inputs')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow-lg border">

    <h1 class="text-xl font-semibold mb-4">Stock Inputs</h1>

    <form id="stockInputForm" action="{{ route('admin.stock-inputs.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- PRODUCT --}}
        <div>
            <label class="block text-sm font-medium mb-1">Product</label>
            <select name="product_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Select Product --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>

            <div id="stockInfo"
                class="hidden text-sm text-gray-600 mt-1">
                Current stock:
                <b id="currentStock" class="font-semibold">0</b>
                |
                Minimum:
                <b id="minStock" class="text-black">0</b>
            </div>
        </div>

        {{-- TYPE --}}
        <div>
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="type" id="typeSelect" class="w-full border rounded px-3 py-2">
                
                <p id="outDisabledMsg" class="hidden text-xs text-red-600 mt-1">
                    Outgoing is disabled because stock is empty.
                </p>
                
                <option value="IN">IN (Incoming Stock)</option>
                <option value="OUT">OUT (Outgoing Stock)</option>
            </select>
        </div>

        {{-- QTY --}}
        <div>
            <label class="block text-sm font-medium mb-1">Quantity</label>
            <input type="number" name="quantity" id="qtyInput" class="w-full border rounded px-3 py-2">
        </div>

        {{-- NOTES --}}
        <div>
            <label class="block text-sm font-medium mb-1">Notes</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Submit Request
        </button>

    </form>

</div>

@endsection

@push('scripts')
    @vite('resources/js/admin/stock-inputs.js')
@endpush
