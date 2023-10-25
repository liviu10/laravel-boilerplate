<div class="row my-3">
    <div>
        <label for="{{ $input['id'] }}" class="form-label">
            {{ $input['label'] }}
        </label>

        <select
            id="{{ $input['id'] }}"
            class="form-select"
            aria-label="Default select example"
            name="{{ $input['id'] }}"
        >
            @if (gettype($input['options']) === 'object')
                <option value="">{{ __('admin.general.choose_an_option_label') }}</option>
                @foreach ($input['options'] as $key => $item)
                    <option
                        value="{{ $item->id }}"
                        @if (
                            isset($input['selected_value']) &&
                            $input['selected_value'] !== '' &&
                            $input['selected_value'] == $item->id
                        ) selected @endif>
                        @foreach ($item->getAttributes() as $property => $value)
                            @if ($loop->index === 1)
                                {{ $value }}
                            @endif
                        @endforeach
                    </option>
                @endforeach
            @else
                <option value="">{{ __('admin.general.choose_an_option_label') }}</option>
                @foreach ($input['options'] as $key => $item)
                    <option
                        value="{{ $key }}"
                        @if (
                            isset($input['selected_value']) &&
                            $input['selected_value'] !== ''
                            && $input['selected_value'] == $key
                        ) selected @endif
                    >
                        {{ $item }}
                    </option>
                @endforeach
            @endif
        </select>

        @error($input['id'])
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
