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

            {{ $data['results'] }}
        </div>
    </div>
@endsection