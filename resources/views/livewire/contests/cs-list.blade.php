<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-project-diagram la-lg"></i> Contests
            </li>
            <li>
                List
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col px-3 py-5 mx-auto">
    <div class="flex justify-between">
        <div>
            <a href="{{ route('contests.create') }}" class="btn btn-sm btn-primary">New Contest</a>
        </div>
        <div>
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
        <table class="table w-full table-zebra table-bordered table-compact">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th class="text-end">Required Shows</th>
                    <th class="text-end">Required Sales</th>
                    <th class="text-end">Required Set Sold</th>
                    <th class="text-end">Start Date</th>
                    <th class="text-end">End Date</th>
                    <th class="text-center">Strict</th>
                    <th class="text-center">Restriction</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                    <tr wire:click="viewContest({{ $row->id }})" class="cursor-pointer">
                        <td class="text-uppercase">{{ $row->serial() }}</td>
                        <td class="text-uppercase">{{ $row->title }}</td>
                        <td>{{ $row->description }}</td>
                        <td class="text-end">{{ $row->shows }}</td>
                        <td class="text-end">{{ number_format($row->sales, 2) }}</td>
                        <td class="text-end">{{ number_format($row->sets, 2) }}</td>
                        <td class="text-end">{{ \Carbon\Carbon::create($row->start_date)->format('M d, Y') }}</td>
                        <td class="text-end">{{ \Carbon\Carbon::create($row->end_date)->format('M d, Y') }}</td>
                        <td class="text-center">{{ $row->strict === 0 ? 'No' : 'Yes' }}</td>
                        <td class="uppercase">{{ $row->restriction }}
                            {{ $row->restriction == 'level' ? ': ' . $row->sspl->level : '' }}
                        </td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <th class="text-center" colspan="9">No record found!</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $data->links() }}
        </div>
    </div>
</div>


@push('scripts')
    <script>
        function showCreate() {
            Livewire.emit('showCreate')
        }
    </script>
@endpush
