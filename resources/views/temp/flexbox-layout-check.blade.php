<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])

    <style>
        body {
            padding: 0px;
            margin: 0px;
            height: 100vh;
        }
    </style>

</head>

<body class="max-h-screen">
    <div class="p-3 bg-gray-200 text-center">Header</div>
    <div class="w-full flex bg-gray-400">
        <div class="bg-lime-200 p-3 w-48 rounded">
            Aside
        </div>
        <div class="bg-lime-400 p-3 rounded">
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
            <div class="h-48 m-3 bg-green-100">Hello</div>
        </div>
    </div>
    <div>Footer</div>
</body>

</html>
