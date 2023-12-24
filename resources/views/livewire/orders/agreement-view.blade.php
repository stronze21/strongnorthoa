<div class="py-12">

    @if (!$oa->submitted)
        <div class="mx-auto mb-5 max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between mb-2 overflow-hidden border-b sm:rounded-lg">
                @if ($oa->status != 'Cancelled' and !$oa->submitted)
                    <div class="p-2border-gray-200">
                        <label class="my-2 btn btn-sm btn-primary ms-2" for="my-modal-5">Add Item</label>
                        <label class="my-2 btn btn-sm btn-warning ms-2" for="add_gift">Add Gift</label>
                        <label class="my-2 btn btn-sm btn-secondary ms-2" for="update_details">Edit Additional
                            Details</label>
                        <a class="my-2 btn btn-sm btn-info ms-2"
                            href="{{ route('signaturepad', $oa->id) }}">Signature</a>
                    </div>
                @endif
                <div>
                    @if ($oa->status != 'Cancelled' and !$oa->submitted)
                        <button class="my-2 btn btn-sm btn-primary ms-2" onclick="submit_order()">Submit Order</button>
                        <button class="my-2 btn btn-sm btn-error ms-2" onclick="cancel_order()">Cancel Order</button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="p-6 text-center bg-white border-b border-gray-200 sm:px-20">
                <h3 class="font-bold">ORDER AGREEMENT</h3>
                @if ($oa->final_oa)
                    <h7 class="font-bold text-error">{{ $oa->final_oa->oa_number }}</h7>
                @else
                    <h7 class="font-bold text-error">OA ref ID: #{{ $oa->id }}</h7>
                @endif
                <hr>
            </div>

            <div class="bg-opacity-25">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-1 px-3">
                        <div class="flex-col">
                            <div>Date: <span class="font-bold">{{ $oa->date }}</span></div>
                            <div>Client: <span class="font-bold capitalize">{{ $oa->client }}</span></div>
                            <div>Address: <span class="font-bold capitalize">{{ $oa->address }}</span></div>
                            <div>Contact #: <span class="font-bold">{{ $oa->contact }}</span></div>
                        </div>
                        <div class="flex-col">
                            <div>Consultant: <span class="font-bold capitalize">{{ $oa->consultant }}</span></div>
                            <div>Associate: <span class="font-bold capitalize">{{ $oa->associate }}</span></div>
                            <div>Presenter: <span class="font-bold capitalize">{{ $oa->presenter }}</span></div>
                            <div>Team Builder: <span class="font-bold capitalize">{{ $oa->team_builder }}</span></div>
                            <div>Distributor: <span class="font-bold capitalize">{{ $oa->distributor }}</span></div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="table w-full border table-compact">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($oa->items()->get() as $order)
                                    <tr class="{!! $order->remarks == 'Composed of:' ? 'active"' : '' !!} cursor-pointer hover"
                                        onclick="delete_item('{{ $order->id }}', 'item')">
                                        <td>{!! $order->product->tblset_id
                                            ? '<span class="font-bold">' . $order->product->product_description . '</span> Composed of:'
                                            : $order->product->product_description !!}</td>
                                        <td class="text-right">{{ number_format($order->item_price, 2) }}</td>
                                        <td class="text-right">{{ $order->item_qty }}</td>
                                        <td class="text-right">{{ number_format($order->item_total, 2) }}</td>
                                        {{-- <td width="5%">
                                            <a href="#" class="btn btn-danger" onclick="delete_item('{{$order->item_id}}', '{{$order->product->product_description}}')">Remove</a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="7">No items found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <table class="table w-full border table-compact">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Gift</th>
                                    <th class="text-right">Item Price</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($oa->gifts()->get() as $order)
                                    <tr class="cursor-pointer hover"
                                        onclick="delete_item('{{ $order->id }}', 'gift')">
                                        <td>{{ $order->type }}</td>
                                        <td>{{ $order->product->product_description }}</td>
                                        <td class="text-right">{{ number_format($order->item_price, 2) }}</td>
                                        <td class="text-right">{{ $order->item_qty }}</td>
                                        <td class="text-right">{{ number_format(0, 2) }}</td>
                                        {{-- <td width="5%">
                                            <a href="#" class="btn btn-sm btn-danger" onclick="delete_gift('{{$order->gift_id}}', '{{$order->gift->product_description}}')">Remove</a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="6">No gifts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                @php
                                    $total = $oa->items()->sum('item_total');
                                @endphp
                                {{-- <tr class='table-light'><td class="text-right" colspan='4'><strong>SUBTOTAL:</strong></td><td class='text-right' colspan="2"><span>&#8369; </span>{{number_format($subtotal = $oa->oa_price_override ? $oa->oa_price_override :  $oa->items()->sum('item_total') ,2)}}</td></tr> --}}
                                <tr class='table-light'>
                                    <td class="text-right" colspan='4'><strong>TOTAL:</strong></td>
                                    <td class="text-right" colspan="2"><strong>&#8369;
                                            {{ number_format($total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="grid grid-cols-2 gap-1 px-3 py-5 border">
                            <div class="flex flex-col">
                                <div class="flex">
                                    <span>Delivery Date: {{ $oa->delivery_date }} </span>
                                </div>
                                <div class="flex">
                                    <span>Time: {{ $oa->delivery__time }} </span>
                                </div>
                                <div class="flex">
                                    <span>Total Amount: {{ number_format($total, 2) }} </span>
                                </div>
                                <br><br><br><br><br>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex">
                                    <span class=" text-ellipsis">Current Spirit of Success Level: </span>
                                    <span>{{ $oa->current_level }}</span>
                                </div>
                                <div class="flex">
                                    <span>Initial Investment: </span> <span
                                        class="ml-1">{{ number_format($oa->initial_investment, 2) }}</span>
                                </div>
                                <div class="flex">
                                    <span>Balance: </span> <span
                                        class="ml-1">{{ number_format($total - $oa->initial_investment, 2) }}</span>
                                </div>
                                <div class="flex">
                                    <span>Terms: </span> <span class="ml-1">{{ $oa->terms }}</span>
                                </div>
                                <p class="text-ellipsis">
                                    <small>Checks payable only to <span class="font-bold uppercase">StrongNorth Cookware
                                            Trading</span></small>
                                </p>
                                <div class="flex flex-col justify-center pt-5 mt-10 text-center">
                                    <div class="mx-auto">
                                        @if ($oa->host_signature)
                                            <img src="{{ url('upload/' . $oa->host_signature) }}" class="h-20"
                                                alt="Host Signature">
                                        @endif
                                    </div>
                                    <div class="w-full border-t">
                                        <span>Signature of Host</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add ITEM MODAL --}}
    <input type="checkbox" id="my-modal-5" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <label for="my-modal-5" class="absolute btn btn-sm btn-circle right-4 top-4">✕</label>
            <h3 class="text-lg font-bold">Add Item</h3>
            <div class="w-full py-4">

                <div class="w-full mb-2 form-control">
                    <label class="w-full input-group">
                        <span>Product</span>
                        <select class="w-full max-w-xs select-bordered select" wire:model='item_id'>
                            <option value=""></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->product_id }}">{{ $product->product_description }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Qty</span>
                        <input type="number" min="1" class="w-full input input-bordered"
                            wire:model="item_qty" />
                    </label>
                    @error('item_qty')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Remarks</span>
                        <input type="text" class="w-full input input-bordered" wire:model="item_remarks" />
                    </label>
                    @error('item_remarks')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-action">
                <label for="my-modal-5" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="add_item()">Submit</button>
            </div>
        </div>
    </div>

    {{-- ADD GIFT MODAL --}}

    <input type="checkbox" id="add_gift" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <label for="add_gift" class="absolute btn btn-sm btn-circle right-4 top-4">✕</label>
            <h3 class="text-lg font-bold">Add Gift</h3>
            <div class="w-full py-4">

                <div class="w-full mb-2 form-control">
                    <label class="w-full input-group">
                        <span>Product</span>
                        <select class="w-full max-w-xs select-bordered select" wire:model='gift_id'>
                            <option value=""></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->product_id }}">{{ $product->product_description }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Qty</span>
                        <input type="number" min="1" class="w-full input input-bordered"
                            wire:model="gift_qty" />
                    </label>
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span>Type</span>
                        <select class="w-full max-w-xs select-bordered select" wire:model='gift_type'>
                            <option value="FCG">FIRST CALL GIFT</option>
                            <option value="PKG">BOOKING GIFT</option>
                            <option value="STG">SHORT TERM GIFT</option>
                            <option value="ROR">ROR GIFT</option>
                            <option value="RLT">ROLETA GIFT</option>
                            <option value="COD">COD GIFT</option>
                            <option value="BIB">BIGGER INITIAL BONUS</option>
                            <option value="JNG">JOINING BONUS</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="modal-action">
                <label for="add_gift" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="add_gift()">Submit</button>
            </div>
        </div>
    </div>

    {{-- UPDATE DETAILS MODAL --}}

    <input type="checkbox" id="update_details" class="modal-toggle" />
    <div class="modal">
        <div class="w-11/12 max-w-5xl modal-box">
            <label for="update_details" class="absolute btn btn-sm btn-circle right-4 top-4">✕</label>
            <h3 class="text-lg font-bold">Update Additional Details</h3>
            <div class="w-full p-4">

                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span class="whitespace-nowrap">Current Level</span>
                        <select class="w-full max-w-xs select-bordered select" wire:model='current_level'>
                            <option value="Associate">Associate</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Senior Consultant">Senior Consultant</option>
                            <option value="Distributor">Distributor</option>
                        </select>
                    </label>
                </div>

                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span class="whitespace-nowrap">Delivery Date</span>
                        <input type="date" min="{{ date('Y-m-d') }}" class="w-full input input-bordered"
                            wire:model="delivery_date" />
                    </label>
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span class="whitespace-nowrap">Delivery Time</span>
                        <input type="time" class="w-full input input-bordered" wire:model="delivery_time" />
                    </label>
                </div>
                <div class="w-full pr-3 mb-2 form-control">
                    <label class="input-group">
                        <span class="text-sm whitespace-nowrap">Initial Investment</span>
                        <input type="number" step="0.01" class="w-full input input-bordered"
                            wire:model="initial_investment" />
                    </label>
                </div>
                <div class="w-full mb-2 form-control">
                    <label class="input-group">
                        <span class="w-1/4 whitespace-nowrap">Terms</span>
                        <input type="text" class="w-full input input-bordered" wire:model="terms" />
                    </label>
                </div>
            </div>
            <div class="modal-action">
                <label for="update_details" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="update_details()">Submit</button>
            </div>
        </div>
    </div>
</div>


@push('modals')
    <script>
        function delete_item(delete_id, type) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#ff0f0f',
                html: `
                        <div class="mt-2 text-slate-500">Do you really want to perform soft delete on this ` + type + `?</div>
                    `,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Livewire.emit('delete_item', delete_id, type)
                }
            })
        }

        function submit_order() {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                html: `
                        <div class="mt-2 text-slate-500">You are about to submit this order to Saladmaster. Click on confirm to continue.</div>
                    `,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Livewire.emit('submit_order')
                }
            })
        }

        function cancel_order() {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                html: `
                <div class="mt-2 text-slate-500">You are about to cancel this order. Click on confirm to continue.</div>
            `,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Livewire.emit('cancel_order')
                }
            })
        }
    </script>
@endpush
