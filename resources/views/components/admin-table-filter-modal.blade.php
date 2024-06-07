<div
    aria-hidden="true"
    aria-labelledby="filterModalLabel"
    class="modal fade"
    id="filterModal"
    tabindex="-1"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">
                    {{ __('Filter record') }}
                </h1>
                <button
                    aria-label="Close"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    type="button"
                ></button>
            </div>
            <form
                id="filterForm"
                method="GET"
                action="{{ Route::has($action) ? route($action) : '#' }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body">
                    @foreach ($form as $input)
                        <div class="form-floating mb-3">
                            @if ($input['type'] === 'text' || $input['type'] === 'mail' || $input['type'] === 'tel')
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
                                    <option selected>{{ __('-- Choose an option --') }}</option>
                                    @foreach ($input['options'] as $option)
                                        <option value="{{ $option['value'] }}">
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
                        {{ _('Filter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
