<nav x-data="{ open: false }" @keydown.escape.window="open = false" class="site-navigation" aria-label="Main navigation">
    @php
        $isUser = Auth::user()->hasRole('user');
        $homeRoute = $isUser ? 'dashboard' : 'admin.dashboard';
        $navigationLinks = [
            [
                'label' => 'Home',
                'route' => $homeRoute,
                'icon' => 'la-home',
                'active' => request()->routeIs($homeRoute, 'gen.dashboard'),
            ],
            [
                'label' => $isUser ? 'My Cooking Shows' : 'All Cooking Shows',
                'route' => $isUser ? 'my-cooking-shows' : 'admin.all',
                'icon' => 'la-stroopwafel',
                'active' => request()->routeIs(
                    'my-cooking-shows',
                    'admin.all',
                    'admin.booked',
                    'admin.cooked',
                    'cs.view',
                    'cs.add',
                    'cs.booked',
                    'cs.cooked',
                ),
            ],
            [
                'label' => 'Full Calendar',
                'route' => 'cs.calendar',
                'icon' => 'la-calendar-alt',
                'active' => request()->routeIs('cs.calendar'),
            ],
        ];
        if (Auth::user()->hasRole('admin')) {
            $navigationLinks = array_merge($navigationLinks, [
                [
                    'label' => 'Lifechanger List',
                    'route' => 'lc.masterlist',
                    'icon' => 'la-users',
                    'active' => request()->routeIs('lc.masterlist', 'lc.create', 'lifechangers'),
                ],
                [
                    'label' => 'Contests',
                    'route' => 'contests.list',
                    'icon' => 'la-project-diagram',
                    'active' => request()->routeIs('contests.*', 'contests'),
                ],
                ['label' => 'QR Codes', 'route' => 'qrs', 'icon' => 'la-qrcode', 'active' => request()->routeIs('qrs')],
                [
                    'label' => 'Reports',
                    'route' => 'reports.index',
                    'icon' => 'la-file-excel',
                    'active' => request()->routeIs('reports.*'),
                ],
            ]);
        }
    @endphp
    <style>
        .site-navigation {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            color: #37465c;
        }

        .site-navigation .nav-shell {
            width: 100%;
            padding: 0 24px;
        }

        .site-navigation .nav-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            gap: 20px;
        }

        .site-navigation .nav-left {
            display: flex;
            align-items: center;
            gap: 24px;
            min-width: 0;
        }

        .site-navigation .nav-brand {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            padding: 4px;
            border-radius: 8px;
        }

        .site-navigation .nav-desktop {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .site-navigation .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 10px 11px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            color: #526078;
            transition: background-color .15s ease, color .15s ease;
        }

        .site-navigation .nav-link i {
            font-size: 19px;
        }

        .site-navigation .nav-link:hover {
            background: #f1f5f9;
            color: #263247;
        }

        .site-navigation .nav-link[aria-current="page"] {
            background: #eef2ff;
            color: #4338ca;
        }

        .site-navigation .nav-account {
            display: flex;
            align-items: center;
            padding-left: 16px;
            border-left: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .site-navigation .account-trigger {
            display: flex;
            align-items: center;
            gap: 9px;
            min-height: 40px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 13px;
            color: #37465c;
            background: #f8fafc;
        }

        .site-navigation .account-name {
            max-width: 185px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .site-navigation .nav-toggle {
            display: none;
            align-items: center;
        }

        .site-navigation .nav-toggle button {
            display: flex;
            gap: 8px;
            align-items: center;
            padding: 10px 12px;
            border-radius: 8px;
            color: #37465c;
            background: #f1f5f9;
            font-weight: 600;
            font-size: 14px;
        }

        .site-navigation .nav-mobile {
            border-top: 1px solid #e2e8f0;
            padding: 12px 16px 20px;
            max-height: calc(100dvh - 76px);
            overflow-y: auto;
        }

        .site-navigation .nav-mobile-links {
            display: grid;
            gap: 4px;
            margin-bottom: 16px;
        }

        .site-navigation .nav-mobile .nav-link {
            padding: 12px;
            font-size: 14px;
        }

        .site-navigation a:focus-visible,
        .site-navigation button:focus-visible {
            outline: 2px solid #4338ca;
            outline-offset: 3px;
        }

        .site-navigation .nav-mobile .nav-user-info {
            overflow-wrap: anywhere;
            min-width: 0;
        }

        @media (max-width: 1250px) {

            .site-navigation .nav-desktop,
            .site-navigation .nav-account {
                display: none;
            }

            .site-navigation .nav-toggle {
                display: flex;
            }

            .site-navigation .nav-row {
                min-height: 68px;
            }
        }

        @media (min-width: 1251px) {
            .site-navigation .nav-mobile {
                display: none !important;
            }
        }

        @media (max-width: 640px) {
            .site-navigation .nav-shell {
                padding: 0 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .site-navigation .nav-link {
                transition: none;
            }
        }
    </style>
    <!-- Primary Navigation Menu -->
    <div class="nav-shell">
        <div class="nav-row">
            <div class="nav-left">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a class="nav-brand" href="{{ route($homeRoute) }}" aria-label="Strongnorth home">
                        <x-jet-application-mark class="block h-10" />
                    </a>
                </div>

                <div class="nav-desktop">
                    @foreach ($navigationLinks as $link)
                        <a href="{{ route($link['route']) }}" class="nav-link"
                            @if ($link['active']) aria-current="page" @endif>
                            <i class="las {{ $link['icon'] }}"
                                aria-hidden="true"></i><span>{{ __($link['label']) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="nav-account">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="account-trigger" aria-label="Open account menu"
                                title="{{ Auth::user()->full_name }}">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="object-cover w-8 h-8 rounded-full"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="" />
                                @else
                                    <i class="las la-user-circle la-lg" aria-hidden="true"></i>
                                @endif
                                <span class="account-name">{{ Auth::user()->full_name }}</span>
                                <i class="las la-angle-down" aria-hidden="true"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Account Profile') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('lc.profile') }}">
                                {{ __('Lifechanger Profile') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('levels.index') }}">
                                {{ __('SSPL Library') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="nav-toggle">
                <button type="button" @click="open = ! open" :aria-expanded="open.toString()"
                    aria-controls="mobile-navigation" aria-label="Toggle navigation"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <span>Menu</span><svg aria-hidden="true" class="w-5 h-5" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-navigation" x-show="open" style="display: none;" class="nav-mobile">
        <div class="nav-mobile-links">
            @foreach ($navigationLinks as $link)
                <a href="{{ route($link['route']) }}" class="nav-link"
                    @if ($link['active']) aria-current="page" @endif>
                    <i class="las {{ $link['icon'] }}" aria-hidden="true"></i><span>{{ __($link['label']) }}</span>
                </a>
            @endforeach
            <a href="{{ route('cs.booked') }}" class="nav-link">{{ __('Booked Shows') }}</a>
            <a href="{{ route('cs.cooked') }}" class="nav-link">{{ __('Cooked Shows') }}</a>
            <a href="{{ route('oa.list') }}" class="nav-link"
                @if (request()->routeIs('oa.*')) aria-current="page" @endif>{{ __('Order Agreements') }}</a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="mr-3 shrink-0">
                        <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->full_name }}" />
                    </div>
                @endif

                <div class="nav-user-info">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->full_name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Account Profile') }}
                </x-jet-responsive-nav-link>

                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('lc.profile') }}" :active="request()->routeIs('lc.profile')">
                    {{ __('Lifechanger Profile') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('levels.index') }}"
                    :active="request()->routeIs('levels.index')">{{ __('SSPL Library') }}</x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
