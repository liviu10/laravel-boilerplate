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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <!-- LOCAL CSS AND JAVASCRIPT -->
        @vite(['resources/sass/guest.scss', 'resources/js/app.js'])
    </head>
    <body>

        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container guest">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('storage/00_logo_portrait_220x40px.svg') }}" width=220 height=40 alt="">
                    </a>
                    <button
                        class="navbar-toggler collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}"
                    >
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about-us">Despre noi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#events">Evenimente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#localization">Unde suntem</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact-us">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="container-fluid">
                @yield('content')
            </main>

            <div class="guest">
                <div class="guest__footer">
                    <p>
                        BRIOFRESH LAND
                    </p>
                    <p>
                        CUI: 14399840, Reg. Com. J40/372/2002
                    </p>
                    <p>
                        ©2024. All Rights reserved.
                    </p>
                    <a href="#" target="_blank">
                        Termeni și Condiții
                    </a>
                </div>
            </div>

            <button
                id="chat_with_us"
                class="btn btn-primary"
                title="Scrie-ne!"
                data-phone-number="+40760961010"
                data-message="Buna ziua! Sunt interesat de capsunile dvs.!"
            >
                <span>
                    <i class="fa-brands fa-whatsapp"></i>
                    Scrie-ne!
                </span>
            </button>

            <button id="scroll_top" class="btn btn-primary" onclick="scrollToTop()" title="Sus">
                <span>
                    <i class="fas fa-arrow-up"></i>
                    Sus
                </span>
            </button>
        </div>
    </body>
</html>
