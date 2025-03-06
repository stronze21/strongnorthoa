<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-users la-lg"></i> Lifechanger Masterlist
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col px-3 py-5 mx-auto ">
    <div class="flex justify-between">
        <div>
            {{-- <label class="my-2 btn btn-sm btn-warning ms-2" for="add_user">New User Account</label> --}}
            <a href="{{ route('lc.create') }}" class="my-2 btn btn-sm btn-warning ms-2">New User Account</a>
        </div>
        <div class="flex space-x-2">
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span><i class="las la-search"></i></span>
                    <input type="text" placeholder="Search" class="input input-bordered input-sm"
                        wire:model.lazy="search" />
                </label>
            </div>
            <!-- Filter Button -->
            <button class="btn btn-sm btn-secondary" wire:click="$set('showFilters', true)">
                <i class="las la-filter"></i> Filter
            </button>

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


            <!-- Print and Export Buttons -->
            <div class="space-x-2">
                <button class="btn btn-sm btn-primary" onclick="printTable()">Print</button>
                <button class="btn btn-sm btn-success" onclick="exportTableToExcel('printableTable')">Export to
                    Excel</button>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center w-full p-5 mt-2 overflow-x-auto bg-white rounded-md">

        <!-- Table -->
        <div class="mt-4 overflow-x-auto">
            <table class="table w-full table-sm" id="printableTable">
                <thead>
                    <tr>
                        @if ($columns['id'])
                            <th>ID</th>
                        @endif
                        @if ($columns['lifechanger'])
                            <th>Lifechanger</th>
                        @endif
                        @if ($columns['birthdate'])
                            <th>Birthdate</th>
                        @endif
                        @if ($columns['town'])
                            <th>Town/City</th>
                        @endif
                        @if ($columns['province'])
                            <th>Province</th>
                        @endif
                        @if ($columns['signup_date'])
                            <th>Sign Up Date</th>
                        @endif
                        @if ($columns['team_builder'])
                            <th>Team Builder</th>
                        @endif
                        @if ($columns['team_leader'])
                            <th>Team Leader</th>
                        @endif
                        @if ($columns['distributor'])
                            <th>Distributor</th>
                        @endif
                        @if ($columns['date_time_show'])
                            <th>Date Time of Show</th>
                        @endif
                        @if ($columns['amount_invested'])
                            <th>Amount Invested</th>
                        @endif
                        @if ($columns['status'])
                            <th>Status</th>
                        @endif
                        @if ($columns['current_level'])
                            <th>Current Level</th>
                        @endif
                        @if ($columns['date_promoted'])
                            <th>Date Promoted</th>
                        @endif
                        @if ($columns['actions'])
                            <th class="text-end">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @if ($columns['id'])
                                <td>{{ $user->user_id }}</td>
                            @endif
                            @if ($columns['lifechanger'])
                                <td>{{ $user->full_name }}</td>
                            @endif
                            @if ($columns['birthdate'])
                                <td>{{ $user->birthdate }}</td>
                            @endif
                            @if ($columns['town'])
                                <td>{{ $user->municipality->municipality_name ?? '' }}</td>
                            @endif
                            @if ($columns['province'])
                                <td>{{ $user->municipality->province->province_name ?? '' }}</td>
                            @endif
                            @if ($user->profile)
                                @if ($columns['signup_date'])
                                    <td>{{ $user->created_at }}</td>
                                @endif
                                @if ($columns['team_builder'])
                                    <td>{{ $user->team_builder }}</td>
                                @endif
                                @if ($columns['team_leader'])
                                    <td>{{ $user->team_leader }}</td>
                                @endif
                                @if ($columns['distributor'])
                                    <td>{{ $user->distributor }}</td>
                                @endif
                                @if ($columns['date_time_show'])
                                    <td>{{ $user->date_time_show }}</td>
                                @endif
                                @if ($columns['amount_invested'])
                                    <td>{{ $user->amount_invested }}</td>
                                @endif
                                @if ($columns['status'])
                                    <td>{{ $user->status }}</td>
                                @endif
                                @if ($columns['current_level'])
                                    <td>{{ $user->cur_level->sspl->level ?? '' }}</td>
                                @endif
                                @if ($columns['date_promoted'])
                                    <td>{{ $user->cur_level->date_promoted ?? '' }}</td>
                                @endif
                            @else
                                <td colspan="9" class="uppercase text-error">Profile not set</td>
                            @endif

                            @if ($columns['actions'])
                                <td class="text-end">
                                    <div class="flex justify-end space-x-2">
                                        @if ($user->cur_level and $user->profile->builder)
                                            <a class="btn btn-sm btn-secondary"
                                                wire:key='view-lc-form-{{ $user->user_id }}'
                                                href="{{ route('lc.assoc.form', $user->user_id) }}"><i
                                                    class="las la-lg la-file-pdf"></i></a>
                                        @endif
                                        <button class="btn btn-sm btn-primary" wire:key='view-lc-{{ $user->user_id }}'
                                            wire:click='view_lc("{{ $user->user_id }}")'><i
                                                class="las la-lg la-eye"></i></button>
                                        <label class="btn btn-sm btn-error" for="delete_user"
                                            onclick="select(`{{ $user->user_id }}`, `{{ $user->email }}`)"><i
                                                class="las la-lg la-trash"></i></label>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
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

        <!-- Filter Modal -->
        <x-modal wire:model.defer="showFilters">
            <x-slot name="title">Filter Users</x-slot>

            <div class="space-y-4">

                <!-- Province Filter -->
                <div>
                    <label class="label">Province</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model="filters.province">
                        <option value="">All</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Municipality/Town Filter (Populates based on selected province) -->
                <div>
                    <label class="label">Town/City</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model="filters.town"
                        @if (empty($towns)) disabled @endif>
                        <option value="">All</option>
                        @foreach ($towns as $town)
                            <option value="{{ $town->municipality_id }}">{{ $town->municipality_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Status</label>
                    <select class="w-full text-sm select select-bordered select-sm" wire:model.defer="filters.status">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="label">Current Level</label>
                    <input type="text" class="w-full input input-bordered input-sm"
                        wire:model.defer="filters.current_level">
                </div>
            </div>

            <x-slot name="footer">
                <button class="btn btn-sm" wire:click="$set('showFilters', false)">Close</button>
                <button class="btn btn-sm btn-error" wire:click="resetFilters">Reset</button>
                <button class="btn btn-sm btn-primary" wire:click="applyFilters">Apply</button>
            </x-slot>
        </x-modal>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>

        <script>
            function select(user_id, email) {
                @this.set('user_id', user_id);
                @this.set('selected_user_email', email);
            }

            function close_mod() {
                $('#close_mod').click();
            }

            function printTable() {
                var printContents = document.getElementById("printableTable").outerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = "<html><head><title>Print</title></head><body>" + printContents + "</body></html>";
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }

            function exportTableToExcel(tableId) {
                var wb = XLSX.utils.table_to_book(document.getElementById(tableId), {
                    sheet: "Users"
                });
                XLSX.writeFile(wb, "users_export.xlsx");
            }
        </script>
    @endpush
