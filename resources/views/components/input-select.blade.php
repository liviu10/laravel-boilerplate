<div class="form-floating mb-3">
    <select
        class="form-select"
        id="{{ $item['key'] }}"
        name="{{ $item['key'] }}"
    >
        <option selected>{{ __('-- Choose an option --') }}</option>
        @foreach ($item['options'] as $key => $option)
            <option
                value="{{ $option['value'] }}"
                @if ($item['value'] !== null && $item['value'] == $key + 1) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
    <label for="test">
        {{ $item['placeholder'] }}
    </label>
</div>
