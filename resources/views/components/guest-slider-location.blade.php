<div class="row guest guest--component" id="localization">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-10 col-11 guest__slider-location">
        <div class="guest__slider-location-announcement">
            <div class="card">
                <img src="{{ asset('storage/11_poza_suntem_aici_370x300px.png') }}" class="card-img-top" width=230 height=186 alt="">
                <div class="card-body">
                    <p class="card-text">
                        {{ $googleMapsLocation['description'] }}
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
                        &q={{ str_replace(' ', '+', $googleMapsLocation['address']) }}">
                </iframe>
            </div>
        </div>
        <div class="guest__slider-location-image">
            <img src="{{ asset('storage/12_poza_targ_01_500x500px.png') }}" width=300 height=300 alt="">
        </div>
        <div class="guest__slider-location-image">
            <img src="{{ asset('storage/13_poza_targ_02_500x500px.png') }}" width=300 height=300 alt="">
        </div>
    </div>
</div>
