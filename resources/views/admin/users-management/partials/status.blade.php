@if ($user->isActive())
    <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
        Active
    </span>
@elseif ($user->isPending())
    <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
        Pending
    </span>
@elseif ($user->isDeleted())
    <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
        Deleted
    </span>
@else
    <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
        Rejected
    </span>
@endif
