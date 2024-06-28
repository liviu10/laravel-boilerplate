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
                    <div class="">
                        @foreach ($data['results'] as $input)
                            @foreach ($input as $item)
                                @if($item['is_create'])
                                    @include('components.input-' . $item['type'], $item)
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class="modal-footer">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleMediaTypeInput() {
                var mediaTypeSelect = document.getElementById('media_type_id');
                var captionInput = document.getElementById('caption');
                var captionLabel = document.querySelector('label[for="caption"]');
                var altTextInput = document.getElementById('alt_text');
                var altTextLabel = document.querySelector('label[for="alt_text"]');
                var descriptionInput = document.getElementById('description');
                var descriptionLabel = document.querySelector('label[for="description"]');

                if (mediaTypeSelect && captionInput && captionLabel &&
                altTextInput && altTextLabel && descriptionInput && descriptionLabel) {
                    // Media type is documents
                    if (mediaTypeSelect.value == '1') {
                        captionInput.style.display = '';
                        captionLabel.style.display = '';
                        altTextInput.style.display = '';
                        altTextLabel.style.display = '';
                        descriptionInput.style.display = '';
                        descriptionLabel.style.display = '';
                    } else {
                        captionInput.style.display = 'none';
                        captionLabel.style.display = 'none';
                        altTextInput.style.display = 'none';
                        altTextLabel.style.display = 'none';
                        descriptionInput.style.display = 'none';
                        descriptionLabel.style.display = 'none';
                    }
                }
            }

            var mediaTypeSelect = document.getElementById('media_type_id');
            if (mediaTypeSelect) {
                mediaTypeSelect.addEventListener('change', toggleMediaTypeInput);
                toggleMediaTypeInput();
            }
        });
    </script>
@endsection
