<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

    </style>
</head>

<body class="font-sans antialiased sm:h-auto">
    <ul class="fixed w-60 top-20 right-2 backdrop-blur-sm z-10" id="toaster-container"></ul>
    <div class="sm:relative sm:min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        <!-- Page Content -->
        <div class="flex-col sm:flex sm:flex-row sm:flex-auto">
            <x-partials.sidebar />
            <section class="w-full sm:h-max overflow-auto" id="main-content-wrapper">
                {{ $slot }}
            </section>
        </div>
    </div>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
