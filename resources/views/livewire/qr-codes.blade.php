<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-qrcode la-lg"></i> QR Codes
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col px-3 py-5 mx-auto">
    <div class="flex justify-between">
        <div>
            <a onclick="new_qr()" class="btn btn-sm btn-primary">Create QR Code</a>
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
                    <th>Date Created</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>QR</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($qrs as $qr)
                    <tr>
                        <td> {{ date('M j, Y gA', strtotime($qr->created_at)) }}</td>
                        <td>{{ $qr->title }}</td>
                        <td>{{ $qr->content }}</td>
                        <td> <img
                                src="data:image/png;base64,{{ base64_encode(
                                    QrCode::format('png')->eyeColor(2, 237, 41, 57, 225, 48, 57)->style('dot')->eye('circle')->generate($qr->code),
                                ) }}"
                                alt="QR Code">
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
            {{ $qrs->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function new_qr() {
            Swal.fire({
                title: '<h5> Create New QR Code </h5>',
                html: `<div class="text-left">
                            <label for="title" class="label-text">Title</label>
                            <input id="title" type="text" class="w-full input input-sm input-bordered" required>
                        </div>
                        <div class="mt-3 text-left">
                            <label for="content" class="label-text">Content/Link</label>
                            <input id="content" type="text" class="w-full input input-sm input-bordered" required>
                        </div>`,
                showCancelButton: true,
                confirmButtonText: `Save`,
                showDenyButton: true,
                denyButtonText: `Delete`,
                didOpen: () => {}
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const title = Swal.getHtmlContainer().querySelector('#title')
                    const content = Swal.getHtmlContainer().querySelector('#content')
                    @this.set('title', title.value);
                    @this.set('content', content.value);

                    Livewire.emit('save')
                }
            });
        }
    </script>
@endpush
