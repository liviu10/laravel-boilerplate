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
            <x-page-subtitle subtitle="{{ __('Quick access') }}" />

            @include('components.admin-card-shortcuts', [
                'shortcuts' => $data['shortcuts'][0],
            ])
        </div>
    </div>
@endsection
