<div class="p-6">
    <!-- Date Filter -->
    <div class="my-6 shadow-sm card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">Date Filter</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Date Range</span>
                    </label>
                    <select wire:model="selectedDateRange" class="w-full select select-bordered">
                        @foreach ($dateRanges as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Start Date</span>
                    </label>
                    <input type="date" wire:model="startDate" class="input input-bordered"
                        {{ $selectedDateRange != 'custom' ? 'disabled' : '' }} />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">End Date</span>
                    </label>
                    <input type="date" wire:model="endDate" class="input input-bordered"
                        {{ $selectedDateRange != 'custom' ? 'disabled' : '' }} />
                </div>
            </div>

            <div class="mt-4 alert alert-info">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-6 h-6 mx-2 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <label>Showing data for: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to
                        {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
        <div class="shadow stats">
            <div class="stat">
                <div class="stat-figure">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Lifechangers</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="shadow stats">
            <div class="stat">
                <div class="stat-figure">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Contests</div>
                <div class="stat-value">{{ $totalContests }}</div>
                <div class="stat-desc">In selected date range</div>
            </div>
        </div>

        <div class="shadow stats">
            <div class="stat">
                <div class="stat-figure">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="stat-title">Total Cooking Shows</div>
                <div class="stat-value">{{ $totalCookingShows }}</div>
                <div class="stat-desc">In selected date range</div>
            </div>
        </div>

        <div class="shadow stats">
            <div class="stat">
                <div class="stat-figure">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Amount Closed</div>
                <div class="stat-value">{{ number_format($totalAmountClosed, 2) }}</div>
                <div class="stat-desc">In selected date range</div>
            </div>
        </div>
    </div>


    <!-- Running Contests Alerts -->
    @if (count($runningContests) > 0)
        <div class="my-6">
            <h2 class="mb-3 text-xl font-bold">Running Contests</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($runningContests as $contest)
                    <div class="shadow-lg alert {{ $contest->days_remaining < 7 ? 'alert-warning' : 'alert-info' }}">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="flex-shrink-0 w-6 h-6 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">{{ $contest->title }} <span
                                        class="badge badge-sm">{{ $contest->serial() }}</span></h3>
                                <div class="text-xs">{{ $contest->days_remaining }}
                                    day{{ $contest->days_remaining !== 1 ? 's' : '' }} remaining (ends
                                    {{ $contest->end_date->format('M d, Y') }})</div>
                                <progress
                                    class="w-full progress {{ $contest->days_remaining < 7 ? 'progress-warning' : 'progress-info' }}"
                                    value="{{ $contest->progress_percentage }}" max="100"></progress>
                                <div class="flex justify-between mt-1 text-xs">
                                    <span>Started: {{ $contest->start_date->format('M d') }}</span>
                                    <span>{{ $contest->progress_percentage }}% complete</span>
                                    <span>Ends: {{ $contest->end_date->format('M d') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-none">
                            <a href="{{ route('contests.view', $contest->id) }}" class="btn btn-sm">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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
                                                class="mr-2">{{ $totalCookingShows > 0 ? round(($count / $totalCookingShows) * 100, 1) : 0 }}%</span>
                                            <progress class="w-56 progress progress-primary"
                                                value="{{ $totalCookingShows > 0 ? ($count / $totalCookingShows) * 100 : 0 }}"
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
                <h2 class="card-title">Monthly Cooking Shows ({{ \Carbon\Carbon::parse($startDate)->format('Y') }})
                </h2>
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
                                                max="{{ $monthlyStats->max('count') > 0 ? $monthlyStats->max('count') : 1 }}"></progress>
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
                            @forelse($recentUsers as $user)
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
                                        <a href="{{ route('lc.profile', $user->user_id) }}"
                                            class="btn btn-ghost btn-xs">details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center">No recent lifechangers in selected
                                        date range</td>
                                </tr>
                            @endforelse
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
                    <a href="{{ route('contests.list') }}" class="btn btn-sm btn-primary">View All</a>
                </h2>
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <tbody>
                            @forelse($recentContests as $contest)
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
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center">No recent contests in selected date
                                        range</td>
                                </tr>
                            @endforelse
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
                    <a href="{{ route('admin.cooked') }}" class="btn btn-sm btn-primary">View All</a>
                </h2>
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <tbody>
                            @forelse($recentCookingShows as $show)
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
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center">No recent cooking shows in selected
                                        date range</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
