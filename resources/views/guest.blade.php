@extends('layouts.guest')

@section('content')
    <div class="guest guest--page">
        @include('components.guest-header', ['title' => 'Bine ai venit la noi!'])

        @include('components.guest-description', [
            'description' => '
                În inima naturii, între peisaje idilice și aer curat, se află ferma noastră, Briofresh Land. Ne mândrim cu o tradiție în
                cultivarea fructelor bio și cu angajamentul nostru ferm pentru mediu și sănătate. Situată într-un colț pitoresc al
                naturii, ne dedicăm pasiunii noastre pentru agricultură ecologică și oferim fructe proaspete și delicioase, crescute
                cu grijă și respect față de mediul înconjurător.
            '
        ])

        @include('components.guest-description', [
            'description' => '
                La Briofresh Land, credem în puterea naturii de a ne hrăni și ne revitaliza. Fiecare zmeură, mură și căpșună pe care
                o cultivăm este o expresie autentică a acestei credințe. De la semințe până la recoltare, respectăm ciclurile
                naturale și folosim practici agricole sustenabile pentru a proteja și îmbogăți ecosistemul nostru local.
            '
        ])

        @include('components.guest-description', [
            'description' => '
                Pentru noi, fiecare caserolă de fructe este mai mult decât un produs - este o poveste a muncii noastre și a
                angajamentului nostru pentru o alimentație sănătoasă și un mediu mai curat. Te invităm să te alături nouă în
                călătoria noastră spre gusturi autentice și prospețime pură, direct din natură, la Briofresh Land!
            '
        ])

        @include('components.guest-line')

        <div class="guest__body">
            <!-- Ce ne recomanda -->
            @include('components.guest-header', ['title' => 'CE NE RECOMANDĂ'])
            @include('components.guest-description', [
                'description' => '
                    La Biofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospetime și savoare autentică.
                '
            ])
            @include('components.guest-line')

            <!-- Vino la noi sa cumper proaspat -->
            @include('components.guest-header', ['title' => 'VINO LA NOI SĂ CUMPERI PROASPĂT'])
            @include('components.guest-description', [
                'description' => '
                    Află unde suntem azi și vino să încerci fructele noastre pline de sănătate. Descoperă locațiile noastre mobile de
                    degustare și desfacere de la Biofresh Land, prezente la târguri, piețe și evenimente speciale din orașul tău.
                    Te invităm să vii și să ne vizitezi punctul mobil de desfacere, unde poți descoperi și degusta fructele proaspete și
                    bio de la Biofresh Land. Experimentează gustul autentic al naturii și bucură-te de o experiență de cumpărături
                    plină de prospețime și bunătate
                '
            ])

            <!-- Ce mai facem prin gradina -->
            @include('components.guest-header', ['title' => 'CE MAI FACEM PRIN GRĂDINĂ'])
            @include('components.guest-description', [
                'description' => '
                    La Biofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospetime și savoare autentică.
                '
            ])

            <!-- Ce spun clientii -->
            @include('components.guest-header', ['title' => 'CE SPUN CLIENȚII'])
            @include('components.guest-description', [
                'description' => '
                    Opiniile clienților noștri spun totul despre gustul și calitatea fructelor noastre. Cu fiecare mușcătură din murele
                    noastre suculente, capsunile dulci și zmeura proaspătă, clienții noștri simt explozia de prospețime și savoare
                    autentică. \'Cele mai bune fructe pe care le-am gustat!', 'Autenticitatea și gustul natural m-au cucerit de la prima
                    mușcătură!\' sunt doar câteva dintre părerile entuziaste ale clienților noștri.
                '
            ])
            @include('components.guest-description', [
                'description' => '
                    Ne bucurăm să aducem bucurie și sănătate în viețile clienților noștri
                    cu fiecare caserolă de fructe Biofresh Land!
                '
            ])
        </div>
    </div>
@endsection
