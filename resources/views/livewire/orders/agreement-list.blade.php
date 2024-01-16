<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Order Agreements') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
            <div class="pb-4">
                <label class="btn btn-primary" for="my-modal-5">Create OA</label>
            </div>
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <table class="table w-full table-compact">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>CS ID</th>
                            <th>Client</th>
                            <th>Contact</th>
                            <th>Consultant</th>
                            <th>Associate</th>
                            <th>Presenter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $oa)
                            <tr wire:key="view-oa-{{ $oa->id }}" wire:click="view_oa({{ $oa->id }})"
                                class="cursor-pointer hover">
                                <td>{{ $oa->date }}</td>
                                <td>{{ $oa->cs_id }}</td>
                                <td>{{ $oa->client }}</td>
                                <td>{{ $oa->contact }}</td>
                                <td>{{ $oa->consultant }}</td>
                                <td>{{ $oa->associate }}</td>
                                <td>{{ $oa->presenter }}</td>
                                <td>
                                    @if ($oa->status == 'Cancelled')
                                        <span class="badge badge-error">{{ $oa->status }}</span>
                                    @elseif ($oa->status == 'Pending')
                                        <span class="badge badge-warning">{{ $oa->status }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $oa->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No record found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="my-modal-5" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">New Order Agreement</h3>
            <div class="w-full py-4">

                <div class="w-full mb-2 form-control">
                    <span>Select Cooking Show</span>
                    <label class="w-full input-group">
                        <select class="w-full max-w-xs select-bordered select" wire:model='cs_id'>
                            <option></option>
                            @foreach ($bookings as $show)
                                <option value="{{ $show->cs_id }}">{{ $show->date }} - {{ $show->host }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline btn-error" wire:click="$set('cs_id', null)">X</button>
                    </label>
                </div>

                <label class="mb-3 h3">Cooking Show Details</label>
                <div class="mb-3 form-control">
                    <label class="label">
                        <span class="label-text">Date</span>
                    </label>
                    <label class="input-group">
                        <span>Date</span>
                        <input type="date" wire:model="oa_date" class="input input-bordered" />
                    </label>
                    @error('oa_date')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <label class="h4">Client Details</label>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Name</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_client" />
                    </label>
                    @error('oa_client')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Address</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_address" />
                    </label>
                    @error('oa_address')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-3 form-control">
                    <label class="input-group">
                        <span>Contact</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_contact" />
                    </label>
                    @error('oa_contact')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <label class="h4">Lifechangers Involved</label>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Consultant</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_consultant" />
                    </label>
                    @error('oa_consultant')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Associate</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_associate" />
                    </label>
                    @error('oa_associate')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Presenter</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_presenter" />
                    </label>
                    @error('oa_presenter')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Team Builder</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_team_builder" />
                    </label>
                    @error('oa_team_builder')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Distributor</span>
                        <input type="text" class="w-full input input-bordered" wire:model="oa_distributor" />
                    </label>
                    @error('oa_distributor')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-action">
                <label for="my-modal-5" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="save">Submit</button>
            </div>
        </div>
    </div>
</div>
