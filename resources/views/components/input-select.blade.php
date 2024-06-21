<div class="form-floating mb-3">
    <select
        class="form-select"
        id="{{ $item['key'] }}"
        name="{{ $item['name'] }}"
    >
        <option selected>{{ __('-- Choose an option --') }}</option>
        @foreach ($item['options'] as $key => $option)
            <option
                @if (
                    in_array($item['key'], [
                        'is_active',
                        'allow_comments',
                        'allow_share',
                        'privacy_policy',
                        'terms_and_conditions',
                        'data_protection'
                    ])
                )
                    value="{{ $option['value'] }}"
                @else
                    value="{{ $option['id'] }}"
                @endif
                @if ($item['value'] !== null && $item['value'] == $key + 1) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>


