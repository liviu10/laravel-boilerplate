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
                    {{ __('Category') }}, {{ __('Visibility') }} and {{ __('Type') }}
                </h5>
                @if ($data['results']->toArray()[0]['content_category'] && count($data['results']->toArray()[0]['content_category']) > 0)
                    @foreach ($data['results']->toArray()[0]['content_category'] as $key => $item)
                        @if ($key !== 'id')
                            <div class="card-text">
                                {{ __('Category') }}: {{ $item }}
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($data['results']->toArray()[0]['content_visibility'] && count($data['results']->toArray()[0]['content_visibility']) > 0)
                    @foreach ($data['results']->toArray()[0]['content_visibility'] as $key => $item)
                        @if ($key !== 'id')
                            <div class="card-text">
                                {{ __('Visibility') }}:
                                <span class="badge text-bg-primary">{{ $item }}</span>
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($data['results']->toArray()[0]['content_type'] && count($data['results']->toArray()[0]['content_type']) > 0)
                    @foreach ($data['results']->toArray()[0]['content_type'] as $key => $item)
                        @if ($key !== 'id')
                            <div class="card-text">
                                {{ __('Type') }}: {{ $item }}
                            </div>
                        @endif
                    @endforeach
                @endif
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Social media') }}
                </h5>
                @if ($data['results']->toArray()[0]['content_social_media'] && count($data['results']->toArray()[0]['content_social_media']) > 0)
                    @foreach ($data['results']->toArray()[0]['content_social_media'] as $key => $item)
                        @if ($key !== 'id')
                            <div class="card-text">
                                {{ ucwords(str_replace('_', ' ', $key)) }}:
                                @if ($key === 'full_share_url')
                                    <a href="{{ $item }}" target="_blank">
                                        {{ $item }}
                                    </a>
                                @else
                                    {{ $item }}
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Tags') }}
                </h5>
                @if ($data['results']->toArray()[0]['tags'] && count($data['results']->toArray()[0]['tags']) > 0)
                    @foreach ($data['results']->toArray()[0]['tags'] as $key => $item)
                        @if ($key !== 'id')
                            <div class="card-text">
                                {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $item }}
                            </div>
                        @endif
                    @endforeach
                @endif
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Content') }}
                </h5>
                @foreach ($data['results']->toArray()[0] as $key => $item)
                    @if ($key !== 'id' && $key !== 'content_visibility_id' && $key !== 'content_type_id' && $key !== 'content_category_id' && $key !== 'user_id')
                        <div class="card-text">
                            @if (!is_array($item))
                                {{ ucwords(str_replace('_', ' ', $key)) }}:
                                @if (
                                    in_array($key, ['allow_comments', 'allow_share', 'is_admin', 'is_guest_home']) &&
                                    (is_bool($item) || (is_numeric($item) && ($item === 0 || $item === 1)))
                                )
                                    <span class="badge {{ $item ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ __($item ? 'Yes' : 'No') }}
                                    </span>
                                @else
                                    {{ $item }}
                                @endif
                            @endif
                        </div>
                    @endif
                @endforeach
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Media') }}
                </h5>
                @if ($data['results']->toArray()[0]['media'] && count($data['results']->toArray()[0]['media']) > 0)
                    @foreach ($data['results']->toArray()[0]['media'] as $key => $item)
                        @if ($key !== 'id' && $key !== 'media_type_id' && $key !== 'content_id')
                            <div class="card-text">
                                {{ ucwords(str_replace('_', ' ', $key)) }}:
                                @if ($key === 'internal_path' && $key === 'external_path')
                                    <a href="{{ $item }}" target="_blank">
                                        {{ $item }}
                                    </a>
                                @elseif ($key === 'media_type'):
                                    @foreach ($item as $subKey => $subItem)
                                        @if ($key !== 'id')
                                            {{ $subItem }}
                                        @endif
                                    @endforeach
                                @else
                                    {{ $item }}
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif
            </x-page-card>

            <x-page-card>
                <h5 class="card-title">
                    {{ __('Comments') }} and {{ __('Appreciations') }}
                </h5>
                @if ($data['results']->toArray()[0]['comments'] && count($data['results']->toArray()[0]['comments']) > 0)
                    @foreach ($data['results']->toArray()[0]['comments'] as $key => $item)
                        @if ($key !== 'id' && $key !== 'comment_type_id' && $key !== 'comment_status_id' && $key !== 'content_id')
                            <div class="card-text">
                                {{ ucwords(str_replace('_', ' ', $key)) }}:
                                @if (
                                    in_array($key, ['notify_new_comments']) &&
                                    (is_bool($item) || (is_numeric($item) && ($item === 0 || $item === 1)))
                                )
                                    <span class="badge {{ $item ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ __($item ? 'Yes' : 'No') }}
                                    </span>
                                @elseif ($key === 'comment_type'):
                                    @foreach ($item as $subKey => $subItem)
                                        @if ($key !== 'id')
                                            {{ $subItem }}
                                        @endif
                                    @endforeach
                                @elseif ($key === 'comment_status'):
                                    @foreach ($item as $subKey => $subItem)
                                        @if ($key !== 'id')
                                            {{ $subItem }}
                                        @endif
                                    @endforeach
                                @else
                                    {{ $item }}
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($data['results']->toArray()[0]['appreciations'] && count($data['appreciations']->toArray()[0]['media']) > 0)
                    @foreach ($data['results']->toArray()[0]['appreciations'] as $key => $item)
                        @if ($key !== 'id' && $key !== 'content_id' && $key !== 'user_id')
                            <div class="card-text">
                                {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $item }}
                            </div>
                        @endif
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
