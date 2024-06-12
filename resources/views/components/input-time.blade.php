<div class="form-floating mb-3">
    <input
        class="form-control"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        max="23:59"
        min="00:00"
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="time"
        value="{{ $item['value'] }}"
    >
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
