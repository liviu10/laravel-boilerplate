<div
    aria-hidden="true"
    aria-labelledby="addNewModalLabel"
    class="modal fade"
    id="addNewModal"
    tabindex="-1"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addNewModalLabel">
                    {{ __('Add a new record') }}
                </h1>
                <button
                    aria-label="Close"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    type="button"
                ></button>
            </div>
            <form
                id="createForm"
                method="POST"
                action="{{ route($create_form['action']) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body">
                    @foreach ($create_form['inputs'] as $input)
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
                            @else
                            <select
                                class="form-select"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                            >
                                <option selected>{{ __('-- Choose an option --') }}</option>
                                @foreach ($input['options'] as $option)
                                    <option value="{{ $option['value'] }}">
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
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
</div>
