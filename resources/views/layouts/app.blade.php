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
</head>

<body class="font-sans antialiased">
    <ul class="fixed w-60 top-20 right-2 backdrop-blur-sm z-10" id="toaster-container"></ul>
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />
        {{--
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            --}}

        <!-- Page Content -->
        <div class="flex">
            <x-partials.sidebar />
            <main class="w-full overflow-auto" id="main-content-wrapper">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:navigated', () => {
            let mainNavbar = document.getElementById("main-nav-bar");
            let mainSidebar = document.getElementById("main-side-bar");
            let mainContentWrapper = document.getElementById("main-content-wrapper");
            if (mainNavbar && mainSidebar && mainContentWrapper) {
                mainSidebar.style.height = `calc(100vh - ${mainNavbar.offsetHeight}px)`;
                mainContentWrapper.style.height = `calc(100vh - ${mainNavbar.offsetHeight}px)`;
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            let mainNavbar = document.getElementById("main-nav-bar");
            let mainSidebar = document.getElementById("main-side-bar");
            let mainContentWrapper = document.getElementById("main-content-wrapper");
            if (mainNavbar && mainSidebar && mainContentWrapper) {
                mainSidebar.style.height = `calc(100vh - ${mainNavbar.offsetHeight}px)`;
                mainContentWrapper.style.height = `calc(100vh - ${mainNavbar.offsetHeight}px)`;
            }
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
