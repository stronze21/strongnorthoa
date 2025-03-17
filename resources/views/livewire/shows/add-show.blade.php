<x-slot name="header">
    <div class="p-4 mb-4 rounded-lg shadow-md bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="text-sm text-white breadcrumbs">
            <ul>
                <li class="font-bold transition-colors duration-200 hover:text-indigo-200">
                    <a href="#" class="flex items-center">
                        <i class="mr-2 las la-stroopwafel la-lg"></i> Cooking Shows
                    </a>
                </li>
                <li class="text-indigo-100">
                    <span class="flex items-center">
                        <i class="mr-2 las la-plus la-lg"></i> Add Cooking Show
                    </span>
                </li>
            </ul>
        </div>
    </div>
</x-slot>

<div class="max-w-lg px-4 py-6 mx-auto sm:px-6 md:max-w-4xl lg:max-w-6xl">
    <div class="overflow-hidden bg-white shadow-xl rounded-xl">
        <!-- Form Header with Progress -->
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <h2 class="flex items-center text-lg font-bold text-gray-800">
                <i class="mr-2 text-indigo-600 las la-calendar-plus la-lg"></i> Book a New Cooking Show
            </h2>

            <!-- Progress Indicator -->
            <div class="px-2 mt-4">
                <div class="flex justify-between mb-1">
                    <div class="text-xs font-medium text-indigo-700">Step {{ $currentStep }} of 3</div>
                    <div class="text-xs font-medium text-gray-500">{{ round(($currentStep / 3) * 100) }}%</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
                        style="width: {{ ($currentStep / 3) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 mx-4 mt-4 border-l-4 border-red-500 rounded-md bg-red-50">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-red-700">{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        <div class="p-4 md:p-6">
            <!-- Step 1: Basic Information -->
            @if ($currentStep == 1)
                <div class="space-y-6">
                    <h3 class="flex items-center font-semibold text-indigo-700 text-md">
                        <i class="mr-1 las la-info-circle"></i> Basic Information
                    </h3>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Date<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="date" type="date" min="{{ date('Y-m-d') }}"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Time<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="time" type="time" value="{{ date('H:i') }}"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Show Type<span class="ml-1 text-red-500">*</span>
                        </label>
                        <select wire:model.defer="type"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm select select-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="Face to Face">Face to Face</option>
                            <option value="Virtual">Virtual</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            First Name<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="host" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Last Name<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="host_surename" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Spouse First Name
                        </label>
                        <input wire:model.defer="spouse" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>
                </div>
            @endif

            <!-- Step 2: Contact Information -->
            @if ($currentStep == 2)
                <div class="space-y-6">
                    <h3 class="flex items-center font-semibold text-indigo-700 text-md">
                        <i class="mr-1 las la-address-book"></i> Contact Information
                    </h3>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Address Line 1<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="address" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Address Line 2
                        </label>
                        <input wire:model.defer="address_2" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Province<span class="ml-1 text-red-500">*</span>
                        </label>
                        <select wire:model="province_id"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm select select-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            City/Town<span class="ml-1 text-red-500">*</span>
                        </label>
                        <select wire:model.defer="municipality_id"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm select select-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            {{ !$province_id ? 'disabled' : '' }}>
                            <option value="">Select City/Town</option>
                            @if ($province_id)
                                @foreach ($municipalities as $municipality)
                                    <option value="{{ $municipality->municipality_id }}">
                                        {{ $municipality->municipality_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if (!$province_id)
                            <p class="mt-1 text-xs text-gray-500">Please select a province first</p>
                        @endif
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Contact Number<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="contact_no" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Occupation
                        </label>
                        <input wire:model.defer="occupation" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>
                </div>
            @endif

            <!-- Step 3: Additional Information -->
            @if ($currentStep == 3)
                <div class="space-y-6">
                    <h3 class="flex items-center font-semibold text-indigo-700 text-md">
                        <i class="mr-1 las la-users"></i> Additional Information
                    </h3>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Email Address<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="host_email" type="email"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Social Media Name
                        </label>
                        <input wire:model.defer="social_media" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Lifechanger<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="lifechanger" type="text"
                            class="w-full bg-white bg-gray-100 border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            readonly />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Partner
                        </label>
                        <select wire:model.defer="partner_id"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm select select-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">N/A</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->user_id }}">
                                    {{ $partner->fullname() . ' [' . $partner->cur_level->sspl->level . ']' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Presenter<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="presenter" type="text"
                            class="w-full bg-white border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Team Builder<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="team_builder" type="text"
                            class="w-full bg-white bg-gray-100 border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            readonly />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Distributor<span class="ml-1 text-red-500">*</span>
                        </label>
                        <input wire:model.defer="distributor" type="text"
                            class="w-full bg-white bg-gray-100 border-gray-300 rounded-md shadow-sm input input-bordered focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            readonly />
                    </div>

                    <div class="form-control">
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Spirit of Success Program Level<span class="ml-1 text-red-500">*</span>
                        </label>
                        <select wire:model.defer="sspl"
                            class="w-full bg-white bg-gray-100 border-gray-300 rounded-md shadow-sm select select-bordered"
                            readonly disabled>
                            <option value="0">Not Set</option>
                            <option value="Associate">Associate</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Senior Consultant">Senior Consultant</option>
                            <option value="Distributor">Distributor</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8">
                @if ($currentStep > 1)
                    <button wire:click="previousStep"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="mr-2 las la-arrow-left"></i> Previous
                    </button>
                @else
                    <div></div>
                @endif

                @if ($currentStep < 3)
                    <button wire:click="nextStep"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Next <i class="ml-2 las la-arrow-right"></i>
                    </button>
                @else
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span wire:loading.remove>
                            <i class="mr-2 las la-calendar-check"></i> Book Show
                        </span>
                        <span wire:loading>
                            <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
