<div class="p-6">
    <div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
        <h1 class="text-2xl font-bold">My Cooking Shows</h1>
        <a href="{{ route('cs.add') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            New Cooking Show
        </a>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
        <div class="shadow stats bg-success text-success-content">
            <div class="stat">
                <div class="stat-title">Closed Shows</div>
                <div class="stat-value">{{ $cookingShows->where('result', 'Closed')->count() }}</div>
            </div>
        </div>

        <div class="shadow stats bg-ghost text-ghost-content">
            <div class="stat">
                <div class="stat-title">Booked Shows</div>
                <div class="stat-value">{{ $cookingShows->where('result', 'Booked')->count() }}</div>
            </div>
        </div>

        <div class="shadow stats bg-warning text-warning-content">
            <div class="stat">
                <div class="stat-title">Follow-up</div>
                <div class="stat-value">{{ $cookingShows->where('result', 'For Follow Up')->count() }}</div>
            </div>
        </div>

        <div class="shadow stats bg-error text-error-content">
            <div class="stat">
                <div class="stat-title">Cancelled</div>
                <div class="stat-value">{{ $cookingShows->where('result', 'Cancelled')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="mb-6 shadow-xl card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">Filters</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Search</span>
                    </label>
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Search hosts, address..."
                        class="input input-bordered" />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select wire:model="statusFilter" class="w-full select select-bordered">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Contest</span>
                    </label>
                    <select wire:model="contestFilter" class="w-full select select-bordered">
                        <option value="">All Contests</option>
                        @foreach ($contests as $contest)
                            <option value="{{ $contest->id }}">{{ $contest->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Date Range</span>
                    </label>
                    <input type="text" wire:model.debounce.500ms="dateRange" placeholder="YYYY-MM-DD to YYYY-MM-DD"
                        class="input input-bordered" />
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
                            <th class="cursor-pointer" wire:click="sortBy('host')">
                                Host
                                @if ($sortField === 'host')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            &#8593;
                                        @else
                                            &#8595;
                                        @endif
                                    </span>
                                @endif
                            </th>
                            <th>Address</th>
                            <th>Status</th>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                Date
                                @if ($sortField === 'created_at')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            &#8593;
                                        @else
                                            &#8595;
                                        @endif
                                    </span>
                                @endif
                            </th>
                            <th>Contest</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cookingShows as $show)
                            <tr class="hover">
                                <td>
                                    <div class="font-bold">{{ $show->host_fullname() }}</div>
                                </td>
                                <td>
                                    <div>{{ $show->full_address() }}</div>
                                </td>
                                <td>{!! $show->current_result() !!}</td>
                                <td>{{ $show->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if ($show->contest)
                                        <div class="badge badge-primary">{{ $show->contest->title }}</div>
                                    @else
                                        <div class="badge badge-ghost">None</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex space-x-1">
                                        <a href="{{ route('cs.view', $show->cs_id) }}"
                                            class="btn btn-square btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center">No cooking shows found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $cookingShows->links() }}
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
                    Showing {{ $cookingShows->firstItem() ?? 0 }} to {{ $cookingShows->lastItem() ?? 0 }} of
                    {{ $cookingShows->total() }} cooking shows
                </div>
            </div>
        </div>
    </div>
</div>
