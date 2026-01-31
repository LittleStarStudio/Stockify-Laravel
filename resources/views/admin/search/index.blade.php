@extends('layouts.app')

@section('title','Search')

@section('content')

    <h1 class="text-2xl font-semibold mb-2">
        Search result for: "{{ $q }}"
    </h1>

    <div class="space-y-8">

        {{-- PRODUCTS --}}
        <div>
            <h2 class="font-bold text-lg mb-2">Products</h2>
            @forelse($products as $p)
                <div class="border p-2 rounded">
                    {{ $p->name }}
                </div>
            @empty
                <p class="text-sm text-gray-500">No products found</p>
            @endforelse
        </div>

        {{-- SUPPLIERS --}}
        <div>
            <h2 class="font-bold text-lg mb-2">Suppliers</h2>
            @forelse($suppliers as $s)
                <div class="border p-2 rounded">
                    {{ $s->name }}
                </div>
            @empty
                <p class="text-sm text-gray-500">No suppliers found</p>
            @endforelse
        </div>

        {{-- USERS --}}
        <div>
            <h2 class="font-bold text-lg mb-2">Users</h2>
            @forelse($users as $u)
                <div class="border p-2 rounded">
                    {{ $u->name }} ({{ $u->email }})
                </div>
            @empty
                <p class="text-sm text-gray-500">No users found</p>
            @endforelse
        </div>

    </div>

@endsection
