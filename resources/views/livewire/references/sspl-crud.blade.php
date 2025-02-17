<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Manage SSPLs</h2>
        <button class="btn btn-primary" wire:click="create">New SSPL</button>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>SSPL</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sspls as $lvl)
                <tr>
                    <td>{{ $lvl->id }}</td>
                    <td>{{ $lvl->level }}</td>
                    <td>{{ ucfirst($lvl->type) }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="edit({{ $lvl->id }})">Edit</button>
                        <button class="btn btn-error btn-sm" wire:click="delete({{ $lvl->id }})"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
            <div class="p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-bold">{{ $ssplId ? 'Edit SSPL' : 'Create SSPL' }}</h2>
                <label class="block mb-2">SSPL Name</label>
                <input type="text" wire:model="sspl" class="w-full mb-3 input input-bordered">
                @error('sspl')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <label class="block mb-2">Type</label>
                <select wire:model="type" class="w-full mb-3 select select-bordered">
                    <option value="">Select Type</option>
                    <option value="lifechanger">Lifechanger</option>
                    <option value="partner">Partner</option>
                </select>
                @error('type')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <div class="flex justify-end mt-4 space-x-2">
                    <button class="btn" wire:click="closeModal">Cancel</button>
                    <button class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    @endif
</div>
