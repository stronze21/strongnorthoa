<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-users la-lg"></i> Lifechanger Masterlist
            </li>
        </ul>
    </div>
</x-slot>

<div class="masterlist-page" x-data="{ columnsOpen: false }">
    <style>
        .masterlist-page { padding: 20px 24px 40px; color: #263247; }
        .masterlist-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 18px; }
        .masterlist-header h1 { font-size: 26px; line-height: 1.3; font-weight: 700; margin-bottom: 4px; }
        .masterlist-header p { font-size: 14px; color: #607087; }
        .masterlist-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 14px 16px; border-bottom: 1px solid #e5e7eb; }
        .masterlist-tools { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }
        .masterlist-page .masterlist-search { height: 38px; min-height: 38px; width: 280px; max-width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; background: white; font-size: 14px; }
        .masterlist-surface { background: white; border-radius: 12px; overflow: hidden; }
        .masterlist-page .masterlist-scroll { overflow-x: auto; }
        .masterlist-page .table { font-size: 13px; }
        .masterlist-page .table th { background: #f8fafc; color: #526078; font-size: 12px; font-weight: 600; text-transform: none; white-space: nowrap; }
        .masterlist-page .table th, .masterlist-page .table td { padding: 11px 14px; line-height: 1.5; }
        .masterlist-page .table td { border-bottom: 1px solid #edf0f4; }
        .masterlist-page .table tr:hover td { background: #fafbff; }
        .masterlist-page .table td:first-child { color: #607087; }
        .masterlist-page .table a.member-name { color: #263247; font-weight: 600; white-space: nowrap; }
        .masterlist-page .table a.member-name:hover { color: #4338ca; text-decoration: underline; }
        .masterlist-page .table .member-date { white-space: nowrap; font-variant-numeric: tabular-nums; }
        .masterlist-page .row-actions { display: flex; justify-content: flex-end; gap: 6px; }
        .masterlist-page .row-actions .btn { width: 32px; min-height: 32px; height: 32px; padding: 0; background: #eef2ff; color: #4338ca; border: 0; }
        .masterlist-page .row-actions .delete-action { background: #fff1f2; color: #be123c; }
        .masterlist-page .missing-profile { color: #92400e; font-size: 12px; }
        .masterlist-page .columns-panel { padding: 16px; border-bottom: 1px solid #e5e7eb; display: flex; gap: 12px 24px; flex-wrap: wrap; }
        .masterlist-page .columns-panel label { display: flex; align-items: center; gap: 8px; font-size: 13px; }
        .masterlist-page .list-empty { text-align: center; padding: 40px !important; color: #607087; }
        .masterlist-page a:focus-visible, .masterlist-page button:focus-visible, .masterlist-page input:focus-visible, .masterlist-page select:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        .masterlist-dialog { border: 0; padding: 0; border-radius: 14px; width: min(500px, calc(100vw - 32px)); max-height: calc(100dvh - 40px); background: white; color: #263247; box-shadow: 0 24px 70px rgba(15,23,42,.24); }
        .masterlist-dialog::backdrop { background: rgba(15,23,42,.55); }
        .masterlist-dialog-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #e5e7eb; }
        .masterlist-dialog h2 { font-size: 21px; font-weight: 700; }
        .masterlist-dialog-body { padding: 24px; font-size: 14px; line-height: 1.7; overflow-wrap: anywhere; }
        .masterlist-dialog-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e5e7eb; }
        .masterlist-dialog .label { font-size: 13px; font-weight: 600; padding: 0 0 6px; }
        .masterlist-dialog .select { min-height: 42px; height: 42px; background: white; border-color: #cbd5e1; }
        @media (max-width: 640px) { .masterlist-page { padding: 16px 12px 28px; } .masterlist-toolbar { align-items: stretch; } .masterlist-page .masterlist-search { width: 100%; } .masterlist-tools { width: 100%; } }
    </style>
    <header class="masterlist-header">
        <div><h1>Lifechanger Masterlist</h1><p>Manage member profiles, locations, and promotion levels.</p></div>
        <a href="{{ route('lc.create') }}" class="btn btn-sm btn-primary"><i class="las la-plus" aria-hidden="true"></i> New User Account</a>
    </header>
    <div class="masterlist-surface">
        <div class="masterlist-toolbar">
            <div class="masterlist-tools">
                <input type="search" placeholder="Search name or email…" aria-label="Search lifechangers" class="input masterlist-search" wire:model.debounce.300ms="search">
                <span class="text-sm">{{ number_format($users->count()) }} members</span>
                <span class="text-xs" wire:loading wire:target="search,filters">Updating…</span>
            </div>
            <div class="masterlist-tools">
                <button type="button" class="btn btn-sm btn-outline" wire:click="$set('showFilters', true)"><i class="las la-filter" aria-hidden="true"></i> Filters</button>
                <button type="button" class="btn btn-sm btn-outline" @click="columnsOpen = !columnsOpen" :aria-expanded="columnsOpen.toString()" aria-controls="masterlist-columns"><i class="las la-columns" aria-hidden="true"></i> Columns</button>
                <button type="button" class="btn btn-sm btn-ghost" wire:click="exportToExcel" wire:loading.attr="disabled" wire:target="exportToExcel"><i class="las la-file-excel" aria-hidden="true"></i> Export</button>
            </div>
        </div>
        <div id="masterlist-columns" class="columns-panel" x-show="columnsOpen" style="display: none;">
            @foreach($columns as $column => $visible)
                <label><input type="checkbox" class="checkbox checkbox-xs" wire:model="columns.{{ $column }}">{{ $column === 'id' ? 'ID' : ucwords(str_replace('_', ' ', $column)) }}</label>
            @endforeach
        </div>
        <!-- Table -->
        <div class="masterlist-scroll" tabindex="0" role="region" aria-label="Lifechanger masterlist">
            <table class="table w-full table-sm" id="printableTable">
                <thead>
                    <tr>
                        @if ($columns['id'])
                            <th>ID</th>
                        @endif
                        @if ($columns['lifechanger'])
                            <th>Lifechanger</th>
                        @endif
                        @if ($columns['birthdate'])
                            <th>Birthdate</th>
                        @endif
                        @if ($columns['town'])
                            <th>Town/City</th>
                        @endif
                        @if ($columns['province'])
                            <th>Province</th>
                        @endif
                        @if ($columns['signup_date'])
                            <th>Sign Up Date</th>
                        @endif
                        @if ($columns['team_builder'])
                            <th>Team Builder</th>
                        @endif
                        @if ($columns['team_leader'])
                            <th>Team Leader</th>
                        @endif
                        @if ($columns['distributor'])
                            <th>Distributor</th>
                        @endif
                        @if ($columns['date_time_show'])
                            <th>Date Time of Show</th>
                        @endif
                        @if ($columns['amount_invested'])
                            <th>Amount Invested</th>
                        @endif
                        @if ($columns['status'])
                            <th>Status</th>
                        @endif
                        @if ($columns['current_level'])
                            <th>Current Level</th>
                        @endif
                        @if ($columns['date_promoted'])
                            <th>Date Promoted</th>
                        @endif
                        @if ($columns['actions'])
                            <th class="text-end">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="member-{{ $user->user_id }}">
                            @if ($columns['id'])
                                <td>{{ $user->user_id }}</td>
                            @endif
                            @if ($columns['lifechanger'])
                                <td><a class="member-name" href="{{ route('lc.create', $user->user_id) }}">{{ $user->full_name }}</a></td>
                            @endif
                            @if ($columns['birthdate'])
                                <td>{{ $user->birthdate }}</td>
                            @endif
                            @if ($columns['town'])
                                <td>{{ $user->municipality->municipality_name ?? '' }}</td>
                            @endif
                            @if ($columns['province'])
                                <td>{{ $user->municipality->province->province_name ?? '' }}</td>
                            @endif
                            @if ($user->profile)
                                @if ($columns['signup_date'])
                                    <td class="member-date">{{ $user->profile->sign_up_date ?: '—' }}</td>
                                @endif
                                @if ($columns['team_builder'])
                                    <td>{{ $user->team_builder }}</td>
                                @endif
                                @if ($columns['team_leader'])
                                    <td>{{ $user->team_leader }}</td>
                                @endif
                                @if ($columns['distributor'])
                                    <td>{{ $user->distributor }}</td>
                                @endif
                                @if ($columns['date_time_show'])
                                    <td>{{ $user->date_time_show }}</td>
                                @endif
                                @if ($columns['amount_invested'])
                                    <td>{{ $user->amount_invested }}</td>
                                @endif
                                @if ($columns['status'])
                                    <td>{{ $user->status }}</td>
                                @endif
                                @if ($columns['current_level'])
                                    <td>{{ $user->cur_level->sspl->level ?? '' }}</td>
                                @endif
                                @if ($columns['date_promoted'])
                                    <td class="member-date">{{ $user->cur_level->date_promoted ?? '—' }}</td>
                                @endif
                            @else
                                @php($profileColumnCount = count(array_filter(array_intersect_key($columns, array_flip(['signup_date', 'team_builder', 'team_leader', 'distributor', 'date_time_show', 'amount_invested', 'status', 'current_level', 'date_promoted'])))))
                                @if($profileColumnCount > 0)<td colspan="{{ $profileColumnCount }}" class="missing-profile">Profile not set</td>@endif
                            @endif

                            @if ($columns['actions'])
                                <td class="text-end">
                                    <div class="row-actions">
                                        @if ($user->cur_level and $user->profile and $user->profile->builder)
                                            <a class="btn btn-sm" title="View associate form" aria-label="View associate form"
                                                wire:key='view-lc-form-{{ $user->user_id }}'
                                                href="{{ route('lc.assoc.form', $user->user_id) }}"><i
                                                    class="las la-lg la-file-pdf"></i></a>
                                        @endif
                                        <button class="btn btn-sm" title="View profile" aria-label="View profile" wire:key='view-lc-{{ $user->user_id }}'
                                            wire:click='view_lc("{{ $user->user_id }}")'><i
                                                class="las la-lg la-eye"></i></button>
                                        <button type="button" class="btn btn-sm delete-action" title="Delete account" aria-label="Delete account" wire:click="confirmDelete({{ $user->user_id }})"><i class="las la-lg la-trash" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="{{ max(1, count(array_filter($columns))) }}" class="list-empty">No lifechangers match your search and filters.<br><button type="button" class="btn btn-sm btn-ghost" wire:click="clearSearchAndFilters">Clear search and filters</button></td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">
                {{-- {{ $users->links() }} --}}
            </div>
        </div>


        <x-modal wire:model="showDelete">
            <x-slot name="title">Delete user account?</x-slot>
            <p>Delete the account for <strong>{{ $selected_user_email }}</strong>?</p>
            <p class="mt-2 text-sm text-gray-600">This member will be removed from the masterlist.</p>
            <x-slot name="footer">
                <button type="button" class="btn btn-sm btn-outline" wire:click="$set('showDelete', false)">Cancel</button>
                <button type="button" class="btn btn-sm btn-error" wire:click="delete_user" wire:loading.attr="disabled" wire:target="delete_user"><span wire:loading.remove wire:target="delete_user">Delete account</span><span wire:loading wire:target="delete_user">Deleting…</span></button>
            </x-slot>
        </x-modal>

        <!-- Filter Modal -->
        <x-modal wire:model.defer="showFilters">
            <x-slot name="title">Filter Users</x-slot>

            <div class="space-y-4">

                <!-- Province Filter -->
                <div>
                    <label class="label">Province</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model="filters.province">
                        <option value="">All</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Municipality/Town Filter (Populates based on selected province) -->
                <div>
                    <label class="label">Town/City</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model="filters.town"
                        @if (empty($towns)) disabled @endif>
                        <option value="">All</option>
                        @foreach ($towns as $town)
                            <option value="{{ $town->municipality_id }}">{{ $town->municipality_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Status</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model.defer="filters.status">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="label">Current Level</label>
                    <select class="w-full select select-bordered select-sm" wire:model="filters.current_level">
                        <option value="">All levels</option>
                        @foreach($levels as $level)<option value="{{ $level->id }}">{{ $level->level }}</option>@endforeach
                    </select>
                </div>
            </div>

            <x-slot name="footer">
                <button class="btn btn-sm" wire:click="$set('showFilters', false)">Close</button>
                <button class="btn btn-sm btn-error" wire:click="resetFilters">Reset</button>
                <button class="btn btn-sm btn-primary" wire:click="applyFilters">Apply</button>
            </x-slot>
        </x-modal>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>

        <script>
            function printTable() {
                var printContents = document.getElementById("printableTable").outerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = "<html><head><title>Print</title></head><body>" + printContents + "</body></html>";
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }

            function exportTableToExcel(tableId) {
                var wb = XLSX.utils.table_to_book(document.getElementById(tableId), {
                    sheet: "Users"
                });
                XLSX.writeFile(wb, "users_export.xlsx");
            }
        </script>
    @endpush

</div>
