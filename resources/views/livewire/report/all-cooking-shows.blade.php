<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> Cooking Shows
            </li>
            <li>
                <i class="mr-1 las la-book la-lg"></i> All Shows
            </li>
        </ul>
    </div>
</x-slot>

<div class="shows-index" x-data="{ mode: 'card', filtersOpen: true }" x-init="try { mode = localStorage.getItem('cookingShowsViewMode') || 'card' } catch (e) {}" x-effect="try { localStorage.setItem('cookingShowsViewMode', mode) } catch (e) {}">
    <style>
        .shows-index { max-width: none; padding: 16px 24px 32px; margin: auto; color: #263247; }
        .shows-index .shows-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
        .shows-index h1 { font-size: 25px; font-weight: 700; line-height: 1.25; margin-bottom: 4px; }
        .shows-index .shows-subtitle { font-size: 14px; color: #607087; }
        .shows-index .shows-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .shows-index .date-presets { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-bottom: 10px; }
        .shows-index .date-presets .btn { min-height: 32px; height: 32px; padding: 0 12px; font-size: 12px; }
        .shows-index .filter-panel { background: white; padding: 12px 16px; border-radius: 10px; margin-bottom: 12px; }
        .shows-index .filters-row { display: grid; grid-template-columns: minmax(220px, 2fr) repeat(2, minmax(140px, 1fr)) minmax(150px, 1fr) minmax(100px, .7fr); gap: 12px; }
        .shows-index .filter-item { min-width: 0; }
        .shows-index .label { padding: 0 0 4px; }
        .shows-index .label-text { color: #526078; font-size: 13px; font-weight: 600; }
        .shows-index .input, .shows-index .select { min-height: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 8px; background: white; color: #263247; font-size: 14px; }
        .shows-index .results-toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin: 12px 0 10px; }
        .shows-index .view-switch { display: flex; gap: 4px; padding: 4px; border-radius: 8px; background: #e8edf4; }
        .shows-index .view-switch .btn { border: 0; background: transparent; box-shadow: none; color: #526078; min-height: 32px; height: 32px; }
        .shows-index .view-switch .btn-active { background: white; color: #4338ca; }
        .shows-index .export-buttons { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .shows-index .export-buttons .btn { background: white; font-size: 12px; min-height: 32px; height: 32px; }
        .shows-index .stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; background: white; border-radius: 12px; padding: 0; margin-bottom: 12px; }
        .shows-index .stat { border-radius: 0; box-shadow: none; border-right: 1px solid #e5e7eb; padding: 10px 16px; min-width: 0; display: flex; align-items: center; gap: 12px; }
        .shows-index .stat:last-child { border-right: 0; }
        .shows-index .stat-title { font-size: 13px; color: #526078; }
        .shows-index .stat-value { font-size: 23px; font-weight: 700; color: #263247; }
        .shows-index .stat-figure { display: none; }
        .shows-index .card-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
        .shows-index .show-card { background: white; border-radius: 12px; overflow: hidden; min-width: 0; }
        .shows-index .show-card-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; padding: 12px 16px; border-bottom: 1px solid #edf0f4; }
        .shows-index .show-card-header h3 { font-size: 16px; line-height: 1.5; overflow-wrap: anywhere; }
        .shows-index .show-card-body { padding: 12px 16px; }
        .shows-index .show-card-footer { padding: 8px 16px; border-top: 1px solid #edf0f4; display: flex; justify-content: flex-end; }
        .shows-index .data-row { display: flex; gap: 8px; font-size: 13px; line-height: 1.45; margin-bottom: 6px; overflow-wrap: anywhere; }
        .shows-index .data-row span { min-width: 0; }
        .shows-index .data-row i { color: #607087; width: 18px; flex-shrink: 0; padding-top: 3px; }
        .shows-index .shows-empty { grid-column: 1 / -1; padding: 32px 24px; background: white; border-radius: 12px; text-align: center; }
        .shows-index .shows-empty p { color: #607087; }
        .shows-index .shows-empty h2 { font-size: 20px; font-weight: 700; margin: 12px 0 8px; }
        .shows-index .table { font-size: 13px; }
        .shows-index .table th { text-transform: none; color: #526078; font-size: 12px; background: #f8fafc; }
        .shows-index .table th, .shows-index .table td { padding: 8px 10px; line-height: 1.4; }
        .shows-index .table td:nth-child(2) { min-width: 190px; max-width: 240px; }
        .shows-index .table td:nth-child(7) { white-space: nowrap; }
        .shows-index .badge { box-shadow: none; font-size: 11px; white-space: nowrap; }
        .shows-index .badge-warning { background: #fee2e2; color: #991b1b; border: 0; }
        .shows-index .badge-success { background: #dbeafe; color: #1e40af; border: 0; }
        .shows-index a:focus-visible, .shows-index button:focus-visible, .shows-index input:focus-visible, .shows-index select:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media (max-width: 1100px) { .shows-index .filters-row { grid-template-columns: repeat(2, minmax(0, 1fr)); } .shows-index .filter-item:first-child { grid-column: 1 / -1; } .shows-index .card-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 640px) { .shows-index { padding: 16px 12px 24px; } .shows-index .card-grid { grid-template-columns: minmax(0, 1fr); } .shows-index .filter-panel { padding: 12px; } .shows-index .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .shows-index .stat { padding: 10px 12px; } .shows-index .stat:nth-child(2) { border-right: 0; } .shows-index .stat:nth-child(-n+2) { border-bottom: 1px solid #e5e7eb; } }
    </style>
    <header class="shows-header">
        <div><h1>All Cooking Shows</h1><p class="shows-subtitle">Manage bookings, follow up with hosts, and review show outcomes.</p></div>
        <div class="shows-actions">
            <a href="{{ route('cs.calendar') }}" class="btn btn-sm btn-outline"><i class="las la-calendar-alt" aria-hidden="true"></i> Full Calendar</a>
            @if (Auth::user()->cur_level and Auth::user()->cur_level->sspl)
                <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary"><i class="las la-plus" aria-hidden="true"></i> Add Show</a>
            @endif
        </div>
    </header>
    <!-- Quick date presets -->
    <div class="date-presets">
        <span class="text-sm mr-2">Show dates</span>
        <div class="flex flex-wrap gap-1">
            <button wire:click="setDateRange('today')" class="btn btn-xs">Today</button>
            <button wire:click="setDateRange('this_week')" class="btn btn-xs">This Week</button>
            <button wire:click="setDateRange('this_month')" class="btn btn-xs">This Month</button>
            <button wire:click="setDateRange('last_month')" class="btn btn-xs">Last Month</button>
            <button wire:click="setDateRange('all_time')" class="btn btn-xs">All Time</button>
            <button wire:click="resetFilters" class="btn btn-xs btn-outline">Reset</button>
        </div>
    </div>

    <!-- Filters section -->
    <div class="filter-panel">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-bold">Filters</h3>
            <button type="button" class="btn btn-xs btn-ghost" id="toggle-filters" @click="filtersOpen = !filtersOpen" :aria-expanded="filtersOpen.toString()" aria-controls="filters-container">
                <i class="las la-filter"></i> <span class="hidden sm:inline">Toggle Filters</span>
            </button>
        </div>

        <div id="filters-container" class="filters-row" x-show="filtersOpen">
            <div class="filter-item form-control">
                <label class="label" for="show-search">
                    <span class="label-text">Search</span>
                </label>
                <input id="show-search" type="search" placeholder="Name, Email, Address..." class="w-full input input-bordered input-sm"
                    wire:model.debounce.300ms="search" />
            </div>

            <div class="filter-item form-control">
                <label class="label" for="date-from">
                    <span class="label-text">From Date</span>
                </label>
                <input type="date" id="date-from" class="w-full input input-bordered input-sm"
                    wire:model.lazy="from_date" />
            </div>

            <div class="filter-item form-control">
                <label class="label" for="date-to">
                    <span class="label-text">To Date</span>
                </label>
                <input type="date" id="date-to" class="w-full input input-bordered input-sm"
                    wire:model.lazy="to_date" />
            </div>

            <div class="filter-item form-control">
                <label class="label" for="show-status-filter">
                    <span class="label-text">Status</span>
                </label>
                <select id="show-status-filter" class="w-full text-sm select select-bordered select-sm" wire:model="show_type">
                    <option value="">All</option>
                    <option value="Booked">Booked</option>
                    <option value="Canceled">Cancelled / Canceled</option>
                    <option value="Rescheduled">Rescheduled / Reschedule</option>
                    <option value="Closed">Closed</option>
                    <option value="For Follow Up">For Follow Up</option>
                </select>
            </div>

            <div class="filter-item form-control">
                <label class="label" for="page-size">
                    <span class="label-text">Results Per Page</span>
                </label>
                <select id="page-size" class="w-full text-sm select select-bordered select-sm" wire:model="page_no">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="mb-4 stat-grid">
        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-primary">
                <i class="las la-calendar-check la-2x"></i>
            </div>
            <div class="text-xs stat-title">Booked</div>
            <div class="text-2xl stat-value text-primary">{{ $stats['booked'] }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-success">
                <i class="las la-check-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Closed</div>
            <div class="text-2xl stat-value text-success">{{ $stats['closed'] }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-warning">
                <i class="las la-exclamation-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Follow Up</div>
            <div class="text-2xl stat-value text-warning">{{ $stats['follow_up'] }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-error">
                <i class="las la-times-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Canceled</div>
            <div class="text-2xl stat-value text-error">{{ $stats['canceled'] }}</div>
        </div>
    </div>

    <!-- Loading indicator -->
    <div wire:loading.flex wire:target="search, from_date, to_date, show_type, page_no, setDateRange, resetFilters"
        class="justify-center hidden w-full my-4">
        <div class="loading loading-spinner loading-lg"></div>
    </div>

    <div class="results-toolbar">
        <div><strong>{{ number_format($shows->total()) }} shows</strong><span class="shows-subtitle"> matching your filters</span></div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="export-buttons" aria-label="Export current page">
                <span class="text-xs mr-1">Export this page</span>
                <button type="button" onclick="copyTableToClipboard()" class="btn btn-xs">Copy</button>
                <button type="button" onclick="exportTableToCSV('cooking-shows.csv')" class="btn btn-xs">CSV</button>
                <button type="button" onclick="exportTableToExcel('cooking-shows.xls')" class="btn btn-xs">Excel</button>
                <button type="button" onclick="printTable()" class="btn btn-xs">Print</button>
            </div>
            <div class="view-switch" role="group" aria-label="Results layout">
                <button type="button" id="card-view-btn" class="btn btn-sm" :class="{ 'btn-active': mode === 'card' }" :aria-pressed="(mode === 'card').toString()" @click="mode = 'card'"><i class="las la-th-large" aria-hidden="true"></i> Cards</button>
                <button type="button" id="table-view-btn" class="btn btn-sm" :class="{ 'btn-active': mode === 'table' }" :aria-pressed="(mode === 'table').toString()" @click="mode = 'table'"><i class="las la-table" aria-hidden="true"></i> Table</button>
            </div>
        </div>
    </div>
    <!-- Card View (Default for mobile) -->
    <div id="card-view" class="card-grid" x-show="mode === 'card'">
        @forelse ($shows as $show)
            <div class="show-card bg-base-100">
                <div class="show-card-header">
                    <h3 class="font-bold">{{ $show->host_fullname() }}</h3>
                    <div>{!! $show->current_result() !!}</div>
                </div>
                <div class="show-card-body">
                    <div class="data-row">
                        <i class="las la-calendar"></i>
                        <span>{{ ($show->date ? $show->date->format('F j, Y') : 'Date not set') . ' · ' . ($show->formatted_time ?: 'Time not set') }}</span>
                    </div>
                    <div class="data-row">
                        <i class="las la-map-marker"></i>
                        <span>{{ $show->full_address() }}</span>
                    </div>
                    <div class="data-row">
                        <i class="las la-phone"></i>
                        <span>{{ $show->contact_no }}</span>
                    </div>
                    <div class="data-row">
                        <i class="las la-envelope"></i>
                        <span>{{ $show->host_email }}</span>
                    </div>
                    <div class="data-row">
                        <i class="las la-user"></i>
                        <span>Lifechanger: {{ $show->lifechanger }}</span>
                    </div>
                    @if ($show->partner_id && $show->partner_user)
                        <div class="data-row">
                            <i class="las la-users"></i>
                            <span>Partner: {{ $show->partner_user->fullname() }}</span>
                        </div>
                    @endif
                    <div class="data-row">
                        <i class="las la-chalkboard-teacher"></i>
                        <span>Presenter: {{ $show->presenter }}</span>
                    </div>
                </div>
                <div class="show-card-footer">
                    <div class="flex gap-1">
                        <a href="{{ route('cs.view', $show->cs_id) }}" class="btn btn-sm btn-outline" aria-label="View cooking show details">
                            <i class="las la-eye"></i> View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="shows-empty">
                <i class="mb-2 text-gray-400 las la-calendar-times la-3x"></i>
                <h2>No cooking shows found</h2>
                <p class="mb-4 text-sm text-gray-500">Try changing your filters or adding a new show</p>
                <button wire:click="setDateRange('all_time')" class="btn btn-sm btn-outline">Show All Dates</button>
                <button wire:click="resetFilters" class="btn btn-sm btn-ghost">Reset Filters</button>
            </div>
        @endforelse
    </div>

    <!-- Table View (Hidden on mobile by default) -->
    <div id="table-view" x-show="mode === 'table'" style="display: none;" class="overflow-x-auto bg-white rounded-xl" tabindex="0" role="region" aria-label="Cooking shows table">
        <table id="cooking-shows-table" class="table w-full table-zebra table-compact">
            <thead>
                <tr>
                    <th>Host</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Lifechanger</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Partner</th>
                    <th>Presenter</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shows as $show)
                    <tr class="border hover">
                        <td class="capitalize whitespace-nowrap">{{ $show->host_fullname() }}</td>
                        <td class="text-xs">{{ $show->full_address() }}</td>
                        <td class="whitespace-nowrap">{{ $show->contact_no }}</td>
                        <td class="whitespace-nowrap">{{ $show->host_email }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->lifechanger }}</td>
                        <td class="whitespace-nowrap">
                            {{ ($show->date ? $show->date->format('M j, Y') : 'Date not set') . ' · ' . ($show->formatted_time ?: 'Time not set') }}
                        </td>
                        <td>{{ $show->type }}</td>
                        <td class="capitalize whitespace-nowrap">
                            {{ $show->partner_id && $show->partner_user ? $show->partner_user->fullname() : '—' }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->presenter }}</td>
                        <td class="capitalize whitespace-nowrap">
                            {!! $show->current_result() !!}
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-1">
                                <a href="{{ route('cs.view', $show->cs_id) }}" class="btn btn-sm btn-outline" aria-label="View cooking show details">
                                    <i class="las la-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="11">No record found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $shows->links() }}
    </div>
</div>

@push('scripts')
    <script>
        // Copy table data to clipboard
        function copyTableToClipboard() {
            let tableData = gatherDataForExport();
            let textVersion = tableData.map(row => row.join('\t')).join('\n');

            // Create temporary textarea element
            let textarea = document.createElement('textarea');
            textarea.value = textVersion;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Show toast or alert
            showNotification('Table data copied to clipboard');
        }

        // Export table to CSV
        function exportTableToCSV(filename) {
            let tableData = gatherDataForExport();

            // Convert to CSV format
            let csv = tableData.map(row => {
                return row.map(cell => {
                    // Escape quotes and wrap in quotes
                    return '"' + (cell + '').replace(/"/g, '""') + '"';
                }).join(',');
            }).join('\n');

            // Download CSV file
            downloadFile(csv, filename, 'text/csv');
        }

        // Export table to Excel
        function exportTableToExcel(filename) {
            let tableData = gatherDataForExport();

            // Convert to CSV for Excel
            let csv = tableData.map(row => {
                return row.map(cell => {
                    return '"' + (cell + '').replace(/"/g, '""') + '"';
                }).join(',');
            }).join('\n');

            // Download as xls file
            downloadFile(csv, filename, 'application/vnd.ms-excel');
        }

        // Print table
        function printTable() {
            // Get current view mode
            const isCardView = $('#card-view').is(':visible');

            let contentToPrint;
            let title = 'Cooking Shows Report';

            if (isCardView) {
                // Print card view
                contentToPrint = document.getElementById('card-view').cloneNode(true);
            } else {
                // Print table view
                contentToPrint = document.getElementById('cooking-shows-table').cloneNode(true);
            }

            // Open print window
            let printWindow = window.open('', '_blank');

            printWindow.document.write(`
        <html>
        <head>
            <title>${title}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; margin-bottom: 20px; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .show-card { border: 1px solid #ddd; margin-bottom: 15px; border-radius: 5px; overflow: hidden; }
                .show-card-header { background-color: #f2f2f2; padding: 10px; border-bottom: 1px solid #ddd; }
                .show-card-body { padding: 10px; }
                .data-row { margin-bottom: 5px; }
                @media print {
                    h1 { margin-top: 0; }
                    .btn, button { display: none !important; }
                }
            </style>
        </head>
        <body>
            <h1>${title}</h1>
            <div>${contentToPrint.outerHTML}</div>
            <div style="text-align: center; margin-top: 20px; font-size: 12px;">
                Generated on ${new Date().toLocaleString()}
            </div>
        </body>
        </html>
    `);

            printWindow.document.close();
            printWindow.focus();

            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 250);
        }

        // Gather data for export (works for both card and table view)
        function gatherDataForExport() {
            let tableData = [];
            let headers = [];

            // Check which view is active
            const isCardView = $('#card-view').is(':visible');

            if (isCardView) {
                // For card view, manually extract data
                headers = ['Date', 'Host', 'Address', 'Contact', 'Email', 'Lifechanger', 'Partner', 'Presenter', 'Status'];
                tableData.push(headers);

                // Get all cards
                const cards = document.querySelectorAll('.show-card');
                cards.forEach(card => {
                    let rowData = [];
                    // Date
                    rowData.push(card.querySelector('.data-row:nth-child(1)').textContent.trim());
                    // Host
                    rowData.push(card.querySelector('.show-card-header h3').textContent.trim());
                    // Address
                    rowData.push(card.querySelector('.data-row:nth-child(2)').textContent.trim());
                    // Contact
                    rowData.push(card.querySelector('.data-row:nth-child(3)').textContent.trim());
                    // Email
                    rowData.push(card.querySelector('.data-row:nth-child(4)').textContent.trim());
                    // Lifechanger
                    rowData.push(card.querySelector('.data-row:nth-child(5)').textContent.trim().replace(
                        'Lifechanger: ', ''));
                    // Partner (may not exist)
                    const partnerEl = card.querySelector('.data-row:nth-child(6)');
                    rowData.push(partnerEl && partnerEl.textContent.includes('Partner:') ?
                        partnerEl.textContent.trim().replace('Partner: ', '') : '');
                    // Presenter
                    const presenterIndex = card.querySelector('.data-row:nth-child(6)') &&
                        card.querySelector('.data-row:nth-child(6)').textContent.includes('Partner:') ? 7 : 6;
                    rowData.push(card.querySelector(`.data-row:nth-child(${presenterIndex})`).textContent.trim()
                        .replace('Presenter: ', ''));
                    // Status
                    rowData.push(card.querySelector('.show-card-header div span').textContent.trim());

                    tableData.push(rowData);
                });
            } else {
                // For table view, extract from HTML table
                const table = document.getElementById('cooking-shows-table');

                // Extract headers
                const headerRow = table.querySelector('thead tr');
                const headerCells = headerRow.querySelectorAll('th');
                headerCells.forEach(cell => {
                    headers.push(cell.textContent.trim());
                });
                tableData.push(headers);

                // Extract data rows
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    let rowData = [];
                    const cells = row.querySelectorAll('td');
                    cells.forEach(cell => {
                        rowData.push(cell.textContent.trim());
                    });
                    tableData.push(rowData);
                });
            }

            return tableData;
        }

        // Helper function to download a file
        function downloadFile(content, filename, mimeType) {
            let blob = new Blob([content], {
                type: mimeType
            });
            let link = document.createElement('a');

            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Show a notification
        function showNotification(message) {
            // Check if we can use toast from DaisyUI
            if (typeof window.toast === 'function') {
                window.toast(message);
            } else {
                // Fallback to simple alert
                alert(message);
            }
        }

        // Handle Livewire updates if Livewire is present
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('message.processed', function() {
                // Refresh export buttons
                setupExportButtons();
            });
        }
    </script>
@endpush
