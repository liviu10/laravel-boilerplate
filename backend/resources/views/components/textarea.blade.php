<div class="row my-3">
    <div>
        <label for="{{ $input['id'] }}" class="form-label">
            {{ $input['label'] }}
        </label>

        <div class="">
            <textarea
                id="{{ $input['id'] }}"
                class="form-control
                @error($input['id']) is-invalid @enderror
                rows="5"
                name="{{ $input['id'] }}"
                autocomplete="{{ $input['id'] }}"
                autofocus
                {{ isset($input['disabled']) && $input['disabled'] ? 'disabled' : '' }}
            ></textarea>

            @error($input['id'])
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
