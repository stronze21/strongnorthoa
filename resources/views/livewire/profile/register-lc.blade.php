<x-slot name="header">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumb"><ul>
        <li><a href="{{ route('lc.masterlist') }}">Lifechanger Masterlist</a></li>
        <li aria-current="page">{{ $user_id ? 'Edit Profile' : 'New Profile' }}</li>
    </ul></nav>
</x-slot>

<div class="profile-editor">
    <style>
        .profile-editor { max-width: 1440px; padding: 24px; margin: auto; color: #263247; }
        .profile-editor-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 18px; }
        .profile-editor-header h1 { font-size: 27px; font-weight: 700; line-height: 1.3; margin-bottom: 6px; overflow-wrap: anywhere; }
        .profile-editor-header p { color: #607087; font-size: 13px; }
        .profile-section-nav { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 18px; }
        .profile-section-nav a { padding: 7px 12px; background: #e8edf4; color: #37465c; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .profile-section-nav a:hover { background: #eef2ff; color: #4338ca; }
        .profile-editor .profile-section { background: white; border-radius: 12px; padding: 22px 24px; margin-bottom: 18px; scroll-margin-top: 20px; }
        .profile-editor .profile-section h2 { font-size: 19px; font-weight: 700; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb; }
        .profile-editor .grid { gap: 12px 20px; margin-bottom: 14px; }
        .profile-editor .form-control { min-width: 0; }
        .profile-editor .label { padding: 0 0 6px; }
        .profile-editor .label-text { font-size: 13px; color: #526078; font-weight: 600; }
        .profile-editor .input, .profile-editor .select, .profile-editor .file-input { min-height: 40px; height: 40px; background: white; border: 1px solid #cbd5e1; border-radius: 8px; color: #263247; font-size: 14px; width: 100%; }
        .profile-editor .file-input { font-size: 12px; }
        .profile-editor .table { font-size: 13px; }
        .profile-editor .table th { background: #f8fafc; color: #526078; text-transform: none; font-size: 12px; }
        .profile-editor .table th, .profile-editor .table td { padding: 10px 12px; }
        .profile-editor .table-wrap { overflow-x: auto; margin-bottom: 14px; }
        .profile-editor .table tbody.border, .profile-editor .table thead.border { border: 0; }
        .profile-editor .section-actions { display: flex; justify-content: flex-end; align-items: center; gap: 12px; padding-top: 16px; border-top: 1px solid #edf0f4; margin-top: 16px; }
        .profile-editor .section-actions .btn { min-height: 36px; height: 36px; font-size: 13px; }
        .profile-editor .password-reset { margin-right: auto; background: white; color: #be123c; border: 1px solid #fecdd3; }
        .profile-editor .text-error { color: #b91c1c; }
        .profile-editor a:focus-visible, .profile-editor button:focus-visible, .profile-editor input:focus-visible, .profile-editor select:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media (max-width: 767px) { .profile-editor { padding: 18px 12px 28px; } .profile-editor .profile-section { padding: 18px 16px; } .profile-editor .grid { gap: 14px; } }
    </style>
    <header class="profile-editor-header">
        <div><h1>{{ $user_id ? trim($f_name . ' ' . $m_name . ' ' . $l_name) : 'New Lifechanger' }}</h1><p>Manage personal information and lifechanger records. Fields marked * are required.</p></div>
        <a href="{{ route('lc.masterlist') }}" class="btn btn-sm btn-outline"><i class="las la-arrow-left" aria-hidden="true"></i> Masterlist</a>
    </header>
    <nav class="profile-section-nav" aria-label="Profile sections">
        <a href="#personal-details">Personal details</a><a href="#dependents">Dependents</a><a href="#work-experience">Work experience</a><a href="#references">References</a><a href="#lifechanger-details">Lifechanger details</a>
    </nav>
    <div class="profile-section" id="personal-details">
        <h2>Personal Details</h2>
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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div class="form-control">
                <label class="label" for="profile-f-name">
                    <span class="label-text">First Name<span class="text-xs text-error">*
                            @error('f_name')
                                {{ $message }}
                            @enderror
                        </span></span>
                </label>
                <label class="">
                    <input id="profile-f-name" wire:model.defer="f_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-m-name">
                    <span class="label-text">Middle Name<span class="text-xs text-error">*
                            @error('m_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-m-name" wire:model.defer="m_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-l-name">
                    <span class="label-text">Last Name
                        <span class="text-xs text-error">*
                            @error('l_name')
                                {{ $message }}
                            @enderror
                        </span></span>
                </label>
                <label class="">
                    <input id="profile-l-name" wire:model.defer="l_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-profile-photo">
                    <span class="label-text">Photo
                        <span class="text-xs text-error">*
                            @error('profile_photo')
                                {{ $message }}
                            @enderror
                        </span></span>
                </label>
                <input id="profile-profile-photo" wire:model.defer="profile_photo" type="file"
                    class="w-full file-input file-input-sm file-input-bordered" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label" for="profile-birth-date">
                    <span class="label-text">Date of Birth<span class="text-xs text-error">*
                            @error('birth_date')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-birth-date" wire:model.defer="birth_date" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-birth-place">
                    <span class="label-text">Birthplace
                        <span class="text-xs text-error">
                            @error('birth_place')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-birth-place" wire:model.defer="birth_place" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-occupation">
                    <span class="label-text">Occupation
                        <span class="text-xs text-error">
                            @error('occupation')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-occupation" wire:model.defer="occupation" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label" for="profile-civil-status">
                    <span class="label-text">Civil Status
                        <span class="text-xs text-error">*
                            @error('civil_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select id="profile-civil-status" wire:model.defer="civil_status" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widow/Widower">Widow/Widower</option>
                        <option value="Separated">Separated</option>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-contact-no">
                    <span class="label-text">Contact No
                        <span class="text-xs text-error">*
                            @error('contact_no')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-contact-no" wire:model.defer="contact_no" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-email">
                    <span class="label-text">Email
                        <span class="text-xs text-error">*
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-email" wire:model.defer="email" type="email" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label" for="profile-region-id">
                    <span class="label-text">Region
                        <span class="text-xs text-error">*
                            @error('region_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select id="profile-region-id" wire:model="region_id" class="w-full text-sm select select-sm select-bordered">
                        @foreach ($regions as $region)
                            <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-province-id">
                    <span class="label-text">Province
                        <span class="text-xs text-error">*
                            @error('province_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select id="profile-province-id" wire:model="province_id" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-municipality-id">
                    <span class="label-text">Municipality
                        <span class="text-xs text-error">*
                            @error('municipality_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select id="profile-municipality-id" wire:model="municipality_id" class="w-full text-sm select select-sm select-bordered">
                        <option value=""></option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality->municipality_id }}">
                                {{ $municipality->municipality_name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-address">
                    <span class="label-text">Address
                        <span class="text-xs text-error">*
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-address" wire:model.defer="address" type="text" class="w-full input input-sm input-bordered">
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-tin">
                    <span class="label-text">TIN No.
                        <span class="text-xs text-error">*
                            @error('tin')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-tin" wire:model.defer="tin" type="text" class="w-full input input-sm input-bordered">
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-spouse">
                    <span class="label-text">Name of Spouse (if any):
                        <span class="text-xs text-error">
                            @error('spouse')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-spouse" wire:model.defer="spouse" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="section-actions">

            <button class="btn password-reset" wire:click="reset_password()"
                @if (!$user_id) disabled @endif>Reset Password</button>
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="save" wire:click="save()"><span wire:loading.remove wire:target="save">Save personal details</span><span wire:loading wire:target="save">Saving…</span></button>
        </div>
    </div>
    <div class="profile-section" id="dependents">
        <h2>Name of Children/Dependents</h2>
        <div class="table-wrap">
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
                <label class="label" for="profile-child-name">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('child_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-child-name" wire:model.defer="child_name" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-child-dob">
                    <span class="label-text">Date of Birth
                        <span class="text-xs text-error">*
                            @error('child_dob')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-child-dob" wire:model.defer="child_dob" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-child-school">
                    <span class="label-text">School
                        <span class="text-xs text-error">
                            @error('child_school')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-child-school" wire:model.defer="child_school" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="section-actions">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="add_dependent" wire:click="add_dependent()"
                @if (!$user_id) disabled @endif><span wire:loading.remove wire:target="add_dependent">Add dependent</span><span wire:loading wire:target="add_dependent">Saving…</span></button>
        </div>
    </div>
    <div class="profile-section" id="work-experience">
        <h2>Work Experience</h2>
        <div class="table-wrap">
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
                <label class="label" for="profile-exp-name">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('exp_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-exp-name" wire:model.defer="exp_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-exp-contact">
                    <span class="label-text">Contact
                        <span class="text-xs text-error">*
                            @error('exp_contact')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-exp-contact" wire:model.defer="exp_contact" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-exp-position">
                    <span class="label-text">Position
                        <span class="text-xs text-error">*
                            @error('exp_position')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-exp-position" wire:model.defer="exp_position" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-exp-salary">
                    <span class="label-text">Salary
                        <span class="text-xs text-error">*
                            @error('exp_salary')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-exp-salary" wire:model.defer="exp_salary" type="number" step="0.01"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-exp-from">
                    <span class="label-text">Start Date
                        <span class="text-xs text-error">*
                            @error('exp_from')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-exp-from" wire:model.defer="exp_from" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-exp-to">
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
                    <input id="profile-exp-to" wire:model.defer="exp_to" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="section-actions">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="add_experience" wire:click="add_experience()"
                @if (!$user_id) disabled @endif><span wire:loading.remove wire:target="add_experience">Add experience</span><span wire:loading wire:target="add_experience">Saving…</span></button>
        </div>
    </div>
    <div class="profile-section" id="references">
        <h2>Character References</h2>
        <div class="table-wrap">
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
                <label class="label" for="profile-ref-name">
                    <span class="label-text">Name
                        <span class="text-xs text-error">*
                            @error('ref_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-ref-name" wire:model.defer="ref_name" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-ref-rel">
                    <span class="label-text">Relationship
                        <span class="text-xs text-error">*
                            @error('ref_rel')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-ref-rel" wire:model.defer="ref_rel" type="text" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-ref-contact">
                    <span class="label-text">Contact #
                        <span class="text-xs text-error">*
                            @error('ref_contact')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-ref-contact" wire:model.defer="ref_contact" type="text"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="section-actions">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="add_reference" wire:click="add_reference()"
                @if (!$user_id) disabled @endif><span wire:loading.remove wire:target="add_reference">Add reference</span><span wire:loading wire:target="add_reference">Saving…</span></button>
        </div>
    </div>
    <div class="profile-section" id="lifechanger-details">
        <h2>Lifechanger Profile</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="form-control">
                <label class="label" for="profile-cs-date">
                    <span class="label-text">Date of Cooking Show<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input id="profile-cs-date" wire:model.defer="cs_date" type="date" class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-amount-invested">
                    <span class="label-text">Amount Invested<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input id="profile-amount-invested" wire:model.defer="amount_invested" type="number"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-sign-up-date">
                    <span class="label-text">Sign-up Date<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <input id="profile-sign-up-date" wire:model.defer="sign_up_date" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-team-leader">
                    <span class="label-text">Team Leader<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select id="profile-team-leader" wire:model="team_leader" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}" class="uppercase">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-team-builder">
                    <span class="label-text">Team Builder<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select id="profile-team-builder" wire:model="team_builder" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($lcs as $lc)
                            <option value="{{ $lc->user_id }}" class="uppercase">{{ $lc->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-distributor">
                    <span class="label-text">Distributor<span class="text-xs text-error">*</span></span>
                </label>
                <label class="">
                    <select id="profile-distributor" wire:model="distributor" class="w-full text-sm select select-sm select-bordered">
                        <option value="">N/A</option>
                        @foreach ($distribs as $dis)
                            <option value="{{ $dis->user_id }}">{{ $dis->user->full_name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="section-actions">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="save_profile" wire:click="save_profile()"
                @if (!$user_id) disabled @endif><span wire:loading.remove wire:target="save_profile">Save lifechanger details</span><span wire:loading wire:target="save_profile">Saving…</span></button>
        </div>
        <span class="mt-5 text-2xl font-bold">Promotion History</span>
        <div class="table-wrap">
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
                <label class="label" for="profile-sspl-id">
                    <span class="label-text">Spirit of Success Program Level
                        <span class="text-xs text-error">*
                            @error('sspl_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <select id="profile-sspl-id" wire:model.defer="sspl_id" class="w-full text-sm select select-sm select-bordered">
                        <option value="">Not Set</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label" for="profile-date-promoted">
                    <span class="label-text">Date Promoted
                        <span class="text-xs text-error">*
                            @error('date_promoted')
                                {{ $message }}
                            @enderror
                        </span>
                    </span>
                </label>
                <label class="">
                    <input id="profile-date-promoted" wire:model.defer="date_promoted" type="date"
                        class="w-full input input-sm input-bordered" />
                </label>
            </div>
        </div>
        <div class="section-actions">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="add_promotion" wire:click="add_promotion()"
                @if (!$user_id) disabled @endif><span wire:loading.remove wire:target="add_promotion">Add promotion</span><span wire:loading wire:target="add_promotion">Saving…</span></button>
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
