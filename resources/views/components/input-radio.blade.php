<div class="form-check mb-3">
    <input
        class="form-check-input"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="radio"
        value="{{ $item['value'] }}"
    >
    <label class="form-check-label" for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
