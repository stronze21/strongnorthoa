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
            <a href="{{route('cs.add')}}" class="btn btn-sm btn-primary">Add Cooking Show</a>
        </div>
        <div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span><i class="las la-search"></i></span>
                    <input type="text" placeholder="Search" class="input input-bordered input-sm" wire:model.lazy="search" />
                </label>
              </div>
        </div>
    </div>
    <div class="flex flex-col justify-center w-full mt-2 overflow-x-auto">
        <table class="table w-full table-zebra table-bordered table-compact">
            <thead>
                <tr>
                    <td>ID</td>
                    <th>Lifechanger</th>
                    <th>Birthdate</th>
                    <th>Town/City</th>
                    <th>Province</th>
                    <th>Sign Up Date</th>
                    <th>Team Builder</th>
                    <th>Team Leader</th>
                    <th>Distributor</th>
                    <th>Date Time of Show</th>
                    <th>Amount Invested</th>
                    <th>Status</th>
                    <th>Current Level</th>
                    <th>Date Promoted</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border cursor-pointer hover">
                        <td>{{$user->user_id}}</td>
                        <td class="capitalize">{{$user->full_name}}</td>
                        <td>{{$user->birth_date ?? 'Not Set'}}</td>
                        <td>{{$user->municipality ? $user->municipality->municipality_name : 'Not Set'}}</td>
                        <td>{{$user->province ? $user->province->province_name : 'Not Set'}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
            {{$users->links()}}
        </div>
      </div>
</div>
