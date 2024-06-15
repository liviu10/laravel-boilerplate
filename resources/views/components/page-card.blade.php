<div class="row page page--component">
    <div class="col-lg-8 col-sm-10 col-12 card page__card">
        <div class="card-body">
            <ul class="list-group">
                @foreach ($body as $key => $item)
                    <li class="list-group-item">
                        {{ $key }}:
                        @if (is_array($item))
                            @foreach ($item as $subKey => $subItem)
                                @if (is_array($subItem))
                                    <ul class="list-group">
                                        @foreach ($subItem as $k => $i)
                                            <li class="list-group-item">
                                                <span>{{ $k }}:</span>
                                                @if (
                                                    in_array($k, ['is_active', 'valid_email', 'privacy_policy', 'terms_and_conditions', 'data_protection']) &&
                                                    (is_bool($i) || (is_numeric($i) && ($i === 0 || $i === 1)))
                                                )
                                                    <span class="badge {{ $i ? 'text-bg-success' : 'text-bg-danger' }}">
                                                        {{ __($i ? 'Yes' : 'No') }}
                                                    </span>
                                                @else
                                                    {{ $i }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>{{ $subKey }}:</span> {{ $subItem }}
                                @endif
                            @endforeach
                        @else
                            {{ $item }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
