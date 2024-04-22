@foreach($adminStats['stats'] as $key => $item)
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm 6 col-12 card">
        <div class="card-body">
            <h5 class="card-title">
                {{ $item['title'] }}
                <i class="{{ $item['icon'] }}"></i>
            </h5>
            @foreach($item['stats'] as $subKey => $subItem)
                <p class="card-text">
                    <span>{{ $subItem['title'] }}</span>
                    {{ $subItem['value'] }}
                </p>
            @endforeach
        </div>
    </div>
@endforeach

