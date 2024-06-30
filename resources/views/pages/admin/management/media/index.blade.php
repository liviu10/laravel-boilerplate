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

            @include('components.admin-table', [
                'results' => [
                    'options' => [
                        'canAdd' => true,
                        'canFilter' => true,
                        'hasActions' => true,
                        'canShow' => false,
                        'canUpdate' => true,
                        'canDelete' => false,
                        'canRestore' => false,
                        'hasPagination' => false,
                    ],
                    'actions' => $data['actions'],
                    'forms' => $data['forms'],
                    'columns' => [
                        'ID', 'Internal path',
                        'Media type', 'Content', 'Actions'
                    ],
                    'rows' => $data['results']
                ]
            ])
        </div>
    </div>
@endsection
