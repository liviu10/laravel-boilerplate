@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <x-page-header title="{{ $data['title'] }}" />

        <div class="admin__jumbotron">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
        </div>

        <div class="admin__body">
            <x-page-card>
                <h5 class="card-title">
                    {{  __('Subject') }}
                </h5>
                @foreach ($data['results']->toArray()[0] as $key => $item)
                    @if (!is_array($item))
                        <div class="card-text">
                            {{ ucwords(str_replace('_', ' ', $key)) }}:
                            @if (
                                in_array($key, ['is_active']) &&
                                (is_bool($item) || (is_numeric($item) && ($item === 0 || $item === 1)))
                            )
                                <span class="badge {{ $item ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ __($item ? 'Yes' : 'No') }}
                                </span>
                            @else
                                {{ $item }}
                            @endif
                        </div>
                    @endif
                @endforeach
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Latest messages') }}
                </h5>
                @if ($data['results']->toArray()[0]['contact_messages'] && count($data['results']->toArray()[0]['contact_messages']) > 0)
                    @foreach ($data['results']->toArray()[0]['contact_messages'] as $key => $item)
                        <p class="card-text">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    @foreach ($item as $subKey => $subItem)
                                        <div>
                                            {{ ucwords(str_replace('_', ' ', $subKey)) }}:
                                            @if (
                                                in_array($subKey, ['privacy_policy', 'terms_and_conditions', 'data_protection']) &&
                                                (is_bool($subItem) || (is_numeric($subItem) && ($subItem === 0 || $subItem === 1)))
                                            )
                                                <span class="badge {{ $subItem ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ __($subItem ? 'Yes' : 'No') }}
                                                </span>
                                            @else
                                                {{ $subItem }}
                                            @endif
                                        </div>
                                    @endforeach
                                    <a
                                        class="btn btn-info"
                                        href="{{ route('messages.show', $item['id']) }}"
                                        type="button"
                                    >
                                        {{ __('See message') }}
                                    </a>
                                </li>
                            </ul>
                        </p>
                    @endforeach
                @endif
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Added by') }}
                </h5>
                @foreach ($data['results']->toArray()[0]['user'] as $key => $item)
                    @if ($key !== 'id')
                        <div class="card-text">
                            {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $item }}
                        </div>
                    @endif
                @endforeach
            </x-page-card>
        </div>
    </div>
@endsection
