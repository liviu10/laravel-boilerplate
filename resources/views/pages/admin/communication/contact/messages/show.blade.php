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
            {{ $data['results'] }}

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
                <input type="hidden" name="contact_message_id" value="{{ $data['rowId'] }}">
                <div class="">
                    @foreach ($data['form'] as $input)
                        @foreach ($input as $item)
                            @if($item['is_create'])
                                @include('components.input-' . $item['type'], $item)
                            @elseif(array_key_exists('is_message_response', $item) && $item['is_message_response'])
                                @include('components.input-' . $item['type'], $item)
                            @endif
                        @endforeach
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
                        {{ _('Respond') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea#message',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            max_height: 500,
            max_width: 500,
            min_height: 100,
            min_width: 400,
            height: 300,
            menubar: false,
        });
    </script>
@endsection
