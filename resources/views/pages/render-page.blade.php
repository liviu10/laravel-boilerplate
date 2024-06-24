@extends('layouts.guest')

@section('content')
    <div class="guest guest--page">
        <x-page-header title="{{ $data['title'] }}" />

        @if (!$data['is_guest_home'])
            <p>
                {{ $data['content_visibility']['label'] }} by {{ $data['user']['full_name'] }} at {{ $data['updated_at'] }}
            </p>
        @endif

        <div class="guest__body">
            {!! $data['content'] !!}
        </div>
    </div>
@endsection
