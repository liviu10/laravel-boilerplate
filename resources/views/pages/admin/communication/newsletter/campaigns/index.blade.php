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
            @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="my-0">
                    {{ __('The record was successfully saved') }}
                </p>
                <button
                    type="button"
                    class="btn btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                />
            </div>
            @endif

            @include('components.admin-table', [
                'results' => [
                    'options' => [
                        'canAdd' => true,
                        'canFilter' => true,
                        'hasActions' => true,
                        'canShow' => true,
                        'canUpdate' => true,
                        'canDelete' => false,
                        'canRestore' => false,
                        'hasPagination' => false,
                    ],
                    'actions' => $data['actions'],
                    'forms' => $data['forms'],
                    'columns' => [
                        'ID', 'Name', 'Is active?', 'Valid from',
                        'Valid to', 'Occur times', 'Occur week',
                        'Occur day', 'Occur hour', 'Actions'
                    ],
                    'rows' => $data['results']
                ]
            ])
        </div>
    </div>
@endsection
