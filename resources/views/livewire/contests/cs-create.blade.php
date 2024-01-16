<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-project-diagram la-lg"></i> Contests
            </li>
            <li>
                <i class="mr-1 las la-plus la-lg"></i> Add Contest
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

    <div class="grid grid-cols-1 gap-3 md:grid-cols-1">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Title<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="title" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Description<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="description" type="text" class="w-full input input-sm input-bordered" />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Start Date<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="start_date" type="date" min="{{ date('Y-m-d') }}"
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">End Date<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="end_date" type="date" min="{{ date('Y-m-d') }}"
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Shows<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="shows" type="number" step='1'
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Sales<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="sales" type="number" step='0.01'
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Sets<span class="text-error">*</span></span>
            </label>
            <label class="">
                <input wire:model.defer="sets" type="number" step='0.01'
                    class="w-full input input-sm input-bordered" />
            </label>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Strict? <span class="text-xs">(If "YES", points used in this contest do not
                        share/overlap with other contest/s.)</span><span class="text-error">*</span></span>
            </label>
            <select wire:model.defer="strict" class="text-sm select select-sm select-bordered">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Level <span class="text-xs">(If "OPEN", all levels are included.)</span><span
                        class="text-error">*</span></span>
            </label>
            <select wire:model="level_restriction" class="text-sm select select-sm select-bordered">
                <option value="open">--Open--</option>
                <option value="specific">--Specify Lifechanger/s--</option>
                <option value="tb">--For Team Builders--</option>
                @foreach ($sspls as $sspl)
                    <option value="{{ $sspl->id }}">{{ $sspl->level }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="{{ $level_restriction == 'specific' ? '' : 'hidden' }}">
        <div class="transition-all form-control" wire:ignore>
            <label class="label">
                <span class="label-text">Lifechanger<span class="text-error">*</span></span>
            </label>
            <select id="lifechangers" class="text-sm select select2 select-sm select-bordered" multiple>
                <option></option>
                @foreach ($lcs as $lc)
                    <option value="{{ $lc->user_id }}">{{ $lc->fullname() }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex justify-center mt-3">
        <button class="btn btn-primary" wire:click="save()">Submit</button>
    </div>
</div>

@push('scripts')
    <script>
        $('.select2').select2({
            width: 'resolve',
        });

        $('#lifechangers').on('change', function() {
            @this.set('lifechangers', $('#lifechangers').select2('val'));
        })
    </script>
@endpush
