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
        </div>
    </div>
    <div class="flex flex-col justify-center w-full p-5 mt-2 overflow-x-auto bg-white rounded-md">
        <table class="table w-full table-compact table-zebra table-bordered" id="table">
            <thead>
                <tr>
                    <td>Date</td>
                    <th>Type</th>
                    <th>Host</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Host Email</th>
                    <th>Lifechanger</th>
                    <th>Presenter</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shows as $show)
                    <tr onclick="window.location='{{ route('cs.view', $show->cs_id) }}'"
                        class="border cursor-pointer hover">
                        <td class="whitespace-nowrap">
                            {{ date('M j, Y gA', strtotime($show->date . ' ' . $show->time)) }}</td>
                        <td>{{ $show->type }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->host_fullname() }}</td>
                        <td class="text-xs capitalize">{{ $show->full_address() }}</td>
                        <td class="whitespace-nowrap">{{ $show->contact_no }}</td>
                        <td class="whitespace-nowrap">{{ $show->host_email }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->lifechanger }}</td>
                        <td class="capitalize whitespace-nowrap">{{ $show->presenter }}</td>
                        <td class="capitalize whitespace-nowrap">{!! $show->current_result() !!}</td>
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
