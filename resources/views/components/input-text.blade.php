<div class="form-floating mb-3">
    <input
        class="form-control"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        maxlength={{ $item['maxlength'] }}
        minlength={{ $item['minlength'] }}
        name="{{ $item['key'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="text"
        value="{{ $item['value'] }}"
    >
    <label for="test">
        {{ $item['placeholder'] }}
    </label>
</div>
