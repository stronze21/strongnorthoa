<li class="relative px-6 py-3">
    @if (request()->routeIs('reports.*'))
        <span class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg bg-primary" aria-hidden="true"></span>
    @endif

    <button
        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('reports.*') ? 'text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }}"
        @click="toggleReportsMenu" aria-haspopup="true">
        <span class="inline-flex items-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <span class="ml-4">Reports</span>
        </span>
        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>

    <template x-if="isReportsMenuOpen">
        <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0"
            x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300"
            x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
            aria-label="submenu">

            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <a class="w-full {{ request()->routeIs('reports.index') ? 'text-primary dark:text-primary font-semibold' : '' }}"
                    href="{{ route('reports.index') }}">
                    Dashboard
                </a>
            </li>

            @foreach ($reports as $key => $report)
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                    <a class="w-full {{ request()->routeIs('reports.' . $key) ? 'text-primary dark:text-primary font-semibold' : '' }}"
                        href="{{ route('reports.' . $key) }}">
                        {{ $report['name'] }}
                    </a>
                </li>
            @endforeach

            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <a class="w-full {{ request()->routeIs('reports.custom') ? 'text-primary dark:text-primary font-semibold' : '' }}"
                    href="{{ route('reports.custom') }}">
                    Custom Report
                </a>
            </li>
        </ul>
    </template>
</li>
