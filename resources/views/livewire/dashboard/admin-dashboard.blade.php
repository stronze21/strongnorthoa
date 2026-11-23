<div class="admin-overview">
    <style>
        .admin-overview { max-width: 1520px; margin: auto; padding: 32px 24px 48px; color: #263247; }
        .overview-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; margin-bottom: 26px; }
        .overview-header h1 { font-size: clamp(26px, 3vw, 34px); font-weight: 700; line-height: 1.25; margin-bottom: 8px; }
        .overview-header p { font-size: 14px; color: #607087; }
        .overview-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .admin-overview .card { border-radius: 12px; box-shadow: none; min-width: 0; }
        .admin-overview .card-body { padding: 24px; gap: 16px; }
        .admin-overview .card-title { font-size: 18px; font-weight: 700; line-height: 1.4; flex-wrap: wrap; gap: 12px; }
        .admin-overview .filter-panel { margin: 0 0 24px; }
        .admin-overview .filter-panel .card-body { padding: 20px 24px; }
        .admin-overview .filter-grid { display: grid; grid-template-columns: minmax(180px, 1.2fr) minmax(160px, 1fr) minmax(160px, 1fr); gap: 18px; }
        .admin-overview .label { padding: 0 0 8px; }
        .admin-overview .label-text { color: #526078; font-size: 13px; font-weight: 600; }
        .admin-overview .input, .admin-overview .select { width: 100%; height: 44px; min-height: 44px; border: 1px solid #cbd5e1; border-radius: 8px; color: #263247; background: white; }
        .admin-overview .input:disabled { background: #f8fafc; color: #526078; opacity: 1; }
        .overview-period { font-size: 13px; color: #526078; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .overview-metrics { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); background: white; border-radius: 12px; margin-bottom: 24px; padding: 6px 0; }
        .overview-metrics .stats { display: block; border-radius: 0; box-shadow: none; border-right: 1px solid #e5e7eb; background: transparent; min-width: 0; }
        .overview-metrics .stats:last-child { border-right: 0; }
        .overview-metrics .stat { display: block; padding: 18px 24px; min-width: 0; }
        .overview-metrics .stat-figure { display: none; }
        .overview-metrics .stat-title { color: #526078; font-size: 13px; white-space: normal; }
        .overview-metrics .stat-value { font-size: clamp(24px, 2.6vw, 36px); color: #263247; font-weight: 700; font-variant-numeric: tabular-nums; margin: 8px 0 4px; overflow-wrap: anywhere; white-space: normal; }
        .overview-metrics .stat-desc { color: #607087; font-size: 12px; white-space: normal; }
        .admin-overview .table { font-size: 13px; }
        .admin-overview .table th { color: #607087; font-size: 12px; font-weight: 600; text-transform: none; }
        .admin-overview .table th, .admin-overview .table td { padding: 12px 10px; white-space: normal; overflow-wrap: anywhere; }
        .admin-overview .table th:first-child, .admin-overview .table td:first-child { padding-left: 0; }
        .admin-overview .table td { color: #37465c; }
        .admin-overview .table .progress { width: 100%; min-width: 48px; max-width: 170px; height: 6px; }
        .admin-overview .opacity-50 { opacity: 1; color: #607087; }
        .admin-overview .card-title .btn { background: transparent; border: 0; color: #4338ca; padding: 0; min-height: 28px; height: auto; box-shadow: none; }
        .admin-overview .empty-cell { padding: 32px 12px !important; color: #607087; text-align: center; line-height: 1.7; }
        .overview-caption { font-size: 12px; color: #607087; margin-top: -6px; }
        .admin-overview a:focus-visible, .admin-overview button:focus-visible, .admin-overview input:focus-visible, .admin-overview select:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        .admin-overview .follow-up-badge { background: #fee2e2; color: #991b1b; border-color: transparent; }
        @media (max-width: 1100px) { .admin-overview .recent-grid { grid-template-columns: minmax(0, 1fr); } }
        @media (max-width: 760px) { .admin-overview { padding: 24px 16px 32px; } .admin-overview .filter-grid { grid-template-columns: minmax(0, 1fr); gap: 14px; } .overview-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); } .overview-metrics .stats:nth-child(2) { border-right: 0; } .overview-metrics .stats:nth-child(-n+2) { border-bottom: 1px solid #e5e7eb; } .overview-metrics .stat { padding: 16px; } .admin-overview .card-body { padding: 20px; } }
    </style>
    <header class="overview-header">
        <div><h1>Dashboard</h1><p>Cooking shows, sales, and team activity at a glance.</p></div>
        <div class="overview-actions">
            <a href="{{ route('cs.calendar') }}" class="btn btn-sm btn-outline"><i class="las la-calendar-alt" aria-hidden="true"></i> Full Calendar</a>
            <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary"><i class="las la-plus" aria-hidden="true"></i> Add Cooking Show</a>
        </div>
    </header>
    <!-- Date Filter -->
    <div class="filter-panel card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">Reporting period</h2>

            <div class="filter-grid">
                <div class="form-control">
                    <label class="label" for="dashboard-range">
                        <span class="label-text">Date Range</span>
                    </label>
                    <select id="dashboard-range" wire:model="selectedDateRange" class="w-full select select-bordered">
                        @foreach ($dateRanges as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label" for="dashboard-start">
                        <span class="label-text">Start Date</span>
                    </label>
                    <input id="dashboard-start" type="date" wire:model="startDate" class="input input-bordered"
                        {{ $selectedDateRange != 'custom' ? 'disabled' : '' }} />
                </div>

                <div class="form-control">
                    <label class="label" for="dashboard-end">
                        <span class="label-text">End Date</span>
                    </label>
                    <input id="dashboard-end" type="date" wire:model="endDate" class="input input-bordered"
                        {{ $selectedDateRange != 'custom' ? 'disabled' : '' }} />
                </div>
            </div>

            <div class="overview-period" aria-live="polite">
                <i class="las la-calendar" aria-hidden="true"></i>
                <span>{{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }} – {{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}</span>
                <span wire:loading wire:target="selectedDateRange,startDate,endDate">Updating dashboard…</span>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="overview-metrics">
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
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
                <div class="stat-desc">All registered lifechangers</div>
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
                <div class="stat-desc">Starting or ending in selected period</div>
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
                <div class="stat-desc">Created in selected period</div>
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
                <div class="stat-value">₱{{ number_format($totalAmountClosed, 2) }}</div>
                <div class="stat-desc">Created in selected period</div>
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
                <p class="overview-caption">Based on scheduled show dates in the selected period.</p>
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
                            @forelse ($cookingShowsByStatus as $status => $count)
                                <tr>
                                    <td>
                                        @if ($status == 'Closed')
                                            <div class="badge badge-success">{{ $status }}</div>
                                        @elseif($status == 'For Follow Up')
                                            <div class="badge follow-up-badge">{{ $status }}</div>
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
                                                class="mr-2">{{ array_sum($cookingShowsByStatus) > 0 ? round(($count / array_sum($cookingShowsByStatus)) * 100, 1) : 0 }}%</span>
                                            <progress class="w-56 progress progress-primary"
                                                value="{{ array_sum($cookingShowsByStatus) > 0 ? ($count / array_sum($cookingShowsByStatus)) * 100 : 0 }}"
                                                max="100"></progress>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="empty-cell">No shows scheduled in this period.<br>Choose a different reporting period or <a class="link" href="{{ route('cs.calendar') }}">open the calendar</a>.</td></tr>
                            @endforelse
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
                                <th>Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($monthlyStats as $stat)
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
                            @empty
                                <tr><td colspan="3" class="empty-cell">No cooking shows scheduled in {{ \Carbon\Carbon::parse($startDate)->format('Y') }}.<br>Choose another year to view its activity.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-grid grid grid-cols-1 gap-6 lg:grid-cols-3">
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
                                    <td colspan="2" class="empty-cell">No recent lifechangers in selected
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
                                    <td colspan="3" class="empty-cell">No recent contests in selected date
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
                    <a href="{{ route('admin.all') }}" class="btn btn-sm btn-primary">View All</a>
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
                                    <td colspan="3" class="empty-cell">No recent cooking shows in selected
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
