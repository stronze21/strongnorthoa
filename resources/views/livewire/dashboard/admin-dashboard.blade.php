<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-user la-lg"></i> Admin
            </li>
            <li>
                <i class="mr-1 las la-tachometer-alt la-lg"></i> Dashboard
            </li>
        </ul>
    </div>
</x-slot>

<div class="py-12">
    <!-- Stats Overview -->
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
            <div class="shadow stats bg-primary text-primary-content">
                <div class="stat">
                    <div class="stat-figure text-primary-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="text-white stat-title">Total Lifechangers</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="shadow stats bg-secondary text-secondary-content">
                <div class="stat">
                    <div class="stat-figure text-secondary-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-white stat-title">Total Contests</div>
                    <div class="stat-value">{{ $totalContests }}</div>
                </div>
            </div>

            <div class="shadow stats bg-accent text-accent-content">
                <div class="stat">
                    <div class="stat-figure text-accent-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="text-white stat-title">Total Cooking Shows</div>
                    <div class="stat-value">{{ $totalCookingShows }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
            <!-- Cooking Shows by Status -->
            <div class="shadow-xl card bg-base-100">
                <div class="card-body">
                    <h2 class="card-title">Cooking Shows by Status</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cookingShowsByStatus as $status => $count)
                                    <tr>
                                        <td>
                                            @if ($status == 'Closed')
                                                <div class="badge badge-success">{{ $status }}</div>
                                            @elseif($status == 'For Follow Up')
                                                <div class="badge badge-warning">{{ $status }}</div>
                                            @elseif($status == 'Booked' || $status == 'Reschedule')
                                                <div class="badge badge-ghost">{{ $status }}</div>
                                            @else
                                                <div class="badge badge-error">{{ $status }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $count }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                <span
                                                    class="mr-2">{{ round(($count / $totalCookingShows) * 100, 1) }}%</span>
                                                <progress class="w-56 progress progress-primary"
                                                    value="{{ ($count / $totalCookingShows) * 100 }}"
                                                    max="100"></progress>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Monthly Statistics -->
            <div class="shadow-xl card bg-base-100">
                <div class="card-body">
                    <h2 class="card-title">Monthly Cooking Shows ({{ date('Y') }})</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Shows</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthlyStats as $stat)
                                    <tr>
                                        <td>{{ $stat->month_name }}</td>
                                        <td>{{ $stat->count }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                <progress class="w-56 progress progress-accent"
                                                    value="{{ $stat->count }}"
                                                    max="{{ $monthlyStats->max('count') }}"></progress>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Recent Lifechangers -->
            <div class="shadow-xl card bg-base-100">
                <div class="card-body">
                    <h2 class="flex justify-between card-title">
                        Recent Lifechangers
                        <a href="{{ route('lifechangers') }}" class="btn btn-sm btn-primary">View All</a>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <tbody>
                                @foreach ($recentUsers as $user)
                                    <tr class="hover">
                                        <td>
                                            <div class="flex items-center space-x-3">
                                                <div class="avatar">
                                                    <div class="w-12 h-12 mask mask-squircle">
                                                        <img src="{{ $user->profile_photo_url }}"
                                                            alt="{{ $user->fullname() }}" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $user->fullname() }}</div>
                                                    <div class="text-sm opacity-50">
                                                        {{ optional($user->profile)->current_level ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('lc.create', $user->user_id) }}"
                                                class="btn btn-ghost btn-xs">details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Contests -->
            <div class="shadow-xl card bg-base-100">
                <div class="card-body">
                    <h2 class="flex justify-between card-title">
                        Recent Contests
                        <a href="{{ route('contests') }}" class="btn btn-sm btn-primary">View All</a>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <tbody>
                                @foreach ($recentContests as $contest)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $contest->title }}</div>
                                            <div class="text-sm opacity-50">{{ $contest->serial() }}</div>
                                        </td>
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="mb-1 badge badge-ghost badge-sm">Shows:
                                                    {{ $contest->shows }}</span>
                                                <span class="badge badge-ghost badge-sm">Sales:
                                                    {{ $contest->sales }}</span>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('contests.view', $contest->id) }}"
                                                class="btn btn-ghost btn-xs">details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Cooking Shows -->
            <div class="shadow-xl card bg-base-100">
                <div class="card-body">
                    <h2 class="flex justify-between card-title">
                        Recent Cooking Shows
                        <a href="{{ route('cooking-shows') }}" class="btn btn-sm btn-primary">View All</a>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <tbody>
                                @foreach ($recentCookingShows as $show)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $show->host_fullname() }}</div>
                                            <div class="text-sm opacity-50">{{ $show->full_address() }}</div>
                                        </td>
                                        <td>
                                            {!! $show->current_result() !!}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('cs.view', $show->cs_id) }}"
                                                class="btn btn-ghost btn-xs">details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
