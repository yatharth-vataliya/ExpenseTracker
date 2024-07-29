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

    <style>
        @keyframes radient-animation {
            0% {
                background-size: 400%;
            }

            50% {
                background-size: 100%;
            }

            75% {
                background-size: 150%;
            }

            100% {
                background-size: 400%;
            }
        }

        .background-gradient-animation {
            background-image: linear-gradient(to right, red, white);
            animation: radient-animation 60s ease-out infinite;
        }
    </style>

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50 background-gradient-animation">
    <div class="dark:bg-black h-screen w-full p-4 flex flex-col">
        <div class="flex justify-end w-full">
            @if (Route::has('login'))
                <livewire:welcome.navigation />
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
