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

        <div class="row guest guest--component" id="about-us">
            <h1 class="col-12 guest__header">
                Bine ai venit la noi!
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
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
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__line"></div>
        </div>

        <div class="row guest guest--component guest--jumbotron">
            <div class="col-4 guest__jumbotron-left">
                <div class="guest__jumbotron-left-top">
                    <div class="content">
                        <p>
                            100% <br>
                            românesc
                        </p>
                        <p class="underline"></p>
                        <p>
                            gustul autentic
                            al României direct la tine în casă.
                        </p>
                    </div>
                    <img src="{{ asset('images/01_icon_100_romanesc_82x82px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="guest__jumbotron-left-bottom">
                    <div class="content">
                        <p>
                            la noi totul <br>
                            este bio
                        </p>
                        <p class="underline"></p>
                        <p>
                            cultivăm și oferim doar produse bio,
                            crescute în armonie cu natura.
                        </p>
                    </div>
                    <img src="{{ asset('images/02_icon_totul_bio_82x82px.svg') }}" width=60 height=60 alt="">
                </div>
            </div>
            <div class="col-4 guest__jumbotron-middle">
                <img src="{{ asset('images/tasty-ripe-sweet-healthy-blackberry.jpg') }}" width=300 height=250 alt="">
            </div>
            <div class="col-4 guest__jumbotron-right">
                <div class="guest__jumbotron-right-top">
                    <img src="{{ asset('images/03_icon_calitate_garantata_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            calitate <br>
                            garantată
                        </p>
                        <p class="underline"></p>
                        <p>
                            garantăm că fiecare gustare este o
                            experiență plină de prospetime și
                            savoare autentică.
                        </p>
                    </div>
                </div>
                <div class="guest__jumbotron-right-bottom">
                    <img src="{{ asset('images/04_icon_tcentru_mobil_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            vino <br>
                            la centrul mobil
                        </p>
                        <p class="underline"></p>
                        <p>
                            te invităm să vii la punctul mobil de
                            degustare și vânzare. Te așteptăm!
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-8 col-sm-12 col-12 guest__jumbotron-responsive">
                <div class="guest__jumbotron-responsive-image">
                    <img src="{{ asset('images/tasty-ripe-sweet-healthy-blackberry-responsive.jpg') }}" width=600 height=500 alt="">
                </div>
                <div class="guest__jumbotron-responsive-content">
                    <img src="{{ asset('images/03_icon_calitate_garantata_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            calitate <br>
                            garantată
                        </p>
                        <p class="underline"></p>
                        <p>
                            garantăm că fiecare gustare este o
                            experiență plină de prospetime și
                            savoare autentică.
                        </p>
                    </div>
                </div>
                <div class="guest__jumbotron-responsive-content">
                    <img src="{{ asset('images/04_icon_tcentru_mobil_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            vino <br>
                            la centrul mobil
                        </p>
                        <p class="underline"></p>
                        <p>
                            te invităm să vii la punctul mobil de
                            degustare și vânzare. Te așteptăm!
                        </p>
                    </div>
                </div>
                <div class="guest__jumbotron-responsive-content">
                    <img src="{{ asset('images/01_icon_100_romanesc_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            100% <br>
                            românesc
                        </p>
                        <p class="underline"></p>
                        <p>
                            gustul autentic
                            al României direct la tine în casă.
                        </p>
                    </div>
                </div>
                <div class="guest__jumbotron-responsive-content">
                    <img src="{{ asset('images/02_icon_totul_bio_82x82px.svg') }}" width=60 height=60 alt="">
                    <div class="content">
                        <p>
                            la noi totul <br>
                            este bio
                        </p>
                        <p class="underline"></p>
                        <p>
                            cultivăm și oferim doar produse bio,
                            crescute în armonie cu natura.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row guest guest-component">
            <div class="col-12 guest__horizontal-line"></div>
        </div>

        <div class="row guest guest--component">
            <h1 class="col-12 guest__header">
                CE NE RECOMANDĂ
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    La Briofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospețime și savoare autentică.
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__line"></div>
        </div>

        <div class="row guest guest--component guest--cards" id="info">
            <div class="col-2 card">
                <div class="card-header">
                    <img src="{{ asset('images/05_icon_01_neselectat_70x70px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="card-body">
                    <p>
                        să ne cunoaștem <br>
                        despre noi
                    </p>
                    <p class="underline"></p>
                    <p>
                        Află mai multe despre
                        Briofresh Land și
                        misiunea noastă.
                    </p>
                </div>
                <div class="card-footer">
                    <img src="https://dummyimage.com/60x60/000/fff" width=60 height=60 alt="">
                </div>
            </div>
            <div class="col-2 card">
                <div class="card-header">
                    <img src="{{ asset('images/06_icon_02_neselectat_70x70px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="card-body">
                    <p>
                        ce mai facem <br>
                        prin gradină știri
                    </p>
                    <p class="underline"></p>
                    <p>
                        Descoperă oamenii, fructele și ferma noastră.
                    </p>
                </div>
                <div class="card-footer">
                    <img src="https://dummyimage.com/60x60/000/fff" width=60 height=60 alt="">
                </div>
            </div>
            <div class="col-2 card">
                <div class="card-header">
                    <img src="{{ asset('images/07_icon_03_selectat_70x70px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="card-body">
                    <p>
                        vino la noi să <br>
                        cumperi proaspăt
                    </p>
                    <p class="underline"></p>
                    <p>
                        Află unde suntem azi și vino să încerci fructele noastre pline de sănătate.
                    </p>
                </div>
                <div class="card-footer">
                    <img src="https://dummyimage.com/60x60/000/fff" width=60 height=60 alt="">
                </div>
            </div>
            <div class="col-2 card">
                <div class="card-header">
                    <img src="{{ asset('images/08_icon_04_neselectat_70x70px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="card-body">
                    <p>
                        suntem sociali <br>
                        caută-ne pe rețelele sociale
                    </p>
                    <p class="underline"></p>
                    <p>
                        <a href="#">Facebook</a>
                        <br>
                        <a href="#">Instagram</a>
                    </p>
                </div>
                <div class="card-footer">
                    <img src="https://dummyimage.com/60x60/000/fff" width=60 height=60 alt="">
                </div>
            </div>
            <div class="col-2 card">
                <div class="card-header">
                    <img src="{{ asset('images/09_icon_05_neselectat_70x70px.svg') }}" width=60 height=60 alt="">
                </div>
                <div class="card-body">
                    <p>
                        cu cine <br>
                        colaborăm noi
                    </p>
                    <p class="underline"></p>
                    <p>
                        Garantăm trasabilitate și
                        transparență pentru fiecare
                        fruct oferit spre vânzare.
                    </p>
                </div>
                <div class="card-footer">
                    <img src="https://dummyimage.com/60x60/000/fff" width=60 height=60 alt="">
                </div>
            </div>
        </div>

        <div class="row guest guest--component" id="events">
            <h1 class="col-12 guest__header">
                VINO LA NOI <br>
                SĂ CUMPERI PROASPĂT
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Află unde suntem azi și vino să încerci fructele noastre pline de sănătate. Descoperă locațiile noastre mobile de
                    degustare și desfacere de la Briofresh Land, prezente la târguri, piețe și evenimente speciale din orașul tău.
                    Te invităm să vii și să ne vizitezi punctul mobil de desfacere, unde poți descoperi și degusta fructele proaspete și
                    bio de la Briofresh Land. Experimentează gustul autentic al naturii și bucură-te de o experiență de cumpărături
                    plină de prospețime și bunătate.
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__image">
                <img src="{{ asset('images/10_poza_centru_mobil_1800x750px.png') }}" width=720 height=300 alt="">
            </div>
        </div>

        <div class="row guest guest--component" id="localization">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__slider-location">
                <div class="guest__slider-location-announcement">
                    <div class="card">
                        <img src="{{ asset('images/11_poza_suntem_aici_370x300px.png') }}" class="card-img-top" width=300 height=224 alt="">
                        <div class="card-body">
                            <p class="card-text">
                                În perioada 01.05. - 10.05.2024 te așteptăm
                                cu drag la Festivalul Murelor din București să
                                încerci fructele noastre delicioase.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="guest__slider-location-image">
                    <div class="card">
                        <iframe
                            width="300"
                            height="300"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDv8eEzN1mcoOt9fibT8iuZqKcQqes7UXw
                                &q=Piata+Unirii,Bucharest">
                        </iframe>
                    </div>
                </div>
                <div class="guest__slider-location-image">
                    <img src="{{ asset('images/12_poza_targ_01_500x500px.png') }}" width=300 height=300 alt="">
                </div>
                <div class="guest__slider-location-image">
                    <img src="{{ asset('images/13_poza_targ_02_500x500px.png') }}" width=300 height=300 alt="">
                </div>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__horizontal-line"></div>
        </div>

        <div class="row guest guest--component">
            <h1 class="col-12 guest__header">
                CE MAI FACEM PRIN GRĂDINĂ
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    La Briofresh Land, ne asigurăm că fiecare fruct este selectat cu grijă și atent examinat pentru a garanta cea mai
                    înaltă calitate. Prin angajamentul nostru față de standardele ridicate și controlul riguros al proceselor, îți garantăm
                    că fiecare gustare este o experiență de neuitat, plină de prospetime și savoare autentică.
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-lg-12 col-10 guest__slider-image">
                <div class="col-lg-4 col-4 guest__slider-image-left">
                    <div>
                        <img src="{{ asset('images/14_poza_gradina_01_500x500px.png') }}" width=350 height=400 alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/15_poza_gradina_02_500x500px.png') }}" width=350 height=400 alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-6 guest__slider-image-right">
                    <div>
                        <img src="{{ asset('images/16_poza_gradina_03_500x1050px.png') }}" width=462 height=816 alt="">
                    </div>
                </div>
            </div>
            <div class="col-10 guest__slider-image-responsive">
                <div>
                    <img src="{{ asset('images/14_poza_gradina_01_500x500px.png') }}" width=480 height=320 alt="">
                </div>
                <div>
                    <img src="{{ asset('images/15_poza_gradina_02_500x500px.png') }}" width=480 height=320 alt="">
                </div>
                <div>
                    <img src="{{ asset('images/16_poza_gradina_03_500x1050px.png') }}" width=480 height=320 alt="">
                </div>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__horizontal-line"></div>
        </div>

        <div class="row guest guest--component">
            <h1 class="col-12 guest__header">
                CE SPUN CLIENȚII
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Opiniile clienților noștri spun totul despre gustul și calitatea fructelor noastre. Cu fiecare mușcătură din murele
                    noastre suculente, căpșunile dulci și zmeura proaspătă, clienții noștri simt explozia de prospețime și savoare
                    autentică. "Cele mai bune fructe pe care le-am gustat! ", "Autenticitatea și gustul natural m-au cucerit de la prima
                    mușcătură! " sunt doar câteva dintre părerile entuziaste ale clienților noștri.
                </p>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Ne bucurăm să aducem bucurie și sănătate în viețile clienților noștri
                    cu fiecare caserolă de fructe Briofresh Land!
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-4 guest__card-reviews">
                <div class="card">
                    <img src="{{ asset('images/17_poza_recenzie_01.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Am fost încântat să descopăr Briofresh Land la un târg local și am decis să încerc
                            murele și zmeura lor. Gustul lor proaspăt și intens m-a surprins plăcut! Fiecare
                            mușcătură era o explozie de savoare. Cu siguranță voi reveni pentru mai multe!" <br>
                            DANIEL MARCU
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-10 guest__card-reviews">
                <div class="col-5 card">
                    <img src="{{ asset('images/18_poza_recenzie_02.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Căpșunile de la Briofresh Land sunt absolut delicioase! Sunt atât de dulci
                            și aromate, iar ambalajul lor convenabil face să fie ușor să le iau cu mine
                            peste tot. Efectiv nu pot să mă satur de ele." <br>
                            CRISTINA POPESCU
                        </p>
                    </div>
                </div>
                <div class="col-5 card">
                    <img src="{{ asset('images/19_poza_recenzie_03.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Am cumpărat câteva caserole de zmeură de la punctul mobil de desfacere
                            Briofresh Land și am fost impresionată de calitatea lor. Recomand cu
                            încredere!" <br>
                            ADELA ION
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-11 guest__card-reviews-responsive">
                <div class="col-5 card">
                    <img src="{{ asset('images/17_poza_recenzie_01.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Am fost încântat să descopăr Briofresh Land la un târg local și am decis să încerc
                            murele și zmeura lor. Gustul lor proaspăt și intens m-a surprins plăcut! Fiecare
                            mușcătură era o explozie de savoare. Cu siguranță voi reveni pentru mai multe!" <br>
                            DANIEL MARCU
                        </p>
                    </div>
                </div>
                <div class="col-5 card">
                    <img src="{{ asset('images/18_poza_recenzie_02.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Căpșunile de la Briofresh Land sunt absolut delicioase! Sunt atât de dulci
                            și aromate, iar ambalajul lor convenabil face să fie ușor să le iau cu mine
                            peste tot. Efectiv nu pot să mă satur de ele." <br>
                            CRISTINA POPESCU
                        </p>
                    </div>
                </div>
                <div class="col-5 card">
                    <img src="{{ asset('images/19_poza_recenzie_03.png') }}" class="card-img-top" width=75 height=75 alt="">
                    <div class="card-body">
                        <p class="card-text">
                            "Am cumpărat câteva caserole de zmeură de la punctul mobil de desfacere
                            Briofresh Land și am fost impresionată de calitatea lor. Recomand cu
                            încredere!" <br>
                            ADELA ION
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-12 guest__horizontal-line"></div>
        </div>

        <div class="row guest guest--component" id="contact-us">
            <h1 class="col-12 guest__header">
                CONTACT
            </h1>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Ne-ar plăcea să auzim de la tine! <br>
                    Pentru întrebări, comenzi sau colaborări, poți să ne contactezi folosind informațiile de mai jos:
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    tel/whatsapp: <br>
                    <span>
                        <a href="tel:+40747339283">
                            +40 747 339 283
                        </a>
                    </span>
                    <br>
                    Email: <br>
                    <span>
                        <a href="mailto:office@briofreshland.ro">
                            office@briofreshland.ro
                        </a>
                    </span>
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Nu ezita să ne trimiți un mesaj sau să ne suni pentru a discuta mai multe despre produsele noastre, punctele noastre mobile de
                    desfacere sau alte detalii legate de Briofresh Land. Suntem aici pentru tine și abia așteptăm să colaborăm sau să-ți oferim cele
                    mai bune fructe bio și proaspete!
                </p>
            </div>
        </div>

        <div class="row guest guest--component">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__description">
                <p>
                    Locațiile noastre mobile de desfacere sunt prezente la diverse evenimente și piețe din orașul tău. Urmărește-ne pe rețelele de
                    socializare pentru a fi la curent cu ultimele noutăți și locațiile noastre actuale. Te așteptăm cu drag să ne faci o vizită și să
                    descoperi gustul autentic al naturii cu Briofresh Land!
                </p>
            </div>
        </div>
    </div>
@endsection
