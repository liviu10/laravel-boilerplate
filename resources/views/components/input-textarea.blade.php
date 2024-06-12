<div class="form-floating mb-3">
    <textarea
        class="form-control"
        id="{{ $item['key'] }}"
        name="{{ $item['name'] }}"
        rows="3"
    >
    </textarea>
    <label for="{{ $item['key'] }}">
        {{ $item['placeholder'] }}
    </label>
</div>
