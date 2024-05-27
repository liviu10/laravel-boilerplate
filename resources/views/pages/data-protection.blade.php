@extends('layouts.guest')

@section('content')
    <div class="guest guest--page">
        <x-page-header title="{{ $data['title'] }}" />

        <div class="guest__body">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
        </div>
    </div>
@endsection
