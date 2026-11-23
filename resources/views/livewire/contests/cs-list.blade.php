<x-slot name="header">
    <nav class="text-sm breadcrumbs" aria-label="Breadcrumb"><ul><li>Contests</li><li aria-current="page">All contests</li></ul></nav>
</x-slot>

<div class="contest-index">
    <style>
        .contest-index { padding: 20px 24px 36px; color: #263247; }
        .contest-heading { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 18px; }
        .contest-heading h1 { font-size: 26px; font-weight: 700; line-height: 1.3; margin-bottom: 5px; }
        .contest-heading p { font-size: 14px; color: #607087; }
        .contest-surface { background: white; border-radius: 12px; overflow: hidden; }
        .contest-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; padding: 14px 18px; border-bottom: 1px solid #e5e7eb; }
        .contest-filters { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .contest-index .input, .contest-index .select { background: white; border: 1px solid #cbd5e1; border-radius: 8px; min-height: 38px; height: 38px; font-size: 13px; }
        .contest-index .input { width: 300px; max-width: 100%; }
        .contest-results { color: #607087; font-size: 13px; }
        .contest-scroll { overflow-x: auto; }
        .contest-index table { width: 100%; min-width: 1140px; font-size: 13px; border-collapse: collapse; }
        .contest-index th { background: #f8fafc; color: #526078; font-size: 12px; font-weight: 600; white-space: nowrap; text-align: left; }
        .contest-index th, .contest-index td { padding: 14px 16px; border-bottom: 1px solid #edf0f4; vertical-align: top; }
        .contest-index tbody tr:hover { background: #fafbff; }
        .contest-index .contest-name { min-width: 270px; max-width: 440px; }
        .contest-name a { font-size: 14px; font-weight: 700; color: #263247; line-height: 1.5; }
        .contest-name a:hover { color: #4338ca; text-decoration: underline; }
        .contest-ref { display: block; font-size: 11px; color: #607087; margin-top: 4px; }
        .contest-index details { margin-top: 8px; color: #526078; font-size: 12px; }
        .contest-index summary { cursor: pointer; color: #4338ca; width: fit-content; }
        .contest-index details p { margin-top: 8px; line-height: 1.7; white-space: pre-wrap; overflow-wrap: anywhere; }
        .contest-index .contest-number { text-align: right; white-space: nowrap; font-variant-numeric: tabular-nums; }
        .contest-index .contest-date { white-space: nowrap; font-size: 12px; line-height: 1.8; }
        .contest-status { display: inline-block; padding: 4px 8px; border-radius: 5px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .contest-status.running { background: #dcfce7; color: #166534; }
        .contest-status.upcoming { background: #dbeafe; color: #1e40af; }
        .contest-status.ended { background: #f1f5f9; color: #526078; }
        .contest-index .contest-empty { padding: 44px 20px; text-align: center; color: #607087; }
        .contest-pagination { padding: 16px 18px; }
        .contest-index a:focus-visible, .contest-index button:focus-visible, .contest-index input:focus-visible, .contest-index select:focus-visible, .contest-index summary:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media (max-width: 640px) { .contest-index { padding: 16px 12px 28px; } .contest-filters { width: 100%; } .contest-index .input { width: 100%; } .contest-index .select { flex: 1; } }
    </style>
    <header class="contest-heading">
        <div><h1>Contests</h1><p>Review contest requirements, schedules, and eligibility.</p></div>
        <a href="{{ route('contests.create') }}" class="btn btn-sm btn-primary"><i class="las la-plus" aria-hidden="true"></i> New Contest</a>
    </header>
    <div class="contest-surface">
        <div class="contest-toolbar">
            <div class="contest-filters">
                <input type="search" class="input" placeholder="Search title or description…" aria-label="Search contests" wire:model.debounce.300ms="search">
                <select class="select" aria-label="Contest schedule" wire:model="schedule">
                    <option value="">All schedules</option><option value="running">Running</option><option value="upcoming">Upcoming</option><option value="ended">Ended</option>
                </select>
                @if($search || $schedule)<button type="button" class="btn btn-sm btn-ghost" wire:click="clearFilters">Clear</button>@endif
            </div>
            <span class="contest-results" aria-live="polite">{{ number_format($data->total()) }} contests <span wire:loading wire:target="search,schedule,clearFilters">· Updating…</span></span>
        </div>
        <div class="contest-scroll" tabindex="0" role="region" aria-label="Contest list">
            <table>
                <thead><tr><th scope="col">Contest</th><th scope="col" class="contest-number">Required shows</th><th scope="col" class="contest-number">Required sales</th><th scope="col" class="contest-number">Required sets</th><th scope="col">Schedule</th><th scope="col">Status</th><th scope="col">Strict</th><th scope="col">Restriction</th><th scope="col">Action</th></tr></thead>
                <tbody>
                    @forelse($data as $row)
                        @php
                            $scheduleStatus = !$row->start_date || !$row->end_date ? 'Not scheduled' : ($row->start_date->isAfter(today()) ? 'Upcoming' : ($row->end_date->isBefore(today()) ? 'Ended' : 'Running'));
                        @endphp
                        <tr wire:key="contest-{{ $row->id }}">
                            <td class="contest-name">
                                <a href="{{ route('contests.view', ['contest_id' => $row->id]) }}">{{ $row->title }}</a>
                                <span class="contest-ref">{{ $row->serial() }}</span>
                                @if($row->description)<details><summary>View description</summary><p>{{ $row->description }}</p></details>@endif
                            </td>
                            <td class="contest-number">{{ $row->shows ?? 0 }}</td>
                            <td class="contest-number">₱{{ number_format($row->sales ?? 0, 2) }}</td>
                            <td class="contest-number">{{ number_format($row->sets ?? 0, 2) }}</td>
                            <td class="contest-date">{{ $row->start_date ? $row->start_date->format('M j, Y') : 'Not set' }}<br><span class="text-gray-500">to</span> {{ $row->end_date ? $row->end_date->format('M j, Y') : 'Not set' }}</td>
                            <td><span class="contest-status {{ strtolower($scheduleStatus) }}">{{ $scheduleStatus }}</span></td>
                            <td>{{ $row->strict ? 'Yes' : 'No' }}</td>
                            <td>{{ ucfirst($row->restriction ?: 'Open') }}{{ $row->restriction === 'level' ? ': ' . (optional($row->sspl)->level ?: 'Not set') : '' }}</td>
                            <td><a href="{{ route('contests.view', ['contest_id' => $row->id]) }}" class="btn btn-sm btn-outline" aria-label="View {{ $row->title }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="contest-empty"><strong>No contests found</strong><p class="mt-2">Try a different search or schedule.</p>@if($search || $schedule)<button type="button" class="btn btn-sm btn-ghost mt-3" wire:click="clearFilters">Clear filters</button>@endif</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="contest-pagination">{{ $data->links() }}</div>
    </div>
</div>
