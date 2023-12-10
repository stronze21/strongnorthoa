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
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-3xl font-bold">Personal Details</span>
        @if ($errors->any())
            <div class="mb-3 rounded-lg shadow-lg alert alert-error">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">First Name<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="f_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Middle Name<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="m_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Last Name</span>
                </label>
                <label class="">
                    <input wire:model.defer="l_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Birth<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="birth_date" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Birthplace<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="birth_place" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Occupation<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="occupation" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Civil Status<span class="text-error">*</span></span>
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
                    <span class="label-text">Contact No<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="contact_no" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="email" type="email" class="w-full input input-sm input-bordered"
                        readonly />
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Region<span class="text-error">*</span></span>
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
                    <span class="label-text">Province<span class="text-error">*</span></span>
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
                    <span class="label-text">Municipality<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="municipality_id" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality->municipality_id }}">{{ $municipality->municipality_name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Address<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="address" type="text" class="w-full input input-sm input-bordered">
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Contact No<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="contact_no" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="email" type="email" class="w-full input input-sm input-bordered"
                        readonly />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="save()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-3xl font-bold">Name of Children/Dependents</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>School</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($dependents as $dependent)
                        <tr>
                            <td>{{ $dependent->name }}</td>
                            <td>{{ $dependent->birth_date }}</td>
                            <td>{{ $dependent->age() }}</td>
                            <td>{{ $dependent->school }}</td>
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
                    <span class="label-text">Name<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="child_name" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Birth<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="child_dob" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">School<span class="text-error">*</span></span>
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
        <span class="text-3xl font-bold">Work Experience</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Inclusive Dates</th>
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
                    <span class="label-text">Name<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Contact</span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_contact" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Position<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_position" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Salary<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_salary" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Start Date<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="exp_from" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">End Date <span class="text-xs text-error">Defaults to "present" if not
                            set.</span></span>
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
        <span class="text-3xl font-bold">Character References</span>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="child_name" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Date of Birth<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="child_dob" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">School<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <input wire:model.defer="child_school" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_reference()">Save</button>
        </div>
    </div>
    <div class="flex flex-col w-full px-3 py-5 mx-auto mt-5 bg-white rounded-lg">
        <span class="text-3xl font-bold">Lifechanger Profile</span>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Spirit of Success Program Level<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model.defer="sspl" class="w-full text-sm select select-sm select-bordered">
                        <option value="">Not Set</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Team Builder<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="team_builder" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}" class="uppercase">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Distributor<span class="text-error">*</span></span>
                </label>
                <label class="">
                    <select wire:model="distributor" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" wire:click="add_dependent()">Save</button>
        </div>
    </div>
</div>
