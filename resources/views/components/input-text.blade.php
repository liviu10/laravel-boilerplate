<div class="form-floating mb-3">
    <input
        class="form-control"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        maxlength={{ $item['maxlength'] }}
        minlength={{ $item['minlength'] }}
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="text"
        value="{{ $item['value'] }}"
    >
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
