<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> Cooking Shows
            </li>
            <li>
                <i class="mr-1 las la-book la-lg"></i> Cooked Shows
            </li>
        </ul>
    </div>
</x-slot>

@push('head')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
@endpush

<div class="flex flex-col px-3 py-5 mx-auto">
    <div class="flex justify-between">
        <div>
            @if (Auth::user()->cur_level and Auth::user()->cur_level->sspl)
                <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary">Add Cooking Show</a>
            @endif
        </div>
        <div class="flex space-x-3">
            <button onclick="ExportToExcel('xlsx')" class="btn btn-sm btn-info"><i class="las la-lg la-file-excel"></i>
                Export</button>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>Items per page</span>
                    <select class="text-sm select select-bordered select-sm" wire:model="page_no">
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="60">60</option>
                        <option value="80">80</option>
                        <option value="100">100</option>
                        <option value="999">All</option>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>From</span>
                    <input type="date" class="input input-bordered input-sm" wire:model.lazy="from_date" />
                </label>
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span>To</span>
                    <input type="date" class="input input-bordered input-sm" wire:model.lazy="to_date" />
                </label>
            </div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span><i class="las la-search"></i></span>
                    <input type="text" placeholder="Search" class="input input-bordered input-sm"
                        wire:model.lazy="search" />
                </label>
            </div>

            <!-- Column Toggle Dropdown -->
            <div class="relative dropdown dropdown-end">
                <label tabindex="0" class="btn btn-sm btn-secondary">Columns</label>
                <ul tabindex="0"
                    class="z-50 p-2 bg-white border border-gray-300 rounded-lg shadow dropdown-content menu w-52">
                    @foreach ($columns as $key => $visible)
                        <li class="px-2 py-1">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" class="checkbox checkbox-sm"
                                    wire:model="columns.{{ $key }}">
                                <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center w-full p-5 mt-2 overflow-x-auto bg-white rounded-md">
        <table class="table w-full table-compact table-zebra table-bordered" id="table">
            <thead>
                <tr>
                    @if ($columns['date'])
                        <td>Date</td>
                    @endif
                    @if ($columns['type'])
                        <th>Type</th>
                    @endif
                    @if ($columns['host'])
                        <th>Host</th>
                    @endif
                    @if ($columns['address'])
                        <th>Address</th>
                    @endif
                    @if ($columns['contact_no'])
                        <th>Contact No</th>
                    @endif
                    @if ($columns['host_email'])
                        <th>Host Email</th>
                    @endif
                    @if ($columns['lifechanger'])
                        <th>Lifechanger</th>
                    @endif
                    @if ($columns['partner'])
                        <th>Partner</th>
                    @endif
                    @if ($columns['presenter'])
                        <th>Presenter</th>
                    @endif
                    @if ($columns['result'])
                        <th>Result</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($shows as $show)
                    <tr onclick="window.location='{{ route('cs.view', $show->cs_id) }}'"
                        class="border cursor-pointer hover">
                        @if ($columns['date'])
                            <td class="whitespace-nowrap">
                                {{ date('M j, Y gA', strtotime($show->date . ' ' . $show->time)) }}</td>
                        @endif
                        @if ($columns['type'])
                            <td>{{ $show->type }}</td>
                        @endif
                        @if ($columns['host'])
                            <td class="capitalize whitespace-nowrap">{{ $show->host_fullname() }}</td>
                        @endif
                        @if ($columns['address'])
                            <td class="text-xs capitalize">{{ $show->full_address() }}</td>
                        @endif
                        @if ($columns['contact_no'])
                            <td class="whitespace-nowrap">{{ $show->contact_no }}</td>
                        @endif
                        @if ($columns['host_email'])
                            <td class="whitespace-nowrap">{{ $show->host_email }}</td>
                        @endif
                        @if ($columns['lifechanger'])
                            <td class="capitalize whitespace-nowrap">{{ $show->lifechanger }}</td>
                        @endif
                        @if ($columns['partner'])
                            <td class="capitalize whitespace-nowrap">
                                {{ $show->partner_id ? $show->partner_user->fullname() : '' }}</td>
                        @endif
                        @if ($columns['presenter'])
                            <td class="capitalize whitespace-nowrap">{{ $show->presenter }}</td>
                        @endif
                        @if ($columns['result'])
                            <td class="capitalize whitespace-nowrap">{!! $show->current_result() !!}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <th class="text-center" colspan="9">No record found!{{ auth()->user()->user_id }}</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $page_no == 999 ? '' : $shows->links() }}
        </div>
    </div>
</div>


@push('scripts')
    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('table');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('export.' + (type || 'xlsx')));
        }
    </script>
@endpush
