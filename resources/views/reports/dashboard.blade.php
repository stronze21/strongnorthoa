@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Reports Dashboard</h1>
            <div>
                <a href="{{ route('reports.custom') }}" class="btn btn-primary">
                    Create Custom Report
                </a>
            </div>
        </div>

        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-lg shadow card">
                <div class="p-5 card-body">
                    <h5 class="mb-2 text-lg font-semibold">Cooking Shows</h5>
                    <p class="text-3xl font-bold text-primary">{{ $totalShows }}</p>
                    <div class="flex justify-between mt-2">
                        <span class="badge badge-success">Closed: {{ $closedShows }}</span>
                        <span class="badge badge-info">Booked: {{ $bookedShows }}</span>
                    </div>
                    <a href="{{ route('reports.shows') }}" class="inline-block mt-3 text-sm text-primary hover:underline">
                        View Details &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow card">
                <div class="p-5 card-body">
                    <h5 class="mb-2 text-lg font-semibold">Lifechangers</h5>
                    <p class="text-3xl font-bold text-primary">{{ $totalLifechangers }}</p>
                    <div class="mt-2">
                        <span class="badge badge-success">Active: {{ $activeLifechangers }}</span>
                    </div>
                    <a href="{{ route('reports.lifechangers') }}"
                        class="inline-block mt-3 text-sm text-primary hover:underline">
                        View Details &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow card">
                <div class="p-5 card-body">
                    <h5 class="mb-2 text-lg font-semibold">Orders</h5>
                    <p class="text-3xl font-bold text-primary">{{ $totalOrders }}</p>
                    <div class="flex justify-between mt-2">
                        <span class="badge badge-success">Complete: {{ $completeOrders }}</span>
                        <span class="badge badge-warning">Pending: {{ $pendingOrders }}</span>
                    </div>
                    <a href="{{ route('reports.orders') }}" class="inline-block mt-3 text-sm text-primary hover:underline">
                        View Details &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow card">
                <div class="p-5 card-body">
                    <h5 class="mb-2 text-lg font-semibold">Contests</h5>
                    <p class="text-3xl font-bold text-primary">{{ $totalContests }}</p>
                    <div class="mt-2">
                        <span class="badge badge-success">Active: {{ $activeContests }}</span>
                    </div>
                    <a href="{{ route('reports.contests') }}"
                        class="inline-block mt-3 text-sm text-primary hover:underline">
                        View Details &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="mb-8 bg-white rounded-lg shadow card">
            <div class="p-6 card-body">
                <h3 class="mb-4 text-xl font-semibold">Monthly Summary</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="text-center">
                        <h5 class="text-lg font-medium text-gray-600">Shows This Month</h5>
                        <p class="mt-2 text-3xl font-bold">{{ $monthlyShows }}</p>
                    </div>
                    <div class="text-center">
                        <h5 class="text-lg font-medium text-gray-600">Orders This Month</h5>
                        <p class="mt-2 text-3xl font-bold">{{ $monthlyOrders }}</p>
                    </div>
                    <div class="text-center">
                        <h5 class="text-lg font-medium text-gray-600">Sales This Month</h5>
                        <p class="mt-2 text-3xl font-bold">₱{{ number_format($monthlySales, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <div class="bg-white rounded-lg shadow card">
                <div class="p-6 card-body">
                    <h3 class="mb-4 text-xl font-semibold">Shows By Month</h3>
                    <canvas id="showsChart" height="300"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow card">
                <div class="p-6 card-body">
                    <h3 class="mb-4 text-xl font-semibold">Orders By Month</h3>
                    <canvas id="ordersChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="bg-white rounded-lg shadow card">
                <div class="p-6 card-body">
                    <h3 class="mb-4 text-xl font-semibold">Recent Shows</h3>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Host</th>
                                    <th>Lifechanger</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentShows as $show)
                                    <tr>
                                        <td>{{ $show->date ? \Carbon\Carbon::parse($show->date)->format('M j, Y') : 'N/A' }}
                                        </td>
                                        <td>{{ $show->host ?? 'N/A' }}</td>
                                        <td>{{ $show->lifechanger ?? 'N/A' }}</td>
                                        <td>{!! $show->current_result() !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow card">
                <div class="p-6 card-body">
                    <h3 class="mb-4 text-xl font-semibold">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order #</th>
                                    <th>Client</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->oa_date ? \Carbon\Carbon::parse($order->oa_date)->format('M j, Y') : 'N/A' }}
                                        </td>
                                        <td>{{ $order->oa_number ?? 'N/A' }}</td>
                                        <td>{{ $order->oa_client ?? 'N/A' }}</td>
                                        <td>₱{{ number_format($order->oa_price_override ?: 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Shows Chart
            const showsCtx = document.getElementById('showsChart').getContext('2d');
            const showsChart = new Chart(showsCtx, {
                type: 'bar',
                data: {
                    labels: @json($showsByMonth['months']),
                    datasets: [{
                        label: 'Cooking Shows',
                        data: @json($showsByMonth['counts']),
                        backgroundColor: 'rgba(79, 129, 189, 0.6)',
                        borderColor: 'rgba(79, 129, 189, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: @json($ordersByMonth['months']),
                    datasets: [{
                        label: 'Orders',
                        data: @json($ordersByMonth['counts']),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
