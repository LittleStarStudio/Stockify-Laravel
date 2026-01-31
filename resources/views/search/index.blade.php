@extends('layouts.app')

@section('title','Search')

@section('content')

<h1 class="text-2xl font-semibold mb-4">
    Search result for: "{{ $q }}"
</h1>

<div class="space-y-8">

    <!-- PRODUCTS -->
    <div>
        <h2 class="font-bold text-lg mb-2">Products</h2>

        @forelse($products as $p)
            <a href="{{ route('admin.products-management.index') }}?highlight={{ $p->id }}"
               class="block p-2 border rounded hover:bg-gray-100">
                {{ $p->name }}
            </a>
        @empty
            <p class="text-sm text-gray-400">No products found</p>
        @endforelse
    </div>

    <!-- SUPPLIERS -->
    <div>
        <h2 class="font-bold text-lg mb-2">Suppliers</h2>

        @forelse($suppliers as $s)
            <a href="{{ route('admin.suppliers-management.index') }}"
               class="block p-2 border rounded hover:bg-gray-100">
                {{ $s->name }}
            </a>
        @empty
            <p class="text-sm text-gray-400">No suppliers found</p>
        @endforelse
    </div>

    <!-- USERS -->
    <div>
        <h2 class="font-bold text-lg mb-2">Users</h2>

        @forelse($users as $u)
            <a href="{{ route('admin.users-management.index') }}"
               class="block p-2 border rounded hover:bg-gray-100">
                {{ $u->name }} ({{ $u->email }})
            </a>
        @empty
            <p class="text-sm text-gray-400">No users found</p>
        @endforelse
    </div>

</div>

@endsection
