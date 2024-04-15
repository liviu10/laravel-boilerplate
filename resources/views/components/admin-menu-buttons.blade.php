<div class="admin__menu-buttons">
    @foreach($data as $key => $value)
        <a class="btn btn-primary" href="{{ $value['url'] }}">
            {{ $value['title'] }}
        </a>
    @endforeach
</div>
