<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin {{ config('app.name') }} | {{ config('app.owner') }}</title>
        <!-- FONT AWESOME V6.3.0 -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <!-- GOOGLE FONTS -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- LOCAL CSS AND JAVASCRIPT -->
        @vite(['resources/sass/admin.scss', 'resources/js/app.js'])
    </head>
    <body>

        <div id="app">
            @include('components.admin-navigation-bar')

            <main class="container-fluid">
                @yield('content')
            </main>
        </div>

    </body>
</html>
