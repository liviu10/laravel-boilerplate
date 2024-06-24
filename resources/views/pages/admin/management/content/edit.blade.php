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
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" />
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
                            @foreach ($input as $item)
                                @if($item['is_edit'])
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
                            {{ _('Update') }}
                        </button>
                    </div>
                </form>
            </x-page-card>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            max_height: 500,
            max_width: 500,
            min_height: 100,
            min_width: 400,
            height: 300,
            menubar: false,
        });

        document.addEventListener('DOMContentLoaded', function() {
            function toggleScheduledOnInput() {
                var contentVisibilitySelect = document.getElementById('content_visibility_id');
                var scheduledOnInput = document.getElementById('scheduled_on');
                var scheduledOnLabel = document.querySelector('label[for="scheduled_on"]');

                if (contentVisibilitySelect && scheduledOnInput && scheduledOnLabel) {
                    // Visibility is scheduled
                    if (contentVisibilitySelect.value == '3') {
                        scheduledOnInput.style.display = '';
                        scheduledOnLabel.style.display = '';
                    } else {
                        scheduledOnInput.style.display = 'none';
                        scheduledOnLabel.style.display = 'none';
                    }
                }
            }

            var contentVisibilitySelect = document.getElementById('content_visibility_id');
            if (contentVisibilitySelect) {
                contentVisibilitySelect.addEventListener('change', toggleScheduledOnInput);
                toggleScheduledOnInput();
            }
        });
    </script>
@endsection
