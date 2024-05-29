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
                id="editForm"
                method="POST"
                action="{{ route($data['action'], $data['rowId']) }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <div class="">
                    @foreach ($data['results'] as $input)
                        <div class="form-floating mb-3">
                            @if ($input['type'] === 'text')
                            <input
                                class="form-control"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                                placeholder="{{ $input['placeholder'] }}"
                                type="{{ $input['type'] }}"
                                value="{{ $input['value'] }}"
                            >
                            @elseif ($input['type'] === 'select')
                            <select
                                class="form-select"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                            >
                                <option value="">{{ __('-- Choose an option --') }}</option>
                                @foreach ($input['options'] as $key => $option)
                                    <option value="{{ $option['value'] }}" @if ($input['value'] !== null && $input['value'] == $key) selected @endif>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @elseif ($input['type'] === 'datetime-local')
                            <input
                                class="form-control"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                                type="{{ $input['type'] }}"
                                value="{{ $input['value'] }}"
                                min="{{ $input['min'] }}"
                            >
                            @elseif ($input['type'] === 'number')
                            <input
                                class="form-control"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                                type="{{ $input['type'] }}"
                                value="{{ $input['value'] }}"
                                min="{{ $input['min'] }}"
                                max="{{ $input['max'] }}"
                            >
                            @elseif ($input['type'] === 'time')
                            <input
                                class="form-control"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                                type="{{ $input['type'] }}"
                                value="{{ $input['value'] }}"
                                min="{{ $input['min'] }}"
                                max="{{ $input['max'] }}"
                            >
                            @endif
                            <label for="{{ $input['key'] }}">
                                {{ $input['placeholder'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success">
                        {{ _('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
