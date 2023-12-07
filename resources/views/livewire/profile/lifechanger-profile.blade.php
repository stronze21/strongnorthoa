<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li>
                <i class="mr-1 las la-user la-lg"></i> Lifechanger Profile
            </li>
        </ul>
    </div>
</x-slot>


<div class="flex flex-col max-w-6xl px-3 py-5 mx-auto mt-5 bg-white rounded-lg">

    @if ($errors->any())
        <div class="mb-3 rounded-lg shadow-lg alert alert-error">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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
              <input wire:model.defer="f_name" type="text" class="w-full input input-sm input-bordered" readonly />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
              <span class="label-text">Middle Name<span class="text-error">*</span></span>
            </label>
            <label class="">
              <input wire:model.defer="m_name" type="text" class="w-full input input-sm input-bordered" readonly />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
              <span class="label-text">Last Name</span>
            </label>
            <label class="">
              <input wire:model.defer="l_name" type="text" class="w-full input input-sm input-bordered" readonly />
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
                    <option value="{{ $municipality->municipality_id }}">{{ $municipality->municipality_name }}</option>
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
              <input wire:model.defer="contact_no" type="text" class="w-full input input-sm input-bordered" />
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
        <div class="form-control">
            <label class="label">
              <span class="label-text">Email<span class="text-error">*</span></span>
            </label>
            <label class="">
              <input wire:model.defer="email" type="email" class="w-full input input-sm input-bordered" readonly />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
              <span class="label-text">Spirit of Success Program Level<span class="text-error">*</span></span>
            </label>
            <label class="">
                <select wire:model.defer="sspl" class="w-full text-sm select select-sm select-bordered">
                    <option value="">Not Set</option>
                    <option value="Associate">Associate</option>
                    <option value="Consultant">Consultant</option>
                    <option value="Senior Consultant">Senior Consultant</option>
                    <option value="Distributor">Distributor</option>
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
    <div class="flex justify-center mt-4">
        <button class="btn btn-primary" wire:click="save()">Submit</button>
    </div>
</div>
