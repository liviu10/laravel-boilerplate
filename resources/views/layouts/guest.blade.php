<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} | {{ config('app.owner') }}</title>
        <!-- FONT AWESOME V6.3.0 IMPORT LINK -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <!-- GOOGLE FONTS IMPORT LINK -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- LOCAL CSS AND JAVASCRIPT -->
        @vite(['resources/sass/guest.scss', 'resources/js/app.js'])
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea#greetings_description',
                plugins: 'code table lists',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
                max_height: 500,
                max_width: 500,
                min_height: 100,
                min_width: 400,
                height: 300,
                menubar: false,
            });
        </script>
    </head>
    <body>

        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('Services') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('Contact me') }}</a>
                            </li>
                            @if (Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.index') }}" target="_blank">
                                        {{ __('View Admin') }}
                                        <i class="fa-solid fa-up-right-from-square"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="container-fluid">
                @yield('content')
            </main>
        </div>

    </body>
</html>
