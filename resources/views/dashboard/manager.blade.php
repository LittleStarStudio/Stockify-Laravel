@extends('layouts.app')

@section('title','Manager Dashboard')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold">Warehouse Manager</h1>
        <p class="text-sm text-gray-600">
            Operational overview today
        </p>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Incoming Today</p>
                    <p id="statViewPending" class="text-2xl font-bold text-green-600">
                        {{ $incomingToday }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                    </svg>           
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Outgoing Today</p>
                    <p id="statViewPending" class="text-2xl font-bold text-red-600">
                        {{ $outgoingToday }}
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                    </svg>            
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Waiting Review</p>
                    <p id="statViewPending" class="text-2xl font-bold text-yellow-600">
                        {{ $pendingRequests }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ca8a04">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>              
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Low Stock</p>
                    <p id="statViewTotal" class="text-2xl font-bold">
                        {{ $lowStockProducts->count() }}
                    </p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- LOW STOCK TABLE -->
    <div class="bg-white border rounded shadow-md">
        <div class="p-4 border-b">
            <h3 class="font-semibold">
                Products Low Stock
            </h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border text-center">Product</th>
                    <th class="p-3 border text-center">Current</th>
                    <th class="p-3 border text-center">Minimum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $p)
                <tr class="border-t hover:bg-red-50">
                    <td class="p-3 border font-semibold">
                        {{ $p->name }}
                    </td>
                    <td class="p-3 border text-center text-red-600">
                        {{ $p->stock ?? 0 }}
                    </td>
                    <td class="p-3 border text-center">
                        {{ $p->minimum_stock }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ACTIVITY -->
    <div class="bg-white border rounded shadow-md">
        <div class="p-4 border-b">
            <h3 class="font-semibold">
                Latest Activity
            </h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">User</th>
                    <th class="p-3 border">Action</th>
                    <th class="p-3 border">Product</th>
                    <th class="p-3 border text-center">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestActivities as $a)
                <tr class="border-t hover:bg-blue-50">
                    <td class="p-3 border font-semibold">
                        {{ $a->user->name }}
                    </td>
                    <td class="p-3 border text-center">
                        <span class="
                            {{ $a->type == 'IN' 
                                ? 'bg-green-100 text-green-700 border border-green-300' 
                                : 'bg-red-100 text-red-700 border border-red-300' 
                            }} 
                            rounded-md p-1.5 text-sm font-medium">
                            {{ $a->type == 'IN' ? 'Received' : 'Issued' }}
                        </span>
                    </td>
                    <td class="p-3 border">
                        {{ $a->product->name }}
                    </td>
                    <td class="p-3 border text-center">
                        {{ $a->quantity }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
