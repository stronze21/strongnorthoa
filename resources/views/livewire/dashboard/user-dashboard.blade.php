<!-- resources/views/livewire/dashboard/user-dashboard.blade.php -->
<div>
    <!-- Welcome Card with Date Filter -->
    <div class="mb-6 shadow-xl card bg-base-100">
        <div class="card-body">
            <div class="flex flex-col items-start justify-between mb-4 md:flex-row md:items-center">
                <div>
                    <h2 class="text-2xl card-title">Welcome, {{ auth()->user()->fullname() }}!</h2>
                    <p class="text-base-content/70">
                        Current Level: <span
                            class="font-bold">{{ optional($userProfile)->current_level ?? 'New Member' }}</span>
                    </p>
                </div>
                <div class="shadow stats">
                    <div class="stat">
                        <div class="stat-title">Total Shows</div>
                        <div class="stat-value">{{ $cookingShowStats['total'] }}</div>
                    </div>
                </div>
            </div>

            <div class="divider">Dashboard Statistics</div>

            <!-- Date Filter -->
            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-4">
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

                <div class="flex items-end form-control">
                    <div class="p-2 alert alert-info">
                        <div class="flex-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="w-4 h-4 mr-2 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to
                                {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
        <div class="shadow stats bg-success text-success-content">
            <div class="stat">
                <div class="stat-figure text-success-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Closed Shows</div>
                <div class="stat-value">{{ $cookingShowStats['closed'] }}</div>
                <div class="stat-desc">
                    {{ $cookingShowStats['total'] > 0 ? round(($cookingShowStats['closed'] / $cookingShowStats['total']) * 100, 1) . '%' : '0%' }}
                    of total
                </div>
            </div>
        </div>

        <div class="shadow stats bg-ghost text-ghost-content">
            <div class="stat">
                <div class="stat-figure text-ghost-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-title">Booked Shows</div>
                <div class="stat-value">{{ $cookingShowStats['booked'] }}</div>
                <div class="stat-desc">
                    {{ $cookingShowStats['total'] > 0 ? round(($cookingShowStats['booked'] / $cookingShowStats['total']) * 100, 1) . '%' : '0%' }}
                    of total
                </div>
            </div>
        </div>

        <div class="shadow stats bg-warning text-warning-content">
            <div class="stat">
                <div class="stat-figure text-warning-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="stat-title">Follow-up Shows</div>
                <div class="stat-value">{{ $cookingShowStats['followup'] }}</div>
                <div class="stat-desc">
                    {{ $cookingShowStats['total'] > 0 ? round(($cookingShowStats['followup'] / $cookingShowStats['total']) * 100, 1) . '%' : '0%' }}
                    of total
                </div>
            </div>
        </div>

        <div class="shadow stats bg-primary text-primary-content">
            <div class="stat">
                <div class="stat-figure text-primary-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="stat-title">Contests</div>
                <div class="stat-value">{{ count($myContests) }}</div>
                <div class="stat-desc">In selected period</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
        <!-- My Cooking Shows -->
        <div class="shadow-xl card bg-base-100">
            <div class="card-body">
                <h2 class="flex justify-between card-title">
                    My Cooking Shows
                    <a href="{{ route('my-cooking-shows') }}" class="btn btn-sm btn-primary">View All</a>
                </h2>
                <div class="overflow-x-auto">
                    @if (count($myCookingShows) > 0)
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Host</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myCookingShows as $show)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $show->host_fullname() }}</div>
                                            <div class="text-sm opacity-50">{{ $show->full_address() }}</div>
                                        </td>
                                        <td>
                                            {!! $show->current_result() !!}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('my-cooking-shows.details', $show->cs_id) }}"
                                                class="btn btn-ghost btn-xs">details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>No cooking shows found in selected date range</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- My Contests -->
        <div class="shadow-xl card bg-base-100">
            <div class="card-body">
                <h2 class="flex justify-between card-title">
                    My Contests
                    <a href="{{ route('my-contests') }}" class="btn btn-sm btn-primary">View All</a>
                </h2>
                <div class="overflow-x-auto">
                    @if (count($myContests) > 0)
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Period</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myContests as $contest)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $contest->title }}</div>
                                            <div class="text-sm opacity-50">{{ $contest->serial() }}</div>
                                        </td>
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="mb-1 badge badge-ghost badge-sm">Start:
                                                    {{ \Carbon\Carbon::parse($contest->start_date)->format('M d, Y') }}</span>
                                                <span class="badge badge-ghost badge-sm">End:
                                                    {{ \Carbon\Carbon::parse($contest->end_date)->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('my-contests.details', $contest->id) }}"
                                                class="btn btn-ghost btn-xs">details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>You're not participating in any contests during the selected period.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Upcoming Contests -->
        <div class="shadow-xl card bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Upcoming Contests</h2>
                <div class="overflow-x-auto">
                    @if (count($upcomingContests) > 0)
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Period</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcomingContests as $contest)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $contest->title }}</div>
                                            <div class="text-sm opacity-50">{{ $contest->serial() }}</div>
                                        </td>
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="mb-1 badge badge-ghost badge-sm">Start:
                                                    {{ \Carbon\Carbon::parse($contest->start_date)->format('M d, Y') }}</span>
                                                <span class="badge badge-ghost badge-sm">End:
                                                    {{ \Carbon\Carbon::parse($contest->end_date)->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-xs">Join</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>No upcoming contests available.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contest Achievements -->
        <div class="shadow-xl card bg-base-100">
            <div class="card-body">
                <h2 class="card-title">My Contest Achievements</h2>
                <div class="overflow-x-auto">
                    @if (count($contestAchievements) > 0)
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Contest</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contestAchievements as $achievement)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold">{{ $achievement['contest_title'] }}</div>
                                        </td>
                                        <td>
                                            {{ $achievement['date_joined'] }}
                                        </td>
                                        <td>
                                            <div class="badge badge-primary">{{ $achievement['status'] }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>No contest achievements in the selected date range.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
