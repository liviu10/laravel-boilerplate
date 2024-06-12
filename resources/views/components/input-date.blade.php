<div class="form-floating mb-3">
    <input
        class="form-control"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        min="{{ $item['min'] }}"
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="date"
        value="{{ $item['value'] }}"
    >
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
