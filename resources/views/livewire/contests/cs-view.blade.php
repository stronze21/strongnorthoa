<x-slot name="header">
    <nav class="text-sm breadcrumbs" aria-label="Breadcrumb"><ul><li><a href="{{ route('contests.list') }}">Contests</a></li><li aria-current="page">{{ $contest->serial() }}</li></ul></nav>
</x-slot>

<div class="contest-detail">
    <style>
        .contest-detail { max-width: 1480px; margin: auto; padding: 24px; color: #263247; }
        .contest-detail-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 20px; }
        .contest-detail h1 { font-size: clamp(23px, 2.5vw, 30px); font-weight: 700; line-height: 1.35; margin-bottom: 8px; overflow-wrap: anywhere; }
        .contest-reference { color: #607087; font-size: 13px; }
        .contest-detail-header .btn { flex-shrink: 0; }
        .contest-overview { display: grid; grid-template-columns: minmax(0, 2fr) minmax(270px, 1fr); gap: 28px; background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; }
        .contest-detail h2 { font-size: 18px; font-weight: 700; margin-bottom: 14px; }
        .contest-description { font-size: 14px; line-height: 1.8; white-space: pre-wrap; overflow-wrap: anywhere; margin-bottom: 18px; max-width: 75ch; }
        .contest-meta { display: flex; flex-wrap: wrap; gap: 10px 22px; font-size: 13px; color: #526078; }
        .contest-state { display: inline-block; font-size: 12px; font-weight: 700; background: #f1f5f9; color: #526078; border-radius: 5px; padding: 4px 9px; margin-left: 10px; }
        .contest-state.running { background: #dcfce7; color: #166534; }
        .contest-state.upcoming { background: #dbeafe; color: #1e40af; }
        .contest-requirements { border-left: 1px solid #e5e7eb; padding-left: 28px; }
        .contest-requirements dl div { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #edf0f4; }
        .contest-requirements dt { color: #607087; }
        .contest-requirements dd { font-weight: 700; font-variant-numeric: tabular-nums; }
        .contest-participants { background: white; border-radius: 12px; overflow: hidden; }
        .contest-participants-heading { padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; border-bottom: 1px solid #e5e7eb; }
        .contest-participants-heading h2 { margin: 0; }
        .contest-participants-heading p { color: #607087; font-size: 12px; margin-top: 5px; }
        .contest-participant-count { font-size: 13px; color: #526078; }
        .contest-detail .contest-progress-scroll { overflow-x: auto; }
        .contest-detail table { width: 100%; min-width: 800px; border-collapse: collapse; font-size: 13px; }
        .contest-detail th { text-align: left; background: #f8fafc; color: #526078; font-size: 12px; font-weight: 600; }
        .contest-detail th, .contest-detail td { padding: 14px 24px; border-bottom: 1px solid #edf0f4; }
        .contest-detail td:first-child { color: #607087; width: 48px; }
        .contest-detail .participant-name { font-weight: 600; min-width: 220px; }
        .contest-progress { min-width: 160px; }
        .contest-progress-label { display: flex; justify-content: space-between; gap: 12px; font-variant-numeric: tabular-nums; margin-bottom: 7px; white-space: nowrap; }
        .contest-progress-label small { color: #607087; font-size: 11px; }
        .contest-detail progress { width: 100%; height: 6px; accent-color: #4f46e5; }
        .contest-detail .no-target { color: #607087; font-size: 12px; }
        .contest-detail .participant-empty { padding: 40px 24px; text-align: center; color: #607087; }
        .contest-detail a:focus-visible, .contest-detail [tabindex]:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media (max-width: 800px) { .contest-overview { grid-template-columns: minmax(0, 1fr); gap: 22px; } .contest-requirements { border-left: 0; border-top: 1px solid #e5e7eb; padding: 20px 0 0; } }
        @media (max-width: 640px) { .contest-detail { padding: 18px 12px 28px; } .contest-detail-header { flex-wrap: wrap; } .contest-overview { padding: 20px; } .contest-participants-heading { padding: 18px 20px; } }
    </style>
    @php
        $status = !$contest->start_date || !$contest->end_date ? 'Not scheduled' : ($contest->start_date->isAfter(today()) ? 'Upcoming' : ($contest->end_date->isBefore(today()) ? 'Ended' : 'Running'));
    @endphp
    <header class="contest-detail-header">
        <div><h1>{{ $contest->title }}</h1><span class="contest-reference">{{ $contest->serial() }}</span><span class="contest-state {{ strtolower($status) }}">{{ $status }}</span></div>
        <a href="{{ route('contests.list') }}" class="btn btn-sm btn-outline"><i class="las la-arrow-left" aria-hidden="true"></i> All Contests</a>
    </header>
    <div id="printDiv">
        <section class="contest-overview" aria-label="Contest overview">
            <div>
                <h2>Contest details</h2>
                <p class="contest-description">{{ $contest->description ?: 'No description provided.' }}</p>
                <div class="contest-meta">
                    <span><i class="las la-calendar" aria-hidden="true"></i> {{ $contest->start_date ? $contest->start_date->format('M j, Y') : 'Not set' }} – {{ $contest->end_date ? $contest->end_date->format('M j, Y') : 'Not set' }}</span>
                    @if($status === 'Ended')<span>Ended {{ $contest->end_date->format('M j, Y') }}</span>
                    @elseif($status === 'Upcoming')<span>Starts in {{ today()->diffInDays($contest->start_date) }} days</span>
                    @elseif($status === 'Running')<span>{{ today()->diffInDays($contest->end_date) }} days remaining</span>@endif
                    <span>Restriction: {{ ucfirst($contest->restriction ?: 'Open') }}{{ $contest->restriction === 'level' ? ': ' . (optional($contest->sspl)->level ?: 'Not set') : '' }}</span>
                    <span>Strict contest: {{ $contest->strict ? 'Yes' : 'No' }}</span>
                </div>
            </div>
            <div class="contest-requirements"><h2>Requirements</h2><dl>
                <div><dt>Validated shows</dt><dd>{{ $contest->shows ?? 0 }}</dd></div>
                <div><dt>Sales</dt><dd>₱{{ number_format($contest->sales ?? 0, 2) }}</dd></div>
                <div><dt>Sets sold</dt><dd>{{ number_format($contest->sets ?? 0, 2) }}</dd></div>
            </dl></div>
        </section>
        <section class="contest-participants" aria-labelledby="participant-heading">
            <header class="contest-participants-heading"><div><h2 id="participant-heading">{{ $contest->for_team_builders ? 'Team builder' : 'Lifechanger' }} progress</h2><p>Actual results compared with this contest’s requirements.</p></div><span class="contest-participant-count">{{ $data->count() }} participants</span></header>
            <div class="contest-progress-scroll" tabindex="0" role="region" aria-label="Participant progress table">
                <table><thead><tr><th scope="col">#</th><th scope="col">{{ $contest->for_team_builders ? 'Team builder' : 'Lifechanger' }}</th><th scope="col">Shows</th><th scope="col">Sales</th><th scope="col">Sets</th></tr></thead><tbody>
                    @forelse($data as $row)
                        <tr><td>{{ $loop->iteration }}</td><td class="participant-name">{{ ($contest->for_team_builders ? $row->team_builder : $row->lifechanger) ?: 'Name not set' }}</td>
                            @foreach(['shows' => 'Shows', 'sales' => 'Sales', 'sets' => 'Sets'] as $field => $label)
                                @php
                                    $actual = (float) ($row->$field ?? 0);
                                    $target = (float) ($contest->$field ?? 0);
                                    $percent = $target > 0 ? min(100, max(0, $actual / $target * 100)) : 0;
                                    $decimals = $field === 'shows' ? 0 : 2;
                                @endphp
                                <td class="contest-progress">
                                    <div class="contest-progress-label"><span>{{ $field === 'sales' ? '₱' : '' }}{{ number_format($actual, $decimals) }} <small>/ {{ number_format($target, $decimals) }}</small></span>@if($target > 0)<small>{{ round($percent) }}%</small>@endif</div>
                                    @if($target > 0)<progress class="progress progress-primary" value="{{ $percent }}" max="100" aria-label="{{ $label }} progress for {{ $contest->for_team_builders ? $row->team_builder : $row->lifechanger }}">{{ round($percent) }}%</progress>@else<span class="no-target">No minimum required</span>@endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="5" class="participant-empty"><strong>No qualifying participants yet</strong><p class="mt-2">Results appear here when cooking shows meet the contest rules.</p></td></tr>
                    @endforelse
                </tbody></table>
            </div>
        </section>
    </div>
</div>
