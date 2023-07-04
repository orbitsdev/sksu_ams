<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        {{-- <style>[x-cloak] { display: none !important; }</style> --}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        
        <!-- Styles -->
        @wireUiScripts
        @vite(['resources/css/custom.css', 'resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        @stack('scripts')
    </head>
    <body class="font-sans antialiased">

        {{ $slot }}
        @stack('modals')
        <x-dialog z-index="z-50" blur="md" align="center" />
        @livewireScripts
    </body>
</html>
