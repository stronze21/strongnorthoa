<div>
    <div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
        <h1 class="text-2xl font-bold">Contests</h1>
        <a href="{{ route('contests.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            New Contest
        </a>
    </div>

    <!-- Filters Card -->
    <div class="mb-6 shadow-xl card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">Filters</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Search</span>
                    </label>
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Search title, description..."
                        class="input input-bordered" />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select wire:model="statusFilter" class="w-full select select-bordered">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="ended">Ended</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">SSPL Level</span>
                    </label>
                    <select wire:model="ssplFilter" class="w-full select select-bordered">
                        <option value="">All Levels</option>
                        @foreach ($ssplLevels as $sspl)
                            <option value="{{ $sspl->id }}">{{ $sspl->level }} ({{ $sspl->type }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button wire:click="$refresh" class="btn btn-outline btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                            clip-rule="evenodd" />
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="shadow-xl card bg-base-100">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="cursor-pointer" wire:click="sortBy('title')">
                                Title
                                @if ($sortField === 'title')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            &#8593;
                                        @else
                                            &#8595;
                                        @endif
                                    </span>
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('start_date')">
                                Period
                                @if ($sortField === 'start_date')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            &#8593;
                                        @else
                                            &#8595;
                                        @endif
                                    </span>
                                @endif
                            </th>
                            <th>Targets</th>
                            <th>SSPL Level</th>
                            <th>Participants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contests as $contest)
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

                                    <div class="mt-2">
                                        @if (\Carbon\Carbon::parse($contest->end_date)->isPast())
                                            <span class="badge badge-error">Ended</span>
                                        @elseif (\Carbon\Carbon::parse($contest->start_date)->isFuture())
                                            <span class="badge badge-info">Upcoming</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="mb-1 badge badge-primary badge-sm">Shows:
                                            {{ $contest->shows }}</span>
                                        <span class="mb-1 badge badge-secondary badge-sm">Sales:
                                            {{ $contest->sales }}</span>
                                        <span class="badge badge-accent badge-sm">Sets: {{ $contest->sets }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if ($contest->sspl)
                                        <span class="badge badge-primary">{{ $contest->sspl->level }}
                                            ({{ $contest->sspl->type }})</span>
                                    @else
                                        <span class="badge badge-ghost">All Levels</span>
                                    @endif

                                    <div class="mt-2">
                                        @if ($contest->for_team_builders)
                                            <span class="badge badge-info">Team Builders</span>
                                        @endif

                                        @if ($contest->strict)
                                            <span class="badge badge-warning">Strict Mode</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <!-- This will be replaced with actual count of participants -->
                                    <span class="badge badge-lg">{{ rand(5, 50) }}</span>
                                </td>
                                <td>
                                    <div class="flex space-x-1">
                                        <a href="{{ route('contests.details', $contest->id) }}"
                                            class="btn btn-square btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('contests.edit', $contest->id) }}"
                                            class="btn btn-square btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <button wire:click="delete({{ $contest->id }})"
                                            class="btn btn-square btn-ghost btn-xs"
                                            onclick="confirm('Are you sure you want to delete this contest?') || event.stopImmediatePropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center">No contests found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $contests->links() }}
            </div>

            <div class="flex items-center justify-between mt-4">
                <div>
                    <select wire:model="perPage" class="select select-bordered select-sm">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div class="text-sm text-gray-600">
                    Showing {{ $contests->firstItem() ?? 0 }} to {{ $contests->lastItem() ?? 0 }} of
                    {{ $contests->total() }} contests
                </div>
            </div>
        </div>
    </div>
</div>
