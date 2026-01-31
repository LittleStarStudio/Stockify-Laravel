@extends('layouts.app')

@section('title','Stock Opname')

@section('content')

    @if(auth()->user()->role === 'staff_gudang')
        @include('admin.stocks-opname.partials.opname-staff')
    @elseif(auth()->user()->role === 'manajer_gudang')
        @include('admin.stocks-opname.partials.opname-manager')
    @else
        @include('admin.stocks-opname.partials.opname-admin')
    @endif

@endsection

@push('scripts')
    @vite('resources/js/admin/stock-opname.js')
@endpush
