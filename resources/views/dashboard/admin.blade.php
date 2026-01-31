@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
<div class="p-6 space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <p class="text-sm text-gray-600">
                Global overview of Stockify system
            </p>
        </div>
    </div>

    <!-- ================= SUMMARY CARDS ================= -->
    <div class="grid grid-cols-4 gap-4">

        <!-- Total Products -->
        <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p>Total Products</p>
                    <p class="text-2xl font-bold text-black-600">
                        {{ $totalProducts }}
                    </p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p>Active Users</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $totalUsers }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p>Low Stock</p>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $lowStock }}
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Transactions -->
        <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p>This Month</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $transactionsThisMonth }}
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

    <!-- ================= CHARTS ================= -->
    <div class="grid grid-cols-2 gap-6">

        <!-- Products by Category -->
        <div class="bg-white p-6 rounded shadow-md">
            <h3 class="font-semibold mb-3">
                Products by Category
            </h3>
            <div class="h-72">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Transaction Status -->
        <div class="bg-white p-6 rounded shadow-md">
            <h3 class="font-semibold mb-3">
                Transaction Status
            </h3>
            <div class="h-72 flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

    </div>

    <!-- ================= ACTIVITY TABLE ================= -->
    <div class="bg-white border rounded shadow-md">
        <div class="p-4 border-b">
            <h3 class="font-semibold">
                Latest Activities
            </h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border text-center">User</th>
                    <th class="p-3 border text-center">Type</th>
                    <th class="p-3 border text-center">Product</th>
                    <th class="p-3 border text-center">Qty</th>
                    <th class="p-3 border text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestActivities as $a)
                <tr class="border-t hover:bg-blue-50">
                    <td class="p-3 border font-semibold">
                        {{ $a->user->name }}
                    </td>
                    <td class="p-3 border text-center">
                        @if($a->type == 'IN')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                IN
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                OUT
                            </span>
                        @endif
                    </td>
                    <td class="p-3 border">
                        {{ $a->product->name }}
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

<!-- ================= CHART JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // BAR CHART
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($stockByCategory->pluck('name')) !!},
                datasets: [{
                    label: 'Products',
                    data: {!! json_encode($stockByCategory->pluck('products_count')) !!},
                    backgroundColor: 'rgba(59,130,246,0.8)',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });

        // DOUGHNUT CHART
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($transactionStatus->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($transactionStatus->pluck('total')) !!},
                    backgroundColor: [
                        '#22c55e', // RECEIVED
                        '#3b82f6', // ISSUED
                        '#f97316', // PENDING
                        '#ef4444'  // REJECTED
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

    });
</script>

@endsection
