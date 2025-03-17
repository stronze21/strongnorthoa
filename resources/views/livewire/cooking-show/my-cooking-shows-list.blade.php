<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> My Cooking Shows
            </li>
            <li>
                <i class="mr-1 las la-book la-lg"></i> Dashboard
            </li>
        </ul>
    </div>
</x-slot>

@push('head')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Custom mobile-first styles */
        .filters-row {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .filter-item {
            width: 100%;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .show-card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .show-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .show-card-body {
            padding: 0.75rem;
        }

        .show-card-footer {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem 0.75rem;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .data-row {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            display: flex;
        }

        .data-row i {
            width: 1.5rem;
            color: #6c757d;
        }

        .export-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-bottom: 0.5rem;
        }

        /* Desktop optimizations */
        @media (min-width: 768px) {
            .filters-row {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .filter-item {
                width: auto;
            }

            .stat-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .table-container {
                display: block;
            }
        }
    </style>
@endpush

<div class="px-2 py-3 mx-auto md:px-4">
    <!-- Action bar -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
        <!-- Left side - Action buttons -->
        <div>
            <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary">
                <i class="las la-plus"></i> <span class="hidden sm:inline">Add Show</span>
            </a>
        </div>

        <!-- Right side - View toggle -->
        <div class="btn-group btn-group-sm">
            <button id="card-view-btn" class="btn btn-active">
                <i class="las la-th-large"></i> <span class="hidden sm:inline">Cards</span>
            </button>
            <button id="table-view-btn" class="btn">
                <i class="las la-table"></i> <span class="hidden sm:inline">Table</span>
            </button>
        </div>
    </div>

    <!-- Quick date presets -->
    <div class="mb-3">
        <label class="block mb-1 text-sm font-bold">Quick date range:</label>
        <div class="flex flex-wrap gap-1">
            <button wire:click="$refresh" class="btn btn-xs">Today</button>
            <button wire:click="$refresh" class="btn btn-xs">This Week</button>
            <button wire:click="$refresh" class="btn btn-xs">This Month</button>
            <button wire:click="$refresh" class="btn btn-xs">Last Month</button>
            <button wire:click="$refresh" class="btn btn-xs btn-outline">Reset</button>
        </div>
    </div>

    <!-- Filters section -->
    <div class="p-3 mb-4 rounded-lg bg-base-200">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-bold">Filters</h3>
            <button class="btn btn-xs" id="toggle-filters">
                <i class="las la-filter"></i> <span class="hidden sm:inline">Toggle Filters</span>
            </button>
        </div>

        <div id="filters-container" class="filters-row">
            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">Search</span>
                </label>
                <input type="text" placeholder="Name, Address..." class="w-full input input-bordered input-sm"
                    wire:model.debounce.300ms="search" />
            </div>

            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select class="w-full text-sm select select-bordered select-sm" wire:model="statusFilter">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">Contest</span>
                </label>
                <select class="w-full text-sm select select-bordered select-sm" wire:model="contestFilter">
                    <option value="">All Contests</option>
                    @foreach ($contests as $contest)
                        <option value="{{ $contest->id }}">{{ $contest->title }}</option>
                    @endforeach
                </select>
            </div>


            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">From Date</span>
                </label>
                <input type="date" id="date-from" class="w-full input input-bordered input-sm"
                    wire:model.lazy="from_date" />
            </div>

            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">To Date</span>
                </label>
                <input type="date" id="date-to" class="w-full input input-bordered input-sm"
                    wire:model.lazy="to_date" />
            </div>

            <div class="filter-item form-control">
                <label class="label">
                    <span class="label-text">Results Per Page</span>
                </label>
                <select class="w-full text-sm select select-bordered select-sm" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Export buttons -->
    <div class="mb-3">
        <label class="block mb-1 text-sm font-bold">Export options:</label>
        <div id="export-buttons" class="export-buttons">
            <!-- Export buttons will be inserted here by JavaScript -->
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="mb-4 stat-grid">
        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-primary">
                <i class="las la-calendar-check la-2x"></i>
            </div>
            <div class="text-xs stat-title">Booked</div>
            <div class="text-2xl stat-value text-primary">{{ $cookingShows->where('result', 'Booked')->count() }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-success">
                <i class="las la-check-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Closed</div>
            <div class="text-2xl stat-value text-success">{{ $cookingShows->where('result', 'Closed')->count() }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-warning">
                <i class="las la-exclamation-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Follow Up</div>
            <div class="text-2xl stat-value text-warning">
                {{ $cookingShows->where('result', 'For Follow Up')->count() }}</div>
        </div>

        <div class="p-3 rounded-lg shadow-md stat bg-base-100">
            <div class="stat-figure text-error">
                <i class="las la-times-circle la-2x"></i>
            </div>
            <div class="text-xs stat-title">Cancelled</div>
            <div class="text-2xl stat-value text-error">{{ $cookingShows->where('result', 'Cancelled')->count() }}
            </div>
        </div>
    </div>

    <!-- Loading indicator -->
    <div wire:loading.flex wire:target="search, statusFilter, contestFilter, dateRange, perPage, sortBy"
        class="justify-center hidden w-full my-4">
        <div class="loading loading-spinner loading-lg"></div>
    </div>

    <!-- Card View (Default for mobile) -->
    <div id="card-view" class="space-y-4">
        @forelse ($cookingShows as $show)
            <div class="show-card bg-base-100">
                <div class="show-card-header">
                    <h3 class="font-bold">{{ $show->host_fullname() }}</h3>
                    <div>{!! $show->current_result() !!}</div>
                </div>
                <div class="show-card-body">
                    <div class="data-row">
                        <i class="las la-calendar"></i>
                        <span>{{ $show->date->format('F j, Y') . ' ' . $show->time->format('h:i a') }}</span>
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
                    @if ($show->partner_id)
                        <div class="data-row">
                            <i class="las la-users"></i>
                            <span>Partner: {{ $show->partner_user ? $show->partner_user->fullname() : '' }}</span>
                        </div>
                    @endif
                    <div class="data-row">
                        <i class="las la-chalkboard-teacher"></i>
                        <span>Presenter: {{ $show->presenter }}</span>
                    </div>
                    @if ($show->contest)
                        <div class="data-row">
                            <i class="las la-trophy"></i>
                            <span>Contest: {{ $show->contest->title }}</span>
                        </div>
                    @endif
                </div>
                <div class="show-card-footer">
                    <div class="flex gap-1">
                        <a href="{{ route('cs.view', $show->cs_id) }}" class="btn btn-xs btn-info">
                            <i class="las la-eye"></i> View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center rounded-lg shadow bg-base-100">
                <i class="mb-2 text-gray-400 las la-calendar-times la-3x"></i>
                <p class="mb-2 text-lg">No cooking shows found</p>
                <p class="mb-4 text-sm text-gray-500">Try changing your filters or adding a new show</p>
                <button wire:click="$refresh" class="btn btn-sm btn-ghost">Reset Filters</button>
            </div>
        @endforelse
    </div>

    <!-- Table View (Hidden on mobile by default) -->
    <div id="table-view" class="hidden overflow-x-auto bg-white rounded-md shadow-lg">
        <table id="cooking-shows-table" class="table w-full table-zebra table-compact">
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
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th class="cursor-pointer" wire:click="sortBy('date')">
                        Date
                        @if ($sortField === 'date')
                            <span class="ml-1">
                                @if ($sortDirection === 'asc')
                                    &#8593;
                                @else
                                    &#8595;
                                @endif
                            </span>
                        @endif
                    </th>
                    <th>Presenter</th>
                    <th>Contest</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cookingShows as $show)
                    <tr class="border hover">
                        <td class="capitalize whitespace-nowrap">{{ $show->host_fullname() }}</td>
                        <td class="text-xs">{{ $show->full_address() }}</td>
                        <td class="whitespace-nowrap">{{ $show->contact_no }}</td>
                        <td class="whitespace-nowrap">{{ $show->host_email }}</td>
                        <td>{{ $show->type }}</td>
                        <td class="whitespace-nowrap">
                            {{ $show->date->format('M j, Y') . ' ' . $show->time->format('h:i a') }}
                        </td>
                        <td class="capitalize whitespace-nowrap">{{ $show->presenter }}</td>
                        <td>
                            @if ($show->contest)
                                <div class="badge badge-primary">{{ $show->contest->title }}</div>
                            @else
                                <div class="badge badge-ghost">None</div>
                            @endif
                        </td>
                        <td class="capitalize whitespace-nowrap">
                            {!! $show->current_result() !!}
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-1">
                                <a href="{{ route('cs.view', $show->cs_id) }}" class="btn btn-xs btn-info">
                                    <i class="las la-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="10">No cooking shows found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $cookingShows->links() }}
    </div>

    <div class="flex justify-between mt-4 text-sm text-gray-600">
        <div class="text-left">
            <select wire:model="perPage" class="text-sm select select-bordered select-sm">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        <div class="text-right">
            Showing {{ $cookingShows->firstItem() ?? 0 }} to {{ $cookingShows->lastItem() ?? 0 }} of
            {{ $cookingShows->total() }} cooking shows
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Wait for document ready
        document.addEventListener('DOMContentLoaded', function() {
            // Set up view toggling
            setupViewToggle();

            // Set up export buttons manually
            setupExportButtons();

            // Set up toggle filters functionality
            $('#toggle-filters').on('click', function() {
                $('#filters-container').slideToggle();
            });
        });

        // Toggle between table and card views
        function setupViewToggle() {
            $('#table-view-btn').on('click', function() {
                $(this).addClass('btn-active');
                $('#card-view-btn').removeClass('btn-active');
                $('#table-view').show();
                $('#card-view').hide();
                localStorage.setItem('myCookingShowsViewMode', 'table');
            });

            $('#card-view-btn').on('click', function() {
                $(this).addClass('btn-active');
                $('#table-view-btn').removeClass('btn-active');
                $('#table-view').hide();
                $('#card-view').show();
                localStorage.setItem('myCookingShowsViewMode', 'card');
            });

            // Check if user has a saved preference
            const savedViewMode = localStorage.getItem('myCookingShowsViewMode');
            if (savedViewMode === 'table') {
                $('#table-view-btn').click();
            }
        }

        // Set up manual export buttons
        function setupExportButtons() {
            // Clear existing buttons
            $('#export-buttons').empty();

            // Add copy button
            $('<button class="btn btn-xs"><i class="las la-copy"></i> Copy</button>')
                .appendTo('#export-buttons')
                .on('click', function() {
                    copyTableToClipboard();
                });

            // Add CSV button
            $('<button class="btn btn-xs"><i class="las la-file-csv"></i> CSV</button>')
                .appendTo('#export-buttons')
                .on('click', function() {
                    exportTableToCSV('my-cooking-shows.csv');
                });

            // Add Excel button
            $('<button class="btn btn-xs"><i class="las la-file-excel"></i> Excel</button>')
                .appendTo('#export-buttons')
                .on('click', function() {
                    exportTableToExcel('my-cooking-shows.xls');
                });

            // Add Print button
            $('<button class="btn btn-xs"><i class="las la-print"></i> Print</button>')
                .appendTo('#export-buttons')
                .on('click', function() {
                    printTable();
                });
        }

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
            let title = 'My Cooking Shows Report';

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
                headers = ['Date', 'Host', 'Address', 'Contact', 'Email', 'Lifechanger', 'Partner', 'Presenter', 'Contest',
                    'Status'
                ];
                tableData.push(headers);

                // Get all cards
                const cards = document.querySelectorAll('.show-card');
                cards.forEach(card => {
                    let rowData = [];

                    // Extract text content, ignoring the icons
                    const getTextContent = (selector) => {
                        const el = card.querySelector(selector);
                        return el ? el.textContent.trim().replace(/^\s*[\r\n]/gm, '') : '';
                    };

                    // Date
                    rowData.push(getTextContent('.data-row:nth-child(1) span'));
                    // Host
                    rowData.push(getTextContent('.show-card-header h3'));
                    // Address
                    rowData.push(getTextContent('.data-row:nth-child(2) span'));
                    // Contact
                    rowData.push(getTextContent('.data-row:nth-child(3) span'));
                    // Email
                    rowData.push(getTextContent('.data-row:nth-child(4) span'));
                    // Lifechanger
                    rowData.push(getTextContent('.data-row:nth-child(5) span').replace('Lifechanger: ', ''));

                    // Partner (may not exist)
                    const partnerEl = card.querySelector('.data-row:nth-child(6)');
                    rowData.push(partnerEl && partnerEl.textContent.includes('Partner:') ?
                        partnerEl.textContent.trim().replace('Partner: ', '') : '');

                    // Figure out the index for presenter
                    const presenterIndex = card.querySelector('.data-row:nth-child(6)') &&
                        card.querySelector('.data-row:nth-child(6)').textContent.includes('Partner:') ? 7 : 6;
                    rowData.push(getTextContent(`.data-row:nth-child(${presenterIndex}) span`).replace(
                        'Presenter: ', ''));

                    // Contest (may not exist)
                    const contestEl = card.querySelector('.data-row:nth-child(8)') ||
                        (presenterIndex === 7 ? card.querySelector('.data-row:nth-child(8)') : card.querySelector(
                            '.data-row:nth-child(7)'));
                    rowData.push(contestEl && contestEl.textContent.includes('Contest:') ?
                        contestEl.textContent.trim().replace('Contest: ', '') : '');

                    // Status
                    rowData.push(getTextContent('.show-card-header div span'));

                    tableData.push(rowData);
                });
            } else {
                // For table view, extract from HTML table
                const table = document.getElementById('cooking-shows-table');

                // Extract headers
                const headerRow = table.querySelector('thead tr');
                const headerCells = headerRow.querySelectorAll('th');
                headerCells.forEach(cell => {
                    // Remove sort indicators
                    let headerText = cell.textContent.replace(/[↑↓]/, '').trim();
                    headers.push(headerText);
                });
                tableData.push(headers);

                // Extract data rows
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    let rowData = [];
                    const cells = row.querySelectorAll('td');
                    cells.forEach((cell, index) => {
                        // Skip the actions column
                        if (index < cells.length - 1) {
                            rowData.push(cell.textContent.trim());
                        }
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
