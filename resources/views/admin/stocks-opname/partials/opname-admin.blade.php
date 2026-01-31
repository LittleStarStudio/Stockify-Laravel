@extends('layouts.app')

@section('title', 'Stock Opname Report')

@section('content')
<div class="p-4 space-y-4 max-w-full">

    <!-- HEADER -->
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            Stock Opname Report
        </h1>
        <p class="text-sm text-gray-600">
            Physical stock audit monitoring
        </p>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border shadow-md">
        <form method="GET" class="grid grid-cols-4 gap-3 text-sm">

            <input type="date" name="date" id="filterDate"
                value="{{ request('date') }}"
                class="border rounded px-2 py-1">

            <select name="staff" id="filterStaff"
                class="border rounded px-2 py-1">
                <option value="">All Staff</option>
                @foreach($opnames->pluck('staff')->unique() as $s)
                    @if($s)
                    <option value="{{ $s->id }}">
                        {{ $s->name }}
                    </option>
                    @endif
                @endforeach
            </select>

            <select name="manager" id="filterManager""
                class="border rounded px-2 py-1">
                <option value="">All Managers</option>
                @foreach($opnames->pluck('manager')->unique() as $m)
                    @if($m)
                    <option value="{{ $m->id }}">
                        {{ $m->name }}
                    </option>
                    @endif
                @endforeach
            </select>

            <select name="status" id="filterStatus"
                class="border rounded px-2 py-1">
                <option value="">All Status</option>
                <option value="APPROVED">Approved</option>
                <option value="REJECTED">Rejected</option>
                <option value="SUBMITTED">Pending</option>
            </select>

            <button class="hidden"></button>
        </form>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-4 gap-3 text-sm">

        <div class="bg-white p-3 rounded border shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Total Opname</p>
                    <p id="statViewTotal" class="text-2xl font-bold">
                        {{ $opnames->count() }}
                    </p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 rounded border shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Approved</p>
                    <p id="statViewApproved" class="text-2xl font-bold text-green-600">
                        {{ $opnames->where('status','APPROVED')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 rounded border shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Rejected</p>
                    <p id="statViewRejected" class="text-2xl font-bold text-red-600">
                        {{ $opnames->where('status','REJECTED')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 rounded border shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>Waiting Review</p>
                    <p id="statViewPending" class="text-2xl font-bold text-yellow-600">
                        {{ $opnames->where('status','SUBMITTED')->count() }}
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

    <!-- TABLE -->
    <div class="bg-white rounded border shadow-md overflow-x-auto">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-2 border text-center">Date</th>
                    <th class="p-2 border text-center">Staff</th>
                    <th class="p-2 border text-center">Manager</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>

            <tbody id="adminOpnameTable">
                @foreach($opnames as $o)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-2 text-sm border text-center font-bold col-date">{{ $o->date }}</td>

                        <td class="p-2 text-sm border col-staff">
                            {{ $o->staff->name }}
                        </td>

                        <td class="p-2 text-sm border col-manager">
                            {{ $o->manager?->name ?? '-' }}
                        </td>

                        <td class="p-2 text-sm border text-center col-status">
                            @if($o->status === 'SUBMITTED')
                                <span class="text-yellow-600 bg-yellow-100 rounded-md p-1.5">UNDER REVIEW</span>
                            @elseif($o->status === 'APPROVED')
                                <span class="text-green-600 bg-green-100 rounded-md p-1.5">APPROVED</span>
                            @else
                                <span class="text-red-600 bg-red-100 rounded-md p-1.5">REJECTED</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection
