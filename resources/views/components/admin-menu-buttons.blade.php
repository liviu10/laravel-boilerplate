<div class="admin__menu-buttons">
    @foreach($data as $key => $value)
        @include('components.generic-href-button', [
            'url' => $value['url'],
            'title' => $value['title']
        ])
    @endforeach
</div>
