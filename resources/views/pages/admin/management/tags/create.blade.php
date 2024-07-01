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
            <x-page-card>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p class="my-0">
                            {{ __('The record was not saved in the database') }}
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </p>
                        <button
                            type="button"
                            class="btn btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        />
                    </div>
                @endif

                <form
                    id="createForm"
                    method="POST"
                    action="{{ route($data['action']) }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="card-form">
                        @foreach ($data['results'] as $input)
                            @foreach ($input as $item)
                                @if($item['is_create'])
                                    @include('components.input-' . $item['type'], $item)
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class="card-action">
                        <button
                            class="btn btn-secondary"
                            onclick="window.history.back();"
                            type="button"
                        >
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-success">
                            {{ _('Save') }}
                        </button>
                    </div>
                </form>
            </x-page-card>
        </div>
    </div>
@endsection
