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
                        'canShow' => true,
                        'canUpdate' => false,
                        'canDelete' => false,
                        'canRestore' => false,
                        'hasPagination' => false,
                    ],
                    'forms' => [
                        'filter_form' => $data['filter_form'],
                    ],
                    'columns' => [
                        'ID', 'Fullname', 'Email',
                        'Phone', 'Privacy policy', 'Terms and conditions',
                        'Data protection', 'Contact subject', 'Actions'
                    ],
                    'rows' => $data['results']
                ]
            ])
        </div>
    </div>
@endsection
