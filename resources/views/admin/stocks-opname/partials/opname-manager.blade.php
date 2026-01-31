<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Stock Opname Review</h1>
            <p class="text-sm text-gray-600">Manager approval</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border grid grid-cols-4 gap-4 shadow-md">
        <input type="date" id="filterDate" class="border rounded px-2 py-1">

        <input type="text" id="filterStaff" placeholder="Staff..." class="border rounded px-2 py-1">

        <select id="filterStatus" class="border rounded px-2 py-1">
            <option value="">All Status</option>
            <option value="SUBMITTED">SUBMITTED</option>
            <option value="APPROVED">APPROVED</option>
            <option value="REJECTED">REJECTED</option>
        </select>

    </div>

    <!-- STAT -->
    <div id="statView" class="grid grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>All Opname</p>
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

        <div class="bg-white p-4 rounded shadow-md">
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

        <div class="bg-white p-4 rounded shadow-md">
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

        <div class="bg-white p-4 rounded shadow-md">
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
    <div class="bg-white border rounded shadow-md">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr class="border">
                    <th class="py-2 px-2.5 border">Date</th>
                    <th class="py-2 px-2.5 border">Staff</th>
                    <th class="py-2 px-2.5 border">Status</th>
                    <th class="py-2 px-2.5 border">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($opnames as $o)
            <tr class="hover:bg-blue-50">
                <td class="px-2 py-2 border font-bold">{{ $o->date }}</td>
                <td class="px-2 py-2 border">{{ $o->staff->name }}</td>

                <td class="px-2 py-2 border text-center font-semibold">
                    @if($o->status === 'SUBMITTED')
                        <span class="text-yellow-600 bg-yellow-100 rounded-md p-1.5">UNDER REVIEW</span>
                    @elseif($o->status === 'APPROVED')
                        <span class="text-green-600 bg-green-100 rounded-md p-1.5">APPROVED</span>
                    @else
                        <span class="text-red-600 bg-red-100 rounded-md p-1.5">REJECTED</span>
                    @endif
                </td>

                <td class="px-2 py-2 border text-center">

                    {{-- STATUS: SUBMITTED --}}
                        @if($o->status === 'SUBMITTED')

                            <div class="flex justify-center gap-2">

                                <button 
                                    class="approveBtn px-3 py-1 bg-green-600 text-white rounded text-xs"
                                    data-id="{{ $o->id }}"
                                    data-status="APPROVED">
                                    Approve
                                </button>

                                <button 
                                    class="rejectBtn px-3 py-1 bg-red-600 text-white rounded text-xs"
                                    data-id="{{ $o->id }}"
                                    data-status="REJECTED">
                                    Reject
                                </button>

                            </div>

                        @else

                            <button 
                                class="changeStatusBtn px-3 py-1 bg-yellow-500 text-white rounded text-xs"
                                data-id="{{ $o->id }}">
                                Change Status
                            </button>

                        @endif

                </td>

            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- CHANGE STATUS MODAL -->
<div id="changeStatusModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-80 space-y-4">
        <h3 class="text-lg font-bold text-center">Change Opname Status</h3>

        <div class="flex justify-center gap-4">
            <button id="modalApprove" class="px-4 py-2 bg-green-600 text-white rounded">
                Approve
            </button>
            <button id="modalReject" class="px-4 py-2 bg-red-600 text-white rounded">
                Reject
            </button>
        </div>

        <button id="closeChangeModal" class="w-full text-sm text-gray-500 hover:underline">
            Cancel
        </button>
    </div>
</div>
