<div class="booking-calendar" x-data="{ exporting: false, exportMessage: '' }">
    <x-slot name="header">
        <h1 class="text-xl font-semibold">Full Calendar</h1>
    </x-slot>

    <style>
        .booking-calendar { padding: 24px; color: #374151; }
        .booking-calendar .calendar-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .booking-calendar h2 { font-size: clamp(26px, 3vw, 42px); font-weight: 700; line-height: 1.2; }
        .booking-calendar .calendar-actions, .booking-calendar .calendar-legend { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .booking-calendar .calendar-legend { margin-bottom: 16px; font-size: 14px; }
        .booking-calendar .calendar-scroll { overflow-x: auto; background: white; }
        .booking-calendar table { table-layout: fixed; width: 100%; min-width: 980px; border-collapse: collapse; }
        .booking-calendar th { padding: 12px 8px; font-size: 14px; background: #f3f4f6; border: 1px solid #d1d5db; }
        .booking-calendar td { height: 150px; vertical-align: top; padding: 8px; border: 1px solid #d1d5db; }
        .booking-calendar .calendar-outside { background: #f9fafb; }
        .booking-calendar .calendar-date { display: inline-block; padding: 2px 6px; margin-bottom: 6px; font-weight: 700; font-size: 13px; }
        .booking-calendar .calendar-today { background: #374151; color: white; border-radius: 4px; }
        .booking-calendar .calendar-event { display: block; padding: 6px; margin-bottom: 5px; border-radius: 4px; font-size: 12px; line-height: 1.5; overflow-wrap: anywhere; background: #f3f4f6; color: #374151; }
        .booking-calendar .calendar-follow-up { background: #fee2e2; color: #991b1b; }
        .booking-calendar .calendar-amount { background: #dbeafe; color: #1e40af; }
        .booking-calendar .calendar-event:hover { text-decoration: underline; }
        .booking-calendar a:focus-visible, .booking-calendar button:focus-visible { outline: 2px solid #1e40af; outline-offset: 2px; }
        .booking-calendar .calendar-status { display: block; font-weight: 700; }
        .booking-calendar .legend-label { padding: 4px 8px; border-radius: 4px; }
        @media (max-width: 640px) { .booking-calendar { padding: 16px; } }
    </style>

    <div class="calendar-toolbar">
        <h2 id="calendar-title" aria-live="polite">{{ $calendarMonth->format('F') }} Bookings <span>{{ $calendarMonth->year }}</span></h2>
        <div class="calendar-actions">
            <button type="button" class="btn btn-sm btn-outline" wire:click="previousMonth" wire:loading.attr="disabled" aria-label="Previous month"><i class="las la-angle-left" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-sm btn-outline" wire:click="today" wire:loading.attr="disabled">Today</button>
            <button type="button" class="btn btn-sm btn-outline" wire:click="nextMonth" wire:loading.attr="disabled" aria-label="Next month"><i class="las la-angle-right" aria-hidden="true"></i></button>
            <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary">Add Cooking Show</a>
            <button type="button" class="btn btn-sm btn-outline" :disabled="exporting" wire:loading.attr="disabled" @click="exporting = true; exportMessage = ''; try { await downloadBookingCalendar($root); exportMessage = 'Calendar PNG downloaded.'; } catch (error) { exportMessage = 'Could not export the calendar. Please try again.'; } finally { exporting = false; }"><i class="las la-download" aria-hidden="true"></i><span x-text="exporting ? 'Exporting…' : 'Download PNG'">Download PNG</span></button>
        </div>
    </div>
    <p x-show="exportMessage" x-text="exportMessage" style="display: none;" class="mb-3 text-sm" role="status"></p>
    <div class="calendar-legend" aria-label="Booking colors">
        <span class="legend-label calendar-follow-up">Follow up / For follow up</span>
        <span class="legend-label calendar-amount">With amount</span>
        <span>Click a booking to view details.</span>
    </div>
    <p class="mb-3 text-sm sm:hidden">Swipe horizontally to view the full week.</p>
    <div class="calendar-scroll" tabindex="0" role="region" aria-label="Monthly booking calendar">
        <table aria-labelledby="calendar-title">
            <thead><tr>@foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $weekday)<th scope="col">{{ $weekday }}</th>@endforeach</tr></thead>
            <tbody>
                @foreach (array_chunk($days, 7) as $week)
                    <tr>
                        @foreach ($week as $day)
                            <td class="{{ $day->month !== $calendarMonth->month ? 'calendar-outside' : '' }}">
                                <time datetime="{{ $day->toDateString() }}" class="calendar-date {{ $day->isToday() ? 'calendar-today' : '' }}" @if($day->isToday()) aria-current="date" @endif>{{ $day->day }}</time>
                                @foreach ($shows->get($day->toDateString(), collect()) as $show)
                                    @php
                                        $status = strtolower(trim(preg_replace('/[\s-]+/', ' ', $show->result ?? '')));
                                        $followUp = in_array($status, ['for follow up', 'follow up']);
                                        $amount = (float) str_replace([',', '₱', ' '], '', $show->amount_sold ?? 0);
                                        $numericResult = is_numeric(str_replace([',', '₱', ' '], '', $show->result ?? ''));
                                    @endphp
                                    <a href="{{ route('cs.view', ['cs_id' => $show->cs_id]) }}" class="calendar-event {{ $followUp ? 'calendar-follow-up' : (($amount > 0 || $numericResult) ? 'calendar-amount' : '') }}">
                                        <strong>{{ $show->formatted_time ?: 'Time not set' }}</strong> — {{ $show->host_fullname() }}
                                        @if($show->lifechanger)<span>({{ $show->lifechanger }})</span>@endif
                                        <span class="calendar-status">{{ $show->result ?: 'Booked' }}@if($amount > 0) · ₱{{ number_format($amount, 2) }}@endif</span>
                                    </a>
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($shows->flatten(1)->filter(function ($show) use ($calendarMonth) { return $show->date->format('Y-m') === $calendarMonth->format('Y-m'); })->isEmpty())
        <p class="mt-4 text-sm" role="status">No cooking show bookings for {{ $calendarMonth->format('F Y') }}.</p>
    @endif
</div>

@push('scripts')
    <script src="{{ asset('js/calendar-export.js') }}"></script>
@endpush

