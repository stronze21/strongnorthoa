<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> Cooking Shows
            </li>
            <li>
                <i class="mr-1 las la-plus la-lg"></i> Add Cooking Show
            </li>
        </ul>
    </div>
</x-slot>


<div class="flex flex-col max-w-6xl px-3 py-5 mx-auto mt-5 bg-white rounded-lg">

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
                <span class="label-text">Date<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="date" type="date" min="{{ date('Y-m-d') }}"
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Time<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="time" type="time" value="{{ date('H:i') }}"
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Show type<span class="text-error">*</span></span>
            </label>
            <select wire:model.defer="type" class="text-sm select select-sm select-bordered">
                <option value="Face to Face">Face to Face</option>
                <option value="Virtual">Virtual</option>
            </select>
        </div>
        <div class="col-span-3 mb-3">
            <hr>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="form-control">
            <label class="label">
                <span class="label-text">First Name of Host<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="host" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Last Name of Host<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="host_surename" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Spouse First Name</span>
            </label>
            <label class="">
                <input wire:model.defer="spouse" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Address Line 1<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="address" type="text" class="w-full input input-sm input-bordered">
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Address Line 2</span>
            </label>
            <label class="">
                <input wire:model.defer="address_2" type="text" class="w-full input input-sm input-bordered">
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="form-control">
            <label class="label">
                <span class="label-text">City/Town<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="city_town" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Province<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="province" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Host Contact No<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="contact_no" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Host Occupation<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="occupation" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Host Email<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="host_email" type="email" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Name of Host on Social Media<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="social_media" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="col-span-2">
            <hr>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Lifechanger<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="lifechanger" type="text" class="w-full input input-sm input-bordered"
                    readonly />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Partner<span class="text-error">*</span></span>
            </label>
            <label class="">
                <select wire:model.defer="partner_id" class="w-full text-sm select select-bordered select-sm">
                    <option value="">N/A</option>
                    @foreach ($partners as $partner)
                        <option value="{{ $partner->user_id }}">
                            {{ $partner->fullname() . ' [' . $partner->cur_level->sspl->level . ']' }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Presenter<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="presenter" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Team Builder<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="team_builder" type="text" class="w-full input input-sm input-bordered"
                    readonly />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Distributor<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="distributor" type="text" class="w-full input input-sm input-bordered"
                    readonly />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Spirit of Success Program Level<span class="text-error">*</span></span>
            </label>
            <label class="">
                <select wire:model.defer="sspl" class="w-full select select-bordered" readonly disabled>
                    <option value="0">Not Set</option>
                    <option value="Associate">Associate</option>
                    <option value="Consultant">Consultant</option>
                    <option value="Senior Consultant">Senior Consultant</option>
                    <option value="Distributor">Distributor</option>
                </select>
            </label>
        </div>
    </div>
    <div class="flex justify-center mt-3">
        <button class="btn btn-primary" wire:click="save()" wire:loading.attr='disabled'>Submit</button>
    </div>
</div>
