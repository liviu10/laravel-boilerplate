<div class="form-floating mb-3">
    <input
        class="form-control"
        @if(array_key_exists('disabled', $item) && $item['disabled'])
        disabled=true
        @endif
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        maxlength={{ $item['maxlength'] }}
        minlength={{ $item['minlength'] }}
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        @if(array_key_exists('readonly', $item) && $item['readonly'])
        readonly=true
        @endif
        type="text"
        value="{{ $item['value'] }}"
    >
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
