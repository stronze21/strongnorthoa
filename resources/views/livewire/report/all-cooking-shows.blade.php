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

@push('head')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
@endpush

<div class="flex flex-col px-3 py-5 mx-auto">
    <div class="flex justify-between mb-4">
        <div>
            @if (Auth::user()->cur_level and Auth::user()->cur_level->sspl)
                <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary">Add Cooking Show</a>
            @endif
        </div>
        <div class="flex space-x-3">
            <div id="export-buttons" class="flex space-x-2">
                <!-- Export buttons will be inserted here by DataTables -->
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>From</span>
                    <input type="date" id="date-from" class="input input-bordered input-sm"
                        wire:model.lazy="from_date" />
                </label>
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>To</span>
                    <input type="date" id="date-to" class="input input-bordered input-sm"
                        wire:model.lazy="to_date" />
                </label>
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>Show</span>
                    <select id="show-type-filter" class="text-sm select select-bordered select-sm">
                        <option value="">All Types</option>
                        <option value="Booked">Booked</option>
                        <option value="Canceled">Canceled</option>
                        <option value="Rescheduled">Rescheduled</option>
                        <option value="Closed">Closed</option>
                        <option value="For Follow Up">For Follow Up</option>
                    </select>
                </label>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center w-full p-5 mt-2 overflow-x-auto bg-white rounded-md">
        <table id="cooking-shows-table" class="table w-full table-zebra table-bordered table-compact">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Host</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Host Email</th>
                    <th>Lifechanger</th>
                    <th>Partner</th>
                    <th>Presenter</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shows as $show)
                    <tr data-href="{{ route('cs.view', $show->cs_id) }}" class="border cursor-pointer hover">
                        <td class="whitespace-nowrap">
                            {{ date('M j, Y gA', strtotime($show->date . ' ' . $show->time)) }}</td>
                        <td>{{ $show->type }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->host_fullname() }}</td>
                        <td class="text-xs capitalize">{{ $show->full_address() }}</td>
                        <td class="whitespace-nowrap">{{ $show->contact_no }}</td>
                        <td class="whitespace-nowrap">{{ $show->host_email }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->lifechanger }}</td>
                        <td class="capitalize whitespace-nowrap">
                            {{ $show->partner_id ? $show->partner_user->fullname() : '' }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->presenter }}</td>
                        <td class="capitalize whitespace-nowrap" data-result="{{ $show->result }}">
                            {!! $show->current_result() !!}</td>
                    </tr>
                @empty
                    <tr>
                        <th class="text-center" colspan="10">No record found!</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            // Initialize DataTable with advanced features
            var table = $('#cooking-shows-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="las la-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="las la-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="las la-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="las la-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="las la-print"></i> Print'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-sm btn-secondary',
                        text: 'Columns'
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 25,
                "orderCellsTop": true,
                "fixedHeader": true,
                "responsive": true
            });

            // Move export buttons to custom div
            table.buttons().container().appendTo('#export-buttons');

            // Make rows clickable to view details
            $('#cooking-shows-table tbody').on('click', 'tr', function() {
                window.location = $(this).data('href');
            });

            // Custom date range filter
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var fromDate = $('#date-from').val();
                    var toDate = $('#date-to').val();

                    if (!fromDate && !toDate) {
                        return true;
                    }

                    var dateString = data[0]; // Get date from first column
                    var dateParts = dateString.split(',');
                    var month = dateParts[0].split(' ')[0];
                    var day = dateParts[0].split(' ')[1];
                    var year = dateParts[1].trim().split(' ')[0];

                    // Convert to YYYY-MM-DD format for comparison
                    var months = {
                        'Jan': '01',
                        'Feb': '02',
                        'Mar': '03',
                        'Apr': '04',
                        'May': '05',
                        'Jun': '06',
                        'Jul': '07',
                        'Aug': '08',
                        'Sep': '09',
                        'Oct': '10',
                        'Nov': '11',
                        'Dec': '12'
                    };

                    var dateValue = year + '-' + months[month] + '-' + day.padStart(2, '0');

                    if (fromDate && toDate) {
                        return dateValue >= fromDate && dateValue <= toDate;
                    } else if (fromDate) {
                        return dateValue >= fromDate;
                    } else if (toDate) {
                        return dateValue <= toDate;
                    }

                    return true;
                }
            );

            // Show type filter
            $('#show-type-filter').on('change', function() {
                var type = $(this).val();

                if (type === '') {
                    table.column(9).search('').draw(); // Clear filter
                } else {
                    table.column(9).search(type).draw();
                }
            });

            // Apply filters when date inputs change
            $('#date-from, #date-to').on('change', function() {
                table.draw();
            });

            // Initialize Livewire hooks to refresh DataTable when Livewire updates
            document.addEventListener('livewire:update', function() {
                table.clear().rows.add($('#cooking-shows-table tbody tr')).draw();
            });
        });
    </script>
@endscript
