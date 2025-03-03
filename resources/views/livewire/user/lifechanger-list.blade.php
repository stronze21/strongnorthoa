<div>
    <div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
        <h1 class="text-2xl font-bold">Lifechangers</h1>
        <a href="{{ route('lifechangers.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            New Lifechanger
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
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Search name, email..."
                        class="input input-bordered" />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Region</span>
                    </label>
                    <select wire:model="regionFilter" class="w-full select select-bordered">
                        <option value="">All Regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Level</span>
                    </label>
                    <select wire:model="levelFilter" class="w-full select select-bordered">
                        <option value="">All Levels</option>
                        @foreach ($ssplLevels as $sspl)
                            <option value="{{ $sspl->level }}">{{ $sspl->level }} ({{ $sspl->type }})</option>
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
                            <th class="cursor-pointer" wire:click="sortBy('l_name')">
                                Name
                                @if ($sortField === 'l_name')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            &#8593;
                                        @else
                                            &#8595;
                                        @endif
                                    </span>
                                @endif
                            </th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Level</th>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                Member Since
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lifechangers as $user)
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
                                            <div class="text-sm opacity-50">ID: {{ $user->user_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $user->email }}</div>
                                    <div class="text-sm opacity-50">{{ $user->contact_no ?? 'No contact' }}</div>
                                </td>
                                <td>
                                    @if ($user->region)
                                        <div>{{ $user->region->region_name }}</div>
                                    @endif
                                    @if ($user->province)
                                        <div class="text-sm opacity-50">{{ $user->province->province_name }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->profile)
                                        <div class="badge badge-primary">{{ $user->profile->current_level }}</div>
                                    @else
                                        <div class="badge badge-ghost">No Profile</div>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="flex space-x-1">
                                        <a href="{{ route('lifechangers.details', $user->user_id) }}"
                                            class="btn btn-square btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('lifechangers.edit', $user->user_id) }}"
                                            class="btn btn-square btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center">No lifechangers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $lifechangers->links() }}
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
                    Showing {{ $lifechangers->firstItem() ?? 0 }} to {{ $lifechangers->lastItem() ?? 0 }} of
                    {{ $lifechangers->total() }} lifechangers
                </div>
            </div>
        </div>
    </div>
</div>
