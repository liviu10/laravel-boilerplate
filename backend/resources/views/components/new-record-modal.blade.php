<button
    id="newRecord"
    type="button"
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#newRecordModal"
>
    <i class="fa-sharp fa-solid fa-pencil"></i>
    {{ $modal['button_label'] }}
</button>
<div
    class="modal fade"
    id="newRecordModal"
    tabindex="-1"
    aria-labelledby="newRecordModal"
    aria-hidden="true"
    data-bs-backdrop="static"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newRecordModalLabel">
                    {{ $modal['title'] }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ $modal['action_route'] }}">
                    @csrf

                    @foreach ($modal['settings'] as $key => $data)
                        @if ($data['component_type'] === 'input')
                            @include('components.generic.input', [
                                'input' => [
                                    'label' => $data['label'],
                                    'id' => $data['input_id'],
                                    'type' => $data['input_type'],
                                    'value' => '',
                                    'autocomplete' => $data['input_id'],
                                    'disabled' => false
                                ]
                            ])
                        @endif
                        @if ($data['component_type'] === 'textarea')
                            @include('components.generic.textarea', [
                                'input' => [
                                    'id' => $data['input_id'],
                                    'label' => $data['label']
                                ]
                            ])
                        @endif
                        @if ($data['component_type'] === 'select')
                            @include('components.generic.select', [
                                'input' => [
                                    'id' => $data['input_id'],
                                    'label' => $data['label'],
                                    'options' => $data['options']
                                ]
                            ])
                        @endif
                    @endforeach

                    <div class="modal-actions">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
