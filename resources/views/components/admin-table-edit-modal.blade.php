<div
    aria-hidden="true"
    aria-labelledby="editModalLabel{{ $key }}"
    class="modal fade"
    id="editModal{{ $key }}"
    tabindex="-1"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel{{ $key }}">
                    {{ __('Edit record') }}
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
                action="{{ route($update_form['action'], $row->id) }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="list-group">
                    @foreach ($record->toArray() as $key => $item)
                        <li class="list-group-item">
                            <b>
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </b>:
                            @if ($key === 'is_active')
                                <span class="badge text-bg-{{ $value ? 'success' : 'danger' }}">
                                    {{ $value ? __('Yes') : __('No') }}
                                </span>
                            @else
                                {{ $item }}
                            @endif
                        </li>
                    @endforeach
                    </ul>
                    <hr>
                    @foreach ($update_form['inputs'] as $input)
                        @php
                            $rowValue = $row->{$input['key']};
                        @endphp
                        <div class="form-floating mb-3">
                            @if ($input['type'] === 'text')
                            <input
                                class="form-control"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                                placeholder="{{ $input['placeholder'] }}"
                                type="{{ $input['type'] }}"
                                value="{{ $rowValue }}"
                            >
                            @else
                            <select
                                class="form-select"
                                id="{{ $input['key'] }}"
                                name="{{ $input['key'] }}"
                            >
                                <option selected>{{ __('-- Choose an option --') }}</option>
                                @foreach ($input['options'] as $option)
                                    <option value="{{ $option['value'] }}" @if ($option['value'] == $rowValue) selected @endif>
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
                    <button type="submit" class="btn btn-warning">
                        {{ _('Edit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
