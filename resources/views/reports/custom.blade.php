@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Custom Report Generator</h1>
            <div>
                <a href="{{ route('reports.index') }}" class="btn btn-ghost">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow card">
            <div class="p-6 card-body">
                <form action="{{ route('reports.custom') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="report_type" class="block mb-1 text-sm font-medium text-gray-700">Report
                                Type</label>
                            <select id="report_type" name="report_type" class="w-full select" required>
                                <option value="">Select a report type</option>
                                @foreach ($reportTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="format" class="block mb-1 text-sm font-medium text-gray-700">Export Format</label>
                            <select id="format" name="format" class="w-full select" required>
                                <option value="">Select a format</option>
                                @foreach ($exportFormats as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="from_date" class="block mb-1 text-sm font-medium text-gray-700">From Date</label>
                            <input type="date" id="from_date" name="from_date" class="w-full input">
                        </div>

                        <div>
                            <label for="to_date" class="block mb-1 text-sm font-medium text-gray-700">To Date</label>
                            <input type="date" id="to_date" name="to_date" class="w-full input">
                        </div>
                    </div>

                    <!-- Dynamic Columns Section -->
                    <div class="hidden mb-6 columns-container">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Columns to Include</label>

                        <div id="shows-columns" class="grid hidden grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]" value="date"
                                    class="mr-2" checked> Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]" value="time"
                                    class="mr-2" checked> Time</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]" value="host"
                                    class="mr-2" checked> Host Name</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="host_surename" class="mr-2"> Host Surname</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]" value="address"
                                    class="mr-2" checked> Address</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="address_2" class="mr-2"> Address Line 2</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="city_town" class="mr-2" checked> City/Town</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]" value="province"
                                    class="mr-2" checked> Province</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="postal_code" class="mr-2"> Postal Code</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="contact_no" class="mr-2" checked> Contact Number</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="host_email" class="mr-2"> Host Email</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="lifechanger" class="mr-2" checked> Lifechanger</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="presenter" class="mr-2" checked> Presenter</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="result" class="mr-2" checked> Status</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="notes" class="mr-2"> Notes</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="created_at" class="mr-2"> Date Created</label>
                        </div>

                        <div id="lifechangers-columns"
                            class="grid hidden grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="user_id" class="mr-2" checked> ID</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="full_name" class="mr-2" checked> Full Name</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="f_name" class="mr-2"> First Name</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="l_name" class="mr-2"> Last Name</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="m_name" class="mr-2"> Middle Name</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="email" class="mr-2" checked> Email</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="contact_no" class="mr-2" checked> Contact Number</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="address" class="mr-2" checked> Address</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="region" class="mr-2" checked> Region</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="province" class="mr-2" checked> Province</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="municipality" class="mr-2" checked> Municipality</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="birth_date" class="mr-2" checked> Birth Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="current_level" class="mr-2" checked> Current Level</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="sign_up_date" class="mr-2" checked> Sign Up Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="team_leader" class="mr-2"> Team Leader</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="team_builder" class="mr-2"> Team Builder</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="distributor" class="mr-2"> Distributor</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="created_at" class="mr-2"> Date Created</label>
                        </div>

                        <div id="orders-columns" class="grid hidden grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_id" class="mr-2"> Order ID</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_number" class="mr-2" checked> Order Number</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_date" class="mr-2" checked> Order Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_client" class="mr-2" checked> Client</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_address" class="mr-2" checked> Address</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_contact" class="mr-2" checked> Contact</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_consultant" class="mr-2" checked> Consultant</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_associate" class="mr-2"> Associate</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_presenter" class="mr-2" checked> Presenter</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_team_builder" class="mr-2"> Team Builder</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_distributor" class="mr-2"> Distributor</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="total_amount" class="mr-2" checked> Total Amount</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="paid_amount" class="mr-2" checked> Paid Amount</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="payment_status" class="mr-2" checked> Payment Status</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="oa_status" class="mr-2" checked> Order Status</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="item_count" class="mr-2"> Number of Items</label>
                        </div>

                        <div id="contests-columns" class="grid hidden grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="id" class="mr-2" checked> ID</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="title" class="mr-2" checked> Title</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="description" class="mr-2"> Description</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="start_date" class="mr-2" checked> Start Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="end_date" class="mr-2" checked> End Date</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="status" class="mr-2" checked> Status</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="sspl_id" class="mr-2"> SSPL Level</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="sspl_type" class="mr-2"> Type</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="for_team_builders" class="mr-2"> For Team Builders</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="total_shows" class="mr-2" checked> Total Shows</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="booked_shows" class="mr-2"> Booked Shows</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="closed_shows" class="mr-2" checked> Closed Shows</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="cancelled_shows" class="mr-2"> Cancelled Shows</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="sales_target" class="mr-2" checked> Sales Target</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="sales_achieved" class="mr-2" checked> Sales Achieved</label>
                            <label class="inline-flex items-center"><input type="checkbox" name="columns[]"
                                    value="performance" class="mr-2" checked> Performance (%)</label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reportTypeSelect = document.getElementById('report_type');
                const columnsContainer = document.querySelector('.columns-container');
                const showsColumns = document.getElementById('shows-columns');
                const lifechangerColumns = document.getElementById('lifechangers-columns');
                const ordersColumns = document.getElementById('orders-columns');
                const contestsColumns = document.getElementById('contests-columns');

                reportTypeSelect.addEventListener('change', function() {
                    // Hide all column sections
                    showsColumns.classList.add('hidden');
                    lifechangerColumns.classList.add('hidden');
                    ordersColumns.classList.add('hidden');
                    contestsColumns.classList.add('hidden');

                    // Show columns container if a report type is selected
                    if (this.value) {
                        columnsContainer.classList.remove('hidden');

                        // Show corresponding columns based on report type
                        if (this.value === 'shows') {
                            showsColumns.classList.remove('hidden');
                        } else if (this.value === 'lifechangers') {
                            lifechangerColumns.classList.remove('hidden');
                        } else if (this.value === 'orders') {
                            ordersColumns.classList.remove('hidden');
                        } else if (this.value === 'contests') {
                            contestsColumns.classList.remove('hidden');
                        }
                    } else {
                        columnsContainer.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
