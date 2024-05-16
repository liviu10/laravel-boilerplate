@extends('layouts.guest')

@section('content')
    <div class="guest guest--page">
        <video
            autoplay
            controlslist="nofullscreen nodownload noremoteplayback noplaybackrate foobar"
            disablepictureinpicture
            disablefullscreen
            loop=1
            muted=1
            width="100%"
        >
            <source src="{{ asset('videos/home_harvest_desktop.mp4') }}" type="video/mp4" />
        </video>

        <x-guest-header headerId="about-us">
            {{ __('Bine ai venit la noi!') }}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    În inima naturii, între peisaje idilice și aer curat, se află ferma noastră, Briofresh Land. Ne mândrim cu o tradiție în
                    cultivarea fructelor bio și cu angajamentul nostru ferm pentru mediu și sănătate. Situată într-un colț pitoresc al
                    naturii, ne dedicăm pasiunii noastre pentru agricultură ecologică și oferim fructe proaspete și delicioase, crescute
                    cu grijă și respect față de mediul înconjurător.
                </p>
                <p>
                    La Briofresh Land, credem în puterea naturii de a ne hrăni și ne revitaliza. Fiecare zmeură, mură și căpșună pe care
                    o cultivăm este o expresie autentică a acestei credințe. De la semințe până la recoltare, respectăm ciclurile
                    naturale și folosim practici agricole sustenabile pentru a proteja și îmbogăți ecosistemul nostru local.
                </p>
                <p>
                    Pentru noi, fiecare caserolă de fructe este mai mult decât un produs - este o poveste a muncii noastre și a
                    angajamentului nostru pentru o alimentație sănătoasă și un mediu mai curat. Te invităm să te alături nouă în
                    călătoria noastră spre gusturi autentice și prospețime pură, direct din natură, la Briofresh Land!
                </p>
            ') !!}
        </x-guest-description>

        @include('components.guest-line')

        <x-guest-jumbotron />

        @include('components.guest-horizontal-line')

        <x-guest-header>
            {{ __('CE NE RECOMANDĂ') }}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    La Briofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospețime și savoare autentică.
                </p>
            ') !!}
        </x-guest-description>

        @include('components.guest-line')

        <x-guest-cards />

        <x-guest-header headerId="events">
            {!! __('VINO LA NOI <br> SĂ CUMPERI PROASPĂT') !!}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    Află unde suntem azi și vino să încerci fructele noastre pline de sănătate. Descoperă locațiile noastre mobile de
                    degustare și desfacere de la Briofresh Land, prezente la târguri, piețe și evenimente speciale din orașul tău.
                    Te invităm să vii și să ne vizitezi punctul mobil de desfacere, unde poți descoperi și degusta fructele proaspete și
                    bio de la Briofresh Land. Experimentează gustul autentic al naturii și bucură-te de o experiență de cumpărături
                    plină de prospețime și bunătate.
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-image />

        <x-guest-slider-location />

        @include('components.guest-horizontal-line')

        <x-guest-header>
            {{ __('CE MAI FACEM PRIN GRĂDINĂ') }}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    La Briofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospetime și savoare autentică.
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-slider-image />

        @include('components.guest-horizontal-line')

        <x-guest-header>
            {{ __('CE SPUN CLIENȚII') }}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    Opiniile clienților noștri spun totul despre gustul și calitatea fructelor noastre. Cu fiecare mușcătură din murele
                    noastre suculente, căpșunile dulci și zmeura proaspătă, clienții noștri simt explozia de prospețime și savoare
                    autentică. "Cele mai bune fructe pe care le-am gustat! ", "Autenticitatea și gustul natural m-au cucerit de la prima
                    mușcătură! " sunt doar câteva dintre părerile entuziaste ale clienților noștri.
                </p>
                <p>
                    Ne bucurăm să aducem bucurie și sănătate în viețile clienților noștri
                    cu fiecare caserolă de fructe Briofresh Land!
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-reviews />

        @include('components.guest-horizontal-line')

        <x-guest-header headerId="contact-us">
            {{ __('CONTACT') }}
        </x-guest-header>

        <x-guest-description>
            {!! __('
                <p>
                    Ne-ar plăcea să auzim de la tine! <br>
                    Pentru întrebări, comenzi sau colaborări, poți să ne contactezi folosind informațiile de mai jos:
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-description>
            {!! __('
                <p>
                    tel/whatsapp: <br>
                    <span>
                        <a href="tel:+40747339283" class="contact-phone">
                            +40 747 339 283
                        </a>
                    </span>
                    <br>
                    Email: <br>
                    <span>
                        <a href="mailto:office@briofreshland.ro" class="contact-email">
                            office@briofreshland.ro
                        </a>
                    </span>
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-description>
            {!! __('
                <p>
                    Nu ezita să ne trimiți un mesaj sau să ne suni pentru a discuta mai multe despre produsele noastre, punctele noastre mobile de
                    desfacere sau alte detalii legate de Briofresh Land. Suntem aici pentru tine și abia așteptăm să colaborăm sau să-ți oferim cele
                    mai bune fructe bio și proaspete!
                </p>
            ') !!}
        </x-guest-description>

        <x-guest-description>
            {!! __('
                <p>
                    Locațiile noastre mobile de desfacere sunt prezente la diverse evenimente și piețe din orașul tău. Urmărește-ne pe rețelele de
                    socializare pentru a fi la curent cu ultimele noutăți și locațiile noastre actuale. Te așteptăm cu drag să ne faci o vizită și să
                    descoperi gustul autentic al naturii cu Briofresh Land!
                </p>
            ') !!}
        </x-guest-description>
    </div>
@endsection
