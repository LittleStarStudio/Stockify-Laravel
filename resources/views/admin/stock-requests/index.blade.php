@extends('layouts.app')

@section('title', 'Stock Request')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">
                Stock Request
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Approve or reject stock transactions
            </p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="relative overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">

        <table id="stockRequestTable" class="w-full text-sm text-left text-black border-collapse table-crud">

            <thead class="bg-blue-600 text-white border-b border-blue-700">
                <tr class="uppercase tracking-wide text-xs font-semibold">
                    <th class="px-5 py-4 text-center col-action">No</th>
                    <th class="px-5 py-4">Product</th>
                    <th class="px-5 py-4">Type</th>
                    <th class="px-5 py-4">Qty</th>
                    <th class="px-5 py-4">Notes</th>
                    <th class="px-5 py-4">User</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-center col-action">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($transactions as $tx)
                    <tr class="border-b hover:bg-gray-100 transition">

                        <td class="px-5 py-4 text-center"></td>

                        <td class="px-5 py-4">{{ $tx->product->name }}</td>

                        <td class="px-5 py-4">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $tx->type === 'IN' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tx->type }}
                            </span>
                        </td>

                        <td class="px-5 py-4">{{ $tx->quantity }}</td>

                        <td class="px-5 py-4">{{ $tx->notes ?? '-' }}</td>

                        <td class="px-5 py-4">{{ $tx->user->name }}</td>

                        <td class="px-5 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                PENDING
                            </span>
                        </td>

                        <td class="px-5 py-4 text-center space-x-2">

                            {{-- APPROVE --}}
                            <form action="{{ route('admin.stock-requests.approve', $tx->id) }}"
                                  method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="px-2 py-1 text-xs text-white bg-green-600 rounded hover:bg-green-700">
                                    Approve
                                </button>
                            </form>

                            {{-- REJECT --}}
                            <form action="{{ route('admin.stock-requests.reject', $tx->id) }}"
                                  method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="px-2 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                                    Reject
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<x-datatable-init
    id="stockRequestTable"
    :columnDefs="[
        ['orderable'=>false,'targets'=>[0,7]]
    ]"
/>

@endsection
