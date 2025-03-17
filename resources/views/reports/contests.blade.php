@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Contest Performance Report</h1>
            <div>
                <a href="{{ route('reports.index') }}" class="mr-2 btn btn-ghost">
                    Back to Dashboard
                </a>
                <a href="{{ route('reports.custom') }}?report_type=contests" class="btn btn-primary">
                    Custom Export
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white rounded-lg shadow card">
            <div class="p-5 card-body">
                <form action="{{ route('reports.contests') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="w-full select">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $key => $value)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="from_date" class="block mb-1 text-sm font-medium text-gray-700">From Date</label>
                        <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full input">
                    </div>
                    <div>
                        <label for="to_date" class="block mb-1 text-sm font-medium text-gray-700">To Date</label>
                        <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}"
                            class="w-full input">
                    </div>
                    <div class="flex justify-end md:col-span-3">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('reports.contests') }}" class="ml-2 btn btn-ghost">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Total Contests</h5>
                    <p class="mt-1 text-2xl font-bold">{{ $contests->total() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Active Contests</h5>
                    <p class="mt-1 text-2xl font-bold text-green-600">
                        {{ $contests->filter(function ($contest) {
                                return $contest->start_date <= now() && $contest->end_date >= now();
                            })->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Total Shows</h5>
                    <p class="mt-1 text-2xl font-bold text-blue-600">
                        {{ $contests->sum(function ($contest) {return $contest->cs->count();}) }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Average Completion</h5>
                    <p class="mt-1 text-2xl font-bold text-purple-600">
                        {{ $contests->count() > 0
                            ? number_format(
                                ($contests->sum(function ($contest) {
                                    return $contest->cs->where('result', 'Closed')->count();
                                }) /
                                    $contests->sum(function ($contest) {
                                        return $contest->cs->count() ?: 1;
                                    })) *
                                    100,
                                1,
                            )
                            : 0 }}%
                    </p>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="overflow-hidden bg-white rounded-lg shadow card">
            <div class="p-0 card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Contest
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Date Range
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Shows
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Performance
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($contests as $contest)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $contest->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $contest->serial() }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $contest->start_date ? \Carbon\Carbon::parse($contest->start_date)->format('M j, Y') : 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $contest->end_date ? \Carbon\Carbon::parse($contest->end_date)->format('M j, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusClass = '';
                                            switch ($contest->getStatusAttribute()) {
                                                case 'Active':
                                                    $statusClass = 'badge-success';
                                                    break;
                                                case 'Upcoming':
                                                    $statusClass = 'badge-info';
                                                    break;
                                                case 'Ended':
                                                    $statusClass = 'badge-warning';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-ghost';
                                            }
                                        @endphp
                                        <span
                                            class="badge {{ $statusClass }}">{{ $contest->getStatusAttribute() }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">Total: {{ $contest->cs->count() }}</div>
                                        <div class="flex mt-1 space-x-1">
                                            <span
                                                class="badge badge-success badge-sm">{{ $contest->cs->where('result', 'Closed')->count() }}
                                                Closed</span>
                                            <span
                                                class="badge badge-info badge-sm">{{ $contest->cs->where('result', 'Booked')->count() }}
                                                Booked</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $completed = $contest->cs->where('result', 'Closed')->count();
                                            $total = $contest->cs->count() ?: 1;
                                            $percentage = round(($completed / $total) * 100);

                                            $progressClass = '';
                                            if ($percentage >= 75) {
                                                $progressClass = 'bg-success';
                                            } elseif ($percentage >= 50) {
                                                $progressClass = 'bg-info';
                                            } elseif ($percentage >= 25) {
                                                $progressClass = 'bg-warning';
                                            } else {
                                                $progressClass = 'bg-error';
                                            }
                                        @endphp
                                        <div class="text-sm text-gray-900">{{ $percentage }}% Complete</div>
                                        <div class="mt-1 h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full {{ $progressClass }} rounded-full"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('contests.view', $contest->id) }}" class="btn btn-sm btn-ghost">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        No contests found matching your criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $contests->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="mt-6 bg-white rounded-lg shadow card">
            <div class="p-5 card-body">
                <h3 class="mb-4 text-lg font-semibold">Export Options</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('reports.custom') }}?report_type=contests&format=excel{{ request('status') ? '&status=' . request('status') : '' }}{{ request('from_date') ? '&from_date=' . request('from_date') : '' }}{{ request('to_date') ? '&to_date=' . request('to_date') : '' }}"
                        class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export to Excel
                    </a>
                    <a href="{{ route('reports.custom') }}?report_type=contests&format=pdf{{ request('status') ? '&status=' . request('status') : '' }}{{ request('from_date') ? '&from_date=' . request('from_date') : '' }}{{ request('to_date') ? '&to_date=' . request('to_date') : '' }}"
                        class="btn btn-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export to PDF
                    </a>
                    <a href="{{ route('reports.custom') }}?report_type=contests&format=csv{{ request('status') ? '&status=' . request('status') : '' }}{{ request('from_date') ? '&from_date=' . request('from_date') : '' }}{{ request('to_date') ? '&to_date=' . request('to_date') : '' }}"
                        class="btn btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export to CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
