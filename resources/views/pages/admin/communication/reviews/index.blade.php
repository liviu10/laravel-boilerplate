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
                        'canAdd' => false,
                        'canFilter' => true,
                        'hasActions' => true,
                        'canShow' => false,
                        'canUpdate' => true,
                        'canDelete' => false,
                        'canRestore' => false,
                        'hasPagination' => false,
                    ],
                    'columns' => [
                        'ID', 'Full name', 'Rating', 'Is active?',
                        'Added by', 'Actions'
                    ],
                    'rows' => $data['results']
                ]
            ])
        </div>
    </div>
@endsection
