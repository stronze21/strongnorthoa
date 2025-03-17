@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Lifechangers Report</h1>
            <div>
                <a href="{{ route('reports.index') }}" class="mr-2 btn btn-ghost">
                    Back to Dashboard
                </a>
                <a href="{{ route('reports.custom') }}?report_type=lifechangers" class="btn btn-primary">
                    Custom Export
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white rounded-lg shadow card">
            <div class="p-5 card-body">
                <form action="{{ route('reports.lifechangers') }}" method="GET"
                    class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="level" class="block mb-1 text-sm font-medium text-gray-700">Level</label>
                        <select id="level" name="level" class="w-full select">
                            <option value="">All Levels</option>
                            @foreach ($levels as $key => $value)
                                <option value="{{ $key }}" {{ request('level') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="region" class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                        <select id="region" name="region" class="w-full select">
                            <option value="">All Regions</option>
                            @foreach ($regions as $key => $value)
                                <option value="{{ $key }}" {{ request('region') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block mb-1 text-sm font-medium text-gray-700">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Name or Email" class="w-full input">
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
                        <a href="{{ route('reports.lifechangers') }}" class="ml-2 btn btn-ghost">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Total Lifechangers</h5>
                    <p class="mt-1 text-2xl font-bold">{{ $lifechangers->total() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Active Lifechangers</h5>
                    <p class="mt-1 text-2xl font-bold text-green-600">
                        {{ $lifechangers->where('deleted_at', null)->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">New This Month</h5>
                    <p class="mt-1 text-2xl font-bold text-blue-600">
                        {{ $lifechangers->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow card">
                <div class="p-4 text-center card-body">
                    <h5 class="font-semibold text-gray-600">Avg. Shows per LC</h5>
                    <p class="mt-1 text-2xl font-bold text-purple-600">
                        {{ number_format($lifechangers->count() > 0 ? \App\Models\CookingShow::count() / $lifechangers->count() : 0, 1) }}
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
                                    Name
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Contact Info
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Location
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Level
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Sign Up Date
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Shows Count
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($lifechangers as $lifechanger)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $lifechanger->fullname() }}</div>
                                        @if ($lifechanger->birth_date)
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($lifechanger->birth_date)->age }} years old
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $lifechanger->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $lifechanger->contact_no ?? 'No contact' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            {{ $lifechanger->municipality ? $lifechanger->municipality->municipality_name : 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $lifechanger->province ? $lifechanger->province->province_name : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            {{ $lifechanger->profile ? 'Level ' . $lifechanger->profile->current_level : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            {{ $lifechanger->profile && $lifechanger->profile->sign_up_date
                                                ? \Carbon\Carbon::parse($lifechanger->profile->sign_up_date)->format('M j, Y')
                                                : \Carbon\Carbon::parse($lifechanger->created_at)->format('M j, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            {{ \App\Models\CookingShow::where('user_id', $lifechanger->user_id)->count() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('profile.show', $lifechanger->user_id) }}"
                                            class="btn btn-sm btn-ghost">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No lifechangers found matching your criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $lifechangers->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="mt-6 bg-white rounded-lg shadow card">
            <div class="p-5 card-body">
                <h3 class="mb-4 text-lg font-semibold">Export Options</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('reports.custom') }}?report_type=lifechangers&format=excel{{ request('level') ? '&level=' . request('level') : '' }}{{ request('region') ? '&region=' . request('region') : '' }}{{ request('search') ? '&search=' . request('search') : '' }}"
                        class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export to Excel
                    </a>
                    <a href="{{ route('reports.custom') }}?report_type=lifechangers&format=pdf{{ request('level') ? '&level=' . request('level') : '' }}{{ request('region') ? '&region=' . request('region') : '' }}{{ request('search') ? '&search=' . request('search') : '' }}"
                        class="btn btn-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export to PDF
                    </a>
                    <a href="{{ route('reports.custom') }}?report_type=lifechangers&format=csv{{ request('level') ? '&level=' . request('level') : '' }}{{ request('region') ? '&region=' . request('region') : '' }}{{ request('search') ? '&search=' . request('search') : '' }}"
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
