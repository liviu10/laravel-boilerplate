<div class="row my-3">
    <div>
        <label for="{{ $input['id'] }}" class="form-label">
            {{ $input['label'] }}
        </label>

        <select
            id="{{ $input['id'] }}"
            class="form-select"
            aria-label="Default select example"
            name="{{ $input['id'] }}"
        >
            @foreach ($input['options'] as $key => $item)
            <option value="{{ $item->id }}">{{ $item->user_role_name }}</option>
            @endforeach
        </select>

        @error($input['id'])
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
