<div class="mb-3">
    <label class="form-label" for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
    <input
        class="form-control"
        id="{{ $item['key'] }}"
        key="{{ $item['key'] }}"
        name="{{ $item['name'] }}"
        placeholder="{{ $item['placeholder'] }}"
        type="file"
        value="{{ $item['value'] }}"
    >
</div>


{{-- @if (array_key_exists('multiple', $item) && $item['multiple'])
name="{{ $item['name'] }}[]"
multiple
@else
name="{{ $item['name'] }}"
@endif --}}
