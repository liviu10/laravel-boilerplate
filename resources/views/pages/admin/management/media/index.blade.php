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
                    'columns' => [
                        'ID', 'Path', 'Title', 'Caption', 'Alternate text',
                        'Media type', 'Content', 'Added by', 'Actions'
                    ],
                    'rows' => $data['results']
                ]
            ])
        </div>
    </div>
@endsection
