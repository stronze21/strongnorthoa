<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> Cooking Shows
            </li>
            <li>
                <i class="mr-1 las la-book la-lg"></i> Booked/Canceled/Rescheduled
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col px-3 py-5 mx-auto">
    <div class="flex justify-between">
        <div>
            @if (Auth::user()->cur_level and Auth::user()->cur_level->sspl)
                <a href="{{ route('cs.add') }}" class="btn btn-sm btn-primary">Add Cooking Show</a>
            @endif
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
                    <td class="w-min">Date</td>
                    <th class="w-min">Type</th>
                    <th class="w-3/12">Host</th>
                    <th class="w-3/12">Address</th>
                    <th class="w-min">Contact No</th>
                    <th class="w-min">Host Email</th>
                    <th class="w-2/12">Lifechanger</th>
                    <th class="w-2/12">Partner</th>
                    <th class="w-2/12">Presenter</th>
                    <th class="w-min">Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shows as $show)
                    <tr onclick="window.location='{{ route('cs.view', $show->cs_id) }}'"
                        class="border cursor-pointer hover">
                        <td> {{ date('M j, Y gA', strtotime($show->date . ' ' . $show->time)) }}</td>
                        <td>{{ $show->type }}</td>
                        <td class="capitalize">{{ $show->host_fullname() }}</td>
                        <td class="text-xs capitalize">{{ $show->full_address() }}</td>
                        <td>{{ $show->contact_no }}</td>
                        <td>{{ $show->host_email }}</td>
                        <td class="capitalize">{{ $show->lifechanger }}</td>
                        <td class="capitalize">{{ $show->partner_id ? $show->partner_user->fullname() : '' }}</td>
                        <td class="capitalize">{{ $show->presenter }}</td>
                        <td class="capitalize">{!! $show->current_result() !!}</td>
                    </tr>
                @empty
                    <tr>
                        <th class="text-center" colspan="9">No record found!</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $shows->links() }}
        </div>
    </div>
</div>
