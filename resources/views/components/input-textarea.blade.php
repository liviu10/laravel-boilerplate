<div class="form-floating mb-3">
    <textarea
        class="form-control"
        id="{{ $item['key'] }}"
        name="{{ $item['name'] }}"
        rows="3"
    >
        @if ($item['value'])
            {{ $item['value'] }}
        @endif
    </textarea>
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
