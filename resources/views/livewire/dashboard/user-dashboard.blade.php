<div>
    <!-- Welcome Card -->
    <div class="mb-6 shadow-xl card bg-base-100">
        <div class="card-body">
            <div class="flex flex-col items-start justify-between md:flex-row md:items-center">
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
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
        <div class="shadow stats bg-success text-success-content">
            <div class="stat">
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
                <div class="stat-title">Contests</div>
                <div class="stat-value">{{ count($myContests) }}</div>
                <div class="stat-desc">Participating</div>
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
                                <span>No cooking shows found. Start by booking your first show!</span>
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
                                <span>You're not participating in any contests yet.</span>
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
                                <span>No upcoming contests at the moment.</span>
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
                                <span>No contest achievements yet. Join contests to earn achievements!</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
