@extends('layouts.app')

@section('title','Stocks Management')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-black">Stock Management</h1>
        <p class="text-sm text-gray-600">All stock transactions history</p>
    </div>

    {{-- TABLE --}}
    <div class="relative overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">

        <table id="stocksTable" class="w-full text-sm text-left text-black border-collapse table-crud">

            <thead class="bg-blue-600 text-white border-b border-blue-700">
                <tr class="uppercase tracking-wide text-xs font-semibold">
                    <th class="px-5 py-4 text-center">No</th>
                    <th class="px-5 py-4">Product</th>
                    <th class="px-5 py-4">Type</th>
                    <th class="px-5 py-4">Qty</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">User</th>
                    <th class="px-5 py-4">Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $t)
                <tr class="border-b hover:bg-gray-100 transition">

                    <td class="px-5 py-3 text-center"></td>
                    <td class="px-5 py-3">{{ $t->product->name }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $t->type === 'IN' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $t->type }}
                        </span>
                    </td>
                    <td class="px-5 py-3">{{ $t->quantity }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $t->status === 'PENDING' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $t->status === 'RECEIVED' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $t->status === 'ISSUED' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $t->status === 'REJECTED' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3">{{ $t->user->name }}</td>
                    <td class="px-5 py-3">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

{{-- DATATABLE --}}
<x-datatable-init
    id="stocksTable"
    :columnDefs="[
        ['orderable'=>false,'targets'=>[0]]
    ]"
/>

@endsection
