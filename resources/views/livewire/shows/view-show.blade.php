<x-slot name="header">
    <nav class="py-2 text-sm breadcrumbs" aria-label="Breadcrumb">
        <ul>
            <li><a href="{{ auth()->user()->hasRole('admin') ? route('admin.all') : route('my-cooking-shows') }}">Cooking Shows</a></li>
            <li aria-current="page">Show #{{ $show->cs_id }}</li>
        </ul>
    </nav>
</x-slot>

<div class="show-page">
    <style>
        .show-page { max-width: 1400px; margin: auto; padding: 28px 24px 48px; color: #263247; }
        .show-heading { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; margin-bottom: 24px; }
        .show-heading h1 { font-size: clamp(24px, 3vw, 34px); line-height: 1.25; font-weight: 700; overflow-wrap: anywhere; margin-bottom: 10px; }
        .show-schedule { display: flex; align-items: center; flex-wrap: wrap; gap: 10px 20px; font-size: 15px; color: #526078; }
        .show-actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .show-layout { display: grid; grid-template-columns: minmax(0, 1fr); gap: 24px; align-items: start; }
        .show-layout.has-orders { grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr); }
        .show-content { min-width: 0; background: white; border-radius: 12px; }
        .show-content-body { padding: 28px; }
        .show-details-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 36px; }
        .show-group h2 { font-size: 18px; font-weight: 700; padding-bottom: 14px; border-bottom: 1px solid #e5e7eb; margin-bottom: 4px; }
        .show-field { display: grid; grid-template-columns: 120px minmax(0, 1fr); gap: 16px; padding: 13px 0; border-bottom: 1px solid #f0f2f5; font-size: 14px; }
        .show-field dt { color: #607087; }
        .show-field dd { font-weight: 600; overflow-wrap: anywhere; }
        .show-field a { color: #4338ca; text-underline-offset: 3px; }
        .show-field a:hover { text-decoration: underline; }
        .show-page a:focus-visible, .show-page button:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        .show-status { padding: 6px 12px; border-radius: 6px; background: #eef2ff; color: #3730a3; font-size: 13px; font-weight: 700; }
        .show-status.follow-up { background: #fee2e2; color: #991b1b; }
        .show-status.with-amount { background: #dbeafe; color: #1e40af; }
        .show-notes { margin-top: 28px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
        .show-notes h2 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
        .show-notes p { white-space: pre-wrap; overflow-wrap: anywhere; font-size: 14px; line-height: 1.7; }
        .show-page .table { white-space: normal; }
        @media (max-width: 1000px) { .show-layout.has-orders { grid-template-columns: minmax(0, 1fr); } }
        @media (max-width: 700px) { .show-page { padding: 20px 16px 32px; } .show-details-grid { grid-template-columns: minmax(0, 1fr); gap: 28px; } .show-content-body { padding: 20px; } .show-field { grid-template-columns: 100px minmax(0, 1fr); gap: 12px; } }
    </style>
    @php
        $normalizedStatus = strtolower(trim(preg_replace('/[\s-]+/', ' ', $show->result ?? '')));
        $isFollowUp = in_array($normalizedStatus, ['for follow up', 'follow up']);
        $sold = (float) str_replace([',', '₱', ' '], '', $show->amount_sold ?? 0);
    @endphp
    <header class="show-heading">
        <div>
            <h1>{{ $show->host_fullname() }}</h1>
            <div class="show-schedule">
                <span><i class="las la-calendar mr-1" aria-hidden="true"></i>{{ $show->date ? $show->date->format('l, F j, Y') : 'Date not set' }}</span>
                <span><i class="las la-clock mr-1" aria-hidden="true"></i>{{ $show->formatted_time ?: 'Time not set' }}</span>
                <span>Show #{{ $show->cs_id }}</span>
            </div>
        </div>
        <div class="show-actions">
            <span class="show-status {{ $isFollowUp ? 'follow-up' : ($sold > 0 ? 'with-amount' : '') }}">{{ $show->result ?: 'Booked' }}</span>
            <button type="button" class="btn btn-sm btn-primary" wire:click="openStatusModal"><i class="las la-edit" aria-hidden="true"></i> Update Status</button>
            <a class="btn btn-sm btn-outline" href="{{ route('cs.calendar', ['month' => $show->date ? $show->date->format('Y-m') : now()->format('Y-m')]) }}">View Calendar</a>
        </div>
    </header>
    <div class="show-layout {{ $show->result === 'Closed' ? 'has-orders' : '' }}">
        <div class="show-content">
            <div class="show-content-body">
                <div class="show-details-grid">
                    <section class="show-group" aria-labelledby="host-details">
                        <h2 id="host-details">Host &amp; contact</h2>
                        <dl>
                            <div class="show-field"><dt>Host</dt><dd>{{ $show->host_fullname() }}</dd></div>
                            <div class="show-field"><dt>Spouse</dt><dd>{{ $show->spouse ?: '—' }}</dd></div>
                            <div class="show-field"><dt>Address</dt><dd>{{ $show->full_address() ?: '—' }}</dd></div>
                            <div class="show-field"><dt>Phone</dt><dd>@if($show->contact_no)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $show->contact_no) }}">{{ $show->contact_no }}</a>@else — @endif</dd></div>
                            <div class="show-field"><dt>Email</dt><dd>@if($show->host_email)<a href="mailto:{{ $show->host_email }}">{{ $show->host_email }}</a>@else — @endif</dd></div>
                            <div class="show-field"><dt>Social media</dt><dd>{{ $show->social_media ?: '—' }}</dd></div>
                            <div class="show-field"><dt>Occupation</dt><dd>{{ $show->occupation ?: '—' }}</dd></div>
                        </dl>
                    </section>
                    <section class="show-group" aria-labelledby="team-details">
                        <h2 id="team-details">Show &amp; team</h2>
                        <dl>
                            @foreach (['type' => 'Show type', 'lifechanger' => 'Lifechanger', 'presenter' => 'Presenter', 'team_builder' => 'Team builder'] as $field => $label)
                                <div class="show-field"><dt>{{ $label }}</dt><dd>{{ $show->$field ?: '—' }}</dd></div>
                            @endforeach
                            <div class="show-field"><dt>Partner</dt><dd>{{ $show->partner_id && $show->partner_user ? $show->partner_user->fullname() : '—' }}</dd></div>
                            @foreach (['partner_type' => 'Partner type', 'distributor' => 'Distributor', 'sspl' => 'SSP level'] as $field => $label)
                                <div class="show-field"><dt>{{ $label }}</dt><dd>{{ $show->$field ?: '—' }}</dd></div>
                            @endforeach
                            <div class="show-field"><dt>Amount sold</dt><dd>₱{{ number_format($sold, 2) }}</dd></div>
                        </dl>
                    </section>
                </div>
                @if($show->notes)
                    <section class="show-notes"><h2>Notes</h2><p>{{ $show->notes }}</p></section>
                @endif

                <!-- Results Section -->
                @if ($show->results->count())
                    <div class="mt-8">
                        <h3 class="flex items-center mb-4 text-lg font-bold text-gray-800">
                            <i class="mr-2 text-indigo-600 las la-chart-bar"></i> Results
                        </h3>
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg">
                            @foreach ($show->results->all() as $result)
                                <div class="p-5 @if (!$loop->last) border-b border-gray-200 @endif">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-indigo-700">
                                            Result from {{ $result->date_submitted }}
                                        </h4>
                                        <span class="px-3 py-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
                                            {{ $result->closed_deal }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Amount:</span>
                                                <span
                                                    class="font-medium">₱{{ number_format($result->amount, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Downpayment:</span>
                                                <span
                                                    class="font-medium">₱{{ number_format($result->down_payment, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Payment Mode:</span>
                                                <span class="font-medium">{!! $result->mode !!}</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Delivery Date:</span>
                                                <span class="font-medium">{{ $result->delivery_date }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Created:</span>
                                                <span class="font-medium">{{ $result->date_created }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Updated:</span>
                                                <span class="font-medium">{{ $result->date_updated }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($result->remarks)
                                        <div class="p-3 mt-3 rounded-md bg-gray-50">
                                            <h5 class="mb-1 text-xs text-gray-500 uppercase">Remarks</h5>
                                            <p class="text-gray-700">{{ $result->remarks }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Order Agreements -->
        @if ($show->result == 'Closed')
            <div class="overflow-hidden bg-white shadow-xl rounded-xl">
                <div class="p-5 border-b border-gray-100 bg-gray-50">
                    <h2 class="flex items-center text-xl font-bold text-gray-800">
                        <i class="mr-2 text-indigo-600 las la-file-contract la-lg"></i> Order Agreements
                    </h2>
                </div>
                <div class="p-5">
                    <button
                        class="flex items-center justify-center w-full mb-5 transition-colors duration-200 bg-indigo-600 border-0 btn btn-sm btn-primary hover:bg-indigo-700"
                        wire:click="create_oa()">
                        <i class="mr-1 las la-plus"></i> Create Order Agreement
                    </button>

                    @if ($show->order_agreements->count())
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg">
                            <table class="table w-full">
                                <thead class="text-gray-700 bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-center">Items</th>
                                        <th class="px-4 py-2 text-center">Gifts</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($show->order_agreements as $order)
                                        <tr wire:key="view-oa-{{ $order->id }}"
                                            wire:click="view_oa({{ $order->id }})"
                                            class="transition-colors duration-150 cursor-pointer hover:bg-indigo-50">
                                            <td class="px-4 py-3 font-medium">{{ $order->date }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 text-indigo-800 bg-indigo-100 rounded-full">
                                                    {{ $order->items->sum('item_qty') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 text-purple-800 bg-purple-100 rounded-full">
                                                    {{ $order->gifts->sum('item_qty') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td colspan="3" class="px-4 py-2 text-right">
                                                <span class="font-semibold text-gray-700">Total: </span>
                                                <span
                                                    class="font-bold text-indigo-700">₱{{ number_format($order->items->sum('item_total'), 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center rounded-lg bg-gray-50">
                            <i class="mb-2 text-gray-400 las la-file-alt la-3x"></i>
                            <p class="text-gray-500">No order agreements yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div x-data="{ opened: @entangle('open_modal') }"
         x-effect="if (opened) { if (!$refs.statusDialog.open) $refs.statusDialog.showModal(); } else { if ($refs.statusDialog.open) $refs.statusDialog.close(); }">
        <style>
            .status-dialog { padding: 0; width: min(520px, calc(100vw - 32px)); max-height: calc(100dvh - 48px); border: 0; border-radius: 16px; background: white; color: #263247; box-shadow: 0 24px 70px rgba(15, 23, 42, .24); }
            .status-dialog::backdrop { background: rgba(15, 23, 42, .55); }
            .status-dialog-header { display: flex; justify-content: space-between; align-items: start; gap: 20px; padding: 26px 28px 20px; border-bottom: 1px solid #e5e7eb; }
            .status-dialog h2 { font-size: 23px; font-weight: 700; line-height: 1.3; }
            .status-dialog-header p { margin-top: 6px; color: #607087; font-size: 14px; overflow-wrap: anywhere; }
            .status-dialog-body { padding: 24px 28px; display: grid; gap: 22px; }
            .status-dialog label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px; }
            .status-dialog input, .status-dialog select { width: 100%; min-width: 0; height: 46px; border: 1px solid #cbd5e1; border-radius: 8px; background: white; color: #263247; font-size: 15px; }
            .status-dialog input:focus, .status-dialog select:focus { outline: 2px solid #4f46e5; outline-offset: 2px; }
            .status-dialog .status-help { font-size: 13px; color: #607087; line-height: 1.6; margin-top: 8px; }
            .status-dialog .status-error { font-size: 13px; color: #b91c1c; margin-top: 6px; }
            .status-dialog .status-dates { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 16px; }
            .status-dialog .status-money { display: flex; align-items: center; gap: 12px; }
            .status-money span { font-weight: 700; color: #607087; }
            .status-dialog-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 18px 28px; background: #f8fafc; border-top: 1px solid #e5e7eb; }
            @media (max-width: 480px) { .status-dialog-header, .status-dialog-body { padding: 20px; } .status-dialog .status-dates { grid-template-columns: minmax(0, 1fr); } .status-dialog-footer { padding: 16px 20px; } }
        </style>
        <dialog x-ref="statusDialog" class="status-dialog" aria-labelledby="status-dialog-title" aria-describedby="status-dialog-description"
                @close="opened = false" @cancel="opened = false">
            <form wire:submit.prevent="update_result">
                <header class="status-dialog-header">
                    <div>
                        <h2 id="status-dialog-title">Update show status</h2>
                        <p id="status-dialog-description">{{ $show->host_fullname() }} · Show #{{ $show->cs_id }}</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-ghost btn-square" aria-label="Close status dialog" wire:click="closeStatusModal" wire:loading.attr="disabled" wire:target="update_result"><i class="las la-times la-lg" aria-hidden="true"></i></button>
                </header>
                <div class="status-dialog-body">
                    <div>
                        <label for="show-status">Status</label>
                        <select id="show-status" wire:model="result" autofocus aria-describedby="status-help" @error('result') aria-invalid="true" @enderror>
                            <option value="For Follow Up">For Follow Up</option>
                            <option value="Booked">Booked</option>
                            <option value="Closed">Closed</option>
                            <option value="Reschedule">Reschedule</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <p id="status-help" class="status-help">@if($result === 'Reschedule') Choose the new date and time for this show.@elseif($result === 'Closed') Saving a closed show creates an order agreement.@elseif($result === 'For Follow Up') This booking will appear in red on the calendar.@else Select the latest outcome for this cooking show.@endif</p>
                        @error('result')<p class="status-error" role="alert">{{ $message }}</p>@enderror
                    </div>
                    @if($result === 'Reschedule')
                        <div class="status-dates" wire:key="reschedule-fields">
                            <div>
                                <label for="show-new-date">New date</label>
                                <input id="show-new-date" type="date" wire:model.defer="date" min="{{ now()->toDateString() }}" required @error('date') aria-invalid="true" @enderror>
                                @error('date')<p class="status-error" role="alert">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="show-new-time">New time</label>
                                <input id="show-new-time" type="time" wire:model.defer="time" required @error('time') aria-invalid="true" @enderror>
                                @error('time')<p class="status-error" role="alert">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    @elseif($result === 'Closed')
                        <div wire:key="amount-field">
                            <label for="show-amount">Amount sold</label>
                            <div class="status-money"><span aria-hidden="true">₱</span><input id="show-amount" type="number" min="0" step="0.01" inputmode="decimal" wire:model.defer="amount_sold" aria-describedby="amount-help" @error('amount_sold') aria-invalid="true" @enderror></div>
                            <p id="amount-help" class="status-help">Total sales in Philippine pesos. Enter 0 if no sale was made.</p>
                            @error('amount_sold')<p class="status-error" role="alert">{{ $message }}</p>@enderror
                        </div>
                    @endif
                </div>
                <footer class="status-dialog-footer">
                    <button type="button" class="btn btn-outline btn-sm" wire:click="closeStatusModal" wire:loading.attr="disabled" wire:target="update_result">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="update_result">
                        <span wire:loading.remove wire:target="update_result">Save changes</span>
                        <span wire:loading wire:target="update_result">Saving…</span>
                    </button>
                </footer>
            </form>
        </dialog>
    </div>
</div>
