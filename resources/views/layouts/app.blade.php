<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="winter">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Styles -->
    @livewireStyles

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .app-pagebar { background: #fff; border-bottom: 1px solid #e2e8f0; }
        .app-pagebar-inner { max-width: 1600px; margin: auto; padding: 7px 24px; min-height: 38px; display: flex; align-items: center; color: #526078; }
        .app-pagebar .breadcrumbs { padding: 0; font-size: 12px; }
        .app-pagebar .breadcrumbs a:hover { color: #4338ca; }
        .app-pagebar a:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media (max-width: 640px) { .app-pagebar-inner { padding: 7px 16px; } }
    </style>
    @stack('head')
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="app-pagebar">
                <div class="app-pagebar-inner">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>

    @stack('scripts')
    @stack('modals')

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
