@extends('layouts.app')

@section('title','Staff Dashboard')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold">Staff Dashboard</h1>
        <p class="text-sm text-gray-600">
            Your daily tasks overview
        </p>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-3 gap-4">

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Incoming Tasks</p>
                    <p id="statViewPending" class="text-2xl font-bold text-green-600">
                        {{ $incomingTasks->count() }}
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
                    <p>Outgoing Tasks</p>
                    <p id="statViewPending" class="text-2xl font-bold text-red-600">
                        {{ $outgoingTasks->count() }}
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
                    <p>Pending Opname</p>
                    <p id="statViewPending" class="text-2xl font-bold text-yellow-600">
                        {{ $pendingOpnames }}
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

    </div>

    <!-- TASK LIST -->
    <div class="grid grid-cols-2 gap-6">

        <!-- Incoming -->
        <div class="bg-white border rounded shadow-md">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-green-700">
                    Incoming Goods
                </h3>
            </div>
            <ul>
                @foreach($incomingTasks as $t)
                <li class="flex justify-between items-center p-3 border-t hover:bg-green-50">
                    <span>{{ $t->product->name }}</span>
                    <span class="font-bold">{{ $t->quantity }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Outgoing -->
        <div class="bg-white border rounded shadow-md">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-red-700">
                    Outgoing Goods
                </h3>
            </div>
            <ul>
                @foreach($outgoingTasks as $t)
                <li class="flex justify-between items-center p-3 border-t hover:bg-red-50">
                    <span>{{ $t->product->name }}</span>
                    <span class="font-bold">{{ $t->quantity }}</span>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    <!-- MY ACTIVITY -->
    <div class="bg-white border rounded shadow-md">
        <div class="p-4 border-b">
            <h3 class="font-semibold">
                My Recent Activity
            </h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Product</th>
                    <th class="p-3 border">Type</th>
                    <th class="p-3 border text-center">Qty</th>
                    <th class="p-3 border text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myActivities as $a)
                <tr class="border-t hover:bg-blue-50">
                    <td class="p-3 border font-semibold">
                        {{ $a->product->name }}
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
                    <td class="p-3 border text-center">
                        {{ $a->quantity }}
                    </td>
                    <td class="p-3 border text-center text-gray-500">
                        {{ $a->date }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
