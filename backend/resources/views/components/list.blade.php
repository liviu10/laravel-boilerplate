@if (count($listContent))
    <ul class="list-group">
        @foreach ($listContent as $item)
            <li class="list-group-item">{{ $item }}</li>
        @endforeach
    </ul>
@endif
