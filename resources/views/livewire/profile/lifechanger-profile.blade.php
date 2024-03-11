<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li>
                <i class="mr-1 las la-user la-lg"></i> Lifechanger Profile
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col mx-auto space-x-0 max-w-screen-2xl">
    @if ($user->profile)
        <div class="flex justify-end mt-5">
            <a class="btn btn-sm btn-primary" href="{{ route('lc.assoc.form', $user->user_id) }}" target="_blank">Preview
                Associate
                Form</a>
        </div>
    @endif
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-2xl font-bold">Personal Details</span>
        {{-- @if ($errors->any())
            <div class="mb-3 rounded-lg shadow-lg alert alert-error">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        @endif --}}

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">First Name<span class="text-xs text-error">*
                            @error('f_name')
                                {{ $message }}
                            @enderror
                        </span></span>
                </label>
                <label class="">
                    <input wire:model.defer="f_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Middle Name<span class="text-xs text-error">*
                            @error('m_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="m_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Last Name
                        <span class="text-xs text-error">*
                            @error('l_name')
                                {{ $message }}
                            @enderror
                        </span></span>
                </label>
                <label class="">
                    <input wire:model.defer="l_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Birth<span class="text-xs text-error">*
                            @error('birth_date')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="birth_date" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Birthplace
                        <span class="text-xs text-error">
                            @error('birth_place')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="birth_place" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Occupation
                        <span class="text-xs text-error">
                            @error('occupation')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="occupation" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Civil Status
                        <span class="text-xs text-error">*
                            @error('civil_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select wire:model.defer="civil_status" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widow/Widower">Widow/Widower</option>
                        <option value="Separated">Separated</option>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Contact No
                        <span class="text-xs text-error">*
                            @error('contact_no')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="contact_no" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email
                        <span class="text-xs text-error">*
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="email" type="email" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Region
                        <span class="text-xs text-error">*
                            @error('region_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select wire:model="region_id" class="w-full text-sm select select-sm select-bordered">
                        @foreach ($regions as $region)
                            <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Province
                        <span class="text-xs text-error">*
                            @error('province_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select wire:model="province_id" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Municipality
                        <span class="text-xs text-error">*
                            @error('municipality_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select wire:model="municipality_id" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality->municipality_id }}">
                                {{ $municipality->municipality_name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Address
                        <span class="text-xs text-error">*
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="address" type="text" class="w-full input input-sm input-bordered">
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name of Spouse (if any):
                        <span class="text-xs text-error">
                            @error('spouse')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="spouse" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-between mt-4">
            <button class="mr-2 btn btn-error" wire:click="reset_password()">Reset Password</button>
            <button class="btn btn-primary" wire:click="save()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-2xl font-bold">Name of Children/Dependents</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>School</th>
                        <th class="text-center">Update/Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($dependents as $dependent)
                        <tr>
                            <td>{{ $dependent->name }}</td>
                            <td>{{ $dependent->birth_date }}</td>
                            <td>{{ $dependent->age() }}</td>
                            <td>{{ $dependent->school }}</td>
                            <td class="text-center"><a class="btn btn-xs btn-warning"
                                    onclick="update_child(`{{ $dependent->id }}`, `{{ $dependent->name }}`, `{{ $dependent->birth_date }}`, `{{ $dependent->school }}`)"><i
                                        class="las la-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No record found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('child_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="child_name" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Birth
                        <span class="text-xs text-error">*
                            @error('child_dob')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="child_dob" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">School
                        <span class="text-xs text-error">
                            @error('child_school')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="child_school" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_dependent()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-2xl font-bold">Work Experience</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Inclusive Dates</th>
                        <th class="text-center">Update/Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($works as $work)
                        <tr>
                            <td>{{ $work->name }}</td>
                            <td>{{ $work->contact }}</td>
                            <td>{{ $work->position }}</td>
                            <td>{{ number_format($work->salary, 2) }}</td>
                            <td>{{ $work->from_date . ' - ' . ($date->to_date ?? 'present') }}</td>
                            <td class="text-center"><a class="btn btn-xs btn-warning"
                                    onclick="update_experience(`{{ $work->id }}`, `{{ $work->name }}`, `{{ $work->contact }}`, `{{ $work->position }}`, `{{ $work->salary }}`, `{{ $work->from_date }}`, `{{ $work->to_date ?? null }}`)"><i
                                        class="las la-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No record found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('exp_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Contact
                        <span class="text-xs text-error">*
                            @error('exp_contact')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_contact" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Position
                        <span class="text-xs text-error">*
                            @error('exp_position')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_position" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Salary
                        <span class="text-xs text-error">*
                            @error('exp_salary')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_salary" type="number" step="0.01"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Start Date
                        <span class="text-xs text-error">*
                            @error('exp_from')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_from" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">End Date <span class="text-xs text-error">Defaults to "present" if not
                            set.</span>
                        <span class="text-xs text-error">
                            @error('exp_to')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_to" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_experience()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-2xl font-bold">Character References</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Contact</th>
                        <th class="text-center">Update/Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($references as $reference)
                        <tr>
                            <td>{{ $reference->name }}</td>
                            <td>{{ $reference->relationship }}</td>
                            <td>{{ $reference->contact }}</td>
                            <td class="text-center"><a class="btn btn-xs btn-warning"
                                    onclick="update_reference(`{{ $reference->id }}`, `{{ $reference->name }}`, `{{ $reference->relationship }}`, `{{ $reference->contact }}`)"><i
                                        class="las la-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No record found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('ref_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="ref_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Relationship
                        <span class="text-xs text-error">*
                            @error('ref_rel')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="ref_rel" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Contact #
                        <span class="text-xs text-error">*
                            @error('ref_contact')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="ref_contact" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_reference()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-2xl font-bold">Lifechanger Profile</span>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Cooking Show<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="cs_date" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Amount Invested<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="amount_invested" type="number"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Sign-up Date<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="sign_up_date" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Team Leader<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="team_leader" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}" class="uppercase">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Team Builder<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="team_builder" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}" class="uppercase">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Distributor<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="distributor" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($distribs as $dis)
                            <option value="{{ $dis->user_id }}">{{ $dis->user->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="save_profile()">Save</button>
        </div>
        <span class="mt-5 text-2xl font-bold">Promotion History</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Level</th>
                        <th>Date Promoted</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->sspl->level }}</td>
                            <td>{{ $promotion->date_promoted }}</td>
                            <td class="text-center"><a class="btn btn-xs btn-warning"
                                    onclick="delete_history(`{{ $promotion->id }}`, `{{ $promotion->sspl->level }}`)"><i
                                        class="las la-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No record found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Spirit of Success Program Level
                        <span class="text-xs text-error">*
                            @error('sspl_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select wire:model.defer="sspl_id" class="w-full text-sm select select-sm select-bordered">
                        <option value="">Not Set</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date Promoted
                        <span class="text-xs text-error">*
                            @error('date_promoted')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input wire:model.defer="date_promoted" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_promotion()">Save</button>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        function update_child(id, name, dob, school) {
            Swal.fire({
                title: '<h5> Update Dependent </h5>',
                html: `<div class="text-left">
                            <label for="name" class="label-text">Name</label>
                            <input id="name" type="text" class="w-full input input-sm input-bordered" value="` + name + `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="dob" class="label-text">Date of Birth</label>
                            <input id="dob" type="date" class="w-full input input-sm input-bordered" value="` + dob + `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="school" class="label-text">School</label>
                            <input id="school" type="text" class="w-full input input-sm input-bordered" value="` +
                    school + `" required>
                        </div>`,
                showCancelButton: true,
                confirmButtonText: `Save`,
                showDenyButton: true,
                denyButtonText: `Delete`,
                didOpen: () => {}
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const new_child_name = Swal.getHtmlContainer().querySelector('#name')
                    const new_child_dob = Swal.getHtmlContainer().querySelector('#dob')
                    const new_child_school = Swal.getHtmlContainer().querySelector('#school')
                    @this.set('child_name', new_child_name.value);
                    @this.set('child_dob', new_child_dob.value);
                    @this.set('child_school', new_child_school.value);

                    Livewire.emit('update_child', id)
                } else if (result.isDenied) {
                    Livewire.emit('remove_child', id)
                }
            });
        }

        function update_experience(id, name, contact, position, salary, start_date, end_date = null) {
            Swal.fire({
                title: '<h5> Update Dependent </h5>',
                html: `<div class="text-left">
                            <label for="name" class="label-text">Name</label>
                            <input id="work_name" type="text" class="w-full input input-sm input-bordered" value="` +
                    name +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="contact" class="label-text">Contact</label>
                            <input id="work_contact" type="text" class="w-full input input-sm input-bordered" value="` +
                    contact +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="position" class="label-text">Position</label>
                            <input id="work_position" type="text" class="w-full input input-sm input-bordered" value="` +
                    position + `" required>
                        </div>
                        <div class="text-left">
                            <label for="salary" class="label-text">Salary</label>
                            <input id="work_salary" type="text" class="w-full input input-sm input-bordered" value="` +
                    salary +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="start_date" class="label-text">Start Date</label>
                            <input id="work_start_date" type="date" class="w-full input input-sm input-bordered" value="` +
                    start_date +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="end_date" class="label-text">End Date</label>
                            <input id="work_end_date" type="text" class="w-full input input-sm input-bordered" required>
                        </div>`,
                showCancelButton: true,
                confirmButtonText: `Save`,
                showDenyButton: true,
                denyButtonText: `Delete`,
                didOpen: () => {}
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const new_name = Swal.getHtmlContainer().querySelector('#work_name')
                    const new_contact = Swal.getHtmlContainer().querySelector('#work_contact')
                    const new_position = Swal.getHtmlContainer().querySelector('#work_position')
                    const new_salary = Swal.getHtmlContainer().querySelector('#work_salary')
                    const new_start_date = Swal.getHtmlContainer().querySelector('#work_start_date')
                    const new_end_date = Swal.getHtmlContainer().querySelector('#work_end_date')
                    @this.set('exp_name', new_name.value);
                    @this.set('exp_contact', new_contact.value);
                    @this.set('exp_position', new_position.value);
                    @this.set('exp_salary', new_salary.value);
                    @this.set('exp_from', new_start_date.value);
                    @this.set('exp_to', new_end_date.value);

                    Livewire.emit('update_experience', id)
                } else if (result.isDenied) {
                    Livewire.emit('remove_experience', id)
                }
            });
        }

        function update_reference(id, name, relationship, contact) {
            Swal.fire({
                title: '<h5> Update Character Reference </h5>',
                html: `<div class="text-left">
                            <label for="new_ref_name" class="label-text">Name</label>
                            <input id="new_ref_name" type="text" class="w-full input input-sm input-bordered" value="` +
                    name +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="new_ref_rel" class="label-text">Relationship</label>
                            <input id="new_ref_rel" type="text" class="w-full input input-sm input-bordered" value="` +
                    relationship +
                    `" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="new_ref_contact" class="label-text">Contact</label>
                            <input id="new_ref_contact" type="text" class="w-full input input-sm input-bordered" value="` +
                    contact + `" required>
                        </div>`,
                showCancelButton: true,
                confirmButtonText: `Save`,
                showDenyButton: true,
                denyButtonText: `Delete`,
                didOpen: () => {}
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const new_ref_name = Swal.getHtmlContainer().querySelector('#new_ref_name')
                    const new_ref_rel = Swal.getHtmlContainer().querySelector('#new_ref_rel')
                    const new_ref_contact = Swal.getHtmlContainer().querySelector('#new_ref_contact')
                    @this.set('ref_name', new_ref_name.value);
                    @this.set('ref_rel', new_ref_rel.value);
                    @this.set('ref_contact', new_ref_contact.value);

                    Livewire.emit('update_reference', id)
                } else if (result.isDenied) {
                    Livewire.emit('remove_reference', id)
                }
            });
        }

        function delete_history(id, sspl) {
            Swal.fire({
                title: '<h5> Delete Promotion History: ' + sspl + ' </h5>',
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: `Delete`,
                didOpen: () => {}
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isDenied) {
                    Livewire.emit('delete_history', id)
                }
            });
        }
    </script>
@endpush
