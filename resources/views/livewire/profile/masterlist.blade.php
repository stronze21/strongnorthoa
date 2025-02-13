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
            {{-- <label class="my-2 btn btn-sm btn-warning ms-2" for="add_user">New User Account</label> --}}
            <a href="{{ route('lc.create') }}" class="my-2 btn btn-sm btn-warning ms-2">New User Account</a>
            <a href="{{ route('lc.create') }}" class="my-2 btn btn-sm btn-primary ms-2">Register</a>
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
                    <th class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border hover">
                        <td>{{ $user->user_id }}</td>
                        <td class="uppercase whitespace-nowrap">{{ $user->full_name }}<br><span
                                class="text-xs lowercase">{{ $user->email }}</span></td>
                        @if ($user->profile)
                            <td class="whitespace-nowrap">{{ $user->profile->birth_date ?? 'Not Set' }}</td>
                            <td>{{ $user->municipality ? $user->municipality->municipality_name : 'Not Set' }}</td>
                            <td>{{ $user->province ? $user->province->province_name : 'Not Set' }}</td>
                            <td class="whitespace-nowrap">{{ $user->profile->sign_up_date }}</td>
                            <td class="uppercase">
                                {{ $user->profile->builder ? $user->profile->builder->fullname() : '' }}</td>
                            <td class="uppercase">
                                {{ $user->profile->leader ? $user->profile->leader->fullname() : '' }}</td>
                            <td class="uppercase">
                                {{ $user->profile->distrib ? $user->profile->distrib->fullname() : '' }}</td>
                            <td class="whitespace-nowrap">{{ $user->profile->cs_date }}</td>
                            <td class="whitespace-nowrap">{{ $user->profile->amount_invested }}</td>
                            <td>{{ $user->email_verified_at ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $user->cur_level ? $user->cur_level->sspl->level : 'N/A' }}</td>
                            <td class="whitespace-nowrap">
                                {{ $user->cur_level ? $user->cur_level->sspl->date_promoted : 'N/A' }}</td>
                        @else
                            <td colspan="12" class="uppercase text-error">Profile not set</td>
                        @endif
                        <td class="text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="btn btn-sm btn-primary" wire:key='view-lc-{{ $user->user_id }}'
                                    wire:click='view_lc("{{ $user->user_id }}")'><i
                                        class="las la-lg la-eye"></i></button>
                                <label class="btn btn-sm btn-error" for="delete_user"
                                    onclick="select(`{{ $user->user_id }}`, `{{ $user->email }}`)"><i
                                        class="las la-lg la-trash"></i></label>
                            </div>
                        </td>
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

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="delete_user" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Delete User</h3>
            <div class="w-full py-4">
                Are you sure you want to delete this user? [{{ $selected_user_email }}]
            </div>
            <div class="modal-action">
                <label id="close_mod" for="delete_user" class="btn btn-secondary">Cancel</label>
                <button class="btn btn-error" wire:click="delete_user()" onclick="close_mod()">Delete</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function select(user_id, email) {
            @this.set('user_id', user_id);
            @this.set('selected_user_email', email);
        }

        function close_mod() {
            $('#close_mod').click();
        }
    </script>
@endpush
