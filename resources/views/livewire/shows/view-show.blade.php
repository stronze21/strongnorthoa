<x-slot name="header">
    <div class="p-4 mb-6 rounded-lg shadow-md bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="text-sm text-white breadcrumbs">
            <ul>
                <li class="font-bold transition-colors duration-200 hover:text-indigo-200">
                    <a href="#" class="flex items-center">
                        <i class="mr-2 las la-stroopwafel la-lg"></i> Cooking Shows
                    </a>
                </li>
                <li class="font-bold transition-colors duration-200 hover:text-indigo-200">
                    <a href="#" class="flex items-center">
                        <i class="mr-2 las la-eye la-lg"></i> View
                    </a>
                </li>
                <li class="text-indigo-100">
                    <span class="px-3 py-1 text-sm rounded-full bg-white/20">{{ $show->cs_id }}</span>
                </li>
            </ul>
        </div>
    </div>
</x-slot>

<div class="flex px-3 py-5 mx-auto max-w-7xl">
    <div class="grid w-full grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Main Content Card -->
        <div class="col-span-2 overflow-hidden bg-white shadow-xl rounded-xl">
            <!-- Card Header with Status -->
            <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50">
                <h2 class="flex items-center text-xl font-bold text-gray-800">
                    <i class="mr-2 text-indigo-600 las la-utensils la-lg"></i> Show Details
                </h2>
                <div class="flex items-center space-x-3">
                    @if ($show->result != 'Expired' or true)
                        <label
                            class="transition-colors duration-200 bg-indigo-600 border-0 btn btn-sm btn-primary hover:bg-indigo-700"
                            for="update_status">
                            <i class="mr-1 las la-edit"></i> Update Status
                        </label>
                    @endif
                    <div class="flex text-xs font-bold uppercase">
                        {!! $show->current_result() !!}
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Show Details -->
                <div class="overflow-hidden bg-white rounded-lg">
                    <table class="table w-full border-collapse">
                        <tbody class="divide-y divide-gray-100">
                            <tr class="transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Date:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->date }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Time:</th>
                                <td class="px-4 py-3 text-gray-800">{{ date('g:i A', strtotime($show->time)) }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Host:</th>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $show->host_fullname() }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Spouse:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->spouse }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Address:</th>
                                <td class="px-4 py-3 text-gray-800">
                                    <div class="flex flex-col">
                                        <div>{{ $show->address }}</div>
                                        <div>{{ $show->address_2 }}</div>
                                        <div>{{ $show->city_town }}</div>
                                        <div>{{ $show->province }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Contact No:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->contact_no }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Email Address:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->host_email }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Social Media:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->social_media }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Occupation:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->occupation }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Presenter:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->presenter }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Team Builder:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->team_builder }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Partner:</th>
                                <td class="px-4 py-3 text-gray-800">
                                    {{ $show->partner_id ? $show->partner_user->fullname() : '-' }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Partner Type:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->partner_type ?: '-' }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Distributor:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->distributor ?: '-' }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">SSP Level:</th>
                                <td class="px-4 py-3 text-gray-800">{{ $show->sspl ?: '-' }}</td>
                            </tr>
                            <tr class="uppercase transition-colors duration-150 hover:bg-gray-50">
                                <th class="w-1/4 px-4 py-3 text-left text-gray-700 bg-gray-50">Amount Sold:</th>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ $show->amount_sold ?: '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Results Section -->
                @if ($show->results->count())
                    <div class="mt-8">
                        <h3 class="flex items-center mb-4 text-lg font-bold text-gray-800">
                            <i class="mr-2 text-indigo-600 las la-chart-bar"></i> Results
                        </h3>
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg">
                            @foreach ($show->results->all() as $result)
                                <div class="p-5 @if (!$loop->last) border-b border-gray-200 @endif">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-indigo-700">
                                            Result from {{ $result->date_submitted }}
                                        </h4>
                                        <span class="px-3 py-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
                                            {{ $result->closed_deal }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Amount:</span>
                                                <span
                                                    class="font-medium">₱{{ number_format($result->amount, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Downpayment:</span>
                                                <span
                                                    class="font-medium">₱{{ number_format($result->down_payment, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Payment Mode:</span>
                                                <span class="font-medium">{!! $result->mode !!}</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Delivery Date:</span>
                                                <span class="font-medium">{{ $result->delivery_date }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Created:</span>
                                                <span class="font-medium">{{ $result->date_created }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 uppercase">Updated:</span>
                                                <span class="font-medium">{{ $result->date_updated }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($result->remarks)
                                        <div class="p-3 mt-3 rounded-md bg-gray-50">
                                            <h5 class="mb-1 text-xs text-gray-500 uppercase">Remarks</h5>
                                            <p class="text-gray-700">{{ $result->remarks }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Order Agreements -->
        @if ($show->result == 'Closed')
            <div class="overflow-hidden bg-white shadow-xl rounded-xl">
                <div class="p-5 border-b border-gray-100 bg-gray-50">
                    <h2 class="flex items-center text-xl font-bold text-gray-800">
                        <i class="mr-2 text-indigo-600 las la-file-contract la-lg"></i> Order Agreements
                    </h2>
                </div>
                <div class="p-5">
                    <button
                        class="flex items-center justify-center w-full mb-5 transition-colors duration-200 bg-indigo-600 border-0 btn btn-sm btn-primary hover:bg-indigo-700"
                        wire:click="create_oa()">
                        <i class="mr-1 las la-plus"></i> Create Order Agreement
                    </button>

                    @if ($show->order_agreements->count())
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg">
                            <table class="table w-full">
                                <thead class="text-gray-700 bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-center">Items</th>
                                        <th class="px-4 py-2 text-center">Gifts</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($show->order_agreements as $order)
                                        <tr wire:key="view-oa-{{ $order->id }}"
                                            wire:click="view_oa({{ $order->id }})"
                                            class="transition-colors duration-150 cursor-pointer hover:bg-indigo-50">
                                            <td class="px-4 py-3 font-medium">{{ $order->date }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 text-indigo-800 bg-indigo-100 rounded-full">
                                                    {{ $order->items->sum('item_qty') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 text-purple-800 bg-purple-100 rounded-full">
                                                    {{ $order->gifts->sum('item_qty') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td colspan="3" class="px-4 py-2 text-right">
                                                <span class="font-semibold text-gray-700">Total: </span>
                                                <span
                                                    class="font-bold text-indigo-700">₱{{ number_format($order->items->sum('item_total'), 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center rounded-lg bg-gray-50">
                            <i class="mb-2 text-gray-400 las la-file-alt la-3x"></i>
                            <p class="text-gray-500">No order agreements yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Modal - Update Status -->
    <input type="checkbox" id="update_status" class="modal-toggle" wire:model="open_modal" />
    <div class="modal">
        <div class="max-w-md p-0 bg-white modal-box rounded-xl">
            <div class="p-4 bg-indigo-600 rounded-t-xl">
                <h3 class="text-lg font-bold text-white">Update Show Status</h3>
            </div>
            <div class="p-6">
                <div class="w-full mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Status</label>
                    <select
                        class="w-full bg-white border-gray-300 rounded-md shadow-sm select select-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        wire:model='result'>
                        <option value="For Follow Up">For Follow Up</option>
                        <option value="Booked">Booked</option>
                        <option value="Closed">Closed</option>
                        <option value="Reschedule">Reschedule</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                @if ($result == 'Reschedule')
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="form-control">
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Date<span class="ml-1 text-red-500">*</span>
                            </label>
                            <input wire:model.defer="date" type="date" min="{{ date('Y-m-d') }}"
                                class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                        <div class="form-control">
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Time<span class="ml-1 text-red-500">*</span>
                            </label>
                            <input wire:model.defer="time" type="time" value="{{ date('H:i') }}"
                                class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                    </div>
                @else
                    <div class="form-control">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Amount Sold</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">₱</span>
                            <input type="number" step="0.01"
                                class="w-full pl-8 bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                wire:model.defer='amount_sold'>
                        </div>
                    </div>
                @endif

                <div class="flex justify-end mt-6 space-x-3">
                    <label for="update_status" class="btn btn-outline btn-error hover:bg-red-50">Cancel</label>
                    <button
                        class="transition-colors duration-200 bg-indigo-600 border-0 btn btn-primary hover:bg-indigo-700"
                        wire:loading.attr="disabled" wire:click="update_result">
                        <span wire:loading.remove>Update</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
