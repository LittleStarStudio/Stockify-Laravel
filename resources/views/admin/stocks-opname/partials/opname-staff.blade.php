<div class="p-6 space-y-6" id="opnamePage" data-mode="view">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Stock Opname</h1>
            <p class="text-sm text-gray-600">Staff opname input</p>
        </div>

        <div class="flex gap-2">

            <button id="startOpname" 
                    class="inline-flex items-center gap-2 px-4 py-2
                            text-sm font-medium text-white
                            bg-blue-600 rounded-md
                            hover:bg-blue-700 transition">

                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>

                Create Opname
            </button>

            <button id="cancelOpname" 
                    class="hidden inline-flex items-center 
                            gap-2 px-4 py-2 rounded-md
                            bg-gray-200 text-gray-700
                            hover:bg-gray-300
                            active:bg-gray-400
                            focus:outline-none focus:ring-2 
                            focus:ring-gray-300
                            transition-all duration-200">
                Cancel
            </button>

            <button id="openModal"
                    class="hidden inline-flex items-center 
                            gap-2 px-4 py-2 rounded-md
                            bg-yellow-500 text-white
                            hover:bg-yellow-600
                            focus:outline-none focus:ring-2 
                            focus:ring-yellow-400
                            transition-all duration-200">
                Add Item
            </button>

            <button id="submitOpname" 
                    class="hidden inline-flex items-center 
                            gap-2 px-4 py-2 rounded-md
                            bg-blue-500 text-white
                            hover:bg-blue-600
                            active:bg-blue-700
                            focus:outline-none focus:ring-2 
                            focus:ring-blue-400
                            transition-all duration-200">
                Submit
            </button>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded border shadow-md">
        <input id="productSearch" type="text"
            placeholder="Search opname..."
            class="w-full border rounded px-3 py-2">
    </div>

    <!-- STAT VIEW MODE -->
    <div id="statView" class="grid grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p>All Opname</p>
                    <p id="statViewTotal" class="text-2xl font-bold">
                        {{ $opnames->where('staff_id', auth()->id())->count() }}
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
                        {{ $opnames->where('staff_id', auth()->id())->where('status','APPROVED')->count() }}
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
                        {{ $opnames->where('staff_id', auth()->id())->where('status','REJECTED')->count() }}
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
                        {{ $opnames->where('staff_id', auth()->id())->whereIn('status',['SUBMITTED','DRAFT'])->count() }}
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

    <!-- STAT INPUT MODE -->
    <div id="statInput" class="hidden grid grid-cols-3 gap-2">

        <div class="bg-white p-4 rounded shadow-md border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p>Total Items</p>
                    <p id="statTotal" class="text-2xl font-bold">0</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow-md border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p>Difference</p>
                <p id="statDiff" class="text-2xl font-bold text-red-600">0</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow-md border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p>Equality</p>
                    <p id="statEqual" class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>


    <!-- TABLE -->
    <div class="bg-white border rounded shadow-md">
        <table id="opnameTable" class="w-full text-sm">

            <!-- HEADER INPUT MODE -->
            <thead id="inputHeader" class="bg-gray-100 hidden">
                <tr>
                    <th>Product</th>
                    <th class="text-center border">Category</th>
                    <th class="text-center border">System</th>
                    <th class="text-center border">Physical</th>
                    <th class="text-center border">Diff</th>
                    <th class="text-center border">Notes</th>
                    <th class="text-center border">Actions</th>
                </tr>
            </thead>

            <!-- HEADER VIEW MODE -->
            <thead id="viewHeader" class="bg-gray-100">
                <tr>
                    <th>Date</th>
                    <th class="text-center border">Total Items</th>
                    <th class="text-center border">Difference</th>
                    <th class="text-center border">Status</th>
                    <th class="text-center border">Action</th>
                </tr>
            </thead>

            <!-- VIEW MODE BODY -->
            <tbody id="historyTable">
                @foreach($opnames->where('staff_id', auth()->id()) as $opname)
                    <tr class="border hover:bg-blue-50">
                        <td class="p-2 border font-bold">{{ $opname->date }}</td>
                        <td class="p-2 border text-center">{{ $opname->items->count() }}</td>
                        <td class="p-2 border text-center">
                            {{ $opname->items->where('difference','!=',0)->count() }}
                        </td>
                        <td class="p-2 border text-center">
                            @if($opname->status === 'SUBMITTED')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    WAITING REVIEW
                                </span> 
                            @elseif($opname->status === 'APPROVED')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    APPROVED
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    REJECTED
                                </span>
                            @endif
                        </td>
                        <td class="p-2 border text-center space-x-2">

                            @if($opname->status === 'APPROVED')

                                <a href="/admin/stocks-opname?view={{ $opname->id }}"
                                class="px-3 py-1 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                                    Detail
                                </a>

                            @else

                                <button 
                                    class="editHistoryBtn px-3 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600"
                                    data-id="{{ $opname->id }}">
                                    Edit
                                </button>

                                <button 
                                    class="deleteHistoryBtn px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700"
                                    data-id="{{ $opname->id }}">
                                    Delete
                                </button>

                            @endif

                        </td>

                    </tr>
                @endforeach
            </tbody>

            <!-- INPUT MODE BODY -->
            <tbody id="tempOpnameTable" class="hidden"></tbody>

        </table>
    </div>

</div>

<!-- MODAL BOX -->
@include('admin.stocks-opname.partials.modal-input-opname')
