<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css'])

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="dark:bg-black h-screen w-full p-2 sm:p-4 flex flex-col bg-gray-100">
        <div class="flex w-full bg-gray-200 rounded">
            @if (Route::has('login'))
                <div
                    class="p-2 sm:p-4 dark:bg-black sm:rounded w-full flex [&_a]:block flex-col gap-2 [&_a]:w-full text-center md:flex-row md:[&_a]:w-auto">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-black bg-white hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 inline-block hover:shadow-md rounded p-2"
                            wire:navigate>Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-black bg-white hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 hover:shadow-md rounded p-2"
                            wire:navigate>Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="font-semibold text-black bg-white hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 hover:shadow-md rounded p-2"
                                wire:navigate>Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="h-full w-full flex flex-col justify-center items-center">
            <div class="text-xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl">
                Expense Tracker
            </div>
            <div class="justify-center items-center text-sm sm:text-sm md:text-2xl lg:text-3xl xl:text-4xl">
                Manage your all of Expense digitally at single space
            </div>
        </div>
    </div>
</body>

</html>
