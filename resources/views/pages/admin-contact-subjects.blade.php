@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <x-page-header title="{{ $data['title'] }}" />

        <div class="admin__jumbotron">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
        </div>

        <div class="admin__body"></div>

        @include('components.admin-table', [
            'results' => [
                'columns' => $data['results']['columns'],
                'rows' => $data['results']['rows'],
                'forms' => $data['results']['forms'],
                'options' => $data['results']['options'],
            ]
        ])
    </div>
@endsection
