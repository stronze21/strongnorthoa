<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-stroopwafel la-lg"></i> Cooking Shows
            </li>
            <li class="font-bold">
                <i class="mr-1 las la-eye la-lg"></i> View
            </li>
            <li>
                {{$show->cs_id}}
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex px-3 py-5 mx-auto max-w-7xl">
    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
        <div class="col-span-2 px-3 py-5 bg-white rounded-lg shadow-xl">
            <div class="grid grid-cols-1 px-3 py-5 md:grid-cols-2">
                <div class="flex flex-col col-span-2 mx-5">
                    <div class="flex justify-between mb-3">
                        <div>
                            @if($show->result != 'Expired')
                                <label class="btn btn-sm btn-primary" for="update_status">Update Status</label>
                            @endif
                        </div>
                        <div class="flex text-xs font-bold uppercase">
                            {!!$show->current_result()!!}
                        </div>
                    </div>
                    <table class="table w-full table-zebra table-compact">
                        <tr class="border">
                            <th>Date:</th>
                            <td>{{$show->date}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Time:</th>
                            <td>{{date('g:i A' , strtotime($show->time))}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Host:</th>
                            <td>{{$show->host_fullname()}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Spouse:</th>
                            <td>{{$show->spouse}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Address:</th>
                            <td class="text-xs text-clip">
                                <div class="flex flex-col">
                                    <div>{{$show->address}}</div>
                                    <div>{{$show->address_2}}</div>
                                    <div>{{$show->city_town}}</div>
                                    <div>{{$show->province}}</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Contact No:</th>
                            <td>{{$show->contact_no}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Email Address:</th>
                            <td>{{$show->host_email}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Social Media:</th>
                            <td>{{$show->social_media}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Occupation:</th>
                            <td>{{$show->occupation}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Presenter:</th>
                            <td>{{$show->presenter}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Team Builder:</th>
                            <td>{{$show->team_builder}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Partner:</th>
                            <td>{{$show->partner}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Partner Type:</th>
                            <td>{{$show->partner_type}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Distributor:</th>
                            <td>{{$show->distributor}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>SSP Level:</th>
                            <td>{{$show->sspl}}</td>
                        </tr>
                        <tr class="uppercase border">
                            <th>Amount Sold:</th>
                            <td>{{$show->amount_sold}}</td>
                        </tr>
                    </table>
                </div>
                @if ($show->results->count())
                <div class="flex flex-col col-span-2 mx-5 mt-5">
                    <table class="table w-full table-compact">
                        <thead>
                            <tr>
                                <th colspan="2">RESULTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($show->results->all() as $result)
                            <tr class="border">
                                <th>Date Submitted: </th>
                                <td>{{$result->date_submitted}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Closed Deal:</th>
                                <td>{{$result->closed_deal}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Amount:</th>
                                <td>{{number_format($result->amount, 2)}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Downpayment:</th>
                                <td>{{number_format($result->down_payment, 2)}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Mode of Payment:</th>
                                <td>{!!$result->mode!!}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Delivery Date:</th>
                                <td>{{$result->delivery_date}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Remarks:</th>
                                <td>{{$result->remarks}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Date Created:</th>
                                <td>{{$result->date_created}}</td>
                            </tr>
                            <tr class="uppercase border">
                                <th>Date Updated:</th>
                                <td>{{$result->date_updated}}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center border active">----------------------------------------------------------------------------------------------------</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
        @if($show->result == 'Closed')
        <div class="px-3 py-5 bg-white rounded-lg shadow-xl">
            <div class="mt-5 mb-3">
                <button class="btn btn-sm btn-primary" wire:click="create_oa()">Create Order Agreement</button>
            </div>
            <table class="table w-full table-compact">
                <thead>
                    <tr>
                        <td>OA Date</td>
                        <td>Items</td>
                        <td>Gifts</td>
                    </tr>
                </thead>
                <tbody class="border">
                    @foreach ($show->order_agreements as $order)
                    <tr wire:key="view-oa-{{$order->id}}" wire:click="view_oa({{$order->id}})" class="cursor-pointer hover">
                        <td>{{$order->date}}</td>
                        <td>{{$order->items->sum('item_qty')}}</td>
                        <td>{{$order->gifts->sum('item_qty')}}</td>
                    </tr>
                    <tr class="border-b">
                        <td colspan="2" class="text-right uppercase"><span> Amount: {{$order->items->sum('item_total')}}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="update_status" class="modal-toggle" wire:model="open_modal" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Update Show</h3>
            <div class="w-full py-4">
                <div class="w-full mb-2 form-control">
                    <span>Select Status</span>
                    <select class="w-full select-bordered select" wire:model.defer='result'>
                            <option value="For Follow Up">For Follow Up</option>
                            <option value="Booked">Booked</option>
                            <option value="Closed">Closed</option>
                            <option value="Reschedule">Reschedule</option>
                            <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="w-full mb-2 form-control">
                    <span>Amount Sold</span>
                    <input type="number" step="0.01" class="w-full select-bordered select" wire:model.defer='amount_sold'>
                </div>
            </div>
            <div class="modal-action">
                <label for="update_status" class="btn btn-error">Cancel</label>
                <button class="btn btn-primary" wire:click="update_result">Submit</button>
            </div>
        </div>
    </div>
</div>
