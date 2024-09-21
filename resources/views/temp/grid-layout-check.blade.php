<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <style>
        body {
            background-color: black;
            padding: 0px;
            margin: 0px;
            height: 100vh;
        }

        main {
            height: 100vh;
            max-height: 100vh;
            background-color: lime;
            display: grid;
            grid-template-areas:
                "head head head"
                "side content content"
                "foot foot foot";
            grid-template-rows: 100px auto 100px;

        }

        header {
            grid-area: head;
            background-color: red;
        }

        article {
            overflow-y: scroll;
            grid-area: content;
            background-color: green;
        }

        aside {
            overflow-y: auto;
            grid-area: side;
            background-color: pink;
        }

        footer {
            grid-area: foot;
            background-color: blue;
        }
    </style>

</head>

<body>
    <main>
        <header>
            Header
        </header>
        <aside>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
        </aside>
        <article>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
            <div style="height: 100px;">Hello</div>
        </article>
        <footer>
            Footer
        </footer>
    </main>
</body>

</html>
