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

<div class="flex flex-col px-3 py-5 mx-auto ">
    <div class="flex justify-between">
        <div>
            <label class="my-2 btn btn-sm btn-warning ms-2" for="add_user">New User Account</label>
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
                    <tr class="border cursor-pointer hover" wire:key='view-lc-{{ $user->user_id }}'
                        wire:click='view_lc("{{ $user->user_id }}")'>
                        <td>{{ $user->user_id }}</td>
                        <td class="capitalize">{{ $user->full_name }}</td>
                        @if ($user->profile)
                            <td>{{ $user->profile->birth_date ?? 'Not Set' }}</td>
                            <td>{{ $user->municipality ? $user->municipality->municipality_name : 'Not Set' }}</td>
                            <td>{{ $user->province ? $user->province->province_name : 'Not Set' }}</td>
                            <td>{{ $user->profile->sign_up_date }}</td>
                            <td>{{ $user->profile->builder ? $user->profile->builder->fullname() : '' }}</td>
                            <td>{{ $user->profile->leader ? $user->profile->leader->fullname() : '' }}</td>
                            <td>{{ $user->profile->distrib ? $user->profile->distrib->fullname() : '' }}</td>
                            <td>{{ $user->profile->cs_date }}</td>
                            <td>{{ $user->profile->amount_invested }}</td>
                            <td>{{ $user->email_verified_at ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $user->cur_level ? $user->cur_level->sspl->level : 'N/A' }}</td>
                            <td>{{ $user->cur_level ? $user->cur_level->sspl->date_promoted : 'N/A' }}</td>
                        @else
                            <td colspan="12" class="uppercase text-error">Profile not set</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <th class="text-center" colspan="9">No record found!</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $users->links() }}
        </div>
    </div>


    {{-- ADD User MODAL --}}

    <input type="checkbox" id="add_user" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <label for="add_user" class="absolute btn btn-sm btn-circle right-4 top-4">✕</label>
            <h3 class="text-lg font-bold">Add New User</h3>
            <div class="w-full py-4">
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>First Name</span>
                        <input type="text" class="w-full input input-bordered" wire:model="f_name" />
                    </label>
                </div>
                @error('f_name')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>
            <div class="w-full py-4">
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Middle Name</span>
                        <input type="text" class="w-full input input-bordered" wire:model="m_name" />
                    </label>
                </div>
                @error('m_name')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>
            <div class="w-full py-4">
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Last Name</span>
                        <input type="text" class="w-full input input-bordered" wire:model="l_name" />
                    </label>
                </div>
                @error('l_name')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>
            <div class="w-full py-4">
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Email</span>
                        <input type="email" class="w-full input input-bordered" wire:model="email" />
                    </label>
                </div>
                @error('email')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>
            <div class="modal-action">
                <label for="add_gift" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="save_user()">Submit</button>
            </div>
        </div>
    </div>
</div>
