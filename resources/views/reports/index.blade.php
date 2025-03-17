@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 md:flex-row">
                <!-- Side Navigation -->
                <div class="flex-shrink-0 w-full md:w-64">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Report Types</h2>
                        </div>
                        <nav class="p-2">
                            <a href="{{ route('reports.index') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.index') && !request()->has('message') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-tachometer-alt la-lg"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('reports.shows') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.shows') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-calendar-check la-lg"></i>
                                Cooking Shows
                            </a>
                            <a href="{{ route('reports.lifechangers') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.lifechangers') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-users la-lg"></i>
                                Lifechangers
                            </a>
                            <a href="{{ route('reports.orders') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.orders') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-shopping-cart la-lg"></i>
                                Orders
                            </a>
                            <a href="{{ route('reports.contests') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.contests') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-trophy la-lg"></i>
                                Contest Performance
                            </a>
                            <a href="{{ route('reports.custom') }}"
                                class="flex items-center px-4 py-3 rounded-md mb-1 {{ request()->routeIs('reports.custom') ? 'bg-primary bg-opacity-10 text-primary font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="mr-3 las la-sliders-h la-lg"></i>
                                Custom Report
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Display message if provided -->
                    @if (isset($message))
                        <div class="p-4 mb-6 text-blue-700 bg-blue-100 border-l-4 border-blue-500">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Dashboard content (when on index page) -->
                    @if (request()->routeIs('reports.index') && !isset($message))
                        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                                <h1 class="text-2xl font-bold text-gray-800">Reports Dashboard</h1>
                                <div>
                                    <a href="{{ route('reports.custom') }}" class="btn btn-primary">
                                        Create Custom Report
                                    </a>
                                </div>
                            </div>

                            <!-- Summary Stats Cards -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    <div class="p-5 bg-white border rounded-lg shadow-sm">
                                        <h5 class="mb-2 text-lg font-semibold">Cooking Shows</h5>
                                        <p class="text-3xl font-bold text-primary">{{ $totalShows ?? 0 }}</p>
                                        <div class="flex justify-between mt-2">
                                            <span class="badge badge-success">Closed: {{ $closedShows ?? 0 }}</span>
                                            <span class="badge badge-info">Booked: {{ $bookedShows ?? 0 }}</span>
                                        </div>
                                        <a href="{{ route('reports.shows') }}"
                                            class="inline-block mt-3 text-sm text-primary hover:underline">
                                            View Details &rarr;
                                        </a>
                                    </div>

                                    <div class="p-5 bg-white border rounded-lg shadow-sm">
                                        <h5 class="mb-2 text-lg font-semibold">Lifechangers</h5>
                                        <p class="text-3xl font-bold text-primary">{{ $totalLifechangers ?? 0 }}</p>
                                        <div class="mt-2">
                                            <span class="badge badge-success">Active: {{ $activeLifechangers ?? 0 }}</span>
                                        </div>
                                        <a href="{{ route('reports.lifechangers') }}"
                                            class="inline-block mt-3 text-sm text-primary hover:underline">
                                            View Details &rarr;
                                        </a>
                                    </div>

                                    <div class="p-5 bg-white border rounded-lg shadow-sm">
                                        <h5 class="mb-2 text-lg font-semibold">Orders</h5>
                                        <p class="text-3xl font-bold text-primary">{{ $totalOrders ?? 0 }}</p>
                                        <div class="flex justify-between mt-2">
                                            <span class="badge badge-success">Complete: {{ $completeOrders ?? 0 }}</span>
                                            <span class="badge badge-warning">Pending: {{ $pendingOrders ?? 0 }}</span>
                                        </div>
                                        <a href="{{ route('reports.orders') }}"
                                            class="inline-block mt-3 text-sm text-primary hover:underline">
                                            View Details &rarr;
                                        </a>
                                    </div>

                                    <div class="p-5 bg-white border rounded-lg shadow-sm">
                                        <h5 class="mb-2 text-lg font-semibold">Contests</h5>
                                        <p class="text-3xl font-bold text-primary">{{ $totalContests ?? 0 }}</p>
                                        <div class="mt-2">
                                            <span class="badge badge-success">Active: {{ $activeContests ?? 0 }}</span>
                                        </div>
                                        <a href="{{ route('reports.contests') }}"
                                            class="inline-block mt-3 text-sm text-primary hover:underline">
                                            View Details &rarr;
                                        </a>
                                    </div>
                                </div>

                                <!-- Monthly Summary -->
                                <div class="mb-8 overflow-hidden bg-white border rounded-lg shadow-sm">
                                    <div class="p-6">
                                        <h3 class="mb-4 text-xl font-semibold">Monthly Summary</h3>
                                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                            <div class="text-center">
                                                <h5 class="text-lg font-medium text-gray-600">Shows This Month</h5>
                                                <p class="mt-2 text-3xl font-bold">{{ $monthlyShows ?? 0 }}</p>
                                            </div>
                                            <div class="text-center">
                                                <h5 class="text-lg font-medium text-gray-600">Orders This Month</h5>
                                                <p class="mt-2 text-3xl font-bold">{{ $monthlyOrders ?? 0 }}</p>
                                            </div>
                                            <div class="text-center">
                                                <h5 class="text-lg font-medium text-gray-600">Sales This Month</h5>
                                                <p class="mt-2 text-3xl font-bold">
                                                    ₱{{ number_format($monthlySales ?? 0, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Charts Section -->
                                <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                                    <div class="bg-white border rounded-lg shadow-sm">
                                        <div class="p-6">
                                            <h3 class="mb-4 text-xl font-semibold">Shows By Month</h3>
                                            <canvas id="showsChart" height="300"></canvas>
                                        </div>
                                    </div>

                                    <div class="bg-white border rounded-lg shadow-sm">
                                        <div class="p-6">
                                            <h3 class="mb-4 text-xl font-semibold">Orders By Month</h3>
                                            <canvas id="ordersChart" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Activities -->
                                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                    <div class="bg-white border rounded-lg shadow-sm">
                                        <div class="p-6">
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
                                                        @forelse ($recentShows ?? [] as $show)
                                                            <tr>
                                                                <td>{{ $show->date ? \Carbon\Carbon::parse($show->date)->format('M j, Y') : 'N/A' }}
                                                                </td>
                                                                <td>{{ $show->host ?? 'N/A' }}</td>
                                                                <td>{{ $show->lifechanger ?? 'N/A' }}</td>
                                                                <td>{!! $show->current_result() !!}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="py-4 text-center text-gray-500">No
                                                                    recent shows found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white border rounded-lg shadow-sm">
                                        <div class="p-6">
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
                                                        @forelse ($recentOrders ?? [] as $order)
                                                            <tr>
                                                                <td>{{ $order->oa_date ? \Carbon\Carbon::parse($order->oa_date)->format('M j, Y') : 'N/A' }}
                                                                </td>
                                                                <td>{{ $order->oa_number ?? 'N/A' }}</td>
                                                                <td>{{ $order->oa_client ?? 'N/A' }}</td>
                                                                <td>₱{{ number_format($order->oa_price_override ?: 0, 2) }}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="py-4 text-center text-gray-500">
                                                                    No recent orders found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (request()->routeIs('reports.index') && !isset($message))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Shows Chart
                const showsCtx = document.getElementById('showsChart').getContext('2d');
                const showsChart = new Chart(showsCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($showsByMonth['months'] ?? []),
                        datasets: [{
                            label: 'Cooking Shows',
                            data: @json($showsByMonth['counts'] ?? []),
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
                        labels: @json($ordersByMonth['months'] ?? []),
                        datasets: [{
                            label: 'Orders',
                            data: @json($ordersByMonth['counts'] ?? []),
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
    @endif
@endpush
