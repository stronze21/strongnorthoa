<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li>
                <i class="mr-1 las la-user la-lg"></i> Lifechanger Profile
            </li>
        </ul>
    </div>
</x-slot>


<div class="flex flex-col p-10 mx-auto mt-5 space-x-0 bg-white max-w-7xl">
    <div class="flex justify-end">
        <button class="btn btn-sm btn-primary" id="btnPrint" onclick="printMe()">Print</button>
    </div>
    <div class="flex flex-col mx-auto text-sm" id="print">
        <div class="grid grid-cols-3">
            <div class="avatar">
                <div class="w-32 rounded">
                    <img class="w-32 h-32" src="{{ $user->profile_photo_url }}" />
                </div>
            </div>
            <div class="mx-auto text-center">
                <img src="{{ asset('storage/header_logo.png') }}" alt="header" class="mx-auto">
                <span class="text-sm">AUTHORZED SALADMASTER DEALERSHP IN THE PHILIPPINES</span>
            </div>
            <div class="flex justify-end">
                <span class="text-xs textarea-ghost">CTRLN:
                    #{{ $user->updated_at->format('Ymd-') . $user->user_id }}</span>
            </div>
        </div>
        <div class="flex mt-5">
            <div class="flex-1">
                Name: <span class="underline">{{ $user->fullname() }}</span>
            </div>
            <div>
                Age: <span class="underline">{{ $user->profile->age_signup() }}</span>
            </div>
        </div>
        <div>Address: <span class="underline">{{ $user->full_address() }}</span></div>
        <div class="flex">
            <div class="flex-1">
                Birth Place: <span class="underline">{{ $user->profile->birth_place }}</span>
            </div>
            <div>
                Date of Birth: <span class="underline">{{ $user->profile->birth_date }}</span>
            </div>
        </div>
        <div class="flex">
            <div class="flex-1">
                Telephone #: <span class="underline"></span>
            </div>
            <div>
                Cellphone #: <span class="underline">{{ $user->contact_no }}</span>
            </div>
        </div>
        <div class="flex">
            <div class="flex-1">
                Email Address: <span class="underline">{{ $user->email }}</span>
            </div>
            <div>
                Civil Status: <span class="underline">{{ $user->profile->civil_status }}</span>
            </div>
        </div>
        <div>Name of Spouse (if any): <span class="underline">{{ $user->profile->spouse }}</span></div>

        <span class="mt-2 font-bold">Name of Children/Dependents</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>School</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($dependents as $dependent)
                        <tr>
                            <td>{{ $dependent->name }}</td>
                            <td>{{ $dependent->birth_date }}</td>
                            <td>{{ $dependent->age() }}</td>
                            <td>{{ $dependent->school }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">N/A</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <span class="mt-2 font-bold">Work Experience</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Inclusive Dates</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">N/A</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <span class="mt-2 font-bold">Character References</span>
        <div class="w-full">
            <table class="table w-full mb-3 overflow-auto table-pin-rows table-xs">
                <thead class="border">
                    <tr>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($references as $reference)
                        <tr>
                            <td>{{ $reference->name }}</td>
                            <td>{{ $reference->relationship }}</td>
                            <td>{{ $reference->contact }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">N/A</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            <span>Name of person who referred/recruited you to the company:
                <span class="font-semibold underline">{{ $user->profile->builder->fullname() }}</span>
            </span>
            <div class="flex">
                <div class="mt-2">Do you have Saladmaster products at home?</div>
                <div class="flex ml-2">
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">Yes </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">No </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                </div>
            </div>
            <div>
                If yes, what products and when did you purchase?
                ___________________________________________________________________
            </div>
            <div class="flex">
                <div class="mt-2">Have you ever been connected to any Saladmaster Dealership before?</div>
                <div class="flex ml-2">
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">Yes </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">No </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                </div>
            </div>
            <div>
                If yes, when and what dealership?
                _________________________________________________________________________
            </div>
            <div class="flex">
                <div class="mt-2">Have you tried selling cookware before?</div>
                <div class="flex ml-2">
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">Yes </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="mr-2 label-text">No </span>
                            <input type="checkbox" disabled class="checkbox" />
                        </label>
                    </div>
                </div>
            </div>
            <div>
                If yes, what and when?
                __________________________________________________________________________
            </div>
            <p class="mt-2">
                I hereby certify that all information in this sheet is true and correct. Any misrepresentation shall be
                sufficient cause for termination. I authorize the company to verify any or all reference herein.
            </p>
        </div>

        <div style="page-break-before: always;" class="mt-5 text-center">
            <span class="text-3xl uppercase">{{ $type }} AGREEMENT</span>
            <article class="space-y-4 text-justify text-md">
                <p>
                    THIS AGREEMENT, made this
                    <span
                        class="underline">{{ Carbon\Carbon::parse($user->profile->sign_up_date)->format('jS') }}</span>
                    day wire:of
                    <span
                        class="underline">{{ Carbon\Carbon::parse($user->profile->sign_up_date)->format('F Y') }}</span>,
                    by between StrongNorth Cookware Trading, with its principal place of business located at 9-10 VYV
                    Bldg.
                    Valdez Center, Barangay 1 San Nicolas, Ilocos Norte (hereinafter called “Dealer”) and
                    <span class="underline">{{ $user->fullname() }}</span> with his address at
                    <span class="underline">{{ $user->full_address() }}</span>
                    (herein after called “the {{ $type }}”)
                </p>
                <p>
                    WHEREAS, Dealer is aware of the necessity of complying with the consumer protection laws and
                    standards
                    wherever it does business, and desires to sell Saladmaster Products of superior quality, reliability
                    and
                    performance to consumers in the convenience of the consumer’s homes; and
                </p>
                <p>
                    WHEREAS, Dealer in keeping with this method of distribution, desires to bring such Saladmaster
                    Products
                    to consumers through direct sales in the convenience of the consumer’s homes; and
                </p>
                <p>
                    WHEREAS, the {{ $type }} holds himself out as willing and able to practice such selling
                    methods and is
                    desirous of contracting with Dealer and an {{ $type }};
                </p>
                <p>
                    NOW, THEREFORE, for good and valuable consideration, the receipt and adequacy of which is mutually
                    acknowledged, the parties hereto mutually agree as follows:
                </p>
                <p>
                    1. The {{ $type }} may, at his option, (i) make payment for said Products by paying cash,
                    or (ii) sell
                    and
                    assign, with recourse, to Dealer any sale contract taken by the {{ $type }} upon the resale
                    of such
                    products, in which event the {{ $type }} will receive cash or credit on account of the
                    purchase price
                    of
                    said Products to the extent of the balance upon the sale contract, provided however, that dealer
                    shall
                    have the right to reject any conditional sale contract not in conformity with the payment schedules
                    accepted to Dealer or when, in Dealer’s sole independent judgement of the credit risk is
                    undesirable.
                    The {{ $type }} shall pay the full price of all Saladmaster products within one day from
                    the date of
                    purchase.
                </p>
                <p>
                    2. The Dealer agrees to lend {{ $type }} a Training Manual and promotional material, which
                    shall
                    remain
                    the property of the Dealer, and upon termination of the contract shall be returned to the Dealer.
                </p>
                <p>
                    3. The relationship between Dealer and {{ $type }} is that of vendor and vendee is governed
                    wholly and
                    exclusively by this Agreement, which supersedes all prior agreements, if any, between the parties,
                    and
                    constitutes the entire agreement between the parties. It may be modified only by a writing signed by
                    both parties. All work and duties to be performed by him as an independent contractor, and
                    {{ $type }}
                    is
                    not, and shall not be treated as, an employee for any purpose whatsoever.
                </p>
                <p>
                    4. {{ $type }} expressly acknowledge that he is not, and will not be as treated as, an
                    employee of the
                    Dealer, and that {{ $type }} alone, is solely responsible for the payment of any
                    self-employment or
                    income
                    taxes which may be due to Government or any Local Government by virtue of earnings made as an
                    independent contractor under this management.
                </p>
                <p>
                    5. The {{ $type }} acknowledges that the Saladmaster trademarks, trade names and emblems
                    are the
                    property
                    of Saladmaster, Inc., and that it is expressly understood that no license to use said marks, names
                    or
                    emblems is granted herein to {{ $type }}. Upon termination of this Agreement, the
                    {{ $type }} is
                    affiliated
                    with anyone who is authorized to sell Saladmaster Products.
                </p>
                <p>
                    6. This Agreement shall continue for a term of one year from the date hereof, and shall be
                    automatically
                    renewed from year to year unless terminated. Either party may cancel this Agreement upon ten days
                    notice
                    in writing to the other party. This Agreement shall automatically terminate in the event Dealer’s
                    Authorized Direct Dealer Agreement by and between Dealer and Saladmaster, Inc., terminates. Upon
                    termination the {{ $type }} agrees to pay any balance due to Dealer within ten days of such
                    termination.
                </p>
                <p>
                    7. This Agreement shall not be assigned by either party except with the written consent of the
                    other.
                </p>
                <p>
                    IN WITNESS WHEREOF the parties hereto have signed this Agreement on the day and year first above
                    written.
                </p>
            </article>
            <div class="text-center mt-14 columns-2">
                <p>___________________________________________</p>
                <p>{{ $type }} (Signature over printed Name) </p>
                <p class="mt-2">___________________________________________</p>
                <p>Home Address </p>
                <p>___________________________________________</p>
                <p>Telephone Number</p>
                <p class="break-before-column">___________________________________________</p>
                <p>Dealer </p>
                <p class="mt-2">By:________________________________________</p>
                <p>Name and Title</p>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        function printMe() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            history.go(-1);
        }
    </script>
@endpush
